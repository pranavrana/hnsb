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
                        <h4 class="page-title">Transfer Students</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <form methd="GET">
                <div class="row mb-2">
                    <h4 class="header-title">Transfer From</h4> 
                    <div class="col-lg-2">
                        <div class="form-group">
                            {{-- <label>Academic Year</label> --}}
                            <select name="academic_year" class="form-control form-select form-select">
                                <option value="" selected="">Academic Year</option>
                                @if(!empty($academicYear))
                                @foreach ($academicYear as $year)
                                    <option value="{{ $year->academic_year_id }}"
                                        {{ request()->get('academic_year') == $year->academic_year_id ? 'selected' : '' }}>
                                        {{ $year->year }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            {{-- <label>Course</label> --}}
                            <select class="form-control form-select form-select" id="course_e" name="course">
                                <option value="" selected="">Course</option>
                                @if(!empty($courses))
                                    @foreach ($courses as $course)
                                    <option value="{{$course->course_id}}" {{ request()->get('course') == $course->course_id ? 'selected' : '' }}>{{$course->course_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            {{-- <label>Semester</label> --}}
                            <select class="form-control form-select form-select" id="semester_e" name="semester">
                                <option value="" selected="">Semester</option>
                                @if(!empty($semesters))
                                    @foreach ($semesters as $semester)
                                    <option value="{{$semester->semester_id}}" {{ request()->get('semester') == $semester->semester_id ? 'selected' : '' }}>{{$semester->semester_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            {{-- <label>Group</label> --}}
                            <select class="form-control form-select form-select" id="group_e" name="group">
                                <option value="" selected="">Group</option>
                                @if(!empty($groups))
                                    @foreach ($groups as $group)
                                    <option value="{{$group->group_id}}" {{ request()->get('group') == $group->group_id ? 'selected' : '' }}>{{$group->group_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning" id="submit" value="Get Students">
                        </div>
                    </div>
                </div>
            </form>
            <form id="transferStudent" method="POST" action="{{ route('admin.transfer') }}" >
                <div class="row mb-2">
                    <h4 class="header-title">Transfer To</h4> 
                    <div class="col-lg-2">
                        <div class="form-group">
                            {{-- <label>Academic Year</label> --}}
                            <select name="trf_academic_year" class="form-control form-select form-select">
                                <option value="" selected="">Academic Year</option>
                                @if(!empty($academicYear))
                                @foreach ($academicYear as $year)
                                    <option value="{{ $year->academic_year_id }}">
                                        {{ $year->year }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            {{-- <label>Course</label> --}}
                            <select class="form-control form-select form-select" id="trf_course_e" name="trf_course">
                                <option value="" selected="">Course</option>
                                @if(!empty($courses))
                                    @foreach ($courses as $course)
                                    <option value="{{$course->course_id}}">{{$course->course_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            {{-- <label>Semester</label> --}}
                            <select class="form-control form-select form-select" id="trf_semester_e" name="trf_semester">
                                <option value="" selected="">Semester</option>
                            {{--
                                @if(!empty($semesters))
                                    @foreach ($semesters as $semester)
                                    <option value="{{$semester->semester_id}}">{{$semester->semester_name}}</option>
                                    @endforeach
                                @endif --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            {{-- <label>Group</label> --}}
                            <select class="form-control form-select form-select" id="trf_group_e" name="trf_group">
                                <option value="" selected="">Group</option>
                                {{-- @if(!empty($groups))
                                    @foreach ($groups as $group)
                                    <option value="{{$group->group_id}}">{{$group->group_name}}</option>
                                    @endforeach
                                @endif --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" id="E_trf_stundents" value="Transfer Students">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th data-sortable="false">
                                                    <input type="checkbox" class="form-check-input checkAll" id="checkbox-signup">
                                                </th>
                                                <th>#</th>
                                                <th>Gr No</th>
                                                <th>Roll No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($studentsData))
                                                @foreach ($studentsData as $key => $student)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="selected[]" class="form-check-input students_selected" id="checkbox-signup" value="{{$student->enrollment_id}}">
                                                        </td>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $student->user->gr_no ?? '-' }}</td>
                                                        <td>{{ $student->roll_no ?? '-' }}</td>
                                                        <td>{{ $student->user['name'] }}</td>
                                                        <td>{{ $student->user['email'] }}</td>
                                                        <td>{{ $student->user['contact_no'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">No Students Found!</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
            </form>
            <!-- end row-->

        </div> <!-- container -->
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
        $('#course_e').on('change', function() {
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
                            $('#semester_e').html('<option value="">Semester</option>');
                            $('#group_e').html('<option value="">Group</option>');
                            if(data.data && data.data != '')
							{
                                $.each(data.data, function(key, value){
                                    $('#semester_e').append('<option value="'+ value.semester_id +'">'+ value.semester_name +'</option>');
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
                $('#semester_e').html('<option value="">Semester</option>');
                $('#group_e').html('<option value="">Group</option>');
			}
		});
        $('#semester_e').on('change', function() {
		    if($(this).val()!='')
			{
				var SemesterID=$(this).val();
				var CourseID=$('#course_e').val();
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
                            $('#group_e').html('<option value="">Group</option>');
                            if(data.data && data.data != '')
							{
                                $.each(data.data, function(key, value){
                                    $('#group_e').append('<option value="'+ value.group_id +'">'+ value.group_name +'</option>');
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
                $('#group_e').html('<option value="">Group</option>');
			}
		});
        $('#trf_course_e').on('change', function() {
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
                            $('#trf_semester_e').html('<option value="">Semester</option>');
                            $('#trf_group_e').html('<option value="">Group</option>');
                            if(data.data && data.data != '')
							{
                                $.each(data.data, function(key, value){
                                    $('#trf_semester_e').append('<option value="'+ value.semester_id +'">'+ value.semester_name +'</option>');
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
                $('#trf_semester_e').html('<option value="">Semester</option>');
                $('#trf_group_e').html('<option value="">Group</option>');
			}
		});
        $('#trf_semester_e').on('change', function() {
		    if($(this).val()!='')
			{
				var SemesterID=$(this).val();
				var CourseID=$('#trf_course_e').val();
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
                            $('#trf_group_e').html('<option value="">Group</option>');
                            if(data.data && data.data != '')
							{
                                $.each(data.data, function(key, value){
                                    $('#trf_group_e').append('<option value="'+ value.group_id +'">'+ value.group_name +'</option>');
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
                $('#trf_group_e').html('<option value="">Group</option>');
			}
		});
        $(document).on("click", "#trf_stundents", function() {
            // var enrollment_id = $(this).attr("data-id");
            Swal.fire({
                title: "Are you sure?",
                text: "You want to transfer students? this step will not be reverted!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#28bb4b",
                cancelButtonColor: "#f34e4e",
                confirmButtonText: "Yes, transfer!",
            }).then(function(e) {
                if (e.value) {
                    // $('#enrollment').val(enrollment_id);
                    $('#staticBackdrop').modal('show')
                }
            });
        });

        $(document).on("click", ".checkAll", function() {
            if ($(this).is(':checked')) {
                $('.students_selected').prop('checked', true);
            } else {
                $('.students_selected').prop('checked', false);
            }
        });

        $('#transferStudent').validate({
                errorClass: 'error text-danger',
                rules: {
                    trf_academic_year: {
                        required: true,
                    },
                    trf_course: {
                        required: true,
                    },
                    trf_semester: {
                        required: true,
                    },
                    trf_group: {
                        required: true,
                    },
                    'selected[]': {
                        required: true,
                    }
                },
                messages: {
                    trf_academic_year: {
                        required: "Please select academic year.",
                    },
                    trf_course: {
                        required: "Please select course.",
                    },
                    trf_semester: {
                        required: "Please select semester.",
                    },
                    trf_group: {
                        required: "Please select group.",
                    },
                    'selected[]': {
                        required: "Please select student to transfer.",
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
                                    }
                                }
                            },
                            // complete:function(){ },
                            error: function(jqXHR, exception) {
                                //window.location = site_url;
                            },
                        });
                    } catch (e) {
                        console.log(e);
                    }
                    return false;
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "selected[]") {
                        error.insertAfter(element.parent().parent().parent().parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
    </script>
@endpush
