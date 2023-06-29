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
                            <a href="{{ route('admin.enrollments') }}" class="btn btn-secondary waves-effect waves-light">
                                <i class="mdi mdi-arrow-left me-1"></i>Back
                            </a>
                        </div>
                        <h4 class="page-title">Enrollment Details</h4>
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
                                        @php
                                            if($studentData->user->caste == 1):
                                            $cast = 'General';
                                            elseif($studentData->user->caste == 2):
                                            $cast = 'OBC';
                                            elseif($studentData->user->caste == 3):
                                            $cast = 'SC';
                                            else:
                                            $cast = 'ST';
                                            endif;
                                        @endphp
                                        <p class="mb-2"><span mb-2an class="fw-semibold me-2">Gr No:</span>
                                                {{ $studentData->user->gr_no ?? '-' }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Name:</span>
                                                {{ $studentData->user->name }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Email:</span>
                                                {{ $studentData->user->email }}</p>
                                            <p class="mb-2" mb-2><span class="fw-semibold me-2">Contact No:</span>
                                                {{ $studentData->user->contact_no }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Birth Date:</span>
                                                {{ $studentData->user->birth_date }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Aadhar Card No:</span>
                                                {{ $studentData->user->aadhar_card_no }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Gender:</span>
                                                {{ $studentData->user->gender }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Caste:</span>
                                                {{ $cast }}
                                                
                                                </p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->user->address }}</p>

                                            @if($studentData->user->address != "")
                                            <h4 class="header-title mt-3">Current Address</h4>
                                            <p class="mb-2"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->user->address }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">City:</span>
                                                {{ $studentData->user->cur_city }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Taluko:</span>
                                                {{ $studentData->user->cur_taluko }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">District:</span>
                                                {{ $studentData->user->cur_district }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Pincode:</span>
                                                {{ $studentData->user->cur_pincode }}</p>
                                            @endif
                                            @if($studentData->user->per_address != "")
                                            <h4 class="header-title mt-3">Permanent Address</h4>
                                            <p class="mb-2"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->user->per_address }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">City:</span>
                                                {{ $studentData->user->per_city }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Taluko:</span>
                                                {{ $studentData->user->per_taluko }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">District:</span>
                                                {{ $studentData->user->per_district }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Pincode:</span>
                                                {{ $studentData->user->per_pincode }}</p>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Current Enrollment Details</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                        <p class="mb-2"><span class="fw-semibold me-2">Academic Year:</span>
                                                {{ $studentData->academicYear->year ?? '-' }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Course:</span>
                                                {{ $studentData->course->course_name }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Semester:</span>
                                                {{ $studentData->semester->semester_name }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Group:</span>
                                                {{ $studentData->group->group_name }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Roll NO:</span>
                                                {{ $studentData->roll_no }}</p>
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
                                                {{ $studentData->user->marksheet_no_12 }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Email:</span>
                                                {{ $studentData->user->email }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Obtained Marks:</span>
                                                {{ $studentData->user->obtained_marks }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Passing Year:</span>
                                                {{ $studentData->user->passing_year }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Exam Center:</span>
                                                {{ $studentData->user->exam_center }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Leaving Date:</span>
                                                {{ $studentData->user->leaving_date }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Join Sate:</span>
                                                {{ $studentData->user->join_date }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">School Name:</span>
                                                {{ $studentData->user->school_name }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Form Fees Paid:</span>
                                                @if ($studentData->user->is_form_fees_paid == 1)
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif ($studentData->user->is_form_fees_paid == 0)
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <p class="fw-semibold mb-2">Student Photo:</p>
                                            <img
                                                src="{{ asset('uploads/student_photo/' . $studentData->user->student_photo) }}"  class="img-fluid rounded" width="250"/>
                                        </li>
                                        <li>
                                            <p class="fw-semibold mb-2">Student Sign:</p>
                                            <img src="{{ asset('uploads/student_sign/' . $studentData->user->student_sign) }}" class="img-fluid rounded" width="250"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="rejectAdmission" method="post" action="{{ route('admin.reject_admission') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Reject Admission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label>Enter Admission Rejection Reason</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"></textarea>
                            <input type="hidden" id="student" name="student">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- content -->
@endsection
@push('style')
    <!-- Sweet Alert-->
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <!-- Sweet Alerts js -->
    <script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
@endpush
