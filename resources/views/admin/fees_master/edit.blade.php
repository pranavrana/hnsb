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
                        <a href="{{ route('admin.fees_master') }}" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
                    </div>
                    <h4 class="page-title">Edit College Fees</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form id="updateFeesMasterForm" method="post" action="{{ route('admin.fees_master_update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$feesMasterData->fees_master_id}}" class="form-control">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="academic_year_id" class="form-label">Select Academic Year <span class="text-danger">*</span></label>
                                        <select class="form-select" id="academic_year_id" name="academic_year_id">
                                            <option value="">Select Year <span class="text-danger">*</span></option>
                                            @foreach ($academicYearData as $academicYear)
                                            @if($academicYear->academic_year_id == $feesMasterData->academic_year_id)
                                            <option value="{{$academicYear->academic_year_id}}" selected> {{$academicYear->year}}</option>
                                            @else
                                            <option value="{{$academicYear->academic_year_id}}"> {{$academicYear->year}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="course_id" class="form-label">Select Course <span class="text-danger">*</span></label>
                                        <select class="form-select" id="course_id" name="course_id" data-semester_id="{{$feesMasterData->semester_id}}">
                                            <option value="">Select course</option>
                                            @foreach ($courseData as $course)
                                            @if($course->course_id == $feesMasterData->course_id)
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
                                        <label for="semester_id" class="form-label">Select Semester<span class="text-danger">*</span></label>
                                        <select class="form-select" id="semester_id" name="semester_id">
                                            <option value="">Select Semester</option>
                                            @foreach ($semesterData as $semester)
                                                @if($semester->semester_id == $feesMasterData->semester_id)
                                                    <option value="{{$semester->semester_id}}" selected> {{$semester->semester_name}}</option>
                                                @else
                                                    <option value="{{$semester->semester_id}}"> {{$semester->semester_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="group_id" class="form-label">Select Group <span class="text-danger">*</span></label>
                                        <select class="form-select" id="group_id" name="group_id">
                                            <option value="">Select Group</option>
                                            @foreach ($groupData as $group)
                                            @if($group->group_id == $feesMasterData->group_id)
                                            <option value="{{$group->group_id}}" selected> {{$group->group_name}}</option>
                                            @else
                                            <option value="{{$group->group_id}}"> {{$group->group_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="gender" id="male" value="Male"
                                                        @if($feesMasterData->gender == "Male") {{"checked"}}@endif>
                                                    <label class="form-check-label"
                                                        for="male">Male</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="gender" id="female" value="Female" @if($feesMasterData->gender == "Female") {{"checked"}}@endif>
                                                    <label class="form-check-label"
                                                        for="female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_tut" class="form-label">Tution Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_tut}}" onblur="calcTotalFee()" id="fee_tut" name="fee_tut" class="form-control" placeholder="Enter Tution Fee">
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_lib" class="form-label">Library Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_lib}}" onblur="calcTotalFee()" id="fee_lib" name="fee_lib" class="form-control" placeholder="Enter Library Fee">
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_sport_gim" class="form-label">Sports Games Fee (Gymkhana) <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_sport_gim}}" onblur="calcTotalFee()" id="fee_sport_gim" name="fee_sport_gim" class="form-control" placeholder="Enter Sports Games Fee (Gymkhana)">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_sport_clg" class="form-label">Sports Fee (College) <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_sport_clg}}" onblur="calcTotalFee()" id="fee_sport_clg" name="fee_sport_clg" class="form-control" placeholder="Enter Sports Fee (College)">
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_clgexam_stat" class="form-label">College Exam Stationary Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_clgexam_stat}}" onblur="calcTotalFee()" id="fee_clgexam_stat" name="fee_clgexam_stat" class="form-control" placeholder="Enter College Exam Stationary Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_student_rahat" class="form-label">Student Relief Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_student_rahat}}" onblur="calcTotalFee()" id="fee_student_rahat" name="fee_student_rahat" class="form-control" placeholder="Enter Student Relief Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_clg_dev" class="form-label">College Campus Development Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_clg_dev}}" onblur="calcTotalFee()" id="fee_clg_dev" name="fee_clg_dev" class="form-control" placeholder="Enter College Campus Development Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_you_fas" class="form-label">Youth Festival & Cult.Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_you_fas}}" onblur="calcTotalFee()" id="fee_you_fas" name="fee_you_fas" class="form-control" placeholder="Enter Youth Festival & Cult.Fee">
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_med" class="form-label">Medical Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_med}}" onblur="calcTotalFee()" id="fee_med" name="fee_med" class="form-control" placeholder="Enter Medical Fee">
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_hb_rasi" class="form-label">Hepatitis B Vaccine Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_hb_rasi}}" onblur="calcTotalFee()" id="fee_hb_rasi" name="fee_hb_rasi" class="form-control" placeholder="Enter Hepatitis B Vaccine  Fee">
                                    </div>
                                </div>


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_union" class="form-label">Student Union Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_union}}" onblur="calcTotalFee()" id="fee_union" name="fee_union" class="form-control" placeholder="Enter Student Union Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_reg" class="form-label">Admission Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_reg}}" onblur="calcTotalFee()" id="fee_reg" name="fee_reg" class="form-control" placeholder="Enter Admission Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_enroll" class="form-label">Enrolment Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_enroll}}" onblur="calcTotalFee()" id="fee_enroll" name="fee_enroll" class="form-control" placeholder="Enter Enrolment Fee">
                                    </div>
                                </div>


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_icard" class="form-label">I-Card Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_icard}}" onblur="calcTotalFee()" id="fee_icard" name="fee_icard" class="form-control" placeholder="Enter I-Card Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_uniother" class="form-label">Uni.Other Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_uniother}}" onblur="calcTotalFee()" id="fee_uniother" name="fee_uniother" class="form-control" placeholder="Enter Uni.Other Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_theal" class="form-label">Thalassemia Testing Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_theal}}" onblur="calcTotalFee()" id="fee_theal" name="fee_theal" class="form-control" placeholder="Enter Thalassemia Testing Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_lab" class="form-label">Laboratory Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_lab}}" onblur="calcTotalFee()" id="fee_lab" name="fee_lab" class="form-control" placeholder="Enter Laboratory Fee">
                                    </div>
                                </div>


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_uni_exam_form" class="form-label">Uni.Exam Form Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_uni_exam_form}}" onblur="calcTotalFee()" id="fee_uni_exam_form" name="fee_uni_exam_form" class="form-control" placeholder="Enter Uni.Exam Form Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_uniexam" class="form-label">Uni.Exam Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_uniexam}}" onblur="calcTotalFee()" id="fee_uniexam" name="fee_uniexam" class="form-control" placeholder="Enter Uni.Exam Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_comp" class="form-label">Computer Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_comp}}" onblur="calcTotalFee()" id="fee_comp" name="fee_comp" class="form-control" placeholder="Enter Computer Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_ele" class="form-label">Ele.Gen.Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_ele}}" onblur="calcTotalFee()" id="fee_ele" name="fee_ele" class="form-control" placeholder="Enter Ele.Gen.Fee">
                                    </div>
                                </div>


                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_other" class="form-label">On-line Computer S/W Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->fee_other}}" onblur="calcTotalFee()" id="fee_other" name="fee_other" class="form-control" placeholder="Enter On-line Computer S/W Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="scope_exam_fee" class="form-label">Scope Exam Fee <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$feesMasterData->scope_exam_fee}}" onblur="calcTotalFee()" id="scope_exam_fee" name="scope_exam_fee" class="form-control" placeholder="Enter Scope Exam Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="total_fee" class="form-label">Total</label>
                                        <input type="text" value="{{$feesMasterData->total_fee}}" onblur="calcTotalFee()" id="total_fee" name="total_fee" class="form-control" placeholder="Enter Total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="cutoff_date" class="form-label">College Fees Cutoff Date <span class="text-danger">*</span> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control datepicker"
                                                name="cutoff_date" data-provide="datepicker"
                                                placeholder="DD-MM-YYYY" data-date-autoclose="true"
                                                data-date-format="dd-mm-yyyy" data-date-start-date="+0d" value="{{$feesMasterData->cutoff_date}}">
                                </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="fee_late" class="form-label">Late Fee <span class="text-danger">*</span></label>
                                        <input type="text" min="0" id="fee_late" name="fee_late" class="form-control" value="{{$feesMasterData->fee_late}}" placeholder="Enter Late Fee">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="cutoff_extension_date" class="form-label">College Fees Cutoff Extention Date</label>
                                        <input type="text" class="form-control datepicker" name="cutoff_extension_date"
                                            data-provide="datepicker" placeholder="DD-MM-YYYY"
                                            data-date-autoclose="true" data-date-format="dd-mm-yyyy"
                                            data-date-start-date="+0d" value="{{$feesMasterData->cutoff_extension_date}}">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="cutoff_extension_status" class="form-label">College Fees Cutoff Extention Status</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" value="1" name="cutoff_extension_status" @if($feesMasterData->cutoff_extension_status == 1){{'checked'}}@endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- end row -->
                        <div class="row mt-1 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i> Save</button>
                                <a href="{{ route('admin.fees_master') }}" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
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
    function calcTotalFee() {
        var fee_other = $('#fee_other').val() != "" ? $('#fee_other').val() : '0';
        var fee_ele = $('#fee_ele').val() != "" ? $('#fee_ele').val() : '0';
        var fee_comp = $('#fee_comp').val() != "" ? $('#fee_comp').val() : '0';
        var fee_uniexam = $('#fee_uniexam').val() != "" ? $('#fee_uniexam').val() : '0';
        var fee_uni_exam_form = $('#fee_uni_exam_form').val() != "" ? $('#fee_uni_exam_form').val() : '0';
        var fee_tut = $('#fee_tut').val() != "" ? $('#fee_tut').val() : '0';
        var fee_lib = $('#fee_lib').val() != "" ? $('#fee_lib').val() : '0';
        var fee_sport_gim = $('#fee_sport_gim').val() != "" ? $('#fee_sport_gim').val() : '0';
        var fee_sport_clg = $('#fee_sport_clg').val() != "" ? $('#fee_sport_clg').val() : '0';
        var fee_clgexam_stat = $('#fee_clgexam_stat').val() != "" ? $('#fee_clgexam_stat').val() : '0';
        var fee_student_rahat = $('#fee_student_rahat').val() != "" ? $('#fee_student_rahat').val() : '0';
        var fee_clg_dev = $('#fee_clg_dev').val() != "" ? $('#fee_clg_dev').val() : '0';
        var fee_you_fas = $('#fee_you_fas').val() != "" ? $('#fee_you_fas').val() : '0';
        var fee_med = $('#fee_med').val() != "" ? $('#fee_med').val() : '0';
        var fee_hb_rasi = $('#fee_hb_rasi').val() != "" ? $('#fee_hb_rasi').val() : '0';
        var fee_union = $('#fee_union').val() != "" ? $('#fee_union').val() : '0';
        var fee_reg = $('#fee_reg').val() != "" ? $('#fee_reg').val() : '0';
        var fee_enroll = $('#fee_enroll').val() != "" ? $('#fee_enroll').val() : '0';
        var fee_icard = $('#fee_icard').val() != "" ? $('#fee_icard').val() : '0';
        var fee_uniother = $('#fee_uniother').val() != "" ? $('#fee_uniother').val() : '0';
        var fee_theal = $('#fee_theal').val() != "" ? $('#fee_theal').val() : '0';
        var fee_lab = $('#fee_lab').val() != "" ? $('#fee_lab').val() : '0';
        var scope_exam_fee = $('#scope_exam_fee').val() != "" ? $('#scope_exam_fee').val() : 0;
        var result = parseInt(fee_other) + parseInt(fee_ele) + parseInt(fee_comp) + parseInt(fee_uniexam) + parseInt(fee_uni_exam_form) + parseInt(fee_tut) + parseInt(fee_lib) + parseInt(fee_sport_gim) + parseInt(fee_sport_clg) + parseInt(fee_clgexam_stat) + parseInt(fee_student_rahat) + parseInt(fee_clg_dev) + parseInt(fee_you_fas) + parseInt(fee_med) + parseInt(fee_hb_rasi) + parseInt(fee_union) + parseInt(fee_reg) + parseInt(fee_enroll) + parseInt(fee_icard) + parseInt(fee_uniother) + parseInt(fee_theal) + parseInt(fee_lab) + parseInt(scope_exam_fee);
        document.getElementById('total_fee').value = result;
    }
    /*
    $(document).on('change', '#course_id', function() {
        var course_id = $(this).val();
        var semester_id = $(this).attr("data-semester_id");
        if (course_id != "") {
            $.ajax({
                type: "GET",
                url: "{{url('admin/get_semester_by_course_id')}}",
                data: "course_id=" + course_id +"&semester_id="+semester_id,
                dataType: "json",
                beforeSend: function() {
                    $("#semester_id").val('');
                    $('#semester_id').prop("disabled", true);
                },
                success: function(data) {
                    $("#semester_id").empty().html(data["content"]);
                    $('#semester_id').prop("disabled", false);
                },
                error: function(error) {
                    $("#semester_id").val('');
                    $('#semester_id').prop("disabled", true);
                }
            });
        } else {
            $("#semester_id").val('');
            $('#semester_id').prop("disabled", true);
        }
    });*/
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
                            $('#group_id').html('<option value="">Please Select Group</option>');
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
                $('#group_id').html('<option value="">Please Select Group</option>');
            }
        });
        $('#semester_id').on('change', function() {
            if ($(this).val() != '') {
                var SemesterID = $(this).val();
                var CourseID = $('#course_id').val();
                try {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: site_url + "/get-groups",
                        dataType: "json",
                        data: {
                            CourseID: CourseID,
                            SemesterID: SemesterID
                        },
                        beforeSend: function() {
                            $('body').css('opacity', '0.5');
                        },
                        success: function(data) {
                            $('body').css('opacity', '1');
                            $('#group_id').html('<option value="">Please Select Group</option>');
                            if (data.data && data.data != '') {
                                $.each(data.data, function(key, value) {
                                    $('#group_id').append('<option value="' + value.group_id +
                                        '">' + value.group_name + '</option>');
                                });
                            }
                        }
                    });
                } catch (e) {
                    console.log(e);
                }
            } else {
                $('#group_id').html('<option value="">Please Select Group</option>');
            }
        });
    $(document).ready(function() {
        //$("#course_id").change();
        $('#updateFeesMasterForm').validate({
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
                group_id: {
                    required: true
                },
                gender: {
                    required: true
                },
                fee_tut: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_lib: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_sport_gim: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_sport_clg: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_clgexam_stat: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_student_rahat: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_clg_dev: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_you_fas: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_med: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_hb_rasi: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_union: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_reg: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_enroll: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_icard: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_uniother: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_theal: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_lab: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_uni_exam_form: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_uniexam: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_comp: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_ele: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_other: {
                    required: true,
                    number:true,
                    min:0
                },
                scope_exam_fee: {
                    required: true,
                    number:true,
                    min:0
                },
                fee_late: {
                    required: true,
                    number:true,
                    min:0
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
                group_id: {
                    required: "Please select group.",
                },
                gender: {
                    required: "Please select gender.",
                },
                fee_tut: {
                    required: "Please enter tution fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_lib: {
                    required: "Please enter library fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_sport_gim: {
                    required: "Please enter sport games fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_sport_clg: {
                    required: "Please enter sport fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_clgexam_stat: {
                    required: "Please enter collage exam stationary fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_student_rahat: {
                    required: "Please enter student relief fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_clg_dev: {
                    required: "Please enter collage campus development fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_you_fas: {
                    required: "Please enter youth festival & cult fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_med: {
                    required: "Please enter medical fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_hb_rasi: {
                    required: "Please enter hepatitis b vaccine fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_union: {
                    required: "Please enter student union fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_reg: {
                    required: "Please enter admission fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_enroll: {
                    required: "Please enter enrolment fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_icard: {
                    required: "Please enter i-card fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_uniother: {
                    required: "Please enter uni.other fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_theal: {
                    required: "Please enter thalassemia testing fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_lab: {
                    required: "Please enter laboratory fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_uni_exam_form: {
                    required: "Please enter uni. exam form fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_uniexam: {
                    required: "Please enter uni. exam fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_comp: {
                    required: "Please enter computer fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_ele: {
                    required: "Please enter ele. gen. fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_other: {
                    required: "Please enter on-line computer s/w fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                scope_exam_fee: {
                    required: "Please enter scope exam fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
                },
                fee_late: {
                    required: "Please enter late fee.",
                    number: "Please enter only numbers.",
                    min:"Please enter valid fees amount."
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
                if(element.attr("name") == "gender") {
                    error.insertAfter(element.parent().parent().parent());
                }
                else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endpush