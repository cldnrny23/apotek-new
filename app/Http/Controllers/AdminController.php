<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Obat;
use App\Models\Pelanggan;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get date range for current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Get statistics for this month
        $totalPenjualan = Penjualan::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $totalPembelian = Pembelian::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Revenue from penjualan this month
        $totalRevenue = Penjualan::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_harga');

        // Cost from pembelian this month
        $totalCost = Pembelian::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_harga');

        // Get all-time statistics
        $totalProduk = Obat::count();
        $totalPelanggan = Pelanggan::count();
        $totalKaryawan = User::count();

        // Low stock products (less than 5 units)
        $lowStockProducts = Obat::where('stok', '<', 5)->count();

        // Get top products (most sold)
        $topProducts = Obat::withCount('penjualanDetails')
            ->orderBy('penjualan_details_count', 'desc')
            ->limit(5)
            ->get();

        // Get recent transactions
        $recentPenjualan = Penjualan::with('pelanggan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate profit margin
        $profit = $totalRevenue - $totalCost;
        $profitMargin = $totalRevenue > 0 ? round(($profit / $totalRevenue) * 100, 2) : 0;

        return view('be.admin.index', [
            'title' => 'Dashboard',
            'totalPenjualan' => $totalPenjualan,
            'totalPembelian' => $totalPembelian,
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'profit' => $profit,
            'profitMargin' => $profitMargin,
            'totalProduk' => $totalProduk,
            'totalPelanggan' => $totalPelanggan,
            'totalKaryawan' => $totalKaryawan,
            'lowStockProducts' => $lowStockProducts,
            'topProducts' => $topProducts,
            'recentPenjualan' => $recentPenjualan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
