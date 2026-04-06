<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Obat;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function toCheckout(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|integer|exists:pelanggans,id',
            'id_metode_bayar' => 'required|integer|exists:metode_bayars,id',
            'id_jenis_kirim' => 'required|integer|exists:jenis_pengirimans,id',
            'ongkos_kirim' => 'required|numeric|min:0',
            'total_bayar' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:obats,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $penjualan = Penjualan::create([
                'id_metode_bayar' => $validated['id_metode_bayar'],
                'tgl_penjualan' => now(),
                'url_resep' => null,
                'ongkos_kirim' => $validated['ongkos_kirim'],
                'biaya_app' => 0,
                'total_bayar' => $validated['total_bayar'],
                'status_order' => 'Menunggu Konfirmasi Pembayaran',
                'keterangan_status' => 'Pesanan dibuat, menunggu pembayaran pelanggan',
                'id_jenis_kirim' => $validated['id_jenis_kirim'],
                'id_pelanggan' => $validated['id_pelanggan'],
            ]);

            foreach ($validated['items'] as $item) {
                $obat = Obat::findOrFail($item['id']);

                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_obat' => $obat->id,
                    'jumlah_beli' => $item['qty'],
                    'harga_beli' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                if ($obat->stok >= $item['qty']) {
                    $obat->decrement('stok', $item['qty']);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil dibuat',
                'order_id' => $penjualan->id,
                'midtrans_order_id' => $penjualan->midtrans_order_id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CheckoutController::toCheckout error', ['exception' => $e]);

            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSnapToken(Request $request, $id)
    {
        $midtransController = new MidtransController();
        return $midtransController->createTransaction($id);
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|string',
            'transaction_status' => 'required|string',
        ]);

        $penjualan = Penjualan::where('midtrans_order_id', $validated['order_id'])->first();

        if (! $penjualan) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $status = $validated['transaction_status'];
        $update = [];

        switch ($status) {
            case 'capture':
            case 'settlement':
                $update = [
                    'status_order' => 'Diproses',
                    'keterangan_status' => 'Pembayaran berhasil, pesanan sedang diproses',
                ];
                break;
            case 'pending':
                $update = [
                    'status_order' => 'Menunggu Konfirmasi',
                    'keterangan_status' => 'Menunggu konfirmasi pembayaran dari pembeli',
                ];
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $update = [
                    'status_order' => 'Dibatalkan Sistem',
                    'keterangan_status' => 'Pembayaran ' . $status,
                ];
                break;
            default:
                return response()->json(['message' => 'Status transaksi tidak dikenali'], 422);
        }

        $penjualan->update($update);

        return response()->json([
            'message' => 'Status pesanan diperbarui',
            'status_order' => $penjualan->status_order,
        ]);
    }
}
