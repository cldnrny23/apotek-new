@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
<div class="container" style="margin: 20px;">
    <h2>Tambah User</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" required>
            @error('no_hp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Jabatan</label>
            <select name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" required>
                <option value="">Pilih Jabatan</option>
                <option value="admin"{{ old('jabatan') == 'admin' ? 'selected' : ''  }}>Admin</option>
                <option value="apoteker"{{ old('jabatan') == 'apoteker' ? 'selected' : ''  }}>Apoteker</option>
                <option value="karyawan"{{ old('jabatan') == 'karyawan' ? 'selected' : ''  }}>Karyawan</option>
                <option value="kasir"{{ old('jabatan') == 'kasir' ? 'selected' : ''  }}>Kasir</option>
                <option value="pemilik"{{ old('jabatan') == 'pemilik' ? 'selected' : ''  }}>Pemilik</option>
                <option value="kurir"{{ old('jabatan') == 'kurir' ? 'selected' : ''  }}>Kurir</option>
            </select>
            @error('jabatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
