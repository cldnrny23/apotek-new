<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>pillloMart</title>
    <link rel="icon" href="{{asset('fe/img/favicon.png')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/bootstrap.min.css')}}">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/animate.css')}}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/owl.carousel.min.css')}}">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/all.css')}}">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('fe/css/themify-icons.css')}}">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/magnific-popup.css')}}">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/slick.css')}}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/style.css')}}">
    <!-- checkout CSS -->
    <link rel="stylesheet" href="{{asset('fe/css/checkout.css')}}">
</head>

<body>
    <!--::header part start::-->
    @if(View::hasSection('navbar'))
        @yield('navbar')
    @else
        @include('fe.navbar')
    @endif
    <!-- Header part end-->

    @yield('list')
    @yield('banner')
    @yield('produk-list')
    @yield('trending-item')
    @yield('about')
    @yield('single-produk')
    @yield('cart')
    @yield('checkout')
    @yield('contact')
    <!-- feature part here -->
    @yield('review')
    <!-- feature part end -->

    <!-- client review part here -->
    @yield('feature')
    <!-- client review part end -->

    <!-- subscribe part here -->
    @yield('subscribe')
    <!-- subscribe part end -->

    @yield('profilefe')

    <!--::footer_part start::-->
<footer class="footer_part" style="
    background: #0C1E45;
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
    overflow: hidden;
">

    {{-- Background decoration --}}
    <div style="position:absolute; width:500px; height:500px; border-radius:50%;
        background:radial-gradient(circle, rgba(43,95,193,.18) 0%, transparent 70%);
        top:-200px; right:-100px; pointer-events:none;"></div>
    <div style="position:absolute; width:300px; height:300px; border-radius:50%;
        background:radial-gradient(circle, rgba(43,95,193,.12) 0%, transparent 70%);
        bottom:-100px; left:-60px; pointer-events:none;"></div>

    {{-- Main footer content --}}
    <div class="container" style="position:relative; z-index:1; padding-top:52px; padding-bottom:36px;">
        <div class="row justify-content-between align-items-start" style="padding-bottom:36px; border-bottom:1px solid rgba(208,221,239,.15);">

            {{-- Logo & Sosmed --}}
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="footer_logo mb-3">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('be/img/cloupillswhite2.png') }}" alt="logo" style="width:200px; height:auto;">
                    </a>
                </div>
                <p style="font-size:13px; color:#7A8CAD; font-weight:300; margin:0 0 20px; max-width:240px; line-height:1.6;">
                    Apotek terpercaya Anda. Kualitas terjamin, harga terjangkau.
                </p>
                <div style="display:flex; gap:10px;">
                    <a href="#" style="width:34px; height:34px; border-radius:8px; background:rgba(43,95,193,.25); border:1px solid rgba(116,170,240,.2); display:flex; align-items:center; justify-content:center;">
                        <i class="fab fa-facebook-f" style="color:#7AAAF0; font-size:13px;"></i>
                    </a>
                    <a href="#" style="width:34px; height:34px; border-radius:8px; background:rgba(43,95,193,.25); border:1px solid rgba(116,170,240,.2); display:flex; align-items:center; justify-content:center;">
                        <i class="fab fa-instagram" style="color:#7AAAF0; font-size:13px;"></i>
                    </a>
                    <a href="#" style="width:34px; height:34px; border-radius:8px; background:rgba(43,95,193,.25); border:1px solid rgba(116,170,240,.2); display:flex; align-items:center; justify-content:center;">
                        <i class="fab fa-google-plus-g" style="color:#7AAAF0; font-size:13px;"></i>
                    </a>
                    <a href="#" style="width:34px; height:34px; border-radius:8px; background:rgba(43,95,193,.25); border:1px solid rgba(116,170,240,.2); display:flex; align-items:center; justify-content:center;">
                        <i class="fab fa-linkedin-in" style="color:#7AAAF0; font-size:13px;"></i>
                    </a>
                </div>
            </div>

            {{-- Nav Links --}}
            <div class="col-lg-3 col-6 mb-4 mb-lg-0">
                <p style="font-size:11px; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:#4476D9; margin:0 0 16px; opacity:.7;">Navigasi</p>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <a href="{{ route('home') }}" style="font-size:14px; color:rgba(255,255,255,.7); text-decoration:none; font-weight:300;">Home</a>
                    <a href="{{ route('fe.about.index') }}" style="font-size:14px; color:rgba(255,255,255,.7); text-decoration:none; font-weight:300;">About</a>
                    <a href="{{ route('list.index') }}" style="font-size:14px; color:rgba(255,255,255,.7); text-decoration:none; font-weight:300;">Products</a>
                </div>
            </div>

            {{-- Help Links --}}
            <div class="col-lg-3 col-6">
                <p style="font-size:11px; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:#4476D9; margin:0 0 16px; opacity:.7;">Bantuan</p>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <a href="#" style="font-size:14px; color:rgba(255,255,255,.7); text-decoration:none; font-weight:300;">Terms &amp; Conditions</a>
                    <a href="#" style="font-size:14px; color:rgba(255,255,255,.7); text-decoration:none; font-weight:300;">FAQ</a>
                </div>
            </div>

        </div>

        {{-- Copyright bar --}}
        <div class="row align-items-center" style="padding-top:24px;">
            <div class="col-lg-8">
                <p style="font-size:12px; color:#7A8CAD; margin:0; font-weight:300;">
                    &copy; <script>document.write(new Date().getFullYear())</script> All rights reserved &mdash;
                    Template by <a href="https://colorlib.com" target="_blank" style="color:#7AAAF0; text-decoration:none;">Colorlib</a>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                <div style="display:inline-flex; align-items:center; gap:6px; background:rgba(43,95,193,.15); border:1px solid rgba(116,170,240,.2); border-radius:100px; padding:4px 14px;">
                    <div style="width:6px; height:6px; border-radius:50%; background:#7AAAF0;"></div>
                    <span style="font-size:11px; color:#7AAAF0; font-weight:600; letter-spacing:.04em;">Apotek Terpercaya</span>
                </div>
            </div>
        </div>

    </div>
</footer>
    <!--::footer_part end::-->

    <!-- jquery plugins here-->
    <script src="{{asset('fe/js/jquery-1.12.1.min.js')}}"></script>
    <!-- popper js -->
    <script src="{{asset('fe/js/popper.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset('fe/js/bootstrap.min.js')}}"></script>
    <!-- magnific popup js -->
    <script src="{{asset('fe/js/jquery.magnific-popup.js')}}"></script>
    <!-- carousel js -->
    <script src="{{asset('fe/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('fe/js/jquery.nice-select.min.js')}}"></script>
    <!-- slick js -->
    <script src="{{asset('fe/js/slick.min.js')}}"></script>
    <script src="{{asset('fe/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('fe/js/waypoints.min.js')}}"></script>
    <script src="{{asset('fe/js/contact.js')}}"></script>
    <script src="{{asset('fe/js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{asset('fe/js/jquery.form.js')}}"></script>
    <script src="{{asset('fe/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('fe/js/mail-script.js')}}"></script>
    <!-- custom js -->
    <script src="{{asset('fe/js/custom.js')}}"></script>
</body>

</html>
