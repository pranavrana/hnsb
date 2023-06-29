@extends('admin.layouts.app')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <a href="{{ route('admin.registed_students') }}" class="btn btn-secondary waves-effect waves-light">
                                <i class="mdi mdi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                        <h4 class="page-title">Admission Form</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <!-- project card -->
                    <div class="card d-block">
                        <div class="card-body">
                            <form id="admissionForm" method="post" action="{{ route('admin.manual_admission') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="student_name" class="form-label">Student Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="student_name" name="student_name" class="form-control"
                                                placeholder="Enter Student Name" value="{{ $studentData->student_name }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="father_name" class="form-label">Father Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="father_name" name="father_name" class="form-control"
                                                placeholder="Enter Father Name" value="{{ $studentData->father_name }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="surname" class="form-label">Surname <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="surname" name="surname" class="form-control"
                                                placeholder="Enter Surname" value="{{ $studentData->surname }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" id="email" class="form-control"
                                                placeholder="Enter Email" value="{{ $studentData->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="contact_no" class="form-label">Contact No <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="contact_no" name="contact_no" class="form-control"
                                                placeholder="Enter Contact No" value="{{ $studentData->contact_no }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender <span
                                                    class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            id="male" value="Male" checked="">
                                                        <label class="form-check-label" for="male">Male</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            id="female" value="Female">
                                                        <label class="form-check-label" for="female">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="birth_date" class="form-label">Birth Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control datepicker" name="birth_date"
                                                data-provide="datepicker" placeholder="DD-MM-YYYY"
                                                data-date-autoclose="true" data-date-format="dd-mm-yyyy">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="caste" class="form-label">Caste <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="caste" name="caste">
                                                <option value="" selected="">Please Select Caste</option>
                                                <option value="1">General</option>
                                                <option value="2">OBC</option>
                                                <option value="3">SC</option>
                                                <option value="4">ST</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="aadhar_card_no" class="form-label">Aadhar Card No <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="aadhar_card_no" name="aadhar_card_no"
                                                class="form-control" placeholder="Enter Aadhar Card No"
                                                value="{{ $studentData->aadhar_card_no }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="student_photo" class="form-label">Student Photo <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" id="student_photo" name="student_photo"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="student_sign" class="form-label">Student Sign <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" id="student_sign" name="student_sign"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Current Address</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="address" name="address" placeholder="Enter Address" value="{{ $studentData->address }}" required>
                                        @error('address')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_city" class="form-label">City <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_city" name="cur_city" placeholder="Enter City" value="{{ $studentData->cur_city }}" required>
                                        @error('cur_city')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_taluko" class="form-label">Taluko <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_taluko" name="cur_taluko" placeholder="Enter Taluko" value="{{ $studentData->cur_taluko }}" required>
                                        @error('cur_taluko')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="cur_district" class="form-label">District <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_district" name="cur_district" placeholder="Enter District" value="{{ $studentData->cur_district }}" required>
                                        @error('cur_district')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cur_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="cur_pincode" name="cur_pincode" placeholder="Enter Pincode" value="{{ $studentData->cur_district }}" required>
                                        @error('cur_pincode')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Permanent Address</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <div class="form-check pt-1">
                                            <input type="checkbox" class="form-check-input" id="checkbox-current-address">
                                            <label class="form-check-label current_address" for="checkbox-current-address">Same As Current Address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="per_address" class="form-label">Address <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="per_address" name="per_address" placeholder="Enter Address" value="{{ $studentData->per_address }}" required>
                                        @error('per_address')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="per_city" class="form-label">City <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="per_city" name="per_city" placeholder="Enter City" value="{{ $studentData->per_city }}" required>
                                        @error('per_city')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="per_taluko" class="form-label">Taluko <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="per_taluko" name="per_taluko" placeholder="Enter Taluko" value="{{ $studentData->per_taluko }}" required>
                                        @error('per_taluko')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label for="per_district" class="form-label">District <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="per_district" name="per_district" placeholder="Enter District" value="{{ $studentData->per_district }}" required>
                                        @error('per_district')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="per_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="per_pincode" name="per_pincode" placeholder="Enter Pincode" value="{{ $studentData->per_pincode }}" required>
                                        @error('per_pincode')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Admission Information</h5>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="course" class="form-label">Course <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="course" name="course">
                                                <option value="" selected="">Please Select Course</option>
                                                @if (!empty($courses))
                                                    @foreach ($courses as $course)
                                                        <option value="{{ $course->course_id }}"  @if($course->course_id == $enrollmentDetails->course_id) {{'selected="selected"'}} @endif>
                                                            {{ $course->course_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="semester" class="form-label">Semester <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="semester" name="semester">
                                                <option value="" selected="">Please Select Semester</option>
                                                @if(!empty($semesters) && count($semesters) > 0)
                                                    @foreach ($semesters as $semester)
                                                        <option value="{{ $semester->semester_id }}" @if($semester->semester_id == $enrollmentDetails->semester_id) {{"selected='selected'"}}@endif> {{ $semester->semester_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="group" class="form-label">Group <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="group" name="group">
                                                <option value="" selected="">Please Select Group</option>
                                                @if(!empty($groups) && count($groups) > 0)
                                                    @foreach ($groups as $group)
                                                        <option value="{{$group->group_id}}" @if($group->group_id == $enrollmentDetails->group_id){{"selected='selected'"}}@endif> {{$group->group_name}}</option>                                                            
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">12th School Information</h5>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="school_name" class="form-label">School Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="school_name" name="school_name"
                                                class="form-control" placeholder="Enter School Name"
                                                value="{{ $studentData->school_name }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="join_date" class="form-label">School Join Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control datepicker" name="join_date"
                                                data-provide="datepicker" placeholder="DD-MM-YYYY"
                                                data-date-autoclose="true" data-date-format="dd-mm-yyyy">

                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="leaving_date" class="form-label">School Leaving Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control datepicker" name="leaving_date"
                                                data-provide="datepicker" placeholder="DD-MM-YYYY"
                                                data-date-autoclose="true" data-date-format="dd-mm-yyyy">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="marksheet_no" class="form-label">12th Marksheet No <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="marksheet_no" name="marksheet_no"
                                                class="form-control" placeholder="Enter 12th Marksheet No"
                                                value="{{ $studentData->marksheet_no_12 }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="exam_center" class="form-label">Exam Center <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="exam_center" name="exam_center"
                                                class="form-control" placeholder="Enter Exam Center"
                                                value="{{ $studentData->exam_center }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="passing_month" class="form-label">Passing Month<span
                                                    class="text-danger">*</span></label>
                                                    <input type='text' class="form-control"  id='datepicker' name="passing_month" name="datepicker" placeholder="MM" value="{{ $studentData->passing_month }}" data-date-autoclose="true"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="passing_year" class="form-label">Passing Year<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="passing_year"
                                                data-provide="datepicker" placeholder="YYYY" data-date-format="yyyy"
                                                data-date-min-view-mode="2" data-date-autoclose="true">

                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="obtained_marks" class="form-label"> Total Obtained Marks
                                                Out of Total Theory Marks <span class="text-danger">*</span></label>
                                            <input type="text" id="obtained_marks" name="obtained_marks"
                                                class="form-control" placeholder="Enter Obtained Marks"
                                                value="{{ $studentData->obtained_marks }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1 mb-2">
                                    <div class="col-12 text-center">
                                        <input type="hidden" name="student" value="{{ $studentData->id }}">
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle me-1"></i> Save</button>
                                        <a href="{{ route('admin.registed_students') }}"
                                            class="btn btn-light waves-effect waves-light m-1"><i
                                                class="fe-x me-1"></i>
                                            Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end card-body-->

                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
@endsection
@push('style')
    <link href="{{ asset('/assets/libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush
@push('scripts')

    <script src="{{ asset('/assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>

    <script src="{{ asset('/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
    $.validator.addMethod('Email', function(value) {
            return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
        }, 'Please enter a valid email.');
        $.validator.addMethod("lettersonly2", function(value, element) {
            return this.optional(element) || /^\S+[a-z]+$/i.test(value);
        }, "Please enter valid full name.");
        $.validator.addMethod("alphanumeric_space", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "");
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-z0-9]+$/i.test(value);
        }, "");
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "");
        $('#admissionForm').validate({
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
                contact_no: {
                    required: true,
                    //matches:"[0-9]+",
                    //min:16,
                },
                gender: {
                    required: true,
                },
                birth_date: {
                    required: true,
                },
                caste: {
                    required: true,
                },
                aadhar_card_no: {
                    required: true,
                    digits:true,
                    minlength:12, 
                    maxlength:12
                },
                address: {
                    required: true
                },
                student_photo: {
                    required: true,
                    extension: "jpg",
                },
                student_sign: {
                    required: true,
                    extension: "jpg",
                },
                course: {
                    required: true
                },
                semester: {
                    required: true
                },
                group: {
                    required: true
                },
                school_name: {
                    required: true,
                   // alphanumeric_space:true
                },
                join_date: {
                    required: true
                },
                leaving_date: {
                    required: true
                },
                marksheet_no: {
                    required: true,
                    alphanumeric:true
                },
                exam_center: {
                    required: true
                },
                passing_month:{
                    required: true
                },
                passing_year: {
                    required: true
                },
                obtained_marks: {
                    required: true,
                    //digits:true
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
                contact_no: {
                    required:"Please enter contact no.",
                    //min:"Please enter valid contact number (ex. (91) 98988-98988)"
                },
                gender: {
                    required: "Please select gender.",
                },
                birth_date: {
                    required: "Please select birth date.",
                },
                caste: {
                    required: "Please select caste.",
                },
                aadhar_card_no: {
                    required: "Please enter aadhar card no.",
                    digits:"Please enter only digits.",
                    minlength:"Adhar card number must be 12 digit.", 
                    maxlength:"Adhar card number must be 12 digit."
                },
                 student_photo: {
                    required: "Please select student photo.",
                    extension: "Please select valid student photo.(.jpg)"
                },
                student_sign: {
                    required: "Please select student sign",
                    extension: "Please select valid student sign.(.jpg)"
                },
                course: {
                    required: "Please select course.",
                },
                semester: {
                    required: "Please select semester.",
                },
                group: {
                    required: "Please select group.",
                },
                school_name: {
                    required: "Please enter school name.",
                    //alphanumeric_space:"Please enter latters, numbers only"
                },
                join_date: {
                    required: "Please select join date.",
                },
                leaving_date: {
                    required: "Please select leaving date.",
                },
                marksheet_no: {
                    required: "Please enter 12th marksheet no.",
                    alphanumeric: "Please enter only alphanumeric (ex. G1234)."
                },
                address: {
                    required: "Please enter address.",
                },
                exam_center: {
                    required: "Please enter exam center.",
                },
                passing_month: {
                    required: "Please select passing month.",
                },
                passing_year: {
                    required: "Please select passing year.",
                },
                obtained_marks: {
                    required: "Please enter total obtained marks out of total theory marks.",
                    //digits: "Please enter only numbers."
                },
            },
             submitHandler: function(form){
             	try{
             		$.ajax({
             			url:$(form).attr("action"),
						type:'POST',
						data:new FormData(form),
						processData: false,
						cache: false,
      					contentType: false,
						datatype : "application/json",
             			beforeSend:function(){
             				$(form).find('button[type="submit"]').prop('disabled', true);
             				//$(form).find('button[type="submit"]').addClass('btn-spinner');
             			},
             			success:function(data){
             				if(data != '')
             				{
             					data=JSON.parse(data);
             					if(data.status_code ==200 && data.message != ''){
             						$.toast({
                                            text: data.message,
                                            icon: 'success',
                                            position: "top-right",
                                            loaderBg: '#008b70',
                                        })
                                        setTimeout(function() {
                                            window.location = data.data.redirect;
                                        }, 3000);
             					}
             					else if(data.status_code ==200 && data.message == ''){
             						window.location = data.data.redirect;
             					}
             					else{
             						$.toast({
                                            text: data.message,
                                            icon: 'error',
                                            position: "top-right",
                                            loaderBg: '#bf441d',
                                        });
             						$(form).find('button[type="submit"]').prop('disabled', false);
             						//$(form).find('button[type="submit"]').removeClass('btn-spinner');
             					}
             				}
             			},
             			// complete:function(){ },
             			error: function (jqXHR, exception) {
             				//window.location = site_url;
             			},
             		});
             	}
             	catch(e)
             	{
             		console.log(e);
             	}
             	return false;
             },
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
        $('#semester').on('change', function() {
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
		});

        $(function () {
             $('#datepicker').datepicker({			    
                 format: 'M',
                 minViewMode: 'months',
                 maxViewMode: 'months',
                 startView: 'months'
             });
         });
        $('#checkbox-current-address').on('change', function() {
            isChecked = $(this).prop('checked');
            if (isChecked === true) {
                $('#per_address').val($('#address').val());
                $('#per_city').val($('#cur_city').val());
                $('#per_taluko').val($('#cur_taluko').val());
                $('#per_district').val($('#cur_district').val());
                $('#per_pincode').val($('#cur_pincode').val());
            }
        });
         </script>
@endpush
