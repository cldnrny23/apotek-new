@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Tambah Metode Pembayaran</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('metode-bayar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Nama Metode Pembayaran</label>
                            <input type="text" name="metode_pembayaran" id="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror" value="{{ old('metode_pembayaran') }}" required>
                            @error('metode_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tempat_bayar" class="form-label">Tempat Bayar</label>
                            <input type="text" name="tempat_bayar" id="tempat_bayar" class="form-control @error('tempat_bayar') is-invalid @enderror" value="{{ old('tempat_bayar') }}" required>
                            @error('tempat_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_rekening" class="form-label">No Rekening</label>
                            <input type="text" name="no_rekening" id="no_rekening" class="form-control @error('no_rekening') is-invalid @enderror" value="{{ old('no_rekening') }}" required>
                            @error('no_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="url_logo" class="form-label">Logo Pembayaran</label>
                            <input type="file" name="url_logo" id="url_logo" class="form-control @error('url_logo') is-invalid @enderror" required>
                            @error('url_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('metode-bayar.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
