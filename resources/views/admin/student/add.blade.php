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
                            <a href="{{ route('admin.students') }}" class="btn btn-secondary waves-effect waves-light"><i
                                    class="mdi mdi-arrow-left me-1"></i> Back</a>
                        </div>
                        <h4 class="page-title">Add Student</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form id="addStudentForm" method="post" action="{{ route('admin.student_insert') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="student_name" class="form-label">Student Name <span class="text-danger">*</span></label>
                                            <input type="text" id="student_name" name="student_name" class="form-control"
                                                placeholder="Enter Student Name">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
                                            <input type="text" id="father_name" name="father_name" class="form-control"
                                                placeholder="Enter Father Name">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                                            <input type="text" id="surname" name="surname" class="form-control"
                                                placeholder="Enter Surname">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="contact_no" class="form-label">Contact No <span class="text-danger">*</span></label>
                                            <input type="text" id="contact_no" name="contact_no" class="form-control"
                                                placeholder="Enter Contact No">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="marksheet_no" class="form-label">12th Marksheet No <span class="text-danger">*</span></label>
                                            <input type="text" id="marksheet_no" name="marksheet_no" class="form-control"
                                                placeholder="Enter 12th Marksheet No">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password <span class="text-danger">*</span> </label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span> </label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Enter confirm password">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $courses = App\Models\Course::get();
                                @endphp
                                <div class="row mb-3">
                                    <div class="col-xl-4">
                                        <label for="course" class="form-label">Course <span class="text-danger">*</span></label>
                                        <select class="form-select" id="course" name="course">
                                            <option value="" selected="">Please Select Course</option>
                                            @if (!empty($courses))
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->course_id }}">
                                                        {{ $course->course_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('course')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-xl-4">
                                        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                        <select class="form-select" id="semester" name="semester">
                                            <option value="" selected="">Please Select Semester</option>
                                        </select>
                                        @error('semester')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="address" name="address" placeholder="Enter Address" required>
                                        @error('address')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_city" class="form-label">City <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_city" name="cur_city" placeholder="Enter City" required>
                                        @error('cur_city')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_taluko" class="form-label">Taluko <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_taluko" name="cur_taluko" placeholder="Enter Taluko" required>
                                        @error('cur_taluko')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="cur_district" class="form-label">District <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_district" name="cur_district" placeholder="Enter District" required>
                                        @error('cur_district')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_pincode" name="cur_pincode" placeholder="Enter Pincode" required>
                                        @error('cur_pincode')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mt-1 mb-2">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i> Save</button>
                                    <a href="{{ route('admin.students') }}"
                                        class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
                                        Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end card body-->

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
            $.validator.addMethod("lettersonly2", function(value, element) {
                return this.optional(element) || /^\S+[a-z]+$/i.test(value);
            }, "Please enter valid full name.");
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-z," "]+$/i.test(value);
            }, "");
            $('#addStudentForm').validate({
                errorClass: 'error text-danger',
                rules: {
                    student_name: {
                        required: true,
                        lettersonly2: true,
                        lettersonly: true,
                        //noSpace: true
                    },
                    father_name: {
                        required: true,
                        lettersonly2: true,
                        lettersonly: true,
                        //noSpace: true
                    },
                    surname: {
                        required: true,
                        lettersonly2: true,
                        lettersonly: true,
                        //noSpace: true
                    },
                    email: {
                        required: true,
                        Email: true,
                        //remote:{
                        //    type: "POST",
                        //    url: site_url+"verifyemail",
                        //}
                    },
                    contact_no: {
                        required: true,
                    },
                    marksheet_no: {
                        required: true,
                    },
                    password: {
                        required: true,
                        strongpassword: true
                    },
                    confirm_password: {
                        required: true,
                        strongpassword: true,
                        equalTo : "#password",
                    },
                    course: {
                        required: true
                    },
                    semester: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    cur_city: {
                        required: true
                    },
                    cur_taluko: {
                        required: true
                    },
                    cur_district: {
                        required: true
                    },
                    cur_pincode: {
                        required: true
                    }
                },
                messages: {
                    student_name: {
                        required: "Please enter student name.",
                        lettersonly2: "Please enter valid student name.",
                        lettersonly: "Please enter valid student name."
                    },
                    father_name: {
                        required: "Please enter father name.",
                        lettersonly2: "Please enter valid father name.",
                        lettersonly: "Please enter valid father name."
                    },
                    surname: {
                        required: "Please enter surname.",
                        lettersonly2: "Please enter valid surname.",
                        lettersonly: "Please enter valid surname."
                    },
                    email: {
                        required: "Please enter an email.",
                        // remote: "This email address is already registred.",
                    },
                    contact_no: {
                        required: "Please enter contact no.",
                    },
                    marksheet_no: {
                        required: "Please enter 12th marksheet no.",
                    },
                    password: {
                        required: "Please enter password.",
                    },
                    confirm_password: {
                        required: "Please enter conform password.",
                        equalTo: 'Password and confirm password are not match.'
                    },
                    course: {
                        required: "Please select course.",
                    },
                    semester: {
                        required: "Please select semester.",
                    },
                    address: {
                        required: "Please enter address.",
                    },
                    cur_city: {
                        required: "Please enter city.",
                    },
                    cur_taluko: {
                        required: "Please enter taluko.",
                    },
                    cur_district:{
                        required: "Please enter district.",
                    },
                    cur_pincode:{
                        required: "Please enter pincode.",
                    }
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
                                        //$(form).find('button[type="submit"]').prop('disabled', false);
                                        //$(form).find('button[type="submit"]').removeClass('btn-spinner');
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
                    if (element.attr("name") == "password" || element.attr("name") == "confirm_password") {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $.validator.addMethod('strongpassword', function(value) {
                    return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(value);
                },
                'Password should contain at least one digit,at least one lower case,at least one upper case and at least 8 from the mentioned characters.'
            );
        });
    </script>
@endpush
