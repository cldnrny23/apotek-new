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
    @yield('navbar', @include('fe.navbar'))
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
    <footer class="footer_part" style="position: static">
        <div class="footer_iner">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-8">
                        <div class="footer_menu">
                            <div class="footer_logo">
                                <a href="{{ route('home') }}"><img src="{{asset('be/img/cloupillsblue2.png')}}" alt="logo" style="width: 200px; height: auto;"></a>
                            </div>
                            <div class="footer_menu_item">
                                <a href="{{ route('home') }}">Home</a>
                                <a href="{{ route('fe.about.index') }}">About</a>
                                <a href="{{ route('list.index') }}">Products</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="social_icon">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright_part">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="copyright_text">
                            <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
                            <div class="copyright_link">
                                <a href="#">Turms & Conditions</a>
                                <a href="#">FAQ</a>
                            </div>
                        </div>
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
