<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
    <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
        <div class="profile-image">
            @if (session('loginId'))
                <?php
                $user = \App\Models\User::find(session('loginId'));
                $profileImage = $user->foto ? asset('storage/'.$user->foto) : asset('auth/assets/images/faces/face8.jpg');
                ?>
                <img src="{{ $profileImage }}" alt="profile" class="img-xs rounded-circle" id="sidebarProfileImage">
            @endif
            <div class="dot-indicator bg-success"></div>
        </div>
        @if (session('loginId'))
        <?php
        $user = \App\Models\User::find(session('loginId'));
        ?>
        <div class="text-wrapper">
            <p class="profile-name">{{ $user->name }}</p>
            <p class="designation text-capitalize">{{ ucfirst($user->jabatan) }}</p>
            <div class="clearfix"></div>
        @endif
        </div>
        </a>
    </li>
    <li class="nav-item nav-category">Main Menu</li>
        <li class="nav-item">
            @php
                if (Auth::check()) {
                    $routePrefix = Auth::user()->jabatan;
                    $url = url("/$routePrefix");
                } else {
                    $url = url('/login');
                }
            @endphp
            <a class="nav-link" href="{{ url("/$routePrefix") }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Dashboard</span>
            </a>
        </li>
    @if (auth()->check() && (auth()->user()->jabatan == 'admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Management User</span>
            </a>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pelanggans.index') }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Management Pelanggan</span>
            </a>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'pemilik' || auth()->user()->jabatan == 'admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('laporan_keuangan.index') }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Laporan Keuangan</span>
            </a>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'apoteker' || auth()->user()->jabatan == 'admin'))
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                    <span class="menu-title">Produk</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jenis_obats.index') }}">Jenis Obat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('obat.index') }}">Daftar Obat</a>
                    </li>
                </ul>
            </div>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'apoteker' || auth()->user()->jabatan == 'admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('distributors.index') }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Distributor</span>
            </a>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'apoteker' || auth()->user()->jabatan == 'admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pembelian.index') }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Pembelian</span>
            </a>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'kasir' || auth()->user()->jabatan == 'admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('penjualans.index') }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Penjualan</span>
            </a>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'karyawan' || auth()->user()->jabatan == 'admin' || auth()->user()->jabatan == 'kurir'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pengiriman.index') }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Pengiriman</span>
            </a>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'karyawan' || auth()->user()->jabatan == 'admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('metode-bayar.index') }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Metode Pembayaran</span>
            </a>
        </li>
    @endif
    @if (auth()->check() && (auth()->user()->jabatan == 'karyawan' || auth()->user()->jabatan == 'admin'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('jenis_pengirimans.index') }}">
        <i class="menu-icon typcn typcn-document-text"></i>
        <span class="menu-title">Jenis Pengiriman</span>
        </a>
    </li>
@endif
</nav>



