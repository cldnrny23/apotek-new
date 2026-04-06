<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Distributor;
use App\Models\Obat;
use App\Models\DetailPembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with('distributor')->get();
        $distributors = Distributor::all();
        $obats = Obat::all();
        return view('be.pembelian.index', compact('distributors', 'pembelians', 'obats'));
    }

    public function create()
    {
        $distributors = Distributor::all();
        $obats = Obat::all();
        return view('be.pembelian.create', compact('distributors', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nonota' => 'required',
            'tgl_pembelian' => 'required|date',
            'total_bayar' => 'required|numeric',
            'id_distributor' => 'required|exists:distributors,id',
        ]);

        $pembelian = Pembelian::create($request->all());
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $distributors = Distributor::all();
        return view('be.pembelian.edit', compact('pembelians', 'distributors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nonota' => 'required',
            'tgl_pembelian' => 'required|date',
            'total_bayar' => 'required|numeric',
            'id_distributor' => 'required|exists:distributors,id',
        ]);

        $pembelian = Pembelian::findOrFail($id);
        $pembelian->update($request->all());
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diupdate');
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus');
    }
}
