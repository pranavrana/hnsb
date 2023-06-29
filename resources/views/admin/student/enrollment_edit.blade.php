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
                            <a href="{{ route('admin.enrollments') }}" class="btn btn-secondary waves-effect waves-light">
                                <i class="mdi mdi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                        <h4 class="page-title">Edit Enrollment</h4>
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
                                        <p class="mb-2"><span class="fw-semibold me-2">Gr No:</span>
                                                {{ $studentData->user->gr_no ?? '-' }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Name:</span>
                                                {{ $studentData->user->name }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Email:</span>
                                                {{ $studentData->user->email }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Contact No:</span>
                                                {{ $studentData->user->contact_no }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Birth Date:</span>
                                                {{ $studentData->user->birth_date }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Gender:</span>
                                                {{ $studentData->user->gender }}</p>
                                            <p class="mb-2"><span class="fw-semibold me-2">Caste:</span>
                                                {{ $studentData->user->caste }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->user->address }}</p>

                                            @if($studentData->user->address != "")
                                            <h4 class="header-title mt-3">Current Address</h4>
                                            <p class="mb-0"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->user->address }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">City:</span>
                                                {{ $studentData->user->cur_city }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Taluko:</span>
                                                {{ $studentData->user->cur_taluko }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">District:</span>
                                                {{ $studentData->user->cur_district }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Pincode:</span>
                                                {{ $studentData->user->cur_pincode }}</p>
                                            @endif
                                            @if($studentData->user->per_address != "")
                                            <h4 class="header-title mt-3">Permanent Address</h4>
                                            <p class="mb-0"><span class="fw-semibold me-2">Address:</span>
                                                {{ $studentData->user->per_address }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">City:</span>
                                                {{ $studentData->user->per_city }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Taluko:</span>
                                                {{ $studentData->user->per_taluko }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">District:</span>
                                                {{ $studentData->user->per_district }}</p>
                                            <p class="mb-0"><span class="fw-semibold me-2">Pincode:</span>
                                                {{ $studentData->user->per_pincode }}</p>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <!-- project card -->
                    <div class="card d-block">
                        <div class="card-body">
                            <form id="editEnrollmentForm" method="post" action="{{ route('admin.enrollment_update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Enrollment Information</h5>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="academic_year" class="form-label">Academic Year <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="academic_year" name="academic_year">
                                                <option value="" selected="">Please Select Academic Year</option>
                                                @if (!empty($academicYearData))
                                                    @foreach ($academicYearData as $academicYear)
                                                        <option value="{{ $academicYear->academic_year_id }}" @if($academicYear->academic_year_id == $studentData->academic_year_id) {{'selected="selected"'}} @endif>
                                                            {{ $academicYear->year }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="course" class="form-label">Course <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="course" name="course">
                                                <option value="" selected="">Please Select Course</option>
                                                @if (!empty($courseData))
                                                    @foreach ($courseData as $course)
                                                        <option value="{{ $course->course_id }}" @if($course->course_id == $studentData->course_id) {{'selected="selected"'}} @endif>
                                                            {{ $course->course_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="semester" class="form-label">Semester <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="semester" name="semester">
                                                <option value="" selected="">Please Select Semester</option>
                                                @if (!empty($semesterData))
                                                    @foreach ($semesterData as $semester)
                                                        <option value="{{$semester->semester_id}}" @if($semester->semester_id == $studentData->semester_id) {{'selected="selected"'}} @endif> {{$semester->semester_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="group" class="form-label">Group <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="group" name="group">
                                                <option value="" selected="">Please Select Group</option>
                                                @if (!empty($groupData))
                                                    @foreach ($groupData as $group)
                                                        <option value="{{$group->group_id}}" @if($group->group_id == $studentData->group_id) {{ 'selected="selected"' }}@endif> {{$group->group_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1 mb-2">
                                    <div class="col-12 text-center">
                                        <input type="hidden" name="enrollment" value="{{ $studentData->enrollment_id }}">
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle me-1"></i> Save</button>
                                        <a href="{{ route('admin.enrollments') }}"
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
@push('scripts')
    <script>
        $('#editEnrollmentForm').validate({
            errorClass: 'error text-danger',
            rules: {
                academic_year: {
                    required: true
                },
                course: {
                    required: true
                },
                semester: {
                    required: true
                },
                group: {
                    required: true
                }
            },
            messages: {
                academic_year: {
                    required: "Please select academic year.",
                },
                course: {
                    required: "Please select course.",
                },
                semester: {
                    required: "Please select semester.",
                },
                group: {
                    required: "Please select group.",
                }
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
                error.insertAfter(element);
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
         </script>
@endpush
