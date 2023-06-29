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
                        <h4 class="page-title">Edit Student</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form id="addStudentForm" method="post" action="{{ route('admin.student_update') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="student_name" class="form-label">Student Name <span class="text-danger">*</span> </label>
                                            <input type="text" id="student_name" name="student_name" class="form-control"
                                                placeholder="Enter Student Name" value="{{$studentData->student_name}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
                                            <input type="text" id="father_name" name="father_name" class="form-control"
                                                placeholder="Enter Father Name" value="{{$studentData->father_name}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                                            <input type="text" id="surname" name="surname" class="form-control"
                                                placeholder="Enter Surname" value="{{$studentData->surname}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Enter Email" value="{{$studentData->email}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="contact_no" class="form-label">Contact No <span class="text-danger">*</span></label>
                                            <input type="text" id="contact_no" name="contact_no" class="form-control"
                                                placeholder="Enter Contact No" value="{{$studentData->contact_no}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="marksheet_no" class="form-label">12th Marksheet No <span class="text-danger">*</span></label>
                                            <input type="text" id="marksheet_no" name="marksheet_no" class="form-control"
                                                placeholder="Enter 12th Marksheet No" value="{{$studentData->marksheet_no_12}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="address" name="address" value="{{$studentData->address}}" placeholder="Enter Address" required >
                                        @error('address')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_city" class="form-label">City <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_city" name="cur_city" value="{{$studentData->cur_city}}" placeholder="Enter City" required>
                                        @error('cur_city')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_taluko" class="form-label">Taluko <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_taluko" name="cur_taluko" value="{{$studentData->cur_taluko}}" placeholder="Enter Taluko" required>
                                        @error('cur_taluko')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="cur_district" class="form-label">District <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_district" name="cur_district" placeholder="Enter District" value="{{$studentData->cur_district}}" required>
                                        @error('cur_district')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_pincode" name="cur_pincode" placeholder="Enter Pincode" value="{{$studentData->cur_pincode}}" required>
                                        @error('cur_pincode')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                
                            </div>
                            <!-- end row -->
                            <div class="row mt-1 mb-2">
                                <div class="col-12 text-center">
                                    <input type="hidden" name="id" value="{{$studentData->id}}" class="form-control">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i> Save</button>
                                    <a href="{{ route('admin.students') }}"
                                        class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
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
<script src="{{ asset('/assets/js/jquery.inputmask.js') }}"></script>
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
        $.validator.addMethod("alphanumeric_space", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "");
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-z0-9]+$/i.test(value);
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
                   // min:16,
                 },
                marksheet_no: {
                    required: true,
                    alphanumeric:true
                },
                address: {
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
                    //min:"Please enter valid contact number (ex. (91) 98988-98988)"
                },
                marksheet_no: {
                    required: "Please enter 12th marksheet no.",
                    alphanumeric: "Please enter only alphanumeric (ex. G1234)."
                },
                address: {
                    required: "Please enter address.",
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
                                console.log(data);
                            
                            if (data != '') {
                                data = JSON.parse(data);
                                console.log(data);
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
      <script>
            $(document).ready(function(){
               // $("#contact_no").inputmask("(99) 99999-99999"); 
            });
        </script>
@endpush
