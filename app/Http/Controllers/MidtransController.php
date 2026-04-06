<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.sanitized');
        Config::$is3ds = config('midtrans.3ds');
    }

    private function resolveEnabledPayments($metodeBayar)
    {
        if (! $metodeBayar) {
            return [];
        }

        $selected = $metodeBayar->midtrans_payment_type;
        if ($selected) {
            return [$selected];
        }

        $search = strtolower($metodeBayar->metode_pembayaran . ' ' . ($metodeBayar->tempat_bayar ?? ''));

        if (str_contains($search, 'gopay')) {
            return ['gopay'];
        }
        if (str_contains($search, 'ovo')) {
            return ['ovo'];
        }
        if (str_contains($search, 'shopeepay')) {
            return ['shopeepay'];
        }
        if (str_contains($search, 'qris')) {
            return ['qris'];
        }
        if (str_contains($search, 'credit card') || str_contains($search, 'kartu kredit')) {
            return ['credit_card'];
        }
        if (str_contains($search, 'bank transfer') || str_contains($search, 'transfer')) {
            return ['bank_transfer'];
        }
        if (str_contains($search, 'bca')) {
            return ['bca_va'];
        }
        if (str_contains($search, 'bni')) {
            return ['bni_va'];
        }
        if (str_contains($search, 'bri')) {
            return ['bri_va'];
        }
        if (str_contains($search, 'permata')) {
            return ['permata_va'];
        }
        if (str_contains($search, 'mandiri')) {
            return ['echannel'];
        }

        return [];
    }

    /**
     * Membuat transaksi Midtrans untuk penjualan
     */
    public function createTransaction($penjualanId, bool $forceNewTransaction = false)
    {
        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualans.obat', 'metodeBayar', 'jenisPengiriman'])
            ->findOrFail($penjualanId);

        // Pastikan penjualan milik user yang sedang login jika ada sesi pelanggan
        if (auth('pelanggan')->check() && $penjualan->id_pelanggan !== auth('pelanggan')->id()) {
            abort(403, 'Unauthorized');
        }

        // Cek apakah sudah ada snap_token dan apakah token tersebut masih dapat digunakan
        if (!$forceNewTransaction && $this->shouldReuseSnapToken($penjualan)) {
            return response()->json([
                'snap_token' => $penjualan->snap_token
            ]);
        }

        // Siapkan data untuk Midtrans
        $transaction_details = [
            'order_id' => 'INV-' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) . '-' . time(),
            'gross_amount' => (int) $penjualan->total_bayar,
        ];

        $customer = $penjualan->pelanggan;
        $customer_details = [
            'first_name' => optional($customer)->nama_pelanggan ?? 'Pelanggan',
            'email' => optional($customer)->email ?? 'customer@example.com',
            'phone' => optional($customer)->no_hp ?? '081234567890',
        ];

        $item_details = [];
        foreach ($penjualan->detailPenjualans as $detail) {
            $item_details[] = [
                'id' => $detail->obat->id,
                'price' => (int) $detail->harga_beli,
                'quantity' => $detail->jumlah_beli,
                'name' => substr($detail->obat->nama_obat, 0, 50), // Max 50 karakter
            ];
        }

        // Tambahkan ongkos kirim sebagai item terpisah
        if ($penjualan->ongkos_kirim > 0) {
            $item_details[] = [
                'id' => 'shipping',
                'price' => (int) $penjualan->ongkos_kirim,
                'quantity' => 1,
                'name' => 'Ongkos Kirim - ' . $penjualan->jenisPengiriman->nama_ekspedisi,
            ];
        }

        // Tambahkan biaya aplikasi jika ada
        if ($penjualan->biaya_app > 0) {
            $item_details[] = [
                'id' => 'service_fee',
                'price' => (int) $penjualan->biaya_app,
                'quantity' => 1,
                'name' => 'Biaya Aplikasi',
            ];
        }

        $transaction_data = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
            'callbacks' => [
                'finish' => route('payment.finish'),
                'error' => route('payment.show', $penjualan->id),
                'pending' => route('payment.show', $penjualan->id),
            ],
        ];

        $enabledPayments = $this->resolveEnabledPayments($penjualan->metodeBayar);
        if (!empty($enabledPayments)) {
            $transaction_data['enabled_payments'] = $enabledPayments;
        }

        try {
            $snapToken = Snap::getSnapToken($transaction_data);

            // Simpan snap_token ke database
            $penjualan->update([
                'snap_token' => $snapToken,
                'midtrans_order_id' => $transaction_details['order_id'],
            ]);

            return response()->json([
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal membuat transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    private function shouldReuseSnapToken(Penjualan $penjualan): bool
    {
        if (! $penjualan->snap_token || ! $penjualan->midtrans_order_id) {
            return false;
        }

        $status = strtolower($penjualan->keterangan_status ?? '');

        if (str_contains($status, 'expired via midtrans')
            || str_contains($status, 'dibatalkan via midtrans')
            || str_contains($status, 'ditolak oleh midtrans')) {
            return false;
        }

        return true;
    }

    /**
     * Update order status based on Midtrans transaction state.
     */
    private function updateOrderStatusFromMidtrans(Penjualan $penjualan, string $transaction, ?string $type = null, ?string $fraud = null)
    {
        switch ($transaction) {
            case 'capture':
                if ($type === 'credit_card') {
                    if ($fraud === 'challenge') {
                        $penjualan->update([
                            'status_order' => 'Menunggu Konfirmasi Pembayaran',
                            'keterangan_status' => 'Pembayaran challenge, menunggu verifikasi manual'
                        ]);
                    } else {
                        $penjualan->update([
                            'status_order' => 'Diproses',
                            'keterangan_status' => 'Pembayaran berhasil via Midtrans, pesanan diproses'
                        ]);
                    }
                }
                break;
            case 'settlement':
                $penjualan->update([
                    'status_order' => 'Diproses',
                    'keterangan_status' => 'Pembayaran berhasil via Midtrans, pesanan diproses'
                ]);
                break;
            case 'pending':
                $penjualan->update([
                    'status_order' => 'Menunggu Konfirmasi Pembayaran',
                    'keterangan_status' => 'Pembayaran pending via Midtrans'
                ]);
                break;
            case 'deny':
                $penjualan->update([
                    'status_order' => 'Dibatalkan Pembeli',
                    'keterangan_status' => 'Pembayaran ditolak oleh Midtrans',
                    'snap_token' => null,
                ]);
                break;
            case 'expire':
                $penjualan->update([
                    'status_order' => 'Dibatalkan Pembeli',
                    'keterangan_status' => 'Pembayaran expired via Midtrans',
                    'snap_token' => null,
                ]);
                break;
            case 'cancel':
                $penjualan->update([
                    'status_order' => 'Dibatalkan Pembeli',
                    'keterangan_status' => 'Pembayaran dibatalkan via Midtrans',
                    'snap_token' => null,
                ]);
                break;
            default:
                // Do not alter order status for unknown states.
                break;
        }
    }

    /**
     * Handle callback dari Midtrans
     */
    public function handleNotification(Request $request)
    {
        return $this->callback($request);
    }

    public function callback(Request $request)
    {
        try {
            $notification = new Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $order_id = $notification->order_id;
            $fraud = $notification->fraud_status;

            // Cari penjualan berdasarkan midtrans_order_id
            $penjualan = Penjualan::where('midtrans_order_id', $order_id)->first();

            if (!$penjualan) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $this->updateOrderStatusFromMidtrans($penjualan, $transaction, $type, $fraud);

            return response()->json(['message' => 'Callback processed successfully']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error processing callback: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Sync the local order status with Midtrans using API status check.
     */
    public function syncTransactionStatus(string $orderId)
    {
        try {
            $status = \Midtrans\Transaction::status($orderId);
            $penjualan = Penjualan::where('midtrans_order_id', $orderId)->first();

            if (!$penjualan) {
                return null;
            }

            $this->updateOrderStatusFromMidtrans(
                $penjualan,
                $status->transaction_status,
                $status->payment_type ?? null,
                $status->fraud_status ?? null
            );

            return $penjualan;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Handle webhook dari Midtrans (sama dengan callback tapi untuk webhook endpoint)
     */
    public function webhook(Request $request)
    {
        return $this->callback($request);
    }

    /**
     * Method untuk cek status transaksi (untuk debugging)
     */
    public function checkStatus($orderId)
    {
        try {
            $status = \Midtrans\Transaction::status($orderId);
            return response()->json($status);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
