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
                <strong>🔄 Alur Konfirmasi Pesanan & Pengiriman:</strong><br>
                <small>
                    1️⃣ Pelanggan checkout → <code>Menunggu Pembayaran</code><br>
                    2️⃣ Pelanggan bayar di Midtrans → <code>Menunggu Konfirmasi</code> <span class="badge bg-success">✅ PEMBAYARAN BERHASIL</span> (baris hijau)<br>
                    3️⃣ <span class="badge bg-success">Kasir</span><span class="badge bg-info">Apoteker</span><span class="badge bg-primary">Admin</span><span class="badge bg-warning text-dark">Pemilik</span>
                    klik <code>KONFIRMASI</code> → <code>Diproses</code> + Pengiriman dibuat otomatis untuk karyawan kurirnya
                </small>
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
                            <th>Keterangan</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualans as $index => $penjualan)
                        <tr @if($penjualan->status_order === 'Menunggu Konfirmasi' && str_contains($penjualan->keterangan_status ?? '', 'BERHASIL')) class="table-success" @endif>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $penjualan->tgl_penjualan ? $penjualan->tgl_penjualan->format('d M Y H:i') : 'N/A' }}</td>
                            <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                            <td>{{ $penjualan->metodeBayar->metode_pembayaran }}</td>
                            <td>
                                @if($penjualan->status_order === 'Menunggu Konfirmasi Pembayaran')
                                    <span class="badge bg-warning text-dark">⏳ Menunggu Pembayaran</span>
                                @elseif($penjualan->status_order === 'Menunggu Konfirmasi')
                                    @if(str_contains($penjualan->keterangan_status ?? '', 'BERHASIL'))
                                        <span class="badge bg-success text-white">✅ PEMBAYARAN BERHASIL</span>
                                    @else
                                        <span class="badge bg-warning text-dark">⏳ Menunggu Konfirmasi</span>
                                    @endif
                                @elseif($penjualan->status_order === 'Diproses')
                                    <span class="badge bg-primary">▶️ Diproses</span>
                                @elseif($penjualan->status_order === 'Menunggu Kurir')
                                    <span class="badge bg-info">📦 Menunggu Kurir</span>
                                @elseif($penjualan->status_order === 'Selesai')
                                    <span class="badge bg-success">✔️ Selesai</span>
                                @elseif(str_contains($penjualan->status_order, 'Batal'))
                                    <span class="badge bg-danger">❌ {{ $penjualan->status_order }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $penjualan->status_order }}</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $penjualan->keterangan_status }}</small>
                            </td>
                            <td>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($penjualan->status_order === 'Menunggu Konfirmasi' && str_contains($penjualan->keterangan_status ?? '', 'BERHASIL'))
                                    <form action="{{ route('penjualans.confirm', $penjualan->id) }}" method="POST" class="d-inline" title="Konfirmasi pembayaran dan lanjut ke pengiriman">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success fw-bold" onclick="return confirm('Konfirmasi pembayaran ini dan buat pengiriman?')">
                                            <i class="fas fa-thumbs-up"></i> KONFIRMASI
                                        </button>
                                    </form>
                                @elseif($penjualan->status_order === 'Menunggu Konfirmasi Pembayaran')
                                    <button type="button" class="btn btn-sm btn-secondary" disabled title="Menunggu pelanggan bayar">
                                        <i class="fas fa-hourglass-half"></i> Menunggu Bayar
                                    </button>
                                @elseif($penjualan->status_order === 'Menunggu Konfirmasi')
                                    <form action="{{ route('penjualans.confirm', $penjualan->id) }}" method="POST" class="d-inline" title="Konfirmasi dan mulai proses pesanan">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pesanan ini dan buat pengiriman?')">
                                            <i class="fas fa-check"></i> Konfirmasi
                                        </button>
                                    </form>
                                @endif

                                @if(in_array(Auth::user()->jabatan, ['admin', 'kasir', 'pemilik']) && !in_array($penjualan->status_order, ['Menunggu Kurir', 'Selesai', 'Dibatalkan Penjual', 'Dibatalkan Pembeli']))
                                    <form action="{{ route('penjualans.cancel', $penjualan->id) }}" method="POST" class="d-inline" title="Batalkan pesanan">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif

                                @if(in_array(Auth::user()->jabatan, ['admin', 'apoteker', 'kasir', 'pemilik']))
                                    <a href="{{ route('penjualans.edit', $penjualan->id) }}" class="btn btn-sm btn-info" title="Edit pesanan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if(in_array(Auth::user()->jabatan, ['admin', 'pemilik']))
                                    <form action="{{ route('penjualans.destroy', $penjualan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus pesanan">
                                            <i class="fas fa-trash"></i>
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
