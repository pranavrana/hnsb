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
                    <h4 class="page-title">Group & Sem Wise Caste Report All Student</h4>
                </div>
            </div>
        </div>
        @include('admin.include.filters')
        <!-- end page title -->
        <div class="row" style="margin-top:10px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if(request()->get('academic_year_id') !== null && request()->get('course_id') !== null && request()->get('semester_id') !== null && request()->get('group_id') !== null)
                            <div class="alert alert-primary">
                                Caste-wise Report of Academic Year: {{ $selectedYear ?? '-' }} - Degree: {{ $selectedCourse ?? '-' }} - Semester: {{ $selectedSemester ?? '-' }} - Group: {{ $selectedGroup ?? '-' }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Caste</th>
                                        <th>Male</th>
                                        <th>Female</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($student))
                                    @php 
                                        $totalStudents = 0;
                                        $totalMale = 0;
                                        $totalFemale = 0;
                                    @endphp
                                    @foreach ($student as $key => $s)
                                    <tr>
                                        @if($s->caste == 1)
                                            <td>{{ 'General' }}</td>
                                        @elseif($s->caste == 2)
                                            <td>{{ 'OBC' }}</td>
                                        @elseif($s->caste == 3)
                                            <td>{{ 'SC' }}</td>
                                        @elseif($s->caste == 4)
                                            <td>{{ 'ST' }}</td>
                                        @endif
                                        <td>{{ $s->Male }}</td>
                                        <td>{{ $s->Female }}</td>
                                        <td>{{ $s->Male + $s->Female }}</td>
                                    </tr>
                                    @php
                                        $totalStudents += $s->Male + $s->Female;
                                        $totalMale += $s->Male;
                                        $totalFemale += $s->Female;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td class="text-right">
                                        <b>Total Nos. Of Students: </b>
                                        </td>
                                        <td>{{ $totalMale }}</td>
                                        <td>{{ $totalFemale }}</td>
                                        <td>
                                            {{$totalStudents}}
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No student Found!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
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