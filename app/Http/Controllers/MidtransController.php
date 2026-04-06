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
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    /**
     * Membuat transaksi Midtrans untuk penjualan
     */
    public function createTransaction($penjualanId)
    {
        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualans.obat', 'metodeBayar', 'jenisPengiriman'])
            ->findOrFail($penjualanId);

        // Pastikan penjualan milik user yang sedang login
        if ($penjualan->id_pelanggan !== auth('pelanggan')->id()) {
            abort(403, 'Unauthorized');
        }

        // Cek apakah sudah ada snap_token
        if ($penjualan->snap_token) {
            return response()->json([
                'snap_token' => $penjualan->snap_token
            ]);
        }

        // Siapkan data untuk Midtrans
        $transaction_details = [
            'order_id' => 'INV-' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) . '-' . time(),
            'gross_amount' => (int) $penjualan->total_bayar,
        ];

        $customer_details = [
            'first_name' => $penjualan->pelanggan->nama_pelanggan,
            'email' => $penjualan->pelanggan->email ?? 'customer@example.com',
            'phone' => $penjualan->pelanggan->no_hp ?? '081234567890',
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
                'finish' => route('payment.success', $penjualan->id),
                'error' => route('payment.show', $penjualan->id),
                'pending' => route('payment.show', $penjualan->id),
            ],
        ];

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
                    'keterangan_status' => 'Pembayaran ditolak oleh Midtrans'
                ]);
                break;
            case 'expire':
                $penjualan->update([
                    'status_order' => 'Dibatalkan Pembeli',
                    'keterangan_status' => 'Pembayaran expired via Midtrans'
                ]);
                break;
            case 'cancel':
                $penjualan->update([
                    'status_order' => 'Dibatalkan Pembeli',
                    'keterangan_status' => 'Pembayaran dibatalkan via Midtrans'
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
