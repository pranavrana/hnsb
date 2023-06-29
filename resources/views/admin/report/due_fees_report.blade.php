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
                    <h4 class="page-title">Due Fee Student's List</h4>
                </div>
            </div>
        </div>
        @include('admin.include.filters')
        <!-- end page title -->
        <div class="row" style="margin-top:10px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Roll No</th>
                                        <th>Gender</th>
                                        <th>Name</th>
                                        <th>Caste</th>
                                        <!-- <th>Admission No</th> -->
                                        <th>GR.No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($students))
                                    @foreach ($students as $key => $s)
                                    <tr>
                                        <td>{{ $s->roll_no }}</td>
                                        <td>{{ $s->user->gender }}</td>
                                        <td>{{ $s->user->name }}</td>
                                        @php
                                            if($s->user->caste == 1):
                                            $cast = 'General';
                                            elseif($s->user->caste == 2):
                                            $cast = 'OBC';
                                            elseif($s->user->caste == 3):
                                            $cast = 'SC';
                                            else:
                                            $cast = 'ST';
                                            endif;
                                        @endphp
                                        <td>{{ $cast }}</td>
                                        <!-- <td>{{ $s->user->admission_no }}</td> -->
                                        <td>{{ $s->user->gr_no }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No Transaction Found!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if (isset($students) && count($students))
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.due_fees_report_print', request()->all()) }}" class="btn btn-success" target="_blank">Print</a>
                            </div>
                        @endif
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

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