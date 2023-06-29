{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | HNSB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="HNSB" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.jpg') }}">

    <!-- Jquery Toast css -->
    <link href="{{ asset('assets/libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap css -->
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="{{ asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="{{ asset('/assets/js/head.js') }}"></script>


</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="home" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('/assets/images/ins_logo.png') }}" alt="HNSB Logo" height="220">
                                        </span>
                                    </a>

                                    <a href="home" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('/assets/images/ins_logo.png') }}" alt="HNSB Logo" height="220">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Enter your email address and password to login.</p>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->has('email'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" name="email" id="emailaddress"
                                        required="" placeholder="Enter your email">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div> --}}

                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>
                                <div class="text-center">
                                    <h5 class="mt-3 text-dark">Don't have an account? Create your account, it takes less
                                        than five minutes</h5>
                                    <div class="text-center d-grid">
                                        <a class="btn btn-dark" href="register"> Register </a>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                            
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="{{ route('password.request') }}" class="text-white ms-1">Forgot your password?</a></p>
                            <p> <a class="text-white ms-1" href="{{ route('aboutUs')}}">About Us</a> |<a class="text-white ms-1" href="{{ route('termsAndConditions')}}">Terms & Conditions</a> |<a class="text-white ms-1" href="{{ route('privacyPolicy')}}">Privacy Policy</a> | <a class="text-white" href="{{ route('contactUs')}}">Contact Us</a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <footer class="footer footer-alt" style="color:black">
        <script>
            document.write(new Date().getFullYear())
        </script> &copy; Developed by <a href="#" class="text-white">Bitsapp</a>
    </footer>
    <script type="text/javascript">
        var site_url = "{{ url('/') }}";
        var asset_url = "{{ asset('/') }}";
    </script>
    <!-- Vendor js -->
    <script src="{{ asset('/assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('/assets/js/app.min.js') }}"></script>
    <!-- Tost-->
    <script src="{{ asset('assets/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>

    @if (session('success'))
        {{-- <script type="text/javascript">
            $(document).ready(function() {
                $.toast({
                    text: "{{ session('success') }}",
                    icon: 'success',
                    position:"top-right",
                    loaderBg:'#008b70',
                })
            });
        </script> --}}
    @endif

    @if (session('error'))
        {{-- <script type="text/javascript">
            $(document).ready(function() {
                $.toast({
                    text: "{{ session('error') }}",
                    icon: 'error',
                    position:"top-right",
                    loaderBg:'#bf441d',
                })
            });
        </script> --}}
    @endif

</body>

</html>
