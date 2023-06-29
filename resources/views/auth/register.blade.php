{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register | HNSB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="HNSB" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.jpg') }}">

    <!-- Bootstrap css -->
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="{{ asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="{{ asset('/assets/js/head.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/noty/noty.min.css') }}">
</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <div class="auth-logo">
                                    <a href="home" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('/assets/images/ins_logo.png') }}" alt="" height="180">
                                            {{-- <h1>HNSB</h1> --}}
                                        </span>
                                    </a>

                                    <a href="home" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('/assets/images/ins_logo.png') }}" alt="" height="180">
                                            {{-- <h1>HNSB</h1> --}}
                                        </span>
                                    </a>
                                    <label class="text-dark">Please provide all the information as per your 12th marksheet (Passed) only</label>
                                </div>
                            </div>
                            <form id="registerForm" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="student_name" class="form-label">Student Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="student_name" name="student_name" placeholder="Enter Student Name" value="{{ old('student_name') }}" required>
                                        @error('student_name')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="father_name" name="father_name" placeholder="Enter Father Name" value="{{ old('father_name') }}" required>
                                        @error('father_name')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="surname" name="surname" placeholder="Enter Surname" value="{{ old('surname') }}" required>
                                        @error('surname')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="contact_no" class="form-label">Contact No <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="contact_no" name="contact_no" placeholder="Enter Contact No" value="{{ old('contact_no') }}" required>
                                        @error('contact_no')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="marksheet_no" class="form-label">12th Marksheet Seat No <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="marksheet_no" name="marksheet_no" placeholder="Enter 12th Marksheet No" value="{{ old('marksheet_no') }}" required>
                                        @error('marksheet_no')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password" required id="password"
                                            placeholder="Enter your password">
                                        @error('password')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="confirm_password"  required id="confirm_password" placeholder="Enter your password">
                                        @error('confirm_password')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
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
                                    {{-- <div class="col-xl-4">
                                        <label for="group" class="form-label">Group <span class="text-danger">*</span></label>
                                        <select class="form-select" id="group" name="group">
                                            <option value="" selected="">Please Select Group</option>
                                        </select>
                                        @error('group')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div> --}}
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="address" name="address" placeholder="Enter Address" value="{{ old('address') }}" required>
                                        @error('address')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_city" class="form-label">City <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_city" name="cur_city" placeholder="Enter City" value="{{ old('cur_city') }}" required>
                                        @error('cur_city')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_taluko" class="form-label">Taluko <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_taluko" name="cur_taluko" placeholder="Enter Taluko" value="{{ old('cur_taluko') }}" required>
                                        @error('cur_taluko')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="cur_district" class="form-label">District <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_district" name="cur_district" placeholder="Enter District" value="{{ old('cur_district') }}" required>
                                        @error('cur_district')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_pincode" name="cur_pincode" placeholder="Enter Pincode" value="{{ old('cur_pincode') }}" required>
                                        @error('cur_pincode')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                            <div class="form-check pt-1">
                                                <input type="checkbox" name="agreement" class="form-check-input" id="checkbox-signup">
                                                <label class="form-check-label" for="checkbox-signup">I accept <a href="{{URL::to('terms-and-condions')}}" class="text-dark">Terms and Conditions</a></label>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-0">
                                            <button class="btn btn-success" type="submit">
                                                Register </button>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row-->
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-grey-50 text-strong" style="color:black">Already have account?  <a href="{{URL::to('login')}}" class="text-white ms-1"><b>Sign In</b></a></p>
                        </div> <!-- end col -->
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    {{-- <footer class="footer footer-alt">
        <script>
            document.write(new Date().getFullYear())
        </script> &copy; Developed by <a href="#" class="text-white-50">Bitsapp</a>
    </footer> --}}
    <footer class="footer footer-alt" style="background-color:#98a6ad1f !important">
        <div class="row">
            <div class="col-md-5">
                <div class="text-md-start footer-links d-none d-sm-block">
                    <a class="text-white" href="https://www.hnsbscihmt.org" target="_blank">www.hnsbscihmt.org</a>
                </div>
            </div>
            <div class="col-md-2">
                <span style="color:black">
                <script>
                    document.write(new Date().getFullYear())
                </script> &copy; Developed by </span><a href="#" class="text-white">Bitsapp</a>
            </div>
            <div class="col-md-5">
                <div class="text-md-end footer-links d-none d-sm-block">
                    <a class="text-white" href="{{ route('login')}}">Login</a>
                    <a class="text-white" href="{{ route('register')}}">Registration</a>
                    <a class="text-white" href="{{ route('aboutUs')}}">About Us</a>
                    <a class="text-white" href="{{ route('termsAndConditions')}}">Terms & Conditions</a>
                    <a class="text-white" href="{{ route('privacyPolicy')}}">Privacy Policy</a>
                    <a class="text-white" href="{{ route('contactUs')}}">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>
    <script type="text/javascript">
        var site_url = "{{ url('/') }}";
        var asset_url = "{{ asset('/') }}";
    </script>
    <!-- Vendor js -->
    <script src="{{ asset('/assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('/assets/js/app.min.js') }}"></script>

    <script src="{{ asset('/assets/plugins/noty/lib/noty.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('/assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.inputmask.js') }}"></script>
    <script>
        $.validator.addMethod('Email', function(value) {
            return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
        }, 'Please enter a valid email.');
        $.validator.addMethod("lettersonly2", function(value, element) {
            return this.optional(element) || /^\S+[a-z]+$/i.test(value);
        }, "Please enter valid full name.");
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "");
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-z0-9]+$/i.test(value);
        }, "");
        $('#registerForm').validate({
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
                // group: {
                //     required: true
                // },
                address: {
                    required: true
                },
                agreement: {
                    required: true
                },
                contact_no: {
                    required: true,
                    //min:16,
                },  
                marksheet_no: {
                    required: true,
                    alphanumeric: true
                },               
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
                    required: "Please enter an email address.",
                    // remote: "This email address is already registred.",
                },
                password: {
                    required: "Please enter password.",
                },
                confirm_password: {
                    required: "Please enter password.",
    				equalTo: 'Password and confirm password are not match.'
                },
                course: {
                    required: "Please select course.",
                },
                semester: {
                    required: "Please select semester.",
                },
                // group: {
                //     required: "Please select group.",
                // },
                contact_no: {
                    required: "Please enter contact no.",
                    //digits:"Please enter only digits.",
                    //min:"Please enter valild contact number.", 
                    //maxlength:"Contact number must be 10 digit."
                },
                marksheet_no: {
                    required: "Please enter 12th marksheet no.",
                    alphanumeric: "Please enter only alphanumeric (ex. G1234).",
                },
                address: {
                    required: "Please enter address.",
                },
                agreement: {
                    required: "Please agree to the terms of service.",
                },
            },
            // submitHandler: function(form){
            // 	try{
            // 		$.ajax({
            // 			url:$(form).attr("action"),
            // 			type:'POST',
            // 			data:$(form).serialize(),
            // 			datatype : "application/json",
            // 			beforeSend:function(){
            // 				$(form).find('button[type="submit"]').prop('disabled', true);
            // 				$(form).find('button[type="submit"]').addClass('btn-spinner');
            // 			},
            // 			success:function(data){
            // 				if(data != '')
            // 				{
            // 					data=JSON.parse(data);
            // 					if(data.status_code ==200 && data.message != ''){
            // 						sl_common.notifyWithtEle(data.message,'success');
            // 						setTimeout(function(){ window.location = data.data.redirect; }, 1000);
            // 					}
            // 					else if(data.status_code ==200 && data.message == ''){
            // 						window.location = data.data.redirect;
            // 					}
            // 					else{
            // 						sl_common.notifyWithtEle(data.message,'error','',5000);
            // 						$(form).find('button[type="submit"]').prop('disabled', false);
            // 						$(form).find('button[type="submit"]').removeClass('btn-spinner');
            // 					}
            // 				}
            // 			},
            // 			// complete:function(){ },
            // 			error: function (jqXHR, exception) {
            // 				window.location = site_url;
            // 			},
            // 		});
            // 	}
            // 	catch(e)
            // 	{
            // 		console.log(e);
            // 	}
            // 	return false;
            // },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "country") {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "state") {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "city") {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "agreement") {
                    error.insertAfter(element.parent().parent('div'));
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

        $('#course').on('change', function() {
		    if($(this).val()!='')
			{
				var CourseID=$(this).val();
				try{
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						type: "POST",
						url: site_url+"/get-semesters",
						dataType: "json",
						data:{CourseID:CourseID},
						beforeSend:function(){
							$('body').css('opacity','0.5');
						},
						success: function(data)
						{
							$('body').css('opacity','1');
                            $('#semester').html('<option value="">Please Select Semester</option>');
                            $('#group').html('<option value="">Please Select Group</option>');
                            if(data.data && data.data != '')
							{
                                $.each(data.data, function(key, value){
                                    $('#semester').append('<option value="'+ value.semester_id +'">'+ value.semester_name +'</option>');
                                });
							}
						}
					});
				}
				catch(e)
				{
					console.log(e);
				}
			}
			else
			{
                $('#semester').html('<option value="">Please Select Semester</option>');
                $('#group').html('<option value="">Please Select Group</option>');
			}
		});

/*        $('#semester').on('change', function() {
		    if($(this).val()!='')
			{
				var SemesterID=$(this).val();
				var CourseID=$('#course').val();
				try{
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						type: "POST",
						url: site_url+"/get-groups",
						dataType: "json",
						data:{CourseID:CourseID,SemesterID:SemesterID},
						beforeSend:function(){
							$('body').css('opacity','0.5');
						},
						success: function(data)
						{
							$('body').css('opacity','1');
                            $('#group').html('<option value="">Please Select Group</option>');
                            if(data.data && data.data != '')
							{
                                $.each(data.data, function(key, value){
                                    $('#group').append('<option value="'+ value.group_id +'">'+ value.group_name +'</option>');
                                });
							}
						}
					});
				}
				catch(e)
				{
					console.log(e);
				}
			}
			else
			{
                $('#group').html('<option value="">Please Select Group</option>');
			}
		}); */
    </script>
</body>

</html>
