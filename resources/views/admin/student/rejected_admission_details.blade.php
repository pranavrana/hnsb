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
                            <a href="{{ route('admin.rejected_admissions') }}" class="btn btn-secondary waves-effect waves-light">
                                <i class="mdi mdi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                        <h4 class="page-title">Admission Details</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Student Details</h4>

                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <p class="mb-2"><span class="fw-semibold me-2">Name:</span>
                                                {{ $studentData->name }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Email:</span>
                                                {{ $studentData->email }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Contact No:</span>
                                                {{ $studentData->contact_no }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Birth Date:</span>
                                                {{ $studentData->birth_date }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Gender:</span>
                                                {{ $studentData->gender }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Caste:</span>
                                                {{ $studentData->caste }}</p>
                                            @if($studentData->address != "")
                                            <h4 class="header-title mt-3">Current Address</h4>
                                            <p class="mb-0"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->address }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">City:</span>
                                                {{ $studentData->cur_city }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Taluko:</span>
                                                {{ $studentData->cur_taluko }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">District:</span>
                                                {{ $studentData->cur_district }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Pincode:</span>
                                                {{ $studentData->cur_pincode }}</p>
                                            @endif
                                            @if($studentData->per_address != "")
                                            <h4 class="header-title mt-3">Permanent Address</h4>
                                            <p class="mb-0"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->per_address }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">City:</span>
                                                {{ $studentData->per_city }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Taluko:</span>
                                                {{ $studentData->per_taluko }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">District:</span>
                                                {{ $studentData->per_district }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Pincode:</span>
                                                {{ $studentData->per_pincode }}</p>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">School Details</h4>

                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <p class="mb-2"><span class="fw-semibold me-2">12th Marksheet No:</span>
                                                {{ $studentData->marksheet_no_12 }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Email:</span>
                                                {{ $studentData->email }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Obtained Marks:</span>
                                                {{ $studentData->obtained_marks }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Passing Year:</span>
                                                {{ $studentData->passing_year }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Exam Center:</span>
                                                {{ $studentData->exam_center }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Leaving Date:</span>
                                                {{ $studentData->leaving_date }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Join Sate:</span>
                                                {{ $studentData->join_date }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">School Name:</span>
                                                {{ $studentData->school_name }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Form Fees Paid:</span>
                                                {{ $studentData->is_form_fees_paid }}</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <p class="fw-semibold">Student Photo:</p>
                                            <img
                                                src="{{ asset('uploads/student_photo/' . $studentData->student_photo) }}" />
                                        </li>
                                        <li>
                                            <p class="fw-semibold">Student Sign:</p>
                                            <img src="{{ asset('uploads/student_sign/' . $studentData->student_sign) }}" />
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Rejection Reason</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p>{{ $studentData->admission_rejection_reason }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row mt-1 mb-2">
                <div class="col-6">
                    <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.rejected_admissions') }}" class="btn btn-light waves-effect waves-light m-1">
                            <i class="fe-x me-1"></i>Back
                        </a>
                            </div>
                    </div>
                </div>
            </div> -->
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
@endsection
@push('style')
    <!-- Sweet Alert-->
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
