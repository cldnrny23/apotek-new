@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('profilefe')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

    .profile-section {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f4f6fb;
        min-height: 100vh;
        padding: 50px 0 80px;
    }

    /* Page Header */
    .profile-page-header {
        margin-bottom: 36px;
    }
    .profile-page-header h3 {
        font-size: 1.7rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0;
        letter-spacing: -0.3px;
    }
    .profile-page-header p {
        color: #7c84a0;
        font-size: 0.9rem;
        margin: 4px 0 0;
    }

    /* Card */
    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #eaecf4;
        box-shadow: 0 2px 24px rgba(30,40,90,0.06);
        overflow: hidden;
    }

    /* Avatar Panel */
    .avatar-panel {
        background: linear-gradient(160deg, #1a1d2e 0%, #2d3250 100%);
        padding: 44px 32px 36px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0;
        position: relative;
    }
    .avatar-panel::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 60px;
        background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.04));
    }

    .avatar-wrapper {
        position: relative;
        margin-bottom: 20px;
    }
    .profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.15);
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        display: block;
    }
    .avatar-placeholder {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        border: 4px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-placeholder i {
        font-size: 3rem;
        color: rgba(255,255,255,0.5);
    }

    .avatar-name {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
        margin: 0 0 4px;
    }
    .avatar-label {
        color: rgba(255,255,255,0.45);
        font-size: 0.78rem;
        text-align: center;
        margin: 0 0 24px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* Upload buttons */
    .upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        margin-bottom: 8px;
    }
    .upload-btn-photo {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.18);
        width: 100%;
        justify-content: center;
    }
    .upload-btn-photo:hover {
        background: rgba(255,255,255,0.2);
    }

    /* KTP Preview */
    .ktp-section {
        width: 100%;
        margin-top: 20px;
    }
    .ktp-label {
        color: rgba(255,255,255,0.5);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 10px;
        display: block;
    }
    .ktp-preview {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.05);
        aspect-ratio: 16/10;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }
    .ktp-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .ktp-preview-empty {
        flex-direction: column;
        gap: 8px;
    }
    .ktp-preview-empty i {
        font-size: 2rem;
        color: rgba(255,255,255,0.2);
    }
    .ktp-preview-empty span {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.3);
    }
    .upload-btn-ktp {
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.7);
        border: 1px dashed rgba(255,255,255,0.2);
        width: 100%;
        justify-content: center;
    }
    .upload-btn-ktp:hover {
        background: rgba(255,255,255,0.14);
        color: #fff;
    }

    /* Form Panel */
    .form-panel {
        padding: 44px 40px 40px;
    }

    /* Section divider */
    .form-section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 36px 0 22px;
    }
    .form-section-title:first-child {
        margin-top: 0;
    }
    .form-section-title h4 {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #7c84a0;
        margin: 0;
        white-space: nowrap;
    }
    .form-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #eaecf4;
    }

    /* Form fields */
    .field-group {
        margin-bottom: 18px;
    }
    .field-group label {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        color: #4a5068;
        margin-bottom: 7px;
        letter-spacing: 0.2px;
    }
    .field-input {
        width: 100%;
        padding: 11px 15px;
        border: 1.5px solid #e4e7f0;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.88rem;
        color: #1a1d2e;
        background: #fafbfd;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        outline: none;
        box-sizing: border-box;
    }
    .field-input:focus {
        border-color: #4361ee;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(67,97,238,0.08);
    }
    .field-input::placeholder {
        color: #b0b8cc;
    }
    textarea.field-input {
        resize: vertical;
        min-height: 90px;
    }

    /* Grid row */
    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }

    /* Alert */
    .alert-custom {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.85rem;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success-custom {
        background: #eefbf3;
        border: 1px solid #a8e6bc;
        color: #1a7a40;
    }
    .alert-error-custom {
        background: #fff0f0;
        border: 1px solid #ffc5c5;
        color: #b91c1c;
    }

    /* Submit button */
    .submit-row {
        display: flex;
        justify-content: flex-end;
        margin-top: 36px;
        padding-top: 28px;
        border-top: 1px solid #eaecf4;
    }
    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        color: #fff;
        border: none;
        padding: 13px 32px;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
        box-shadow: 0 4px 18px rgba(67,97,238,0.3);
        letter-spacing: 0.2px;
    }
    .btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 24px rgba(67,97,238,0.4);
    }
    .btn-save:active {
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .profile-card-inner {
            flex-direction: column;
        }
        .avatar-panel {
            padding: 36px 24px;
        }
        .form-panel {
            padding: 32px 24px;
        }
        .field-row {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 767px) {
        .field-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="profile-section">
    <div class="container">

        <!-- Page header -->
        <div class="profile-page-header">
            <h3>Profil Saya</h3>
            <p>Kelola informasi dan alamat pengiriman Anda</p>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="fa fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-custom alert-error-custom">
                <i class="fa fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="profile-card">
            <form method="POST" action="{{ route('profilefe.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="profile-card-inner" style="display:flex;">

                    <!-- Left: Avatar Panel -->
                    <div class="avatar-panel" style="min-width:260px; max-width:280px; flex-shrink:0;">

                        <div class="avatar-wrapper">
                            @if($pelanggan->foto)
                                <img src="{{ asset('storage/'.$pelanggan->foto) }}"
                                     class="profile-avatar" id="avatarPreview">
                            @else
                                <div class="avatar-placeholder" id="avatarPlaceholder">
                                    <i class="fa fa-user"></i>
                                </div>
                                <img id="avatarPreview" class="profile-avatar" style="display:none;">
                            @endif
                        </div>

                        <p class="avatar-name">{{ $pelanggan->nama_pelanggan ?? 'Guest' }}</p>
                        <p class="avatar-label">Pelanggan</p>

                        <label class="upload-btn upload-btn-photo">
                            <i class="fa fa-camera"></i> Ganti Foto
                            <input type="file" name="foto" id="foto" class="d-none" accept="image/*">
                        </label>

                        <!-- KTP -->
                        <div class="ktp-section">
                            <span class="ktp-label"><i class="fa fa-id-card"></i> &nbsp;KTP</span>
                            <div class="ktp-preview @if(!$pelanggan->url_ktp) ktp-preview-empty @endif" id="ktpWrapper">
                                @if($pelanggan->url_ktp)
                                    <img src="{{ asset('storage/'.$pelanggan->url_ktp) }}" id="ktpPreview">
                                @else
                                    <i class="fa fa-id-card"></i>
                                    <span>Belum ada KTP</span>
                                @endif
                            </div>
                            <label class="upload-btn upload-btn-ktp">
                                <i class="fa fa-upload"></i> Upload KTP
                                <input type="file" name="url_ktp" id="url_ktp" class="d-none" accept="image/*">
                            </label>
                        </div>

                    </div>

                    <!-- Right: Form Panel -->
                    <div class="form-panel" style="flex:1;">

                        <!-- Informasi Akun -->
                        <div class="form-section-title">
                            <h4>Informasi Akun</h4>
                        </div>

                        <div class="field-row" style="grid-template-columns:1fr 1fr;">
                            <div class="field-group">
                                <label for="nama_pelanggan">Nama Lengkap</label>
                                <input class="field-input" type="text" id="nama_pelanggan" name="nama_pelanggan"
                                       value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}"
                                       placeholder="Nama lengkap" required>
                            </div>
                            <div class="field-group">
                                <label for="email">Email</label>
                                <input class="field-input" type="email" id="email" name="email"
                                       value="{{ old('email', $pelanggan->email) }}"
                                       placeholder="email@contoh.com" required>
                            </div>
                        </div>

                        <div class="field-row" style="grid-template-columns:1fr 1fr;">
                            <div class="field-group">
                                <label for="no_telp">No. Telepon / HP</label>
                                <input class="field-input" type="text" id="no_telp" name="no_telp"
                                       value="{{ old('no_telp', $pelanggan->no_telp) }}"
                                       placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="field-group">
                                <label for="password">Password Baru</label>
                                <input class="field-input" type="password" id="password" name="password"
                                       placeholder="Kosongkan jika tidak diubah">
                            </div>
                        </div>

                        <!-- Alamat Utama -->
                        <div class="form-section-title">
                            <h4>Alamat Utama</h4>
                        </div>

                        <div class="field-group">
                            <label for="alamat1">Alamat Lengkap</label>
                            <textarea class="field-input" id="alamat1" name="alamat1"
                                      placeholder="Jl. ..." required>{{ old('alamat1', $pelanggan->alamat1) }}</textarea>
                        </div>
                        <div class="field-row">
                            <div class="field-group">
                                <label for="kota1">Kota</label>
                                <input class="field-input" type="text" id="kota1" name="kota1"
                                       value="{{ old('kota1', $pelanggan->kota1) }}" placeholder="Kota" required>
                            </div>
                            <div class="field-group">
                                <label for="propinsi1">Provinsi</label>
                                <input class="field-input" type="text" id="propinsi1" name="propinsi1"
                                       value="{{ old('propinsi1', $pelanggan->propinsi1) }}" placeholder="Provinsi" required>
                            </div>
                            <div class="field-group">
                                <label for="kodepos1">Kode Pos</label>
                                <input class="field-input" type="text" id="kodepos1" name="kodepos1"
                                       value="{{ old('kodepos1', $pelanggan->kodepos1) }}" placeholder="00000" required>
                            </div>
                        </div>

                        <!-- Alamat Alternatif 1 -->
                        <div class="form-section-title">
                            <h4>Alamat Alternatif 1</h4>
                        </div>

                        <div class="field-group">
                            <label for="alamat2">Alamat Lengkap</label>
                            <textarea class="field-input" id="alamat2" name="alamat2"
                                      placeholder="Opsional">{{ old('alamat2', $pelanggan->alamat2) }}</textarea>
                        </div>
                        <div class="field-row">
                            <div class="field-group">
                                <label for="kota2">Kota</label>
                                <input class="field-input" type="text" id="kota2" name="kota2"
                                       value="{{ old('kota2', $pelanggan->kota2) }}" placeholder="Kota">
                            </div>
                            <div class="field-group">
                                <label for="propinsi2">Provinsi</label>
                                <input class="field-input" type="text" id="propinsi2" name="propinsi2"
                                       value="{{ old('propinsi2', $pelanggan->propinsi2) }}" placeholder="Provinsi">
                            </div>
                            <div class="field-group">
                                <label for="kodepos2">Kode Pos</label>
                                <input class="field-input" type="text" id="kodepos2" name="kodepos2"
                                       value="{{ old('kodepos2', $pelanggan->kodepos2) }}" placeholder="00000">
                            </div>
                        </div>

                        <!-- Alamat Alternatif 2 -->
                        <div class="form-section-title">
                            <h4>Alamat Alternatif 2</h4>
                        </div>

                        <div class="field-group">
                            <label for="alamat3">Alamat Lengkap</label>
                            <textarea class="field-input" id="alamat3" name="alamat3"
                                      placeholder="Opsional">{{ old('alamat3', $pelanggan->alamat3) }}</textarea>
                        </div>
                        <div class="field-row">
                            <div class="field-group">
                                <label for="kota3">Kota</label>
                                <input class="field-input" type="text" id="kota3" name="kota3"
                                       value="{{ old('kota3', $pelanggan->kota3) }}" placeholder="Kota">
                            </div>
                            <div class="field-group">
                                <label for="propinsi3">Provinsi</label>
                                <input class="field-input" type="text" id="propinsi3" name="propinsi3"
                                       value="{{ old('propinsi3', $pelanggan->propinsi3) }}" placeholder="Provinsi">
                            </div>
                            <div class="field-group">
                                <label for="kodepos3">Kode Pos</label>
                                <input class="field-input" type="text" id="kodepos3" name="kodepos3"
                                       value="{{ old('kodepos3', $pelanggan->kodepos3) }}" placeholder="00000">
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="submit-row">
                            <button type="submit" class="btn-save">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                        </div>

                    </div>
                    <!-- /form panel -->

                </div>
                <!-- /inner -->
            </form>
        </div>
        <!-- /card -->

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Foto preview
    document.getElementById('foto').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        const preview = document.getElementById('avatarPreview');
        const placeholder = document.getElementById('avatarPlaceholder');
        if (placeholder) placeholder.style.display = 'none';
        preview.src = url;
        preview.style.display = 'block';
    });

    // KTP preview
    document.getElementById('url_ktp').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        const wrapper = document.getElementById('ktpWrapper');
        wrapper.classList.remove('ktp-preview-empty');
        wrapper.innerHTML = `<img src="${url}" style="width:100%;height:100%;object-fit:contain;">`;
    });

    // SweetAlert notifications
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('swal'))
            Swal.fire({
                position: 'top-end',
                icon: '{{ session('swal.icon') }}',
                title: '{{ session('swal.title') }}',
                text: '{{ session('swal.text') }}',
                showConfirmButton: false,
                timer: {{ session('swal.timer') ?? 1500 }},
                toast: true
            });
        @endif

        @if($errors->any())
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Validasi Error',
                html: '<ul style="text-align:left;margin:0;padding-left:16px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                showConfirmButton: false,
                timer: 4000,
                toast: true
            });
        @endif
    });
</script>

@endsection
