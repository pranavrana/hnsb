@push('style')
    <link href="{{ asset('/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
<form action={{Request::url()}} methd="GET">
<div class="row">
    @if(!in_array(Route::currentRouteName(), ['admin.admission_fees','admin.admission_requests']))
    <div class="col-lg-3">
        <div class="form-group">
            <label>Academic Year</label>
            <select class="form-select" name="academic_year_id">
                <option value="" selected="">Academic Year</option>
                @if(!empty($year))
                    @foreach($year as $y)
                        <option value="{{ $y->academic_year_id}}" {{request()->get('academic_year_id') == $y->academic_year_id ? 'selected' : ''}}>{{ $y->year}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    @endif
    @if(!in_array(Route::currentRouteName(), ['admin.consolidated_report', 'admin.admission_fees','admin.admission_requests']))
    <div class="col-lg-3">
        <div class="form-group">
            <label>Course</label>
            <select name="course_id" class="form-select"  id="course" name="course">
                <option value="" selected="">Course</option>
                @if(!empty($course))
                    @foreach($course as $c)
                        <option value="{{ $c->course_id}}" {{request()->get('course_id') == $c->course_id ? 'selected' : ''}}>{{ $c->course_name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label>Semester</label>
            <select name="semester_id" class="form-select"  id="semester" name="semester">
                <option value="" selected="">Semester</option>
                @if(isset($semesters) && count($semesters))
                    @foreach($semesters as $s)
                        <option value="{{ $s->semester_id}}" {{request()->get('semester_id') == $s->semester_id ? 'selected' : ''}}>{{ $s->semester_name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    @endif
    @if(!in_array(Route::currentRouteName(), ['admin.sem_cast_all_student_report', 'admin.sem_cast_all_student_admitted_only_report', 'admin.forfeit_report_1', 'admin.consolidated_report', 'admin.admission_fees', 'admin.registed_students','admin.admission_requests']))
        <div class="col-lg-3">
            <div class="form-group">
                <label>Group</label>
                <select name="group_id" class="form-select" id="group" name="group">
                    <option value="" selected="">Group</option>
                    @if(isset($groups) && count($groups))
                        @foreach($groups as $g)
                            <option value="{{ $g->group_id}}" {{request()->get('group_id') == $g->group_id ? 'selected' : ''}}>{{ $g->group_name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    @endif
    @if(in_array(Route::currentRouteName(), ['admin.sem_group_fees_collection_report', 'admin.sem_group_fees_collection_all_user_report', 'admin.fee_head_degree_audit_report', 'admin.fee_head_degree_audit_without_cancel_report', 'admin.consolidated_report', 'admin.college_fees', 'admin.admission_fees', 'admin.registed_students','admin.admission_requests']))
        <div class="col-lg-3 mb-3">
            <div class="form-group">
            <label>From Date</label>
                <input type="text" class="form-control" data-provide="datepicker" data-date-format="d-m-yyyy" name="from_date" id="from_date" value="{{request()->get('from_date')}}" placeholder="dd-m-yyyy">
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="form-group">
            <label>To Date</label>
                <input type="text" class="form-control" data-provide="datepicker" data-date-format="d-m-yyyy" name="to_date" id="to_date" value="{{request()->get('to_date')}}" placeholder="dd-m-yyyy">
            </div>
        </div>
    @endif
    <div class="col-lg-3">
        <label></label>
        <div class="form-group">
            <input type="submit" class="btn btn-success" id="submit" value="Search">
            {{-- <input type="reset" class="btn btn-danger" id="reset"> --}}
        </div>
    </div>
</div>
</form>
@push('scripts')
    <script src="{{ asset('/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            $('#from_date').datepicker({			    
                orientation: "bottom",

            });
            $('#to_date').datepicker({			    
                orientation: "bottom",

            });
        });
    </script>
@endpush