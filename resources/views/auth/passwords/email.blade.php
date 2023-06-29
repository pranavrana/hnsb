{{-- 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Forgot Password | HNSB</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.jpg') }}">

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
                                        <a href="{{route('home')}}" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="{{ asset('/assets/images/ins_logo.png') }}" alt="HNSB Logo" height="220">
                                            </span>
                                        </a>
                    
                                        <a href="{{route('home')}}" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="{{ asset('/assets/images/ins_logo.png') }}" alt="HNSB Logo" height="220">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                                </div>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input class="form-control" type="email" id="email" required="" placeholder="Enter your email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                        @error('email')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                        
                                    </div>

                                    <div class="text-center d-grid">
                                        <button class="btn btn-primary" type="submit"> Reset Password </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-dark">Back to <a href="{{ route('login') }}" class="text-white ms-1"><b>Log in</b></a></p>
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

        <!-- Vendor js -->
        <script src="{{ asset('/assets/js/vendor.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('/assets/js/app.min.js') }}"></script>
        
    </body>
</html>