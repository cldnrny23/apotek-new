@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Penjualan</h5>
                <div>
                    <span class="badge bg-info me-2">
                        <i class="fas fa-user-circle me-1"></i>{{ ucfirst(Auth::user()->jabatan) }}
                    </span>
                    @if(Auth::user()->jabatan === 'admin' || Auth::user()->jabatan === 'apoteker' || Auth::user()->jabatan === 'kasir' || Auth::user()->jabatan === 'pemilik')
                        <a href="{{ route('penjualans.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Tambah Penjualan
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info alert-dismissible fade show">
                <i class="fas fa-lightbulb me-2"></i>
                <strong>Alur Konfirmasi Pesanan:</strong>
                Pelanggan checkout → <strong>Menunggu Konfirmasi</strong> →
                Pelanggan konfirmasi pembayaran di FE → <strong>Menunggu Konfirmasi</strong> →
                <span class="badge bg-primary">Admin</span>
                <span class="badge bg-success">Apoteker</span>
                <span class="badge bg-info">Kasir</span>
                <span class="badge bg-warning text-dark">Pemilik</span>
                konfirmasi pesanan → <strong>Diproses</strong> + Pengiriman dibuat otomatis
                <button type="button" class="btn-close close" data-bs-dismiss="alert"></button>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Metode Bayar</th>
                            <th>Status</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualans as $index => $penjualan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $penjualan->tgl_penjualan ? $penjualan->tgl_penjualan->format('d M Y H:i') : 'N/A' }}</td>
                            <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                            <td>{{ $penjualan->metodeBayar->metode_pembayaran }}</td>
                            <td>
                                @if($penjualan->status_order === 'Menunggu Konfirmasi')
                                    <span class="badge bg-warning text-dark">{{ $penjualan->status_order }}</span>
                                @elseif($penjualan->status_order === 'Diproses')
                                    <span class="badge bg-primary">{{ $penjualan->status_order }}</span>
                                @elseif($penjualan->status_order === 'Selesai')
                                    <span class="badge bg-success">{{ $penjualan->status_order }}</span>
                                @elseif(strpos($penjualan->status_order, 'Batal') !== false)
                                    <span class="badge bg-danger">{{ $penjualan->status_order }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $penjualan->status_order }}</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($penjualan->status_order === 'Menunggu Konfirmasi')
                                    <form action="{{ route('penjualans.confirm', $penjualan->id) }}" method="POST" class="d-inline" title="Konfirmasi dan mulai proses pesanan">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pesanan ini dan buat pengiriman?')">
                                            <i class="fas fa-check"></i> Konfirmasi Pesanan
                                        </button>
                                    </form>
                                @endif

                                @if(in_array(Auth::user()->jabatan, ['admin', 'kasir', 'pemilik']) && !in_array($penjualan->status_order, ['Menunggu Kurir', 'Selesai', 'Dibatalkan Penjual', 'Dibatalkan Pembeli']))
                                    <form action="{{ route('penjualans.cancel', $penjualan->id) }}" method="POST" class="d-inline" title="Batalkan pesanan">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            <i class="fas fa-times"></i> Batalkan
                                        </button>
                                    </form>
                                @endif

                                @if(in_array(Auth::user()->jabatan, ['admin', 'apoteker', 'kasir', 'pemilik']))
                                    <a href="{{ route('penjualans.edit', $penjualan->id) }}" class="btn btn-sm btn-primary" title="Edit pesanan">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endif
                                @if(in_array(Auth::user()->jabatan, ['admin', 'pemilik']))
                                    <form action="{{ route('penjualans.destroy', $penjualan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus pesanan">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data penjualan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
