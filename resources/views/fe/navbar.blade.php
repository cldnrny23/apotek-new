<!--::header part start::-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

<style>
/* =====================================================
   HEADER — Blue Apotik Theme
   ===================================================== */
.apo-header {
    background: rgba(255,255,255,.97);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-bottom: 1.5px solid #D0DDEF;
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: sticky;
    top: 0;
    z-index: 999;
    box-shadow: 0 2px 16px rgba(12,30,69,.06);
}

.apo-inner {
    height: 68px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

/* ── Nav links ── */
.apo-nav {
    display: flex;
    align-items: center;
    gap: 2px;
}

.apo-nav a {
    font-size: 13px;
    font-weight: 500;
    color: #334166;
    text-decoration: none;
    padding: 7px 14px;
    border-radius: 8px;
    transition: background .18s, color .18s;
    letter-spacing: .01em;
}

.apo-nav a:hover { background: #EEF3FB; color: #2B5FC1; }
.apo-nav a.active {
    background: #D6E4FB;
    color: #2B5FC1;
    font-weight: 600;
}

/* ── Icon buttons (search, cart) ── */
.apo-icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: #EEF3FB;
    border: 1.5px solid #D0DDEF;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: border-color .18s, background .18s;
    text-decoration: none;
    position: relative;
    flex-shrink: 0;
}

.apo-icon-btn:hover {
    border-color: #4476D9;
    background: #D6E4FB;
}

.apo-cart-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #2B5FC1;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
}

/* ── Profile pill ── */
.apo-profile-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 5px 12px 5px 5px;
    border-radius: 100px;
    border: 1.5px solid #D0DDEF;
    background: #EEF3FB;
    cursor: pointer;
    transition: border-color .2s, background .2s, box-shadow .2s;
    text-decoration: none;
}

.apo-profile-pill:hover,
.apo-profile-pill.show {
    border-color: #4476D9;
    background: #D6E4FB;
    box-shadow: 0 2px 12px rgba(43,95,193,.15);
    text-decoration: none;
}

.apo-profile-pill .name {
    font-size: 13px;
    font-weight: 600;
    color: #0C1E45;
    letter-spacing: -.01em;
}

/* ── Avatar circle ── */
.apo-avatar-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2B5FC1 0%, #1A3A7A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    overflow: hidden;
    flex-shrink: 0;
    letter-spacing: .02em;
}

.apo-avatar-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* ── Dropdown menu ── */
.apo-dropdown-menu {
    min-width: 220px !important;
    background: #FFFFFF !important;
    border: 1.5px solid #D0DDEF !important;
    border-radius: 16px !important;
    box-shadow: 0 2px 8px rgba(12,30,69,.06), 0 12px 40px rgba(12,30,69,.12) !important;
    padding: 0 !important;
    overflow: hidden;
    font-family: 'Plus Jakarta Sans', sans-serif;
    margin-top: 8px !important;
}

/* Header block */
.apo-dropdown-menu .dropdown-header {
    background: linear-gradient(135deg, #2B5FC1 0%, #1A3A7A 100%);
    color: #fff !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    padding: 15px 18px 13px;
    line-height: 1.3;
    white-space: normal;
    letter-spacing: -.01em;
}

.apo-dropdown-menu .dropdown-header small {
    display: block;
    font-size: 11px;
    font-weight: 400;
    color: rgba(255,255,255,.60) !important;
    margin-top: 3px;
    letter-spacing: .02em;
}

/* Items */
.apo-dropdown-menu .dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 18px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    color: #0C1E45;
    transition: background .15s, color .15s;
    border-radius: 0;
    background: #FFFFFF;
}

.apo-dropdown-menu .dropdown-item i {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #2B5FC1;
    color: #FFFFFF;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background .15s, color .15s;
}

.apo-dropdown-menu .dropdown-item:hover {
    background: #F7FBFF;
    color: #0C1E45;
}

.apo-dropdown-menu .dropdown-item:hover i {
    background: #1A3A7A;
    color: #FFFFFF;
}

/* Sign Out */
.apo-dropdown-menu .dropdown-item.text-danger {
    color: #A32D2D !important;
}

.apo-dropdown-menu .dropdown-item.text-danger i {
    background: #FCEBEB;
    color: #A32D2D;
}

.apo-dropdown-menu .dropdown-item.text-danger:hover {
    background: #FFF5F5;
    color: #791F1F !important;
}

.apo-dropdown-menu .dropdown-item.text-danger:hover i {
    background: #F7C1C1;
    color: #791F1F;
}

.apo-dropdown-menu .dropdown-divider {
    margin: 0 !important;
    border-color: #4476D9 !important;
}

/* ── Search bar (slide-down) ── */
.apo-search-bar {
    background: #0C1E45;
    padding: 12px 0;
    border-bottom: 1px solid rgba(116,170,240,.15);
    display: none;
    animation: apo-search-in .2s ease both;
}

@keyframes apo-search-in {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}

.apo-search-inner {
    display: flex;
    align-items: center;
    gap: 10px;
}

.apo-search-inner input {
    flex: 1;
    height: 40px;
    border-radius: 10px;
    border: 1.5px solid rgba(116,170,240,.25);
    background: rgba(255,255,255,.08);
    color: #fff;
    padding: 0 16px;
    font-size: 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    outline: none;
    transition: border-color .2s;
}

.apo-search-inner input::placeholder { color: rgba(255,255,255,.4); }
.apo-search-inner input:focus { border-color: #7AAAF0; }

.apo-search-close {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(255,255,255,.1);
    border: none;
    cursor: pointer;
    color: rgba(255,255,255,.7);
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s, color .15s;
    flex-shrink: 0;
}

.apo-search-close:hover { background: rgba(255,255,255,.2); color: #fff; }

/* ── Mobile nav ── */
.apo-mobile-nav a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    font-size: 13.5px;
    font-weight: 500;
    color: #334166;
    border-radius: 8px;
    text-decoration: none;
    transition: background .15s, color .15s;
}

.apo-mobile-nav a:hover,
.apo-mobile-nav a.active {
    background: #EEF3FB;
    color: #2B5FC1;
}

.apo-mobile-nav a i {
    width: 26px;
    height: 26px;
    border-radius: 7px;
    background: #EEF3FB;
    color: #4476D9;
    font-size: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background .15s;
}

.apo-mobile-nav a:hover i { background: #D6E4FB; }

/* ── Separator line ── */
.apo-sep {
    width: 1px;
    height: 24px;
    background: #D0DDEF;
    flex-shrink: 0;
}
</style>

<header class="apo-header">
    <div class="container">
        <div class="apo-inner">

            {{-- Logo --}}
            <a class="navbar-brand" href="{{ route('home') }}" style="flex-shrink:0;">
                <img src="{{ asset('be/img/cloupillsblue2.png') }}" alt="ClouPills" style="width:160px; height:auto;">
            </a>

            {{-- Mobile toggler --}}
            <button class="navbar-toggler d-lg-none ml-auto" type="button"
                data-toggle="collapse" data-target="#navbarMain"
                style="border:1.5px solid #D0DDEF; border-radius:9px; padding:6px 10px; background:#EEF3FB; outline:none;">
                <i class="fas fa-bars" style="color:#2B5FC1; font-size:14px;"></i>
            </button>

            {{-- Desktop nav --}}
            <nav class="apo-nav d-none d-lg-flex" style="flex:1; justify-content:center;">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('fe.about.index') }}" class="{{ request()->routeIs('fe.about.*') ? 'active' : '' }}">About</a>
                <a href="{{ route('list.index') }}" class="{{ request()->routeIs('list.*') ? 'active' : '' }}">Product</a>
                @if(Auth::guard('pelanggan')->check())
                <a href="{{ route('profilefe.index') }}" class="{{ request()->routeIs('profilefe.*') ? 'active' : '' }}">Profile</a>
                @endif
            </nav>

            {{-- Actions (Desktop) --}}
            <div class="d-none d-lg-flex" style="align-items:center; gap:8px;">

                {{-- Search --}}
                <a class="apo-icon-btn" href="javascript:void(0)" id="search_toggle" title="Cari produk">
                    <i class="ti-search" style="color:#2B5FC1; font-size:13px;"></i>
                </a>

                {{-- Cart --}}
                <a class="apo-icon-btn" href="{{ route('cart.index') }}" title="Keranjang">
                    <i class="flaticon-shopping-cart-black-shape" style="color:#2B5FC1; font-size:15px;"></i>
                </a>

                <div class="apo-sep"></div>

                {{-- Profile dropdown --}}
                <div class="dropdown">
                    @if(Auth::guard('pelanggan')->check())
                        @php
                            $pelanggan = Auth::guard('pelanggan')->user();
                            $profileImage = $pelanggan->foto && $pelanggan->foto != 'default.jpg'
                                ? asset('storage/'.$pelanggan->foto)
                                : null;
                            $initials = strtoupper(substr($pelanggan->nama_pelanggan, 0, 2));
                        @endphp

                        <a href="#" class="apo-profile-pill dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div class="apo-avatar-circle">
                                @if($profileImage)
                                    <img src="{{ $profileImage }}" alt="Foto">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            <span class="name">{{ Str::limit($pelanggan->nama_pelanggan, 12) }}</span>
                            <i class="fas fa-chevron-down" style="font-size:9px; color:#7A8CAD; margin-left:1px;"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right apo-dropdown-menu">
                            <li>
                                <div class="dropdown-header">
                                    {{ $pelanggan->nama_pelanggan }}
                                    <small>My Profile</small>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profilefe.index') }}">
                                    <i class="fa fa-id-card"></i> Your Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-shopping-bag"></i> Your Orders
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout-pelanggan') }}" method="POST">
                                    @csrf
                                    <a class="dropdown-item text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ti-power-off"></i> Sign Out
                                    </a>
                                </form>
                            </li>
                        </ul>

                    @else

                        <a href="#" class="apo-profile-pill dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div class="apo-avatar-circle" style="background:#EEF3FB; border:1.5px solid #D0DDEF;">
                                <i class="fa fa-user" style="color:#7A8CAD; font-size:11px;"></i>
                            </div>
                            <span class="name" style="color:#7A8CAD; font-weight:500;">Guest</span>
                            <i class="fas fa-chevron-down" style="font-size:9px; color:#7A8CAD; margin-left:1px;"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right apo-dropdown-menu">
                            <li>
                                <div class="dropdown-header">
                                    Selamat Datang
                                    <small>Silakan masuk atau daftar</small>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('loginfe') }}">
                                    <i class="fa fa-sign-in"></i> Login
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('registerfe') }}">
                                    <i class="fa fa-user-plus"></i> Register
                                </a>
                            </li>
                        </ul>

                    @endif
                </div>
            </div>

        </div>

        {{-- Mobile nav collapse --}}
        <div class="collapse navbar-collapse d-lg-none apo-mobile-nav" id="navbarMain"
            style="border-top:1px solid #D0DDEF; padding:10px 0 14px;">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa fa-home"></i> Home
            </a>
            <a href="{{ route('fe.about.index') }}" class="{{ request()->routeIs('fe.about.*') ? 'active' : '' }}">
                <i class="fa fa-info-circle"></i> About
            </a>
            <a href="{{ route('list.index') }}" class="{{ request()->routeIs('list.*') ? 'active' : '' }}">
                <i class="fa fa-pills"></i> Product
            </a>
            @if(Auth::guard('pelanggan')->check())
            <a href="{{ route('profilefe.index') }}" class="{{ request()->routeIs('profilefe.*') ? 'active' : '' }}">
                <i class="fa fa-id-card"></i> Profile
            </a>
            @endif
            <div style="height:1px; background:#D0DDEF; margin:8px 12px;"></div>
            <a href="{{ route('cart.index') }}">
                <i class="fa fa-shopping-cart"></i> Cart
            </a>
            @if(Auth::guard('pelanggan')->check())
            <a href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                style="color:#A32D2D;">
                <i class="ti-power-off" style="background:#FCEBEB; color:#A32D2D;"></i> Sign Out
            </a>
            <form id="logout-form-mobile" action="{{ route('logout-pelanggan') }}" method="POST" class="d-none">@csrf</form>
            @else
            <a href="{{ route('loginfe') }}">
                <i class="fa fa-sign-in"></i> Login
            </a>
            <a href="{{ route('registerfe') }}">
                <i class="fa fa-user-plus"></i> Register
            </a>
            @endif
        </div>
    </div>

    {{-- Search bar --}}
    <div class="apo-search-bar" id="search_input_box">
        <div class="container">
            <div class="apo-search-inner">
                <input type="text" id="search_input" placeholder="Cari obat, suplemen, atau produk...">
                <button class="apo-search-close" id="close_search" type="button">&#x2715;</button>
            </div>
        </div>
    </div>
</header>
<!-- Header part end -->

<script>
(function () {
    var toggle = document.getElementById('search_toggle');
    var box    = document.getElementById('search_input_box');
    var close  = document.getElementById('close_search');
    var input  = document.getElementById('search_input');

    toggle.addEventListener('click', function (e) {
        e.preventDefault();
        var open = box.style.display === 'block';
        box.style.display = open ? 'none' : 'block';
        if (!open) input.focus();
    });

    close.addEventListener('click', function () {
        box.style.display = 'none';
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && box.style.display === 'block') {
            box.style.display = 'none';
        }
    });
})();
</script>
