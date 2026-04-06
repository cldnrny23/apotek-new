<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Obat;
use App\Models\MetodeBayar;
use App\Models\JenisPengiriman;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    private function getPelangganId()
    {
        return Auth::guard('pelanggan')->check() ? Auth::guard('pelanggan')->id() : null;
    }

    private function getCartFromDatabase()
    {
        $pelangganId = $this->getPelangganId();

        if (!$pelangganId) {
            return [];
        }

        return Keranjang::with('obat')
            ->where('id_pelanggan', $pelangganId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->id_obat,
                    'name' => $item->obat?->nama_obat ?? 'Produk tidak ditemukan',
                    'price' => $item->harga,
                    'quantity' => $item->jumlah,
                    'image' => $item->obat?->foto1,
                    'stock' => $item->obat?->stok ?? 0,
                    'is_keras' => str_contains(strtolower($item->obat?->nama_obat ?? ''), 'keras') ||
                                 str_contains(strtolower($item->obat?->nama_obat ?? ''), 'resep') ||
                                 str_contains(strtolower($item->obat?->nama_obat ?? ''), 'narkotika'),
                ];
            })


            ->toArray();
    }

    private function getCartItems()
    {
        if (Auth::guard('pelanggan')->check()) {
            return $this->getCartFromDatabase();
        }

        return session()->get('cart', []);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = $this->getCartItems();
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('fe.keranjang.index', [
            'title' => 'cart',
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function checkout()
    {
        $checkout_items = $this->getCartItems();
        $total_price = collect($checkout_items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $metode_bayars = MetodeBayar::all();
        $jenis_pengirimans = JenisPengiriman::all();

        // Check if any item is obat keras (temporary: check if name contains 'keras' or similar)
        $has_obat_keras = collect($checkout_items)->contains(function ($item) {
            return str_contains(strtolower($item['name']), 'keras') ||
                   str_contains(strtolower($item['name']), 'resep') ||
                   str_contains(strtolower($item['name']), 'narkotika');
        });

        return view('fe.checkout.index', [
            'title' => 'checkout',
            'checkout_items' => $checkout_items,
            'total_price' => $total_price,
            'metode_bayars' => $metode_bayars,
            'jenis_pengirimans' => $jenis_pengirimans,
            'has_obat_keras' => $has_obat_keras,
        ]);
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'id_jenis_kirim' => 'required|exists:jenis_pengirimans,id',
            'id_metode_bayar' => 'required|exists:metode_bayars,id',
            'ongkir' => 'required|numeric|min:0',
            'total_bayar' => 'required|numeric|min:0',
            'produk' => 'required|json',
            'url_resep' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        // Parse produk JSON
        $produkData = json_decode($request->produk, true);

        // Handle resep upload if provided
        $resepPath = null;
        if ($request->hasFile('url_resep')) {
            $resepPath = $request->file('url_resep')->store('reseps', 'public');
        }

        // Get pengiriman details
        $jenisPengiriman = JenisPengiriman::findOrFail($request->id_jenis_kirim);
        $metodeBayar = MetodeBayar::findOrFail($request->id_metode_bayar);

        // Create Penjualan record
        $penjualan = Penjualan::create([
            'id_metode_bayar' => $request->id_metode_bayar,
            'tgl_penjualan' => now(),
            'url_resep' => $resepPath,
            'ongkos_kirim' => $request->ongkir,
            'biaya_app' => 0,
            'total_bayar' => $request->total_bayar,
            'status_order' => 'Menunggu Konfirmasi Pembayaran',
            'keterangan_status' => 'Pesanan dibuat, menunggu pembayaran pelanggan',
            'id_jenis_kirim' => $request->id_jenis_kirim,
            'id_pelanggan' => $this->getPelangganId(),
        ]);

        // Create DetailPenjualan records
        foreach ($produkData as $produk) {
            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id,
                'id_obat' => $produk['id'],
                'jumlah_beli' => $produk['qty'],
                'harga_beli' => $produk['price'],
                'subtotal' => $produk['price'] * $produk['qty'],
            ]);

            // Update stock
            $obat = Obat::find($produk['id']);
            if ($obat) {
                $obat->decrement('stok', $produk['qty']);
            }
        }

        // Clear cart
        if (Auth::guard('pelanggan')->check()) {
            Keranjang::where('id_pelanggan', $this->getPelangganId())->delete();
        } else {
            session()->forget('cart');
        }

        return redirect()->route('payment.show', $penjualan->id)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran sesuai metode yang dipilih.');
    }

    public function showPayment($penjualanId)
    {
        $penjualan = Penjualan::with(['metodeBayar', 'jenisPengiriman', 'pelanggan', 'detailPenjualans.obat'])
            ->findOrFail($penjualanId);

        // Ensure the penjualan belongs to the current user
        if ($penjualan->id_pelanggan !== $this->getPelangganId()) {
            abort(403, 'Unauthorized');
        }

        // Jika belum ada snap_token, buat transaksi Midtrans
        if (!$penjualan->snap_token) {
            $midtransController = new \App\Http\Controllers\MidtransController();
            $response = $midtransController->createTransaction($penjualanId);

            if ($response->getStatusCode() == 200) {
                $penjualan->refresh(); // Refresh untuk mendapatkan snap_token yang baru
            }
        }

        // Sinkronisasi status Midtrans bila order sudah pernah dibuat
        if ($penjualan->midtrans_order_id) {
            $midtransController = new \App\Http\Controllers\MidtransController();
            $midtransController->syncTransactionStatus($penjualan->midtrans_order_id);
            $penjualan->refresh();
        }

        return view('fe.payment.show', compact('penjualan'));
    }

    public function paymentSuccess($penjualanId)
    {
        $penjualan = Penjualan::with(['metodeBayar', 'jenisPengiriman', 'pelanggan', 'detailPenjualans.obat'])
            ->findOrFail($penjualanId);

        if ($penjualan->id_pelanggan !== $this->getPelangganId()) {
            abort(403, 'Unauthorized');
        }

        if ($penjualan->midtrans_order_id) {
            $midtransController = new \App\Http\Controllers\MidtransController();
            $midtransController->syncTransactionStatus($penjualan->midtrans_order_id);
            $penjualan->refresh();
        }

        return view('fe.payment.success', compact('penjualan'));
    }

    public function confirmPayment($penjualanId)
    {
        $penjualan = Penjualan::findOrFail($penjualanId);

        // Ensure the penjualan belongs to the current user
        if ($penjualan->id_pelanggan !== $this->getPelangganId()) {
            abort(403, 'Unauthorized');
        }

        // Update status to indicate payment has been confirmed by customer
        $penjualan->update([
            'status_order' => 'Menunggu Konfirmasi',
            'keterangan_status' => 'Pembayaran telah dilakukan oleh pelanggan, menunggu verifikasi admin'
        ]);

        return redirect()->route('home')->with('success', 'Pembayaran berhasil dikonfirmasi! Admin akan memproses pesanan Anda dalam 1x24 jam.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:obats,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Obat::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        if (Auth::guard('pelanggan')->check()) {
            $pelangganId = $this->getPelangganId();
            $cartItem = Keranjang::where('id_pelanggan', $pelangganId)
                ->where('id_obat', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->jumlah += $quantity;
                $cartItem->save();
            } else {
                Keranjang::create([
                    'id_pelanggan' => $pelangganId,
                    'id_obat' => $product->id,
                    'harga' => $product->harga_jual,
                    'jumlah' => $quantity,
                ]);
            }

            $cartCount = Keranjang::where('id_pelanggan', $pelangganId)->sum('jumlah');
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->nama_obat,
                    'price' => $product->harga_jual,
                    'quantity' => $quantity,
                    'image' => $product->foto1,
                    'stock' => $product->stok,
                ];
            }

            session()->put('cart', $cart);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang.',
                'cartCount' => $cartCount,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = (int) $request->quantity;

        if (Auth::guard('pelanggan')->check()) {
            $pelangganId = $this->getPelangganId();
            $cartItem = Keranjang::where('id_pelanggan', $pelangganId)
                ->where(function ($query) use ($id) {
                    $query->where('id', $id)
                        ->orWhere('id_obat', $id);
                })
                ->first();

            if ($cartItem) {
                $cartItem->jumlah = $quantity;
                $cartItem->save();
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah keranjang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::guard('pelanggan')->check()) {
            $pelangganId = $this->getPelangganId();
            $cartItem = Keranjang::where('id_pelanggan', $pelangganId)
                ->where(function ($query) use ($id) {
                    $query->where('id', $id)
                        ->orWhere('id_obat', $id);
                })
                ->first();

            if ($cartItem) {
                $cartItem->delete();
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function cancelOrder($penjualanId)
    {
        $penjualan = Penjualan::findOrFail($penjualanId);

        // Ensure the penjualan belongs to the current user
        if ($penjualan->id_pelanggan !== $this->getPelangganId()) {
            abort(403, 'Unauthorized');
        }

        // Check if order can be cancelled (only if not already processed)
        if (in_array($penjualan->status_order, ['Diproses', 'Menunggu Kurir', 'Selesai'])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        // Update status to cancelled by customer
        $penjualan->update([
            'status_order' => 'Dibatalkan Pembeli',
            'keterangan_status' => 'Pesanan dibatalkan oleh pelanggan'
        ]);

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
