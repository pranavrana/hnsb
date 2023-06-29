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
                        <a href="{{ route('admin.students') }}" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
                    </div>
                    <h4 class="page-title">Reset Credentials</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form id="resetCredentialsForm" method="post" action="{{ route('admin.credentialsReset') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="mt-2 mb-1">Student Name :</label>
                                    <p>
                                        {{$studentData->name}}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="mt-2 mb-1">12 Marksheet No :</label>
                                    <p>
                                        {{$studentData->marksheet_no_12}}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="mt-2 mb-1">Contact No :</label>
                                    <p>
                                        {{$studentData->contact_no}}
                                    </p>
                                </div>
                            </div> <!-- end row -->
                            <div class="row">
                                @php
                                $enrollmentDetails = App\Models\StudentEnrollment::with(['academicYear', 'course', 'semester', 'group'])->where('user_id', $studentData->id)->latest()->first();

                                @endphp
                                <div class="col-md-3">
                                    <label class="mt-2 mb-1">Current Academic Year :</label>
                                    <p>
                                        {{$enrollmentDetails->academicYear->year ?? '-'}}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="mt-2 mb-1">Current Course :</label>
                                    <p>
                                        {{$enrollmentDetails->course->course_name ?? '-'}}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="mt-2 mb-1">Current Semester :</label>
                                    <p>
                                        {{$enrollmentDetails->semester->semester_name ?? '-'}}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="mt-2 mb-1">Current Group :</label>
                                    <p>
                                        {{$enrollmentDetails->group->group_name ?? '-'}}
                                    </p>
                                </div>
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{$studentData->email}}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="text" id="password" name="password" class="form-control" placeholder="Enter Password">
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mt-1 mb-2">
                                <div class="col-12 text-center">
                                        <input type="hidden" id="student_id" name="student_id" class="form-control" value="{{$studentData->id}}">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i> Save</button>
                                    <a href="{{ route('admin.students') }}" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
                                        Cancel</a>
                                </div>
                            </div>
                        </div> <!-- end card body-->
                    </form>

                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

</div> <!-- content -->
@endsection
@push('style')
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        $.validator.addMethod('Email', function(value) {
            return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
        }, 'Please enter a valid email.');
        $('#resetCredentialsForm').validate({
            errorClass: 'error text-danger',
            rules: {
                email: {
                    required: true,
                    Email: true
                }
            },
            messages: {
                email: {
                    required: "Please select course.",
                }
            },
            submitHandler: function(form) {
                try {
                    $.ajax({
                        url: $(form).attr("action"),
                        type: 'POST',
                        data: $(form).serialize(),
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
                                    });
                                    setTimeout(function() {
                                        window.location = data.data.redirect;
                                    }, 1500);
                                } else if (data.status_code == 200 && data.message == '') {
                                    window.location = data.data.redirect;
                                } else {
                                    $.toast({
                                        text: data.message,
                                        icon: 'error',
                                        position: "top-right",
                                        loaderBg: '#bf441d',
                                    });
                                    //$(form).find('button[type="submit"]').prop('disabled', false);
                                    //$(form).find('button[type="submit"]').removeClass('btn-spinner');
                                }
                            }
                        },
                        // complete:function(){ },
                        error: function(jqXHR, exception) {
                            // window.location = site_url;
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
