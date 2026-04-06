<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Star Admin Premium Bootstrap Admin Dashboard Template</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('auth/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('auth/assets/vendors/iconfonts/ionicons/dist/css/ionicons.css') }}">
        <link rel="stylesheet" href="{{ asset('auth/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('auth/assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ asset('auth/assets/vendors/css/vendor.bundle.addons.css') }}">
        <!-- endinject -->
        <!-- plugin css for this page -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="{{ asset('auth/assets/css/shared/style.css') }}">
        <!-- endinject -->
        <!-- Layout styles -->
        <link rel="stylesheet" href="{{ asset('auth/assets/css/demo_1/style.css') }}">
        <!-- End Layout styles -->
        <link rel="shortcut icon" href="{{ asset('auth/assets/images/favicon.ico') }}" />
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
                    <div class="row w-100">
                        <div class="col-lg-4 mx-auto">
                            <h2 class="text-center mb-4">Register</h2>
                            <div class="auto-form-wrapper">
                                <form class="pt-3" method="POST" action="{{ route('register-user') }}">
                                    @csrf
                                    <!-- Ensure this directive is present -->
                                    @if(Session::has('success'))
                                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                                    @endif
                                    @if(Session::has('fail'))
                                        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                                    @endif
                                    <div class="form-group">
                                        <div>
                                            <input name="name" type="text" class="form-control form-control-lg" id="name" placeholder="Username" required value="{{ old('name') }}">
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('name') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <input input name="email" type="email" class="form-control form-control-lg" id="email" placeholder="Email" required value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('email') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <input name="password" type="password" class="form-control form-control-lg" id="password" placeholder="Password" required value="{{ old('password') }}">
                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <input name="no_hp" type="no_hp" class="form-control form-control-lg" id="no_hp" placeholder="Phone Number" required>
                                            @if ($errors->has('no_hp'))
                                                <span class="invalid-feedback">{{ $errors->first('no_hp') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <select name="jabatan" id="jabatan" class="form-control form-control-lg" required>
                                                <option disabled selected>Select Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="pemilik">Pemilik</option>
                                                <option value="apoteker">Apoteker</option>
                                                <option value="karyawan">Karyawan</option>
                                                <option value="kasir">Kasir</option>
                                                <option value="kurir">Kurir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" checked> I agree to the terms </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary submit-btn btn-block" type="submit">Register</button>
                                    </div>
                                    <div class="text-block text-center my-3">
                                        <span class="text-small font-weight-semibold">Already have and account ?</span>
                                        <a href="{{ route('login') }}" class="text-black text-small">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="{{ asset('auth/assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <script src="{{ asset('auth/assets/vendors/js/vendor.bundle.addons.js') }}"></script>
        <!-- endinject -->
        <!-- inject:js -->
        <script src="{{ asset('auth/assets/js/shared/off-canvas.js') }}"></script>
        <script src="{{ asset('auth/assets/js/shared/misc.js') }}"></script>
        <!-- endinject -->
    </body>
</html>
