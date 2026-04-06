@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Edit Penjualan</h5>
                <span class="badge bg-info">
                    <i class="fas fa-user-circle me-1"></i>
                    {{ ucfirst(Auth::user()->jabatan) }}
                </span>
            </div>
        </div>
        <div class="card-body">
            @if($penjualan->status_order === 'Menunggu Konfirmasi')
                <div class="alert alert-warning alert-dismissible fade show">
                    <i class="fas fa-hourglass-half me-2"></i>
                    <strong>Status Menunggu Konfirmasi</strong><br>
                    Pesanan ini menunggu pelanggan untuk mengkonfirmasi pembayaran. Silakan hubungi pelanggan jika diperlukan.
                </div>
            @endif
                <div class="alert alert-info alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Pesanan Siap Dikonfirmasi</strong><br>
                    Pelanggan telah mengkonfirmasi pembayaran. Verifikasi pembayaran dan lanjutkan proses pesanan.
                </div>
            @endif
            <form action="{{ route('penjualans.update', $penjualan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tgl_penjualan" class="form-label">Tanggal Penjualan</label>
                            <input type="date" class="form-control @error('tgl_penjualan') is-invalid @enderror"
                                id="tgl_penjualan" name="tgl_penjualan" value="{{ old('tgl_penjualan', $penjualan->tgl_penjualan ? $penjualan->tgl_penjualan->format('Y-m-d') : '') }}">
                            @error('tgl_penjualan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="url_resep" class="form-label">URL Resep</label>
                            <input type="text" class="form-control @error('url_resep') is-invalid @enderror"
                                id="url_resep" name="url_resep" value="{{ old('url_resep', $penjualan->url_resep) }}">
                            @error('url_resep')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_pelanggan" class="form-label">Pelanggan</label>
                            <select class="form-select @error('id_pelanggan') is-invalid @enderror"
                                id="id_pelanggan" name="id_pelanggan">
                                <option value="">Pilih Pelanggan</option>
                                @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}"
                                        {{ old('id_pelanggan', $penjualan->id_pelanggan) == $pelanggan->id ? 'selected' : '' }}>
                                        {{ $pelanggan->nama_pelanggan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_metode_bayar" class="form-label">Metode Pembayaran</label>
                            <select class="form-select @error('id_metode_bayar') is-invalid @enderror"
                                id="id_metode_bayar" name="id_metode_bayar">
                                <option value="">Pilih Metode Pembayaran</option>
                                @foreach($metodeBayars as $metode)
                                    <option value="{{ $metode->id }}"
                                        {{ old('id_metode_bayar', $penjualan->id_metode_bayar) == $metode->id ? 'selected' : '' }}>
                                        {{ $metode->nama_metode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_metode_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_jenis_kirim" class="form-label">Jenis Pengiriman</label>
                            <select class="form-select @error('id_jenis_kirim') is-invalid @enderror"
                                id="id_jenis_kirim" name="id_jenis_kirim">
                                <option value="">Pilih Jenis Pengiriman</option>
                                @foreach($jenisPengirimans as $jenisPengiriman)
                                    <option value="{{ $jenisPengiriman->id }}"
                                        {{ old('id_jenis_kirim', $penjualan->id_jenis_kirim) == $jenisPengiriman->id ? 'selected' : '' }}>
                                        {{ $jenisPengiriman->nama_ekspedisi }} — {{ $jenisPengiriman->jenis_kirim }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jenis_kirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ongkos_kirim" class="form-label">Ongkos Kirim</label>
                            <input type="number" class="form-control @error('ongkos_kirim') is-invalid @enderror"
                                id="ongkos_kirim" name="ongkos_kirim" value="{{ old('ongkos_kirim', $penjualan->ongkos_kirim) }}">
                            @error('ongkos_kirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="biaya_app" class="form-label">Biaya Aplikasi</label>
                            <input type="number" class="form-control @error('biaya_app') is-invalid @enderror"
                                id="biaya_app" name="biaya_app" value="{{ old('biaya_app', $penjualan->biaya_app) }}">
                            @error('biaya_app')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="total_bayar" class="form-label">Total Bayar</label>
                            <input type="number" class="form-control @error('total_bayar') is-invalid @enderror"
                                id="total_bayar" name="total_bayar" value="{{ old('total_bayar', $penjualan->total_bayar) }}">
                            @error('total_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status_order" class="form-label">Status Order</label>
                    <select class="form-select @error('status_order') is-invalid @enderror"
                        id="status_order" name="status_order">
                        <option value="">Pilih Status</option>
                        @foreach(['Menunggu Konfirmasi', 'Diproses', 'Menunggu Kurir', 'Dibatalkan Pembeli',
                                'Dibatalkan Penjual', 'Bermasalah', 'Selesai'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status_order', $penjualan->status_order) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan_status" class="form-label">Keterangan Status</label>
                    <textarea class="form-control @error('keterangan_status') is-invalid @enderror"
                        id="keterangan_status" name="keterangan_status" rows="3">{{ old('keterangan_status', $penjualan->keterangan_status) }}</textarea>
                    @error('keterangan_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <a href="{{ route('penjualans.index') }}" class="btn btn-secondary me-2">Batal</a>
                    @if($penjualan->awaitingPaymentVerification())
                        <form action="{{ route('penjualans.confirm', $penjualan->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success me-2" onclick="return confirm('Konfirmasi pesanan ini dan mulai proses?')">
                                <i class="fas fa-check-circle me-1"></i>Konfirmasi & Proses
                            </button>
                        </form>
                    @endif
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

            <div class="mt-4 pt-4 border-top">
                <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Panduan Konfirmasi Pesanan</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Status: Menunggu Konfirmasi</h6>
                                <p class="card-text small">Pesanan dibuat, menunggu pelanggan mengkonfirmasi pembayaran di halaman pembayaran.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Status: Menunggu Konfirmasi</h6>
                                <p class="card-text small"><strong>Role yang dapat mengkonfirmasi:</strong></p>
                                <ul class="small mb-0">
                                    <li><span class="badge bg-primary">Admin</span></li>
                                    <li><span class="badge bg-success">Apoteker</span></li>
                                    <li><span class="badge bg-info">Kasir</span></li>
                                    <li><span class="badge bg-warning text-dark">Pemilik</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Status: Diproses</h6>
                                <p class="card-text small">Admin/Apoteker memverifikasi pembayaran dan mulai memproses pesanan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Hak Akses Per Role</h6>
                                <ul class="small mb-0">
                                    <li><strong>Edit:</strong> Admin, Apoteker, Kasir, Pemilik</li>
                                    <li><strong>Hapus:</strong> Admin, Pemilik (saja)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
