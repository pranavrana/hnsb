{{-- 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
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
    <title>Reset Password | HNSB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="HNSB" name="author" />
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
                                <h4 class="mb-4 mt-3">{{ __('Reset Password') }}</h4>
                            </div>
                            @error('email')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            @error('password')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                            <form id="resetPassword" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" name="email" id="emailaddress"
                                        value="{{ $email ?? old('email') }}" readonly>
                                </div>
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password-confirm" name="password_confirmation" class="form-control"
                                            placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Reset Password </button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

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
    <script src="{{ asset('/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('/assets/js/additional-methods.min.js') }}"></script>

    <script>
        $.validator.addMethod('Email', function(value) {
            return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
        }, 'Please enter a valid email.');
        $('#resetPassword').validate({
            errorClass: 'error text-danger',
            rules: {
                email: {
                    required: true,
                    Email: true,
                },
                password: {
                    required: true,
                    strongpassword: true
                },
                password_confirmation: {
                    required: true,
                    strongpassword: true,
                    equalTo : "#password",
                },
            },
            messages: {
                email: {
                    required: "Please enter an email address.",
                    // remote: "This email address is already registred.",
                },
                password: {
                    required: "Please enter password.",
                },
                password_confirmation: {
                    required: "Please enter confirm password.",
    				equalTo: 'Password and confirm password are not match.'
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "password" || element.attr("name") == "password_confirmation") {
                    error.insertAfter(element.parent('div'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $.validator.addMethod('strongpassword', function(value) {
                return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(value);
            },
            'Password should contain at least one digit,at least one lower case,at least one upper case and at least 8 from the mentioned characters.'
        );
    </script>
</body>

</html>
