<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->jabatan === 'kurir') {
            // Kurir hanya lihat pengiriman mereka
            $pengirimans = Pengiriman::where('nama_kurir', $user->name)
                ->with(['penjualan.pelanggan'])
                ->latest()
                ->paginate(10);
        } else {
            // Admin, karyawan, dll lihat semua
            $pengirimans = Pengiriman::with(['penjualan.pelanggan'])->latest()->paginate(10);
        }

        return view('be.pengiriman.index', compact('pengirimans'));
    }

    public function create()
    {
        // Hanya karyawan yang bisa membuat pengiriman
        if (auth()->user()->jabatan !== 'karyawan') {
            return redirect()->route('pengiriman.index')->with('error', 'Hanya karyawan yang bisa membuat pengiriman');
        }

        $penjualans = Penjualan::with('pelanggan')->whereDoesntHave('pengiriman')->get();
        $kurirs = User::where('jabatan', 'kurir')->get();
        return view('be.pengiriman.create', compact('penjualans', 'kurirs'));
    }

    public function store(Request $request)
    {
        // Hanya karyawan yang bisa membuat pengiriman
        if (auth()->user()->jabatan !== 'karyawan') {
            return redirect()->route('pengiriman.index')->with('error', 'Hanya karyawan yang bisa membuat pengiriman');
        }

        $request->validate([
            'id_penjualan' => 'required|exists:penjualans,id',
            'nama_kurir' => 'required|max:30',
            'telpon_kurir' => 'required|max:15',
            'no_invoice' => 'required|unique:pengirimans',
            'tgl_kirim' => 'required',
            'bukti_foto' => 'nullable|image|max:2048'
        ]);

        $pengiriman = new Pengiriman($request->all());
        $pengiriman->status_kirim = 'Menunggu Konfirmasi';
        $pengiriman->tgl_tiba = null; // Belum tiba

        if ($request->hasFile('bukti_foto')) {
            // Ensure upload directory exists
            $uploadPath = public_path('uploads/pengiriman');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('bukti_foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $pengiriman->bukti_foto = $filename;
        }

        $pengiriman->save();
        return redirect()->route('pengiriman.index')->with('success', 'Pengiriman berhasil ditambahkan');
    }

    public function edit(Pengiriman $pengiriman)
    {
        $user = auth()->user();

        if (!in_array($user->jabatan, ['karyawan', 'admin', 'kurir'])) {
            return redirect()->route('pengiriman.index')->with('error', 'Anda tidak memiliki akses untuk mengedit pengiriman');
        }

        if ($user->jabatan === 'kurir' && $pengiriman->nama_kurir !== $user->name) {
            return redirect()->route('pengiriman.index')->with('error', 'Pengiriman ini bukan untuk Anda');
        }

        $penjualans = Penjualan::with('pelanggan')->get();
        $kurirs = User::where('jabatan', 'kurir')->get();
        return view('be.pengiriman.edit', compact('pengiriman', 'penjualans', 'kurirs'));
    }

    public function update(Request $request, Pengiriman $pengiriman)
    {
        // Hanya karyawan yang bisa edit full detail
        if (auth()->user()->jabatan !== 'karyawan') {
            return redirect()->route('pengiriman.index')->with('error', 'Hanya karyawan yang bisa edit pengiriman');
        }

        $request->validate([
            'id_penjualan' => 'required|exists:penjualans,id',
            'nama_kurir' => 'required|max:30',
            'telpon_kurir' => 'required|max:15',
            'no_invoice' => 'required|unique:pengirimans,no_invoice,' . $pengiriman->id,
            'tgl_kirim' => 'required',
            'status_kirim' => 'required|in:Menunggu Konfirmasi,Sedang Dikirim,Diterima',
            'bukti_foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('bukti_foto')) {
            // Delete old image
            if ($pengiriman->bukti_foto && file_exists(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto))) {
                unlink(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto));
            }

            // Ensure upload directory exists
            $uploadPath = public_path('uploads/pengiriman');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('bukti_foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $pengiriman->bukti_foto = $filename;
        }

        $pengiriman->update($request->except('bukti_foto'));
        return redirect()->route('pengiriman.index')->with('success', 'Pengiriman berhasil diupdate');
    }

    public function destroy(Pengiriman $pengiriman)
    {
        // Hanya karyawan yang bisa delete pengiriman
        if (auth()->user()->jabatan !== 'karyawan') {
            return redirect()->route('pengiriman.index')->with('error', 'Hanya karyawan yang bisa menghapus pengiriman');
        }

        // Delete associated image file if exists
        if ($pengiriman->bukti_foto && file_exists(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto))) {
            unlink(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto));
        }

        $pengiriman->delete();
        return redirect()->route('pengiriman.index')->with('success', 'Pengiriman berhasil dihapus');
    }

    /**
     * Update status pengiriman oleh kurir
     */
    public function updateStatus(Request $request, Pengiriman $pengiriman)
    {
        // Hanya kurir yang bisa update status
        if (auth()->user()->jabatan !== 'kurir') {
            return redirect()->route('pengiriman.index')->with('error', 'Hanya kurir yang bisa update status');
        }

        // Validasi bahwa pengiriman ini untuk kurir tersebut
        if ($pengiriman->nama_kurir !== auth()->user()->name) {
            return redirect()->route('pengiriman.index')->with('error', 'Pengiriman ini bukan untuk Anda');
        }

        $request->validate([
            'status_kirim' => 'required|in:Menunggu Konfirmasi,Sedang Dikirim,Diterima',
            'bukti_foto' => 'nullable|image|max:2048'
        ]);

        // Update status
        $pengiriman->status_kirim = $request->status_kirim;

        // Jika diterima, set tgl_tiba
        if ($request->status_kirim === 'Diterima') {
            $pengiriman->tgl_tiba = now();
        }

        // Handle bukti foto
        if ($request->hasFile('bukti_foto')) {
            // Delete old image
            if ($pengiriman->bukti_foto && file_exists(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto))) {
                unlink(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto));
            }

            $uploadPath = public_path('uploads/pengiriman');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('bukti_foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $pengiriman->bukti_foto = $filename;
        }

        $pengiriman->save();
        return redirect()->route('pengiriman.index')->with('success', 'Status pengiriman berhasil diupdate');
    }
}
