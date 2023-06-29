@extends('admin.layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                    </div>
                    <h4 class="page-title">Forfeit Report 1</h4>
                </div>
            </div>
        </div>
        @include('admin.include.filters')
        @if(request()->has('academic_year_id') && !empty(request()->get('academic_year_id')) && request()->has('course_id') && !empty(request()->get('course_id')) && request()->has('semester_id') && !empty(request()->get('semester_id')))
            <div class="row" style="margin-top:10px;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.forfeit_report_1_print', request()->all()) }}" class="btn btn-success" target="_blank">Generate</a>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        @endif
    </div> <!-- container -->

</div> <!-- content -->
@endsection
@push('style')
<!-- third party css -->
<link href="{{ asset('/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
@endpush
@push('scripts')
<!-- third party js -->
<script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
{{-- <script src="{{ asset('/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script> --}}
<!-- third party js ends -->

<!-- Datatables init -->
<script src="{{ asset('/assets/js/pages/datatables.init.js') }}"></script>
@endpush