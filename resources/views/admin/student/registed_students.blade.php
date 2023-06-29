@extends('admin.layouts.app')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        {{-- @if(Auth::guard('admin')->user()->hasPermissionTo('registered-students-export')) --}}
                        <div class="page-title-right">
                            <a href="{{ route('admin.registered_students_export', request()->all()) }}" class="btn btn-danger waves-effect waves-light">
                                <i class="mdi mdi-download-circle me-1"></i> Download
                            </a>
                        </div>
                        {{-- @endif --}}
                        <h4 class="page-title">Registered Students</h4>
                    </div>
                </div>
            </div>
            @include('admin.include.filters')
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
                                        <th>Address</th>
                                        <th>Form Fees Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($studentsData))
                                        @foreach ($studentsData as $key => $student)
                                            @php
                                                $enrollmentData = App\Models\StudentEnrollment::where('user_id', $student->id)->where('group_id', 0)->orWhere('group_id', null)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $enrollmentData->course->course_name ?? '--' }}</td>
                                                <td>{{ $enrollmentData->semester->semester_name ?? '--' }}</td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->contact_no }}</td>
                                                <td>{{ $student->marksheet_no_12 }}</td>
                                                <td>{{ $student->address }}</td>
                                                <td>
                                                    @if ($student->is_form_fees_paid == 1)
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif ($student->is_form_fees_paid == 0)
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td id="tooltip-container">
                                                    @if ($student->is_form_fees_paid == 0)
                                                        <a href="{{route('admin.manual_admission_fees', $student->id)}}" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Collect Admission Fee Manually"> <i class="mdi mdi-account-cash"></i></a>
                                                    @endif
                                                    <a href="{{ URL::to('admin/edit-student').'/'.$student->id }}" class="action-icon" data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Student Details"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                    @if ($student->is_form_fees_paid == 1 && $student->is_completed_registration == 0)
                                                        <a href="{{route('admin.admission_form', $student->id)}}" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Admission Form"> <i class="mdi mdi-book-edit"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No Registed Students Found!</td>
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
