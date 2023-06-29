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
        @include('layouts.header')
        <div class="content-page">
            @yield('content')
        </div>
      
        @include('layouts.footer')
        <script type="text/javascript">
            var site_url = "{{ url('/') }}";
            var asset_url = "{{ asset('/') }}";
            var asset_url = "{{ asset('/') }}";
        </script>

        <!-- App js-->
        <script src="{{ asset('/assets/js/vendor.min.js') }}"></script>

        <!-- Plugins js-->
        <script src="{{ asset('/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <script src="{{ asset('/assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>

        <!-- Dashboar 1 init js-->
        <script src="{{ asset('/assets/js/pages/dashboard-1.init.js') }}"></script>

        <!-- App js-->
        <script src="{{ asset('/assets/js/app.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/noty/lib/noty.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.validate.js') }}"></script>
        <script src="{{ asset('/assets/js/additional-methods.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.inputmask.js') }}"></script>

        <!-- Tost-->
        <script src="{{ asset('assets/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>

        @if (session('success'))
            <script type="text/javascript">
                $(document).ready(function() {
                    $.toast({
                        text: "{{ session('success') }}",
                        icon: 'success',
                        position: "top-right",
                        loaderBg: '#008b70',
                    });
                });
            </script>
            @php
                Session::forget(['success']);
            @endphp
        @endif

        @if (session('error'))
            <script type="text/javascript">
                $(document).ready(function() {
                    $.toast({
                        text: "{{ session('error') }}",
                        icon: 'error',
                        position: "top-right",
                        loaderBg: '#bf441d',
                    });
                });
            </script>
            @php
                Session::forget(['error']);
            @endphp
        @endif
    @stack('scripts')
    <script>
        $(document).ready(function() {
            if ($('[data-bs-toggle="tooltip"]').length) {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    </script>
</body>

</html>
