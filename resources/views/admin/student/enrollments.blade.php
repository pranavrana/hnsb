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
                            <a href="{{ route('admin.transfer_students') }}" class="btn btn-info waves-effect waves-light"><i
                                    class="mdi mdi-book-arrow-right me-1"></i> Transfer Students</a>
                            <a href="{{ route('admin.enrollment_export', request()->all()) }}" class="btn btn-danger waves-effect waves-light">
                                <i class="mdi mdi-download-circle me-1"></i> Download
                            </a>
                            <a href="{{ route('admin.downloadEnrolledStudentsFiles', request()->all()) }}" class="btn btn-warning waves-effect waves-light">
                                <i class="mdi mdi-download-circle me-1"></i> Download Student Images
                            </a>
                        </div>
                        <h4 class="page-title">Student Enrollments</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <form methd="GET">
                <div class="row mb-2">
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
                                {{$semesters}}
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
                            <input type="submit" class="btn btn-success" id="submit" value="Filter">
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="header-title">Basic Data Table</h4> --}}
                            {{-- <p class="text-muted font-13 mb-4">
                                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                                            function:
                                            <code>$().DataTable();</code>.
                                        </p> --}}
                            <div class="table-responsive">
                                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Academic Year</th>
                                            <th>Course</th>
                                            <th>Semester</th>
                                            <th>Group</th>
                                            <th>Gr No</th>
                                            <th>Roll No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact No</th>
                                            <th>Fees Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($studentsData))
                                            @foreach ($studentsData as $key => $student)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $student->academicyear->year ?? '-' }}</td>
                                                    <td>{{ $student->course->course_name ?? '-' }}</td>
                                                    <td>{{ $student->semester->semester_name ?? '-' }}</td>
                                                    <td>{{ $student->group->group_name ?? '-' }}</td>
                                                    <td>{{ $student->user->gr_no ?? '-' }}</td>
                                                    <td>{{ $student->roll_no ?? '-' }}</td>
                                                    <td>{{ $student->user['name'] }}</td>
                                                    <td>{{ $student->user['email'] }}</td>
                                                    <td>{{ $student->user['contact_no'] }}</td>
                                                    <td>
                                                    @if ($student->is_fees_paid == 1)
                                                        <span class="badge badge-soft-success rounded-pill">Paid</span>
                                                    @elseif($student->is_fees_paid == 0)
                                                        <span class="badge badge-soft-danger rounded-pill">Not Paid</span>
                                                    @endif
                                                    </td>
                                                    <td id="tooltip-container">
                                                        @if($student->is_fees_paid == 1 && $student->is_id_card_generated == 0)
                                                            <a href="javascript:void(0);" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Student ID Card" id="generateIdCard" data-id="{{ $student->enrollment_id }}">
                                                                <i class="mdi mdi-card"></i>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('admin.enrollment_details', $student->enrollment_id) }}"
                                                            class="action-icon" data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.enrollment_edit', $student->enrollment_id) }}" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Enrollment"> <i class="mdi mdi-account-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" id="cancel"
                                                            data-id="{{ $student->enrollment_id }}" class="action-icon"
                                                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Cancel Admission"> <i
                                                                class="mdi mdi-account-cancel-outline"></i></a>
                                                        @if($student->is_fees_paid == 0)
                                                            <a href="{{ URL::to('admin/manual-college-fees').'/'.$student->user_id }}" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Collect College Fees"> <i class="mdi mdi-cash"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Students Found!</td>
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
                    <form id="cancelAdmission" method="post" action="{{ route('admin.cancel_admission') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Cancel Admission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Enter Admission Cancellation Note <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="cancellation_note" name="cancellation_note" rows="3"></textarea>
                                    <input type="hidden" id="enrollment" name="enrollment">
                                </div>
                                <div class="col-md-6">
                                    <label class="mt-2">Enter Refund Amount (If Any)</label>
                                    <input class="form-control" type="text" id="refund" name="refund">
                                </div>
                            </div>
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
        $(document).on("click", "#cancel", function() {
            var enrollment_id = $(this).attr("data-id");
            Swal.fire({
                title: "Are you sure?",
                text: "You want to cancel this admission!",
                icon: "error",
                showCancelButton: !0,
                confirmButtonColor: "#28bb4b",
                cancelButtonColor: "#f34e4e",
                confirmButtonText: "Yes, cancel it!",
            }).then(function(e) {
                if (e.value) {
                    $('#enrollment').val(enrollment_id);
                    $('#staticBackdrop').modal('show')
                }
            });
        });

        $('#cancelAdmission').validate({
            errorClass: 'error text-danger',
            rules: {
                cancellation_note: {
                    required: true,
                },
            },
            messages: {
                cancellation_note: {
                    required: "Please enter cancellation note.",
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
                            //window.location = site_url;
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

        $(document).on("click", "#generateIdCard", function() {
            var element = $(this);
            var enrollment_id = $(this).attr("data-id");
            Swal.fire({
                title: "Are you sure?",
                text: "You want to generate id card!",
                icon: "info",
                showCancelButton: !0,
                confirmButtonColor: "#28bb4b",
                cancelButtonColor: "#f34e4e",
                confirmButtonText: "Yes, Generate!",
            }).then(function(e) {
                try {
                    $.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
                    $.ajax({
                        url: site_url + "/admin/generate-id",
                        type: 'POST',
                        dataType: "json",
						data:{enrollment: enrollment_id},
                        beforeSend: function() {
                            //$(form).find('button[type="submit"]').prop('disabled', true);
                            //$(form).find('button[type="submit"]').addClass('btn-spinner');
                        },
                        success: function(data) {
                            if (data != '') {
                                if (data.status_code == 200 && data.message != '') {
                                    $.toast({
                                        text: data.message,
                                        icon: 'success',
                                        position: "top-right",
                                        loaderBg: '#008b70',
                                    });
                                    element.css('display','none');
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
            });
        });
    </script>
@endpush
