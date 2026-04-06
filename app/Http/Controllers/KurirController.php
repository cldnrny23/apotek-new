<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Support\Facades\Auth;

class KurirController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get shipments for this courier
        $pengirimans = Pengiriman::where('nama_kurir', $user->name)
            ->with(['penjualan.pelanggan'])
            ->latest()
            ->paginate(10);
        
        // Get statistics
        $total_pengiriman = Pengiriman::where('nama_kurir', $user->name)->count();
        $sedang_dikirim = Pengiriman::where('nama_kurir', $user->name)
            ->where('status_kirim', 'Sedang Dikirim')->count();
        $tiba_ditujuan = Pengiriman::where('nama_kurir', $user->name)
            ->where('status_kirim', 'Tiba Ditujuan')->count();
        
        return view('be.kurir.dashboard', compact('pengirimans', 'total_pengiriman', 'sedang_dikirim', 'tiba_ditujuan', 'user'));
    }
}
