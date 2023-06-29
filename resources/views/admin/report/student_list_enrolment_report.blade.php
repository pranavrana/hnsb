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
                    <h4 class="page-title">Student List For Enrolment (Sem Wise & Group Wise)</h4>
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
                                        <th>Surname</th>
                                        <th>Student Name</th>
                                        <th>Father Name</th>
                                        <th>Degree</th>
                                        <th>Combination Code</th>
                                        <th>Student Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Taluka</th>
                                        <th>City</th>
                                        <th>Nationality</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Caste</th>
                                        <th>12th Passing Year</th>
                                        <th>12th Passing Month</th>
                                        <th>12th Exam Seat No.</th>
                                        <th>College Code</th>
                                        <th>Exam Name</th>
                                        <th>Obtain Marks</th>
                                        <th>Total Marks</th>
                                        <th>Semester</th>
                                        <th>Phone No.</th>
                                        <th>Email</th>
                                        <th>HSC Exam Centre</th>
                                        <th>HSC School Name</th>
                                        <th>School Joining Date</th>
                                        <th>School Leaving Date</th>
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
                                        <td>{{ $s->surname }}</td>
                                        <td>{{ $s->student_name }}</td>
                                        <td>{{ $s->father_name }}</td>
                                        <td>
                                            @if(isset($enrollmentDetails) && !empty($enrollmentDetails) && isset($enrollmentDetails->course) && !empty($enrollmentDetails->course))
                                                {{ $enrollmentDetails->course->course_name }}
                                            @else 
                                                {{ '--' }}
                                            @endif
                                        </td>
                                        <td>{{ $s->combination_code }}</td>
                                        <td>{{ $s->address }}</td>
                                        <td>{{ $s->cur_state }}</td>
                                        <td>{{ $s->cur_district }}</td>
                                        <td>{{ $s->cur_taluko }}</td>
                                        <td>{{ $s->cur_city }}</td>
                                        <td>{{ $s->nationality }}</td>
                                        <td>{{ $s->birth_date }}</td>
                                        <td>{{ $s->gender }}</td>
                                        <td>{{ $s->caste }}</td>
                                        <td>{{ $s->passing_year }}</td>
                                        <td>{{ $s->passing_month }}</td>
                                        <td>{{ $s->marksheet_no_12 }}</td>
                                        <td>{{ $s->college_code }}</td>
                                        <td>{{ $s->exam_name }}</td>
                                        <td>{{ $s->obtained_marks }}</td>
                                        <td>{{ $s->total_marks }}</td>
                                        <td>
                                            @if(isset($enrollmentDetails) && !empty($enrollmentDetails) && isset($enrollmentDetails->semester) && !empty($enrollmentDetails->semester))
                                                {{ $enrollmentDetails->semester->semester_name }}
                                            @else 
                                                {{ '--' }}
                                            @endif
                                        </td>
                                        <td>{{ $s->contact_no }}</td>
                                        <td>{{ $s->email }}</td>
                                        <td>{{ $s->exam_center }}</td>
                                        <td>{{ $s->school_name}}</td>
                                        <td>{{ $s->join_date }}</td>
                                        <td>{{ $s->leaving_date }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="9" class="text-center">No Data Found!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if (!empty($student) && count($student))
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.student_list_enrolment_export', request()->all()) }}" class="btn btn-success">Export to Excel</a>
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
<script type='text/javascript'>
    if("{{ request()->get('course_id') !== null || request()->get('course_id') !== ''}}"){
        $('#course').val("{{ request()->get('course_id') }}");
    }
    if("{{ request()->get('semester_id') !== null || request()->get('semester_id') !== ''}}"){
        $('#semester').val("{{request()->get('semester_id')}}");
    }
    if("{{ request()->get('group_id') !== null || request()->get('group_id') !== ''}}"){
        $('#group').val("{{request()->get('group_id')}}");
    }

</script>
@endpush