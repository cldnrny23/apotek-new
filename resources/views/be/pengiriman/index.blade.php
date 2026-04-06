@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Pengiriman</h5>
                @if(in_array(auth()->user()->jabatan, ['admin', 'karyawan', 'kurir']))
                    <a href="{{ route('pengiriman.create') }}" class="btn btn-primary">Tambah Pengiriman</a>
                @endif
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Invoice</th>
                            <th>Tanggal Kirim</th>
                            <th>Status</th>
                            <th>Kurir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengirimans as $pengiriman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pengiriman->no_invoice }}</td>
                            <td>{{ $pengiriman->tgl_kirim ? \Carbon\Carbon::parse($pengiriman->tgl_kirim)->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $pengiriman->status_kirim }}</td>
                            <td>{{ $pengiriman->nama_kurir }}</td>
                            <td>
                                @if(in_array(auth()->user()->jabatan, ['admin', 'karyawan', 'kurir']))
                                    <a href="{{ route('pengiriman.edit', $pengiriman->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                @endif
                                @if(in_array(auth()->user()->jabatan, ['admin', 'karyawan']))
                                    <form action="{{ route('pengiriman.destroy', $pengiriman->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $pengirimans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
