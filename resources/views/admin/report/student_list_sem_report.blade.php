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
                    <h4 class="page-title">Student List (Sem Wise)</h4>
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
                                        <th>Admission No.</th>
                                        <th>GR No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($student) && count($student))
                                    @foreach ($student as $key => $s)
                                    @php
                                        $enrollmentDetails = $s->enrollment()->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id'), 'group_id' => request()->get('group_id')])->first();
                                    @endphp
                                    <tr>
                                        <td>
                                            @if(isset($enrollmentDetails) && !empty($enrollmentDetails) && isset($enrollmentDetails->roll_no) && !empty($enrollmentDetails->roll_no))
                                                {{ $enrollmentDetails->roll_no }}
                                            @else 
                                                {{ '--' }}
                                            @endif    
                                        </td>
                                        <td>{{ $s->gender }}</td>
                                        <td>{{ $s->name }}</td>
                                        @if($s->caste == 1)
                                        <td>General</td>
                                        @elseif($s->caste == 2)
                                        <td>OBC</td>
                                        @elseif($s->caste == 3)
                                        <td>SC</td>
                                        @else
                                        <td>ST</td>
                                        @endif
                                        <td>{{ $s->admission_no }}</td>
                                        <td>{{ $s->gr_no }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No Student Found!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if (!empty($student) && count($student))
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.student_list_sem_report_export', request()->all()) }}" class="btn btn-success">Export to Excel</a>
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