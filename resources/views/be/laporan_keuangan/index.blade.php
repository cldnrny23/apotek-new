@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection

@section('content')
<div class="container-fluid" style="margin: 20px;">
    <h2 class="mb-4">Laporan Keuangan</h2>

    <!-- Filter Section -->
    <div class="card border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" value="{{ $tahun }}" class="form-control" min="2020" max="2099">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-control">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromFormat('m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="text-muted">Total Pendapatan</h6>
                    <h3 class="text-success">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
                    <small class="text-muted">Penjualan + Ongkos Kirim + Biaya App</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="text-muted">Total Pengeluaran</h6>
                    <h3 class="text-danger">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</h3>
                    <small class="text-muted">Pembelian Obat</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="text-muted">Laba Bersih</h6>
                    <h3 class="{{ $laba_bersih >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp {{ number_format($laba_bersih, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Pendapatan - Pengeluaran</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="text-muted">Jumlah Transaksi</h6>
                    <h3>{{ $penjualan->count() + $pembelian->count() }}</h3>
                    <small class="text-muted">{{ $penjualan->count() }} Penjualan + {{ $pembelian->count() }} Pembelian</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Summary -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Rincian Pendapatan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Penjualan (Harga Obat):</span>
                            <strong>Rp {{ number_format($total_penjualan, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim:</span>
                            <strong>Rp {{ number_format($total_ongkos_kirim, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Biaya App/Admin:</span>
                            <strong>Rp {{ number_format($total_biaya_app, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total Pendapatan:</strong>
                        <strong class="text-success">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Rincian Pengeluaran</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Pembelian Obat:</span>
                            <strong>Rp {{ number_format($total_pembelian, 0, ',', '.') }}</strong>
                        </div>
                        <small class="text-muted">Dari {{ $pembelian->count() }} transaksi pembelian</small>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total Pengeluaran:</strong>
                        <strong class="text-danger">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Daftar Penjualan ({{ $penjualan->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    @if($penjualan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penjualan as $pj)
                                        <tr>
                                            <td><small>{{ $pj->tgl_penjualan ? $pj->tgl_penjualan->format('d M Y') : 'N/A' }}</small></td>
                                            <td><small>{{ $pj->pelanggan->nama_pelanggan ?? 'N/A' }}</small></td>
                                            <td class="text-end"><small>Rp {{ number_format($pj->total_bayar, 0, ',', '.') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="2">Total:</th>
                                        <th class="text-end">Rp {{ number_format($total_penjualan, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            Belum ada data penjualan untuk bulan ini
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Daftar Pembelian ({{ $pembelian->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    @if($pembelian->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Distributor</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pembelian as $pb)
                                        <tr>
                                            <td><small>{{ $pb->tgl_pembelian }}</small></td>
                                            <td><small>{{ $pb->distributor->nama_distributor ?? 'N/A' }}</small></td>
                                            <td class="text-end"><small>Rp {{ number_format($pb->total_bayar, 0, ',', '.') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="2">Total:</th>
                                        <th class="text-end">Rp {{ number_format($total_pembelian, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            Belum ada data pembelian untuk bulan ini
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.5rem !important;
    }
</style>
@endsection
