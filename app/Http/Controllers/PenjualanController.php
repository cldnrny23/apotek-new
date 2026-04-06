<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pengiriman;
use App\Models\MetodeBayar;
use App\Models\JenisPengiriman;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        $metodeBayars = MetodeBayar::all();
        $jenisPengirimans = JenisPengiriman::all();
        $pelanggans = Pelanggan::all();
        $penjualans = Penjualan::with(['metodeBayar', 'jenisPengiriman', 'pelanggan'])->get();
        return view('be.penjualans.index', compact('penjualans'));
    }

    public function create()
    {
        $metodeBayars = MetodeBayar::all();
        $jenisPengirimans = JenisPengiriman::all();
        $pelanggans = Pelanggan::all();
        return view('be.penjualans.create', compact('metodeBayars', 'jenisPengirimans', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_metode_bayar' => 'required|exists:metode_bayars,id',
            'tgl_penjualan' => 'required|date',
            'url_resep' => 'nullable|string',
            'ongkos_kirim' => 'required|numeric',
            'biaya_app' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'status_order' => 'required|in:Menunggu Konfirmasi,Diproses,Menunggu Kurir,Dibatalkan Pembeli,Dibatalkan Penjual,Bermasalah,Selesai',
            'keterangan_status' => 'nullable|string',
            'id_jenis_kirim' => 'required|exists:jenis_pengirimans,id',
            'id_pelanggan' => 'required|exists:pelanggans,id',
        ]);

        Penjualan::create($validated);
        return redirect()->route('penjualans.index')->with('success', 'Data penjualan berhasil ditambahkan');
    }

    public function edit(Penjualan $penjualan)
    {
        if (!$penjualan || !$penjualan->id) {
            abort(404, 'Penjualan tidak ditemukan');
        }

        $metodeBayars = MetodeBayar::all();
        $jenisPengirimans = JenisPengiriman::all();
        $pelanggans = Pelanggan::all();
        return view('be.penjualans.edit', compact('penjualan', 'metodeBayars', 'jenisPengirimans', 'pelanggans'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        if (!$penjualan || !$penjualan->id) {
            abort(404, 'Penjualan tidak ditemukan');
        }

        $validated = $request->validate([
            'id_metode_bayar' => 'required|exists:metode_bayars,id',
            'tgl_penjualan' => 'required|date',
            'url_resep' => 'nullable|string',
            'ongkos_kirim' => 'required|numeric|min:0',
            'biaya_app' => 'required|numeric|min:0',
            'total_bayar' => 'required|numeric|min:0',
            'status_order' => 'required|in:Menunggu Konfirmasi,Diproses,Menunggu Kurir,Dibatalkan Pembeli,Dibatalkan Penjual,Bermasalah,Selesai',
            'keterangan_status' => 'nullable|string',
            'id_jenis_kirim' => 'required|exists:jenis_pengirimans,id',
            'id_pelanggan' => 'required|exists:pelanggans,id',
        ]);

        $penjualan->update($validated);
        return redirect()->route('penjualans.index')->with('success', 'Data penjualan berhasil diperbarui');
    }

    public function destroy(Penjualan $penjualan)
    {
        if (!$penjualan || !$penjualan->id) {
            abort(404, 'Penjualan tidak ditemukan');
        }

        $penjualan->delete();
        return redirect()->route('penjualans.index')->with('success', 'Data penjualan berhasil dihapus');
    }

    public function confirm(Penjualan $penjualan)
    {
        $this->authorize_role(['admin', 'apoteker', 'kasir', 'pemilik']);

        // Only allow confirming orders after customer payment has been verified
        if (! $penjualan->awaitingPaymentVerification()) {
            return redirect()->route('penjualans.index')
                ->with('error', 'Hanya pesanan yang sudah dikonfirmasi pembayarannya oleh pelanggan yang dapat diproses.');
        }

        // Update status to processed
        $penjualan->update([
            'status_order' => 'Diproses',
            'keterangan_status' => 'Pesanan dikonfirmasi oleh ' . ucfirst(Auth::user()->jabatan) . ' pada ' . now()->format('d M Y H:i')
        ]);

        // Automatically create pengiriman record
        $no_invoice = 'INV-' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) . '-' . now()->format('YmdHi');

        Pengiriman::create([
            'id_penjualan' => $penjualan->id,
            'no_invoice' => $no_invoice,
            'tgl_kirim' => now(),
            'tgl_tiba' => null,
            'status_kirim' => 'Menunggu Konfirmasi',
            'nama_kurir' => 'Belum Dipilih',
            'telpon_kurir' => '-',
            'bukti_foto' => '-',
            'keterangan' => 'Pengiriman otomatis dibuat saat pesanan dikonfirmasi dan menunggu pemilihan kurir oleh karyawan'
        ]);

        return redirect()->route('penjualans.index')
            ->with('success', 'Pesanan #' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) . ' berhasil dikonfirmasi dan pengiriman telah dibuat!');
    }

    private function authorize_role($allowed_roles)
    {
        if (!in_array(Auth::user()->jabatan, $allowed_roles)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}
