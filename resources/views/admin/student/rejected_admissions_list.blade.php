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
                        <h4 class="page-title">Rejected Admissions</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course</th>
                                            <th>Semester</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact No</th>
                                            <th>12th Marksheet No</th>
                                            <th>Passing Year</th>
                                            <th>Exam Center</th>
                                            <th>School Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($studentsData))
                                            @foreach ($studentsData as $key => $student)
                                                @php
                                                    $enrollmentData = App\Models\StudentEnrollment::where('user_id', $student->id)->where('is_fees_paid', 0)->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $enrollmentData->course->course_name ?? '--' }}</td>
                                                    <td>{{ $enrollmentData->semester->semester_name ?? '--' }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->email }}</td>
                                                    <td>{{ $student->contact_no }}</td>
                                                    <td>{{ $student->marksheet_no_12 }}</td>
                                                    <td>{{ $student->passing_year }}</td>
                                                    <td>{{ $student->exam_center }}</td>
                                                    <td>{{ $student->school_name }}</td>
                                                    <td id="tooltip-container">
                                                        <a href="{{ route('admin.rejected_admission_view', $student->id) }}"
                                                            class="action-icon" data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                            <i class="mdi mdi-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Admission Requests Found!</td>
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
    <link href="{{ asset('/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />

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
