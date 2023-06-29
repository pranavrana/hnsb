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
                    <h4 class="page-title">Enrolment Student List</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Select Year</label>
                    <select name="" class="form-control">
                        @foreach($year as $y)
                            <option value="{{ $y->academic_year_id}}">{{ $y->year}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Select Course</label>
                    <select name="" class="form-control">
                        @foreach($course as $c)
                            <option value="{{ $c->course_id}}">{{ $c->course_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Select Semester</label>
                    <select name="" class="form-control">
                        @foreach($sem as $s)
                            <option value="{{ $s->semester_id}}">{{ $s->semester_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Select Group</label>
                    <select name="" class="form-control">
                        @foreach($group as $g)
                            <option value="{{ $g->group_id}}">{{ $g->group_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row" style="margin-top:10px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Roll No</th>
                                        <th>Admission No</th>
                                        <th>Surname</th>
                                        <th>Student Name</th>
                                        <th>Father Name</th>
                                        <th>Degree Name</th>
                                        <th>Combination Code</th>
                                        <th>Student Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Taluka</th>
                                        <th>City</th>
                                        <th>Nationality</th>
                                        <th>Date Of Birth</th>
                                        <th>Gender</th>
                                        <th>Cast</th>
                                        <th>12th Passing Year</th>
                                        <th>12th Passing  Month</th>
                                        <th>12th Exam Seat No.</th>
                                        <th>Collage Code</th>
                                        <th>Exam Name</th>
                                        <th>Obtain Marks</th>
                                        <th>Total Marks</th>
                                        <th>Semester</th>
                                        <th>Phone No.</th>
                                        <th>Email</th>
                                        <th>HSC  Exam Center</th>
                                        <th>HSC School Name</th>
                                        <th>School Joining Date</th>
                                        <th>School Leaving Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($student))
                                    @foreach ($student as $key => $s)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $s->surname }}</td>
                                        <td>{{ $s->student_name }}</td>
                                        <td>{{ $s->father_name }}</td>
                                        <td>degree</td>
                                        <td>combination_code</td>
                                        <td>{{ $s->address }}</td>
                                        <td>State</td>
                                        <td>District</td>
                                        <td>Taluka</td>
                                        <td>City</td>
                                        <td>Nationality</td>
                                        <td>{{ $s->birth_date }}</td>
                                        <td>{{ $s->gender }}</td>
                                        <td>{{ $s->cast }}</td>
                                        <td>12th Passing Year</td>
                                        <td>12th Passing  Month</td>
                                        <td>{{ $s->marksheet_no_12 }}</td>
                                        <td>Collage Code</td>
                                        <td>Exam Name</td>
                                        <td>Obtain Marks</td>
                                        <td>Total Marks</td>
                                        <td>Semester</td>
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
                                        <td colspan="9" class="text-center">No Transaction Found!</td>
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