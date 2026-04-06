@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('checkout')

<div class="chk-hero">
    <div class="chk-hero__bg-orb chk-hero__bg-orb--1"></div>
    <div class="chk-hero__bg-orb chk-hero__bg-orb--2"></div>
    <div class="chk-hero__grid"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="chk-hero__inner text-center">
            <div class="chk-hero__eyebrow">
                <span class="chk-hero__eyebrow-dot"></span>
                Apotek Medicare
            </div>
            <h1 class="chk-hero__title">
                <i class="fas fa-check-circle me-2"></i>
                Pembayaran <span class="chk-hero__title-accent">Berhasil</span>
            </h1>
            <p class="chk-hero__desc">Terima kasih, pembayaran Anda telah berhasil diproses. Silakan simpan detail pesanan berikut untuk referensi.</p>
        </div>
    </div>
</div>

<div class="chk-main">
    <div class="container">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="alert alert-success mb-4" role="alert">
                    <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i> Pembayaran Sukses!</h4>
                    <p>Pembayaran Anda berhasil diterima. Pesanan akan diproses secepatnya.</p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h5>Informasi Pesanan</h5>
                            <p class="mb-1"><strong>No. Invoice:</strong> #{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }}</p>
                            <p class="mb-1"><strong>Tanggal:</strong> {{ $penjualan->tgl_penjualan ? $penjualan->tgl_penjualan->format('d M Y H:i') : 'N/A' }}</p>
                            <p class="mb-1"><strong>Status:</strong> {{ $penjualan->status_order }}</p>
                            <p class="mb-1"><strong>Metode Pembayaran:</strong> {{ $penjualan->metodeBayar->metode_pembayaran }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h5>Ringkasan</h5>
                            <p class="mb-1"><strong>Total Produk:</strong> {{ count($penjualan->detailPenjualans) }} item</p>
                            <p class="mb-1"><strong>Ongkos Kirim:</strong> Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</p>
                            <p class="mb-1"><strong>Total Bayar:</strong> <strong>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</strong></p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->detailPenjualans as $detail)
                                <tr>
                                    <td>{{ $detail->obat->nama_obat }}</td>
                                    <td class="text-center">{{ $detail->jumlah_beli }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                    <a href="{{ route('payment.show', $penjualan->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
