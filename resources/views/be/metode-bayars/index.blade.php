@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Metode Pembayaran</h5>
                <a href="{{ route('metode-bayar.create') }}" class="btn btn-primary">Tambah Metode Bayar</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Metode</th>
                            <th>Tempat Bayar</th>
                            <th>No Rekening</th>
                            <th>Logo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($metodeBayars as $metode)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $metode->metode_pembayaran }}</td>
                            <td>{{ $metode->tempat_bayar }}</td>
                            <td>{{ $metode->no_rekening }}</td>
                            <td>
                                <img src="{{ strpos($metode->url_logo, 'http://') === 0 || strpos($metode->url_logo, 'https://') === 0 ? $metode->url_logo : asset('storage/' . $metode->url_logo) }}" alt="Logo {{ $metode->metode_pembayaran }}" style="max-width: 100px; max-height: 50px; object-fit: contain;">
                            </td>
                            <td>
                                <a href="{{ route('metode-bayar.edit', $metode->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('metode-bayar.destroy', $metode->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus metode ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada metode pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
