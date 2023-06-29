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
                            <a href="{{ route('admin.admission_requests') }}" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
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
                                                @php
                                                    if($studentData->caste == 1):
                                                    echo 'General';
                                                    elseif($studentData->caste == 2):
                                                    echo 'OBC';
                                                    elseif($studentData->caste == 3):
                                                    echo 'SC';
                                                    else:
                                                    echo 'ST';
                                                    endif;
                                                @endphp
                                            </p>
                                            <h4 class="header-title mt-3">Current Address</h4>
                                            <p class="mb-2"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->address }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">City:</span>
                                                {{ $studentData->cur_city }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Taluko:</span>
                                                {{ $studentData->cur_taluko }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">District:</span>
                                                {{ $studentData->cur_district }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Pincode:</span>
                                                {{ $studentData->cur_pincode }}</p>
                                            <h4 class="header-title mt-3">Permanent Address</h4>
                                            <p class="mb-2"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->per_address }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">City:</span>
                                                {{ $studentData->per_city }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Taluko:</span>
                                                {{ $studentData->per_taluko }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">District:</span>
                                                {{ $studentData->per_district }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Pincode:</span>
                                                {{ $studentData->per_pincode }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="track-order-list">
                                <div class="text-center">
                                    <button id="approve" data-id="{{$studentData->id}}" class="btn btn-success">Approve</button>
                                    <button id="reject" data-id="{{$studentData->id}}" class="btn btn-danger">Reject</button>
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
                                            <p class="mb-2"><span class="fw-semibold me-2">Exam Center:</span>
                                                {{ $studentData->exam_center }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">School Name:</span>
                                                {{ $studentData->school_name }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Obtained Marks:</span>
                                                {{ $studentData->obtained_marks }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Form Fees Paid:</span>
                                                @if ($studentData->is_form_fees_paid == 1)
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif ($studentData->is_form_fees_paid == 0)
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                            </p>
                                            @php
                                                $enrollmentData = App\Models\StudentEnrollment::where('user_id', $studentData->id)->where('is_fees_paid', 0)->where('is_cancelled', 0)->first();
                                            @endphp
                                            <p class="mb-2"><span class="fw-semibold me-2">Course:</span>
                                                {{ $enrollmentData->course->course_name ?? '--' }}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <p class="mb-2"><span class="fw-semibold me-2">Passing Year:</span>
                                                {{ $studentData->passing_year }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Join Date:</span>
                                                {{ $studentData->join_date }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Leaving Date:</span>
                                                {{ $studentData->leaving_date }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Email:</span>
                                                {{ $studentData->email }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Group</span>
                                                {{ $enrollmentData->group->group_name ?? '--' }}
                                            </p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Semester:</span>
                                                {{ $enrollmentData->semester->semester_name ?? '--' }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">   
                                <div class="col-lg-6">
                                    {{-- <ul class="list-unstyled mb-0">
                                        <li class="mb-2"> --}}
                                            <p class="fw-semibold">Student Photo:</p>
                                            <img class="img-thumbnail" src="{{ asset('uploads/student_photo/' . $studentData->student_photo) }}" />
                                        {{-- </li>
                                        <li class="mb-2"> --}}
                                        </div>
                                <div class="col-lg-6">

                                            <p class="fw-semibold">Student Sign:</p>
                                            <img class="img-thumbnail" src="{{ asset('uploads/student_sign/' . $studentData->student_sign) }}" />
                                        {{-- </li>
                                    </ul> --}}
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
    <script>
        $(document).ready(function() {
            $(document).on("click", "#approve", function() {
                var student_id = $(this).attr("data-id");
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to approve this admission!",
                    icon: "success",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Yes, approve it!",
                }).then(function(e) {
                    if (e.value) {
                        try {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: site_url + "/admin/approve-admission",
                                type: 'POST',
                                data: {student:student_id},
                                datatype: "application/json",
                                success: function(data) {
                                    if (data != '') {
                                        data = JSON.parse(data);
                                        if (data.status_code == 200 && data.message != '') {
                                            $.toast({
                                                text: data.message,
                                                icon: 'success',
                                                position: "top-right",
                                                loaderBg: '#008b70',
                                            })
                                            setTimeout(function() {
                                                window.location = data.data
                                                    .redirect;
                                            }, 3000);
                                        } else if (data.status_code == 200 && data.message == '') {
                                            //window.location = data.data.redirect;
                                        } else {
                                            $.toast({
                                                text: data.message,
                                                icon: 'error',
                                                position: "top-right",
                                                loaderBg: '#bf441d',
                                            });
                                        }
                                    }
                                },
                                // complete:function(){ },
                                error: function(jqXHR, exception) {
                                    window.location = site_url;
                                },
                            });
                        } catch (e) {
                            console.log(e);
                        }
                    }
                });
            });
            $(document).on("click", "#reject", function() {
                var student_id = $(this).attr("data-id");
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to reject this admission!",
                    icon: "error",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Yes, reject it!",
                }).then(function(e) {
                    if (e.value) {
                        $('#student').val(student_id);
                        $('#staticBackdrop').modal('show')
                    }
                });
            });
            $('#rejectAdmission').validate({
                errorClass: 'error text-danger',
                rules: {
                    rejection_reason: {
                        required: true,
                    },
                },
                messages: {
                    rejection_reason: {
                        required: "Please enter rejection reason.",
                    },
                },
                submitHandler: function(form) {
                    try {
                        $.ajax({
                            url: $(form).attr("action"),
                            type: 'POST',
                            data: $(form).serialize(),
                            datatype: "application/json",
                            beforeSend: function() {
                                //$(form).find('button[type="submit"]').prop('disabled', true);
                                //$(form).find('button[type="submit"]').addClass('btn-spinner');
                            },
                            success: function(data) {
                                if (data != '') {
                                    data = JSON.parse(data);
                                    if (data.status_code == 200 && data.message != '') {
                                        $.toast({
                                            text: data.message,
                                            icon: 'success',
                                            position: "top-right",
                                            loaderBg: '#008b70',
                                        })
                                        setTimeout(function() {
                                            window.location = data.data.redirect;
                                        }, 3000);
                                    } else if (data.status_code == 200 && data.message ==
                                        '') {
                                        //window.location = data.data.redirect;
                                    } else {
                                        $.toast({
                                            text: data.message,
                                            icon: 'error',
                                            position: "top-right",
                                            loaderBg: '#bf441d',
                                        });
                                    }
                                }
                            },
                            // complete:function(){ },
                            error: function(jqXHR, exception) {
                                window.location = site_url;
                            },
                        });
                    } catch (e) {
                        console.log(e);
                    }
                    return false;
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endpush
