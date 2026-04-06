@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Kurir</h5>
                <a href="{{ route('kurir.create') }}" class="btn btn-primary">Tambah Kurir</a>
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
                            <th>Nama Kurir</th>
                            <th>Telpon</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kurirs as $kurir)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kurir->nama_kurir }}</td>
                            <td>{{ $kurir->telpon_kurir }}</td>
                            <td>{{ $kurir->alamat ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $kurir->status === 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $kurir->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('kurir.edit', $kurir->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('kurir.destroy', $kurir->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $kurirs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
