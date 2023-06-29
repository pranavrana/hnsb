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

            <form id="transferStudent" method="POST" action="{{ route('admin.studentImport') }}" enctype="multipart/form-data" >
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Academic Year</label>
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
                                            <label>Course</label>
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
                                            <label>Semester</label>
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
                                            <label>Group</label>
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
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="mb-3">
                                            <label for="file" class="form-label">File <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" id="file" name="excel"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1 mt-3"><i
                                                class="fe-check-circle me-1 "></i> Save</button>
                                    </div>
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
@endpush
@push('scripts')
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
</script>
@endpush
