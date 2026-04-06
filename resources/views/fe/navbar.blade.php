<!--::header part start::-->
<header class="main_menu home_menu">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="{{ route('home') }}"> <img src="{{asset('be/img/cloupillsblue2.png')}}" alt="logo" style="width: 200px; height: auto;"> </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="menu_icon"><i class="fas fa-bars"></i></span>
                    </button>

                    <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('fe.about.index') }}">about</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('list.index') }}">product</a>
                            </li>
                            @if(Auth::guard('pelanggan')->check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profilefe.index') }}">Profile</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="hearer_icon d-flex align-items-center">
                        <a id="search_1" href="javascript:void(0)"><i class="ti-search"></i></a>
                        <a href="{{ route('cart.index') }}">
                            <i class="flaticon-shopping-cart-black-shape"></i>
                        </a>
                    </div>
                      <!-- Profile -->
                    <!-- Profile Section -->
                    <div class="dropdown" style="display: flex; align-items: center;">
                        @if(Auth::guard('pelanggan')->check())
                            @php
                                $pelanggan = Auth::guard('pelanggan')->user();
                                $profileImage = $pelanggan->foto && $pelanggan->foto != 'default.jpg'
                                    ? asset('storage/'.$pelanggan->foto)
                                    : asset('images/default-user.jpg');
                            @endphp
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" style="display: flex; align-items: center;">
                                <img src="{{ $profileImage }}"
                                    class="rounded-circle"
                                    style="width: 35px; height: 35px; object-fit: cover; margin-left: 50px;"
                                    alt="Profile Image">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" style="min-width: 200px;">
                                <li><a class="dropdown-item"><strong class="ml-2">{{ $pelanggan->nama_pelanggan }} - My Profile</strong></a></li>
                                <li><a class="dropdown-item" href="{{ route('profilefe.index') }}"><i class="fa fa-id-card mr-2"></i> Your Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa fa-shopping-bag mr-2"></i> Your Orders</a></li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout-pelanggan') }}" method="POST">
                                        @csrf
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="dropdown-item-icon ti-power-off"></i> Sign Out
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" style="display: flex; align-items: center;">
                                <i class="fa fa-user-o" style="font-size: 20px; margin-right: 5px;"></i>
                                <span style="margin-left: 8px;">Guest</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" style="min-width: 200px;">
                                <li><a class="dropdown-item"><strong class="ml-2">Guest</strong></a></li>
                                <li><a class="dropdown-item" href="{{ route('loginfe') }}"><i class="fa fa-user me-2"></i> Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('registerfe') }}"><i class="fa fa-user-plus me-2"></i> Register</a></li>
                            </ul>
                        @endif
                    </div>
                    <!-- /Profile -->

                </nav>
            </div>
        </div>
    </div>
    <div class="search_input" id="search_input_box">
        <div class="container ">
            <form class="d-flex justify-content-between search-inner">
                <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                <button type="submit" class="btn"></button>
                <span class="ti-close" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>
<!-- Header part end-->