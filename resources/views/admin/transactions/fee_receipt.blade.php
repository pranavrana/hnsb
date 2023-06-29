<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name', 'HNSB') }}</title>

    <link rel="icon" href="{{ asset('/assets/images/favicon.jpg') }}" type="image/ico" sizes="16x16">

    <!-- Jquery Toast css -->
    <link href="{{ asset('assets/libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="{{ asset('/assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap css -->
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="{{ asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="{{ asset('/assets/js/head.js') }}"></script>
    
    @stack('style')

</head>

<body data-layout-mode="default" data-theme="light" data-layout-width="fluid" data-topbar-color="dark"
    data-menu-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Transaction Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <!-- project card -->
                                <div class="card d-block">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="mt-2 mb-1">Payment Type :</label>
                                                <p>Admission Fees / College Fees</p>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="mt-2 mb-1">Student :</label>
                                                <div class="d-flex align-items-start">
                                                    <p> <a href="#"> {{$transaction->student->name ?? ''}} </a></p>
                                                </div> <!-- end col -->
                                            </div> <!-- end col -->
                                            <div class="col-md-4">
                                                <!-- assignee -->
                                                <label class="mt-2 mb-1">Email :</label>
                                                <div class="d-flex align-items-start">
                                                    <div class="w-100">
                                                        <p> {{$transaction->email}} </p>
                                                    </div>
                                                </div>
                                                <!-- end assignee -->
                                            </div> <!-- end col -->
                                            <div class="col-md-4">
                                                <label class="mt-2 mb-1">Contact No :</label>
                                                <div class="d-flex align-items-start">
                                                    <p> {{$transaction->contact_no}} </p>
                                                </div> <!-- end col -->
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="mt-2 mb-1">Order ID :</label>
                                                <div class="d-flex align-items-start">
                                                    <p> {{$transaction->order_id}} </p>
                                                </div> <!-- end col -->
                                            </div> <!-- end col -->
                                            <div class="col-md-4">
                                                <!-- assignee -->
                                                <label class="mt-2 mb-1">Amount :</label>
                                                <div class="d-flex align-items-start">
                                                    <div class="w-100">
                                                        <p> {{$transaction->amount}} </p>
                                                    </div>
                                                </div>
                                                <!-- end assignee -->
                                            </div> <!-- end col -->
                                            <div class="col-md-4">
                                                <label class="mt-2 mb-1">Transaction ID :</label>
                                                <div class="d-flex align-items-start">
                                                    <p> {{$transaction->txn_id}} </p>
                                                </div> <!-- end col -->
                                            </div> <!-- end col -->

                                            <div class="col-md-4">
                                                <!-- assignee -->
                                                <label class="mt-2 mb-1">Transaction Amount :</label>
                                                <div class="d-flex align-items-start">
                                                    <div class="w-100">
                                                        <p> {{$transaction->txn_amount}} </p>
                                                    </div>
                                                </div>
                                                <!-- end assignee -->
                                            </div> <!-- end col -->
                                        {{-- </div> <!-- end row --> --}}

                                        {{-- <div class="row"> --}}
                                            <div class="col-md-4">
                                                <label class="mt-2 mb-1">Payment Mode :</label>
                                                <div class="d-flex align-items-start">
                                                    <p> {{$transaction->txn_payment_mode}} </p>
                                                </div> <!-- end col -->
                                            </div> <!-- end col -->

                                            <div class="col-md-4">
                                                <!-- assignee -->
                                                <label class="mt-2 mb-1">Transaction Status :</label>
                                                <div class="d-flex align-items-start">
                                                    <div class="w-100">
                                                        <p> {{$transaction->txn_status}} </p>
                                                    </div>
                                                </div>
                                                <!-- end assignee -->
                                            </div> <!-- end col -->
                                            
                                            <div class="col-md-4">
                                                <!-- assignee -->
                                                <label class="mt-2 mb-1">Trnasaction Date Time :</label>
                                                <p>{{\Carbon\Carbon::parse($transaction->created_at)->format('Y/m/d')}} <small class="text-muted">{{\Carbon\Carbon::parse($transaction->created_at)->format('h:i A')}}</small></p>
                                                <!-- end assignee -->
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <label class="mt-4 mb-1">Overview :</label>

                                        <p class="text-muted mb-0">
                                            This is a wider card with supporting text below as a natural lead-in to additional
                                            content. This content is a little bit longer. Some quick example text to build on the
                                            card title and make up the bulk of the card's content. Some quick example text to build
                                            on the card title and make up.
                                        </p>

                                    </div> <!-- end card-body-->

                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- container -->
            </div> <!-- content -->
        </div>
    </div>
</body>

</html>