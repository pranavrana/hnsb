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
                        <a href="{{ route('admin.group') }}" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
                    </div>
                    <h4 class="page-title">Edit Group</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form id="editGroupForm" method="post" action="{{ route('admin.group_update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$groupData->group_id}}" class="form-control">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="course_id" class="form-label">Select Course <span class="text-danger">*</span></label>
                                        <select class="form-select" id="course_id" name="course_id" data-semester_id="{{$groupData->semester_id}}">
                                            @foreach ($courseData as $course)
                                            @if($groupData->course_id == $course->course_id)
                                            <option value="{{$course->course_id}}" selected> {{$course->course_name}}</option>
                                            @else
                                            <option value="{{$course->course_id}}"> {{$course->course_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="semester_id" class="form-label">Semester <span class="text-danger">*</span></label>
                                        <select class="form-select" id="semester_id" name="semester_id">
                                            <option value="" selected="">Please Select Semester</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="mb-3">
                                        <label for="group_name" class="form-label">Group Name <span class="text-danger">*</span></label>
                                        <input type="text" id="group_name" value="{{$groupData->group_name}}" name="group_name" class="form-control" placeholder="Enter Group Name">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="mb-3">
                                        <label for="range_for_roll_no" class="form-label">Range For Roll Number <span class="text-danger">*</span></label>
                                        <input type="text" id="range_for_roll_no" value="{{$groupData->range_for_roll_no}}" name="range_for_roll_no" class="form-control" placeholder="Enter range for roll number">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="mb-3">
                                        <label for="combination_code" class="form-label">Combination Code</label>
                                        <input type="text" id="combination_code" name="combination_code" class="form-control" value="{{$groupData->combination_code}}" placeholder="Enter Combination Code">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mt-1 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i> Save</button>
                                <a href="{{ route('admin.group') }}" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
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
    $('#course_id').on('change', function() {
        if ($(this).val() != '') {
            var CourseID = $(this).val();
            var semesterId = $(this).attr("data-semester_id");

            try {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: site_url + "/get-semesters",
                    dataType: "json",
                    data: {
                        CourseID: CourseID
                    },
                    beforeSend: function() {
                        $('body').css('opacity', '0.5');
                    },
                    success: function(data) {
                        $('body').css('opacity', '1');
                        $('#semester_id').html('<option value="">Please Select Semester</option>');
                        if (data.data && data.data != '') {
                            $.each(data.data, function(key, value) {
                                $('#semester_id').append('<option value="' + value.semester_id + '" >' + value.semester_name + '</option>');
                            });
                            $('#semester_id option[value=' + semesterId + ']').attr('selected', 'selected');
                        }
                    }
                });
            } catch (e) {
                console.log(e);
            }
        } else {
            $('#semester').html('<option value="">Please Select Semester</option>');
        }
    });

    $(document).ready(function() {
        $("#course_id").change();
        $('#editGroupForm').validate({
            errorClass: 'error text-danger',
            rules: {
                course_id: {
                    required: true
                },
                semester_id: {
                    required: true
                },
                group_name: {
                    required: true,
                },
                range_for_roll_no:{
                    required: true
                }
            },
            messages: {
                semester_id: {
                    required: "Please select semester.",
                },
                course_id: {
                    required: "Please select course.",
                },
                group_name: {
                    required: "Please enter group name.",
                },
                range_for_roll_no: {
                    required: "Please enter range for roll number.",
                },
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