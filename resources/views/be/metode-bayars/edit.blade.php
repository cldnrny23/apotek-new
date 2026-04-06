@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Edit Metode Pembayaran</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('metode-bayar.update', $metodeBayar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Nama Metode Pembayaran</label>
                            <input type="text" name="metode_pembayaran" id="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror" value="{{ old('metode_pembayaran', $metodeBayar->metode_pembayaran) }}" required>
                            @error('metode_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tempat_bayar" class="form-label">Tempat Bayar</label>
                            <input type="text" name="tempat_bayar" id="tempat_bayar" class="form-control @error('tempat_bayar') is-invalid @enderror" value="{{ old('tempat_bayar', $metodeBayar->tempat_bayar) }}" required>
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
                            <input type="text" name="no_rekening" id="no_rekening" class="form-control @error('no_rekening') is-invalid @enderror" value="{{ old('no_rekening', $metodeBayar->no_rekening) }}" required>
                            @error('no_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="midtrans_payment_type" class="form-label">Midtrans Payment Type</label>
                            <select name="midtrans_payment_type" id="midtrans_payment_type" class="form-select @error('midtrans_payment_type') is-invalid @enderror">
                                <option value="">-- Tidak terintegrasi Midtrans --</option>
                                <option value="bank_transfer" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="permata_va" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'permata_va' ? 'selected' : '' }}>Permata VA</option>
                                <option value="bca_va" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'bca_va' ? 'selected' : '' }}>BCA VA</option>
                                <option value="bni_va" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'bni_va' ? 'selected' : '' }}>BNI VA</option>
                                <option value="bri_va" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'bri_va' ? 'selected' : '' }}>BRI VA</option>
                                <option value="gopay" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'gopay' ? 'selected' : '' }}>GoPay</option>
                                <option value="ovo" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'ovo' ? 'selected' : '' }}>OVO</option>
                                <option value="shopeepay" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'shopeepay' ? 'selected' : '' }}>ShopeePay</option>
                                <option value="qris" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'qris' ? 'selected' : '' }}>QRIS</option>
                                <option value="credit_card" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="echannel" {{ old('midtrans_payment_type', $metodeBayar->midtrans_payment_type) === 'echannel' ? 'selected' : '' }}>Mandiri Bill / E-Channel</option>
                            </select>
                            @error('midtrans_payment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="mb-3">
                            <label for="url_logo" class="form-label">Logo Pembayaran</label>
                            <input type="file" name="url_logo" id="url_logo" class="form-control @error('url_logo') is-invalid @enderror">
                            @error('url_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($metodeBayar->url_logo)
                            <div class="mb-3">
                                <label class="form-label">Logo Saat Ini</label>
                                <div>
                                    <img src="{{ strpos($metodeBayar->url_logo, 'http://') === 0 || strpos($metodeBayar->url_logo, 'https://') === 0 ? $metodeBayar->url_logo : asset('storage/' . $metodeBayar->url_logo) }}" alt="Logo {{ $metodeBayar->metode_pembayaran }}" class="img-fluid" style="max-height: 80px;">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('metode-bayar.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
