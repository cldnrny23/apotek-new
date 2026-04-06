<?php

namespace App\Http\Controllers;

use App\Models\MetodeBayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MetodeBayarController extends Controller
{
    public function index()
    {
        $metodeBayars = MetodeBayar::all();
        return view('be.metode-bayars.index', compact('metodeBayars'));
    }

    public function create()
    {
        return view('be.metode-bayars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|max:255',
            'tempat_bayar' => 'required|string|max:50',
            'no_rekening' => 'required|string|max:25',
            'url_logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'midtrans_payment_type' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('url_logo')) {
            $validated['url_logo'] = $request->file('url_logo')->store('metode-bayar-logos', 'public');
        }

        MetodeBayar::create($validated);
        return redirect()->route('metode-bayar.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function edit(MetodeBayar $metodeBayar)
    {
        return view('be.metode-bayars.edit', compact('metodeBayar'));
    }

    public function update(Request $request, MetodeBayar $metodeBayar)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|max:255',
            'tempat_bayar' => 'required|string|max:50',
            'no_rekening' => 'required|string|max:25',
            'url_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'midtrans_payment_type' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('url_logo')) {
            if ($metodeBayar->url_logo && Storage::disk('public')->exists($metodeBayar->url_logo)) {
                Storage::disk('public')->delete($metodeBayar->url_logo);
            }
            $validated['url_logo'] = $request->file('url_logo')->store('metode-bayar-logos', 'public');
        } else {
            unset($validated['url_logo']);
        }

        $metodeBayar->update($validated);
        return redirect()->route('metode-bayar.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui');
    }

    public function destroy(MetodeBayar $metodeBayar)
    {
        $metodeBayar->delete();
        return redirect()->route('metode-bayar.index')
            ->with('success', 'Metode pembayaran berhasil dihapus');
    }
}
