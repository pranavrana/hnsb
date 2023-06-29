<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>HNSB | Contact Us</title>
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

<!-- body start -->
<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="">
            <div class="content">
                <!-- Start Content-->
                <div class="container-lg">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    {{-- <a href="{{URL::to('login')}}" class="btn btn-secondary waves-effect me-2">Go to Login</a>
                                    <a href="{{URL::to('register')}}" class="btn btn-secondary waves-effect">Go to Registration</a> --}}
                                </div>
                                <center>
                                    <h2 class="mt-5 mb-4">Contact Us</h2>
                                </center>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <i class="mdi mdi-phone h2 text-muted"></i>
                                                    <h5><b>Phone</b></h5>
                                                    <p class="mb-1"><span class="fw-semibold">
                                                    (02772) 228925</span></p>
                                                    </br></br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <i class="mdi mdi-email h2 text-muted"></i>
                                                    <h5><b>Email</b></h5>
                                                    <p class="mb-1"><span class="fw-semibold">scihmt@yahoo.co.in</br>info@portal-hnsbscihmt.org</span></p>
                                                    </br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <i class="mdi mdi-map-marker h2 text-muted"></i>
                                                    <h5><b>Address</b></h5>
                                                    <p class="mb-1"><span class="fw-semibold">The HNSB LTD Science College, College Campus, Motipura, Himatnagar - 383 001. Dist Sabarkantha - Gujarat - India</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-5">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="tab-content p-3">
                                                    <div class="tab-pane fade active show" id="custom-v-pills-billing" role="tabpanel" aria-labelledby="custom-v-pills-billing-tab">
                                                        <div>
                                                            <h4 class="header-title">Contact Us</h4>
                                                            <p class="sub-header">Leave us your info and we will get back to you.</p>
                                                            <form id="submitContactForm" method="post" action="{{ route('submitContact') }}">
                                                            @csrf
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="billing-first-name" class="form-label">Name<span class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text" name="name" placeholder="Enter your name name" id="billing-first-name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="billing-email-address" class="form-label">Email <span class="text-danger">*</span></label>
                                                                            <input class="form-control" type="email" name="email" placeholder="Enter your email" id="billing-email-address">
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- end row -->
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="billing-phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text" name="phone" placeholder="(xx) xxx xxxx xxx" id="billing-phone">
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- end row -->
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="mb-3">
                                                                            <label for="example-textarea" class="form-label">Message<span class="text-danger">*</span></label>
                                                                            <textarea class="form-control" id="example-textarea" rows="3" placeholder="Write your message here" name="message"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- end row -->
        
                                                                <div class="row mt-1">
                                                                    <div class="col-sm-6">
                                                                        <button class="btn btn-success" type="submit"> Submit </button>
                                                                        <a class="btn btn-secondary" href="{{ route('contactUs')}}"> Reset </a>
                                                                    </div> <!-- end col -->
                                                                </div> <!-- end row -->
                                                            </form>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div> <!-- container -->

            </div> <!-- content -->
            <footer class="footer footer-alt" style="background-color:#98a6ad1f">
                <div class="row">
                    <div class="col-md-5">
                        <div class="text-md-start footer-links d-none d-sm-block">
                            <a class="text-dark" href="https://www.hnsbscihmt.org" target="_blank">www.hnsbscihmt.org</a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> &copy; Developed by <a href="#" class="text-dark">Bitsapp</a>
                    </div>
                    <div class="col-md-5">
                        <div class="text-md-end footer-links d-none d-sm-block">
                            <a class="text-dark" href="{{ route('login')}}">Login</a>
                            <a class="text-dark" href="{{ route('register')}}">Registration</a>
                            <a class="text-dark" href="{{ route('aboutUs')}}">About Us</a>
                            <a class="text-dark" href="{{ route('termsAndConditions')}}">Terms & Conditions</a>
                            <a class="text-dark" href="{{ route('privacyPolicy')}}">Privacy Policy</a>
                            <a class="text-dark" href="{{ route('contactUs')}}">Contact Us</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="{{ asset('/assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('/assets/js/app.min.js') }}"></script>
    <!-- Tost-->
    <script src="{{ asset('assets/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('/assets/js/additional-methods.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.validator.addMethod("noHTML", function(value, element) {
                return this.optional(element) || /^([A-Za-z0-9\n,.'"!@#$%^&*/()+-:;?€ ]+)$/.test(value);
            }, "No HTML tags are allowed!");	
            $('#submitContactForm').validate({
                errorClass: 'error text-danger',
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    message: {
                        required: true,
					    noHTML:true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter name.",
                    },
                    email: {
                        required: "Please enter an email.",
                    },
                    phone: {
                        required: "Please enter phone.",
                    },
                    message: {
                        required: "Please enter message.",
                    }
                },
                submitHandler: function(form) {
                    try {
                        $.ajax({
                            url: $(form).attr("action"),
                            type: 'POST',
                            data: $(form).serialize(),
                            datatype: "application/json",
                            beforeSend: function() {
                            },
                            success: function(data) {
                                if (data != '') {
                                    data = JSON.parse(data);
                                    if (data.status_code == 200 && data.message != '') {
                                        $.toast({
                                            text: data.message,
                                            icon: 'success',
                                            position: "top-right",
                                            loaderBg: '#008b70',
                                        })
                                        $(form).trigger("reset");
                                    } else if (data.status_code == 200 && data.message ==
                                        '') {
                                        //window.location = data.data.redirect;
                                    } else {
                                        $.toast({
                                            text: data.message,
                                            icon: 'error',
                                            position: "top-right",
                                            loaderBg: '#bf441d',
                                        });
                                    }
                                }
                            },
                            error: function(jqXHR, exception) {
                                window.location = site_url;
                            },
                        });
                    } catch (e) {
                        console.log(e);
                    }
                    return false;
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
</body>
</html>
