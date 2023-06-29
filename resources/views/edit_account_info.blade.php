@extends('layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('home') }}" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
                    </div>
                    <h4 class="page-title">Account Info</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <form id="updateAccountForm" method="post" action="{{ route('account_update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$userData->id}}" class="form-control">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 mb-3">
                                <h4 class="text-center">Manage Profile</h4>
                                <div class="mt-3">
                                    <input type="hidden" name="old_image_path" id="old_image_path" value="{{$userData->student_photo}}" />
                                    @if($userData->student_photo != null && file_exists( public_path() . '/uploads/student_photo/' . $userData->student_photo))
                                    <label for="student_photo" class="form-label">Profile</label>
                                    <input type="file" data-plugins="dropify" id="student_photo" name="student_photo" data-default-file="{{ asset('/uploads/student_photo/'.$userData->student_photo) }}" />
                                    @else
                                    <label for="student_photo" class="form-label">Profile</label>
                                    <input type="file" data-plugins="dropify" id="student_photo" name="student_photo" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="student_name" class="form-label">Student Name <span class="text-danger">*</span></label>
                                    <input type="text" id="student_name" name="student_name" value="{{$userData->student_name}}" class="form-control" placeholder="Enter Student Name">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
                                    <input type="father_name" id="father_name" value="{{$userData->father_name}}" name="father_name" class="form-control" placeholder="Enter Father Name" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                                    <input type="surname" id="surname" value="{{$userData->surname}}" name="surname" class="form-control" placeholder="Enter Surname" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="contact_no" class="form-label">Contact No</label>
                                    <input type="contact_no" id="contact_no" value="{{$userData->contact_no}}" name="contact_no" class="form-control" placeholder="Contact No" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="marksheet_no_12" class="form-label">12th Marksheet No</label>
                                    <input type="marksheet_no_12" id="marksheet_no_12" value="{{$userData->marksheet_no_12}}" name="marksheet_no_12" class="form-control" placeholder="Enter 12th Marksheet No" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="address" id="address" value="{{$userData->address}}" name="address" class="form-control" placeholder="Enter Address" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" value="{{$userData->email}}" name="email" class="form-control" placeholder="Enter Email" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="gr_no" class="form-label">GR. No</label>
                                    <input type="gr_no" id="gr_no" value="{{$userData->gr_no}}" name="gr_no" class="form-control" placeholder="Enter GR. No" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="aadhar_card_no" class="form-label">Adhar Card No.</label>
                                    <input type="aadhar_card_no" id="aadhar_card_no" value="{{$userData->aadhar_card_no}}" name="aadhar_card_no" class="form-control" placeholder="Enter Adharcard No" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Birth Date</label>
                                    <input type="birth_date" id="birth_date" value="{{$userData->birth_date}}" name="birth_date" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- end row -->
                        <div class="row mt-1 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i> Save</button>
                                <a href="{{ route('home') }}" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
                                    Cancel</a>
                            </div>
                        </div>
                </div> <!-- end card body-->
                </form>

            </div> <!-- end card -->
            <div class="col-12">
                <div class="card">
                    <form id="changePasswordForm" method="post" action="{{ route('change_password') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$userData->id}}" class="form-control">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h4 class="text-center">Change Password</h4>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter current password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter current password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Enter confirm password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mt-1 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i> Save</button>
                                <a href="{{ route('home') }}" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
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
<!-- third party css -->

<link href="{{ asset('/assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
@endpush
@push('scripts')

<script src="{{ asset('/assets/libs/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('/assets/libs/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('/assets/js/pages/form-fileuploads.init.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#updateAccountForm').validate({
            errorClass: 'error text-danger',
            rules: {
                name: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter name.",
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                console.log(form);
                try {
                    $.ajax({
                        url: $(form).attr("action"),
                        type: 'POST',
                        datatype: "application/json",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
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

        $('#changePasswordForm').validate({
            errorClass: 'error text-danger',
            rules: {
                current_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                    strongpassword: true,
                },
                confirm_password: {
                    required: true,
                    strongpassword: true,
                    equalTo: "#new_password",
                }
            },
            messages: {
                current_password: {
                    required: "Please enter current password.",
                },
                new_password: {
                    required: "Please enter new password.",
                },
                confirm_password: {
                    required: "Please enter confirm password.",
                    equalTo: 'New Password and confirm password are not match.'
                }
            },
            submitHandler: function(form) {
                try {
                    $.ajax({
                        url: $(form).attr("action"),
                        type: 'POST',
                        datatype: "application/json",
                        data: $(form).serialize(),
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
                if (element.attr("name") == "current_password") {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "new_password") {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "confirm_password") {
                    error.insertAfter(element.parent());
                }
            }
        });
    });
    $.validator.addMethod('strongpassword', function(value) {
            return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(value);
        },
        'Password should contain at least one digit,at least one lower case,at least one upper case and at least 8 from the mentioned characters.'
    );
    $(".dropify-clear").click(function() {
        $("#old_image_path").val('');
    });
</script>
@endpush