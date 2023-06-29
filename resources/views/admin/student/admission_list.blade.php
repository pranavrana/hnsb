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
                            {{-- <a href="javascript:void(0)" class="btn btn-danger waves-effect waves-light"> --}}
                            <a href="{{ route('admin.admission_requests_export', request()->all()) }}" class="btn btn-danger waves-effect waves-light">
                                <i class="mdi mdi-download-circle me-1"></i> Download
                            </a>
                        </div>
                        <h4 class="page-title">Admission Requests</h4>
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
                                            <th>Obtained Marks</th>
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
                                                    $enrollmentData = App\Models\StudentEnrollment::where('user_id', $student->id)->where('is_fees_paid', 0)->where('is_cancelled', 0)->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $enrollmentData->course->course_name ?? '--' }}</td>
                                                    <td>{{ $enrollmentData->semester->semester_name ?? '--' }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->email }}</td>
                                                    <td>{{ $student->contact_no }}</td>
                                                    <td>{{ $student->obtained_marks }}</td>
                                                    <td>{{ $student->marksheet_no_12 }}</td>
                                                    <td>{{ $student->passing_year }}</td>
                                                    <td>{{ $student->exam_center }}</td>
                                                    <td>{{ $student->school_name }}</td>
                                                    <td id="tooltip-container">
                                                        <a href="{{ URL::to('admin/edit-admission-request').'/'.$student->id }}" class="action-icon" data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="{{ route('admin.admission_request_view', $student->id) }}"
                                                            class="action-icon" data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                            <i class="mdi mdi-eye"></i></a>
                                                        <a href="javascript:void(0);" id="approve"
                                                            data-id="{{ $student->id }}" class="action-icon"
                                                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Approve Admission"> <i
                                                                class="mdi mdi-account-check-outline"></i></a>
                                                        <a href="javascript:void(0);" id="reject"
                                                            data-id="{{ $student->id }}" class="action-icon"
                                                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Reject Admission"> <i
                                                                class="mdi mdi-account-cancel-outline"></i></a>
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
    <!-- third party css -->
    <link href="{{ asset('/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

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
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            $.ajax({
                                url: site_url + "/admin/approve-admission",
                                type: 'POST',
                                data: {
                                    student: student_id
                                },
                                datatype: "application/json",
                                success: function(data) {
                                    if (data != '') {
                                        data = JSON.parse(data);
                                        if (data.status_code == 200 && data.message !=
                                            '') {
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
                                        } else if (data.status_code == 200 && data
                                            .message == '') {
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
