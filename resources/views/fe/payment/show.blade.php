@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('checkout')

{{-- ===== Hero Banner ===== --}}
<div class="chk-hero">
    <div class="chk-hero__bg-orb chk-hero__bg-orb--1"></div>
    <div class="chk-hero__bg-orb chk-hero__bg-orb--2"></div>
    <div class="chk-hero__grid"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="chk-hero__inner">
            <div class="chk-hero__eyebrow">
                <span class="chk-hero__eyebrow-dot"></span>
                Apotek Medicare
            </div>
            <h1 class="chk-hero__title">
                <i class="fas fa-credit-card me-2"></i>
                Halaman <span class="chk-hero__title-accent">Pembayaran</span>
            </h1>
            <p class="chk-hero__desc">Lakukan pembayaran sesuai instruksi di bawah ini. Pesanan akan diproses setelah pembayaran dikonfirmasi.</p>
            <div class="chk-hero__badges">
                <span class="chk-hero__badge"><i class="fas fa-lock"></i> Transaksi Aman</span>
                <span class="chk-hero__badge"><i class="fas fa-clock"></i> Konfirmasi Cepat</span>
                <span class="chk-hero__badge"><i class="fas fa-headset"></i> Dukungan 24/7</span>
            </div>
        </div>
    </div>
</div>

{{-- ===== Payment Area ===== --}}
<div class="chk-main">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            {{-- ===== Order Summary ===== --}}
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <strong>No. Invoice:</strong><br>
                                <span class="text-primary">#{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="col-sm-6">
                                <strong>Tanggal Pesanan:</strong><br>
                                {{ $penjualan->tgl_penjualan ? $penjualan->tgl_penjualan->format('d M Y H:i') : 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <strong>Status Pesanan:</strong><br>
                                <span class="badge bg-warning">{{ $penjualan->status_order }}</span>
                            </div>
                            <div class="col-sm-6">
                                <strong>Metode Pembayaran:</strong><br>
                                {{ $penjualan->metodeBayar->metode_pembayaran }}
                            </div>
                        </div>

                        {{-- Products List --}}
                        <div class="table-responsive">
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $detail->obat->gambar) }}"
                                                     alt="{{ $detail->obat->nama_obat }}"
                                                     class="rounded me-3"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <strong>{{ $detail->obat->nama_obat }}</strong>
                                                    @if($detail->obat->kategori)
                                                        <br><small class="text-muted">{{ $detail->obat->kategori }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $detail->jumlah_beli }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Ongkos Kirim:</strong></td>
                                        <td class="text-end">Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Biaya Aplikasi:</strong></td>
                                        <td class="text-end">Rp {{ number_format($penjualan->biaya_app, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td colspan="3" class="text-end"><strong>Total Bayar:</strong></td>
                                        <td class="text-end"><strong>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== Payment Instructions ===== --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-money-bill-wave me-2"></i>Instruksi Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-primary">{{ $penjualan->metodeBayar->metode_pembayaran }}</h6>
                            @if($penjualan->metodeBayar->no_rekening)
                                <p class="mb-1"><strong>No. Rekening:</strong></p>
                                <div class="bg-light p-2 rounded text-center">
                                    <strong class="text-primary fs-5">{{ $penjualan->metodeBayar->no_rekening }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <h6>Tempat Pembayaran:</h6>
                            <p>{{ $penjualan->metodeBayar->tempat_bayar }}</p>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Harap transfer sesuai nominal yang tertera.
                            Pesanan akan diproses setelah pembayaran dikonfirmasi oleh admin.
                        </div>

                        <div class="d-grid gap-2">
                            <form action="{{ route('payment.confirm', $penjualan->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mb-2"
                                        onclick="return confirm('Apakah Anda sudah melakukan pembayaran?')">
                                    <i class="fas fa-check-circle me-2"></i>Saya Sudah Bayar
                                </button>
                            </form>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>Kembali ke Beranda
                            </a>
                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20sudah%20transfer%20untuk%20pesanan%20%23{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }}"
                               class="btn btn-success" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>Konfirmasi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Shipping Info --}}
                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-shipping-fast me-2"></i>Info Pengiriman
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Ekspedisi:</strong></p>
                        <p>{{ $penjualan->jenisPengiriman->nama_ekspedisi }} - {{ $penjualan->jenisPengiriman->jenis_kirim }}</p>

                        <p class="mb-1"><strong>Ongkos Kirim:</strong></p>
                        <p>Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
