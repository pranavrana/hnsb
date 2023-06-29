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
                            <a href="{{ route('admin.admission_fees_list') }}"
                                class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i>
                                Back</a>
                        </div>
                        <h4 class="page-title">Edit Admission Fees</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form id="editAdmissionForm" method="post" action="{{ route('admin.admission_fees_update') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{$data->admission_fees_id}}" class="form-control">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="academic_year_id" class="form-label">Select Academic Year <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="academic_year_id" name="academic_year_id">
                                                <option value="">Select Year</option>
                                                @foreach ($academicYears as $academicYear)
                                                    <option value="{{ $academicYear->academic_year_id }}" @if($academicYear->academic_year_id == $data->academic_year_id) {{"selected='selected'"}}@endif>
                                                        {{ $academicYear->year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="course_id" class="form-label">Select Course <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="course_id" name="course_id">
                                                <option value="">Select course</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->course_id }}" @if($course->course_id == $data->course_id) {{"selected='selected'"}}@endif> {{ $course->course_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="semester_id" class="form-label">Select Semester <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="semester_id" name="semester_id">
                                                <option value="">Select Semester</option>
                                                @if(!empty($semesters) && count($semesters) > 0)
                                                    @foreach ($semesters as $semester)
                                                        <option value="{{ $semester->semester_id }}" @if($semester->semester_id == $data->semester_id) {{"selected='selected'"}}@endif> {{ $semester->semester_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="admission_fees" class="form-label">Admission Fee <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" min="0" id="admission_fees"
                                                name="admission_fees" class="form-control" placeholder="Enter Admission Fee" value="{{$data->admission_fees}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="mb-3">
                                            <label for="cutoff_date" class="form-label">Admission Cutoff Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control datepicker"
                                                        name="cutoff_date" data-provide="datepicker"
                                                        placeholder="DD-MM-YYYY" data-date-autoclose="true"
                                                        data-date-format="dd-mm-yyyy" value="{{$data->cutoff_date}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mt-1 mb-2">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i> Save</button>
                                    <a href="{{ route('admin.admission_fees_list') }}"
                                        class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
                                        Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->
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
        $('#course_id').on('change', function() {
            if ($(this).val() != '') {
                var CourseID = $(this).val();
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
                                    $('#semester_id').append('<option value="' + value
                                        .semester_id + '">' + value.semester_name +
                                        '</option>');
                                });
                            }
                        }
                    });
                } catch (e) {
                    console.log(e);
                }
            } else {
                $('#semester_id').html('<option value="">Please Select Semester</option>');
            }
        });

        $(document).ready(function() {
            $('#editAdmissionForm').validate({
                errorClass: 'error text-danger',
                rules: {
                    academic_year_id: {
                        required: true
                    },
                    course_id: {
                        required: true
                    },
                    semester_id: {
                        required: true
                    },
                    admission_fees: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    cutoff_date: {
                        required: true,
                    }
                },
                messages: {
                    academic_year_id: {
                        required: "Please select academic year.",
                    },
                    course_id: {
                        required: "Please select course.",
                    },
                    semester_id: {
                        required: "Please select semester.",
                    },
                    admission_fees: {
                        required: "Please enter admission fee.",
                        number: "Please enter only numbers.",
                        min: "Please enter valid admission fee amount."
                    },
                    cutoff_date: {
                        required: "Please select cutoff date.",
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
                                    } else if (data.status_code == 200 && data.message ==
                                        '') {
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
