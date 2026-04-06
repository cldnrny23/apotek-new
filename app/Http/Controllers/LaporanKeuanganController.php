<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $bulan = $request->get('bulan', date('m'));

        // Get sales/penjualan
        $penjualan = Penjualan::whereYear('tgl_penjualan', $tahun)
            ->whereMonth('tgl_penjualan', $bulan)
            ->get();

        // Get purchases/pembelian
        $pembelian = Pembelian::whereYear('tgl_pembelian', $tahun)
            ->whereMonth('tgl_pembelian', $bulan)
            ->get();

        // Calculate totals
        $total_penjualan = $penjualan->sum('total_bayar');
        $total_pembelian = $pembelian->sum('total_bayar');
        $total_ongkos_kirim = $penjualan->sum('ongkos_kirim');
        $total_biaya_app = $penjualan->sum('biaya_app');

        // Net profit
        $total_pengeluaran = $total_pembelian;
        $total_pendapatan = $total_penjualan + $total_ongkos_kirim + $total_biaya_app;
        $laba_bersih = $total_pendapatan - $total_pengeluaran;

        // Monthly data untuk chart
        $monthly_sales = $this->getMonthlySales($tahun);
        $monthly_purchases = $this->getMonthlyPurchases($tahun);

        return view('be.laporan_keuangan.index', compact(
            'tahun',
            'bulan',
            'penjualan',
            'pembelian',
            'total_penjualan',
            'total_pembelian',
            'total_ongkos_kirim',
            'total_biaya_app',
            'total_pendapatan',
            'total_pengeluaran',
            'laba_bersih',
            'monthly_sales',
            'monthly_purchases'
        ));
    }

    private function getMonthlySales($tahun)
    {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = Penjualan::whereYear('tgl_penjualan', $tahun)
                ->whereMonth('tgl_penjualan', $i)
                ->sum('total_bayar');
            $data[] = $total;
        }
        return $data;
    }

    private function getMonthlyPurchases($tahun)
    {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = Pembelian::whereYear('tgl_pembelian', $tahun)
                ->whereMonth('tgl_pembelian', $i)
                ->sum('total_bayar');
            $data[] = $total;
        }
        return $data;
    }
}
