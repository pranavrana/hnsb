<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Group;
use App\Models\Course;
use App\Models\PaidFees;
use App\Models\StudentEnrollment;
use App\Exports\StudentListEnrolmentExport;
use App\Exports\StudentListSemExport;
use App\Exports\SemGroupFeesCollectionReportExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:student-list-enrolment-report-semester-and-group-wise', ['only' => ['studentListEnrolment']]);
        $this->middleware('permission:student-list-semester-report', ['only' => ['studentListSem']]);
        $this->middleware('permission:semester-and-group-fees-collection-report', ['only' => ['semGroupFeesCollectionReport']]);
        $this->middleware('permission:semester-and-group-fees-collection-all-user-report', ['only' => ['semGroupFeesCollectionAllUserReport']]);
        $this->middleware('permission:group-and-semester-wise-caste-report-all-student', ['only' => ['groupSemCastAllStudentReport']]);
        $this->middleware('permission:group-and-semester-wise-caste-report-all-student-admitted-only', ['only' => ['semCastAllStudentAdmittedOnlyReport']]);
        $this->middleware('permission:fee-head-degree-audit-report', ['only' => ['feeHeadDegreeAuditReport']]);
        $this->middleware('permission:fee-head-degree-audit-report-without-cancel', ['only' => ['feeHeadDegreeAuditWithoutCancelReport']]);
    }

    public function getSelectedData($request){
        $returnData = [];
        if($request->get('academic_year_id')){
            $returnData['selectedYear'] = AcademicYear::where('academic_year_id', $request->get('academic_year_id'))->first()->year;
        }
        if($request->get('course_id')){
            $returnData['selectedCourse'] = Course::where('course_id', $request->get('course_id'))->first()->course_name;
        }
        if($request->get('semester_id')){
            $returnData['selectedSemester'] = Semester::where('semester_id', $request->get('semester_id'))->first()->semester_name;
        }
        if($request->get('group_id')){
            $returnData['selectedGroup'] = Group::where('group_id', $request->get('group_id'))->first()->group_name;
        }
        return $returnData;
    }

    /**
     * Show the transaction listing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function studentListEnrolment(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null && $request->get('group_id') !== null){
            $student = User::whereHas('enrollment', function($q) use($request){
                $q->where('is_fees_paid', 1)
                ->where('academic_year_id', $request->get('academic_year_id'))
                ->where('course_id', $request->get('course_id'))
                ->where('semester_id', $request->get('semester_id'))
                ->where('group_id', $request->get('group_id'));
            })->with('enrollment')->where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1])->orderBy('id','DESC')->get();
            $arr = ['student' => $student,'year'=>$year, 'course'=>$course];
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.student_list_enrolment_report')->with($arr);
    }

    public function studentListEnrolmentExport(Request $request)
    {
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null && $request->get('group_id') !== null){
            $studentsData = User::whereHas('enrollment', function($q) use($request){
                $q->where('is_fees_paid', 1)
                ->where('academic_year_id', $request->get('academic_year_id'))
                ->where('course_id', $request->get('course_id'))
                ->where('semester_id', $request->get('semester_id'))
                ->where('group_id', $request->get('group_id'));
            })->with('enrollment')->where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, ])->orderBy('id','DESC')->get();
            return Excel::download(new StudentListEnrolmentExport($studentsData), 'STUDENT_LIST_ENROLLMENT_REPORT_'.date('d_m_Y_h_i_A').'.xlsx');
        }else{
         return back()->with('error', 'No Data Selected');   
        }
    }

    public function studentListSem(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        if($request->get('academic_year_id') !== null || $request->get('course_id') !== null || $request->get('semester_id') !== null || $request->get('group_id') !== null){
            $student = User::whereHas('enrollment', function($q) use ($request){
                $q->where('is_fees_paid', 1)
                ->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                    return $q->where('academic_year_id', $request->get('academic_year_id'));
                })
                ->when($request->get('course_id') !== null, function ($q) use ($request) {
                    return $q->where('course_id', $request->get('course_id'));
                })
                ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                    return $q->where('semester_id', $request->get('semester_id'));
                })
                ->when($request->get('group_id') !== null, function ($q) use ($request) {
                    return $q->where('group_id', $request->get('group_id'));
                });
            })->with('enrollment')->where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, ])->orderBy('id','DESC')->get();
            $arr = ['student' => $student,'year'=>$year, 'course'=>$course];
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.student_list_sem_report')->with($arr);
    }

    public function studentListSemExport(Request $request)
    {
        if($request->get('academic_year_id') !== null || $request->get('course_id') !== null || $request->get('semester_id') !== null || $request->get('group_id') !== null){
            $studentsData = User::whereHas('enrollment', function($q) use ($request){
                $q->where('is_fees_paid', 1)
                ->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                    return $q->where('academic_year_id', $request->get('academic_year_id'));
                })
                ->when($request->get('course_id') !== null, function ($q) use ($request) {
                    return $q->where('course_id', $request->get('course_id'));
                })
                ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                    return $q->where('semester_id', $request->get('semester_id'));
                })
                ->when($request->get('group_id') !== null, function ($q) use ($request) {
                    return $q->where('group_id', $request->get('group_id'));
                });
            })->with('enrollment')->where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, ])->orderBy('id','DESC')->get();
            return Excel::download(new StudentListSemExport($studentsData), 'STUDENT_LIST_SEM_REPORT_'.date('d_m_Y_h_i_A').'.xlsx');
        }else{
            return back()->with('error', 'No Data Selected');   
        }
    }

    public function consolidatedReport(Request $request){
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        $arr = ['year'=>$year, 'course'=>$course];

        // if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        // $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $semesters = Semester::orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        // }
        return view('admin.report.consolidated_report')->with($arr);
    }

    public function consolidatedReportPrint(Request $request){
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        $selectedData = $this->getSelectedData($request);
        $arr = ['year'=>$year, 'course'=>$course];
        $semesters = Semester::get();
        // $semesters = Semester::where('course_id', $request->course_id)->get();
        $arr['semesters'] = $semesters;
        $arr = array_merge($arr, $selectedData);
        return view('admin.report.consolidated_report_print')->with($arr);
    }

    public function semGroupFeesCollectionReport(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        if($request->get('academic_year_id') !== null || $request->get('course_id') !== null || $request->get('semester_id') !== null || $request->get('group_id') !== null || $request->get('from_date') !== null || $request->get('to_date') !== null){
            $feesData = PaidFees::select(
                'gender',
                DB::raw('Count(*) as total'),
                DB::raw('SUM(fee_tut) as total_fee_tut'),
                DB::raw('SUM(fee_lib) as total_fee_lib'),
                DB::raw('SUM(fee_sport_gim) as total_fee_sport_gim'),
                DB::raw('SUM(fee_sport_clg) as total_fee_sport_clg'),
                DB::raw('SUM(fee_clgexam_stat) as total_fee_clgexam_stat'),
                DB::raw('SUM(fee_student_rahat) as total_fee_student_rahat'),
                DB::raw('SUM(fee_clg_dev) as total_fee_clg_dev'),
                DB::raw('SUM(fee_you_fas) as total_fee_you_fas'),
                DB::raw('SUM(fee_med) as total_fee_med'),
                DB::raw('SUM(fee_hb_rasi) as total_fee_hb_rasi'),
                DB::raw('SUM(fee_union) as total_fee_union'),
                DB::raw('SUM(fee_reg) as total_fee_reg'),
                DB::raw('SUM(fee_enroll) as total_fee_enroll'),
                DB::raw('SUM(fee_icard) as total_fee_icard'),
                DB::raw('SUM(fee_uniother) as total_fee_uniother'),
                DB::raw('SUM(fee_theal) as total_fee_theal'),
                DB::raw('SUM(fee_lab) as total_fee_lab'),
                DB::raw('SUM(fee_uni_exam_form) as total_fee_uni_exam_form'),
                DB::raw('SUM(fee_uniexam) as total_fee_uniexam'),
                DB::raw('SUM(fee_comp) as total_fee_comp'),
                DB::raw('SUM(fee_ele) as total_fee_ele'),
                DB::raw('SUM(fee_other) as total_fee_other'),
                DB::raw('SUM(fee_late) as total_fee_late'),
                DB::raw('SUM(total_fee) as total_total_fee'),
            )
            ->when($request->get('from_date') !== null, function ($q) use ($request) {
                return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
            })
            ->when($request->get('to_date') !== null, function ($q) use ($request) {
                return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
            })
            ->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                return $q->where('academic_year_id', $request->get('academic_year_id'));
            })
            ->when($request->get('course_id') !== null, function ($q) use ($request) {
                return $q->where('course_id', $request->get('course_id'));
            })
            ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                return $q->where('semester_id', $request->get('semester_id'));
            })
            ->when($request->get('group_id') !== null, function ($q) use ($request) {
                return $q->where('group_id', $request->get('group_id'));
            })
            ->groupBy('gender')->get();
              $selectedData = $this->getSelectedData($request);
              $arr = ['feesData' => $feesData,'year'=>$year, 'course'=>$course];
              $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.sem_group_fees_collection_report')->with($arr);
    }

    public function semGroupFeesCollectionReportExport(Request $request)
    {
        if($request->get('academic_year_id') !== null || $request->get('course_id') !== null || $request->get('semester_id') !== null || $request->get('group_id') !== null || $request->get('from_date') !== null || $request->get('to_date') !== null){
            $feesData = PaidFees::query()
            ->when($request->get('from_date') !== null, function ($q) use ($request) {
                return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
            })
            ->when($request->get('to_date') !== null, function ($q) use ($request) {
                return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
            })
            ->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                return $q->where('academic_year_id', $request->get('academic_year_id'));
            })
            ->when($request->get('course_id') !== null, function ($q) use ($request) {
                return $q->where('course_id', $request->get('course_id'));
            })
            ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                return $q->where('semester_id', $request->get('semester_id'));
            })
            ->when($request->get('group_id') !== null, function ($q) use ($request) {
                return $q->where('group_id', $request->get('group_id'));
            })    
            // ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
            //     ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
            //     ->where('academic_year_id', $request->get('academic_year_id'))
            //     ->where('course_id', $request->get('course_id'))
            //     ->where('semester_id', $request->get('semester_id'))
            //     ->where('group_id', $request->get('group_id'))
                ->get();
            if(count($feesData)){
                $feesData = PaidFees::select(
                    'gender',
                    DB::raw('Count(*) as total'),
                    DB::raw('IFNULL(SUM(fee_tut), 0) as total_fee_tut'),
                    DB::raw('IFNULL(SUM(fee_lib), 0) as total_fee_lib'),
                    DB::raw('IFNULL(SUM(fee_sport_gim), 0) as total_fee_sport_gim'),
                    DB::raw('IFNULL(SUM(fee_sport_clg), 0) as total_fee_sport_clg'),
                    DB::raw('IFNULL(SUM(fee_clgexam_stat), 0) as total_fee_clgexam_stat'),
                    DB::raw('IFNULL(SUM(fee_student_rahat), 0) as total_fee_student_rahat'),
                    DB::raw('IFNULL(SUM(fee_clg_dev), 0) as total_fee_clg_dev'),
                    DB::raw('IFNULL(SUM(fee_you_fas), 0) as total_fee_you_fas'),
                    DB::raw('IFNULL(SUM(fee_med), 0) as total_fee_med'),
                    DB::raw('IFNULL(SUM(fee_hb_rasi), 0) as total_fee_hb_rasi'),
                    DB::raw('IFNULL(SUM(fee_union), 0) as total_fee_union'),
                    DB::raw('IFNULL(SUM(fee_reg), 0) as total_fee_reg'),
                    DB::raw('IFNULL(SUM(fee_enroll), 0) as total_fee_enroll'),
                    DB::raw('IFNULL(SUM(fee_icard), 0) as total_fee_icard'),
                    DB::raw('IFNULL(SUM(fee_uniother), 0) as total_fee_uniother'),
                    DB::raw('IFNULL(SUM(fee_theal), 0) as total_fee_theal'),
                    DB::raw('IFNULL(SUM(fee_lab), 0) as total_fee_lab'),
                    DB::raw('IFNULL(SUM(fee_uni_exam_form), 0) as total_fee_uni_exam_form'),
                    DB::raw('IFNULL(SUM(fee_uniexam), 0) as total_fee_uniexam'),
                    DB::raw('IFNULL(SUM(fee_comp), 0) as total_fee_comp'),
                    DB::raw('IFNULL(SUM(fee_ele), 0) as total_fee_ele'),
                    DB::raw('IFNULL(SUM(fee_other), 0) as total_fee_other'),
                    DB::raw('IFNULL(SUM(fee_late), 0) as total_fee_late'),
                    DB::raw('IFNULL(SUM(total_fee), 0) as total_total_fee'),
                )
                ->when($request->get('from_date') !== null, function ($q) use ($request) {
                    return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
                })
                ->when($request->get('to_date') !== null, function ($q) use ($request) {
                    return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
                })
                ->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                    return $q->where('academic_year_id', $request->get('academic_year_id'));
                })
                ->when($request->get('course_id') !== null, function ($q) use ($request) {
                    return $q->where('course_id', $request->get('course_id'));
                })
                ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                    return $q->where('semester_id', $request->get('semester_id'));
                })
                ->when($request->get('group_id') !== null, function ($q) use ($request) {
                    return $q->where('group_id', $request->get('group_id'));
                })
                // ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
                // ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
                // ->where('academic_year_id', $request->get('academic_year_id'))
                // ->where('course_id', $request->get('course_id'))
                // ->where('semester_id', $request->get('semester_id'))
                // ->where('group_id', $request->get('group_id'))
                ->groupBy('gender')->get();
                return Excel::download(new SemGroupFeesCollectionReportExport($feesData), 'SEM_GROUP_FEES_COLLECTION_REPORT_'.date('d_m_Y_h_i_A').'.xlsx');
            } else {
                return back()->with('error', 'No Data Available');   
            }
        }else{
            return back()->with('error', 'No Data Selected');   
        }
    }

    public function semGroupFeesCollectionAllUserReport(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        if($request->get('academic_year_id') !== null || $request->get('course_id') !== null || $request->get('semester_id') !== null || $request->get('group_id') !== null || $request->get('from_date') !== null || $request->get('to_date') !== null){
            $feesData = PaidFees::select(
                'gender',
                DB::raw('Count(*) as total'),
                DB::raw('SUM(fee_tut) as total_fee_tut'),
                DB::raw('SUM(fee_lib) as total_fee_lib'),
                DB::raw('SUM(fee_sport_gim) as total_fee_sport_gim'),
                DB::raw('SUM(fee_sport_clg) as total_fee_sport_clg'),
                DB::raw('SUM(fee_clgexam_stat) as total_fee_clgexam_stat'),
                DB::raw('SUM(fee_student_rahat) as total_fee_student_rahat'),
                DB::raw('SUM(fee_clg_dev) as total_fee_clg_dev'),
                DB::raw('SUM(fee_you_fas) as total_fee_you_fas'),
                DB::raw('SUM(fee_med) as total_fee_med'),
                DB::raw('SUM(fee_hb_rasi) as total_fee_hb_rasi'),
                DB::raw('SUM(fee_union) as total_fee_union'),
                DB::raw('SUM(fee_reg) as total_fee_reg'),
                DB::raw('SUM(fee_enroll) as total_fee_enroll'),
                DB::raw('SUM(fee_icard) as total_fee_icard'),
                DB::raw('SUM(fee_uniother) as total_fee_uniother'),
                DB::raw('SUM(fee_theal) as total_fee_theal'),
                DB::raw('SUM(fee_lab) as total_fee_lab'),
                DB::raw('SUM(fee_uni_exam_form) as total_fee_uni_exam_form'),
                DB::raw('SUM(fee_uniexam) as total_fee_uniexam'),
                DB::raw('SUM(fee_comp) as total_fee_comp'),
                DB::raw('SUM(fee_ele) as total_fee_ele'),
                DB::raw('SUM(fee_other) as total_fee_other'),
                DB::raw('SUM(fee_late) as total_fee_late'),
                DB::raw('SUM(total_fee) as total_total_fee'),
            )
            ->when($request->get('from_date') !== null, function ($q) use ($request) {
                return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
            })
            ->when($request->get('to_date') !== null, function ($q) use ($request) {
                return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
            })
            ->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                return $q->where('academic_year_id', $request->get('academic_year_id'));
            })
            ->when($request->get('course_id') !== null, function ($q) use ($request) {
                return $q->where('course_id', $request->get('course_id'));
            })
            ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                return $q->where('semester_id', $request->get('semester_id'));
            })
            ->when($request->get('group_id') !== null, function ($q) use ($request) {
                return $q->where('group_id', $request->get('group_id'));
            })
                // ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
                // ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
                // ->where('academic_year_id', $request->get('academic_year_id'))
                // ->where('course_id', $request->get('course_id'))
                // ->where('semester_id', $request->get('semester_id'))
                // ->where('group_id', $request->get('group_id'))
                ->groupBy('gender')->get();
              $selectedData = $this->getSelectedData($request);
              $arr = ['feesData' => $feesData,'year'=>$year, 'course'=>$course];
              $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.sem_group_fees_collection_all_user_report')->with($arr);
    }

    public function semGroupFeesCollectionAllUserReportExport(Request $request)
    {
        if($request->get('academic_year_id') !== null || $request->get('course_id') !== null || $request->get('semester_id') !== null || $request->get('group_id') !== null || $request->get('from_date') !== null || $request->get('to_date') !== null){
            $feesData = PaidFees::query()
            ->when($request->get('from_date') !== null, function ($q) use ($request) {
                return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
            })
            ->when($request->get('to_date') !== null, function ($q) use ($request) {
                return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
            })
            ->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                return $q->where('academic_year_id', $request->get('academic_year_id'));
            })
            ->when($request->get('course_id') !== null, function ($q) use ($request) {
                return $q->where('course_id', $request->get('course_id'));
            })
            ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                return $q->where('semester_id', $request->get('semester_id'));
            })
            ->when($request->get('group_id') !== null, function ($q) use ($request) {
                return $q->where('group_id', $request->get('group_id'));
            })    
            // ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
                // ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
                // ->where('academic_year_id', $request->get('academic_year_id'))
                // ->where('course_id', $request->get('course_id'))
                // ->where('semester_id', $request->get('semester_id'))
                // ->where('group_id', $request->get('group_id'))
                ->get();
            if(count($feesData)){
                $feesData = PaidFees::select(
                    'gender',
                    DB::raw('Count(*) as total'),
                    DB::raw('IFNULL(SUM(fee_tut), 0) as total_fee_tut'),
                    DB::raw('IFNULL(SUM(fee_lib), 0) as total_fee_lib'),
                    DB::raw('IFNULL(SUM(fee_sport_gim), 0) as total_fee_sport_gim'),
                    DB::raw('IFNULL(SUM(fee_sport_clg), 0) as total_fee_sport_clg'),
                    DB::raw('IFNULL(SUM(fee_clgexam_stat), 0) as total_fee_clgexam_stat'),
                    DB::raw('IFNULL(SUM(fee_student_rahat), 0) as total_fee_student_rahat'),
                    DB::raw('IFNULL(SUM(fee_clg_dev), 0) as total_fee_clg_dev'),
                    DB::raw('IFNULL(SUM(fee_you_fas), 0) as total_fee_you_fas'),
                    DB::raw('IFNULL(SUM(fee_med), 0) as total_fee_med'),
                    DB::raw('IFNULL(SUM(fee_hb_rasi), 0) as total_fee_hb_rasi'),
                    DB::raw('IFNULL(SUM(fee_union), 0) as total_fee_union'),
                    DB::raw('IFNULL(SUM(fee_reg), 0) as total_fee_reg'),
                    DB::raw('IFNULL(SUM(fee_enroll), 0) as total_fee_enroll'),
                    DB::raw('IFNULL(SUM(fee_icard), 0) as total_fee_icard'),
                    DB::raw('IFNULL(SUM(fee_uniother), 0) as total_fee_uniother'),
                    DB::raw('IFNULL(SUM(fee_theal), 0) as total_fee_theal'),
                    DB::raw('IFNULL(SUM(fee_lab), 0) as total_fee_lab'),
                    DB::raw('IFNULL(SUM(fee_uni_exam_form), 0) as total_fee_uni_exam_form'),
                    DB::raw('IFNULL(SUM(fee_uniexam), 0) as total_fee_uniexam'),
                    DB::raw('IFNULL(SUM(fee_comp), 0) as total_fee_comp'),
                    DB::raw('IFNULL(SUM(fee_ele), 0) as total_fee_ele'),
                    DB::raw('IFNULL(SUM(fee_other), 0) as total_fee_other'),
                    DB::raw('IFNULL(SUM(fee_late), 0) as total_fee_late'),
                    DB::raw('IFNULL(SUM(total_fee), 0) as total_total_fee'),
                )
                ->when($request->get('from_date') !== null, function ($q) use ($request) {
                    return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
                })
                ->when($request->get('to_date') !== null, function ($q) use ($request) {
                    return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
                })
                ->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                    return $q->where('academic_year_id', $request->get('academic_year_id'));
                })
                ->when($request->get('course_id') !== null, function ($q) use ($request) {
                    return $q->where('course_id', $request->get('course_id'));
                })
                ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                    return $q->where('semester_id', $request->get('semester_id'));
                })
                ->when($request->get('group_id') !== null, function ($q) use ($request) {
                    return $q->where('group_id', $request->get('group_id'));
                })
                    // ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
                    // ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
                    // ->where('academic_year_id', $request->get('academic_year_id'))
                    // ->where('course_id', $request->get('course_id'))
                    // ->where('semester_id', $request->get('semester_id'))
                    // ->where('group_id', $request->get('group_id'))
                    ->groupBy('gender')->get();
                  return Excel::download(new SemGroupFeesCollectionReportExport($feesData), 'SEM_GROUP_FEES_COLLECTION_ALL_USER_REPORT_'.date('d_m_Y_h_i_A').'.xlsx');
                  
            } else {
                return back()->with('error', 'No Data Available');   
            }
        }else{
            return back()->with('error', 'No Data Selected');   
        }
    }

    public function groupSemCastAllStudentReport(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null && $request->get('group_id') !== null){
            $student = User::select(DB::raw('SUM(gender="MALE") AS Male'), DB::raw('SUM(gender="FEMALE") AS Female'), 'caste')
                ->whereHas('enrollment', function($q) use ($request){
                    $q->where('is_fees_paid', 1)
                    ->where('academic_year_id', $request->get('academic_year_id'))
                    ->where('course_id', $request->get('course_id'))
                    ->where('semester_id', $request->get('semester_id'))
                    ->where('group_id', $request->get('group_id'));
                })
                ->with('enrollment')
                ->where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, ])->groupBy('caste')
                ->orderBy('id','DESC')
                ->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['student' => $student,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.group_sem_cast_all_student_report')->with($arr);
    }

    public function groupSemCastReportAllStudentAdmittedOnly(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null && $request->get('group_id') !== null){
            $student = User::select(DB::raw('SUM(gender="MALE") AS Male'), DB::raw('SUM(gender="FEMALE") AS Female'), 'caste')
                ->whereHas('enrollment', function($q) use ($request){
                    $q->where('is_fees_paid', 1)
                    ->where('academic_year_id', $request->get('academic_year_id'))
                    ->where('course_id', $request->get('course_id'))
                    ->where('semester_id', $request->get('semester_id'))
                    ->where('group_id', $request->get('group_id'));
                })
                ->with('enrollment')
                ->where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, ])->groupBy('caste')
                ->orderBy('id','DESC')
                ->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['student' => $student,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.group_sem_cast_report_all_student_admitted_only')->with($arr);
    }

    public function semCastAllStudentReport(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $student = User::select(DB::raw('SUM(gender="MALE") AS Male'), DB::raw('SUM(gender="FEMALE") AS Female'), 'caste')
                ->whereHas('enrollment', function($q) use ($request){
                    $q->where('is_fees_paid', 1)
                    ->where('academic_year_id', $request->get('academic_year_id'))
                    ->where('course_id', $request->get('course_id'))
                    ->where('semester_id', $request->get('semester_id'));
                })
                ->with('enrollment')
                ->where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, ])->groupBy('caste')
                ->orderBy('id','DESC')
                ->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['student' => $student,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.sem_cast_all_student_report')->with($arr);
    }

    public function semCastAllStudentAdmittedOnlyReport(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $student = User::select(DB::raw('SUM(gender="MALE") AS Male'), DB::raw('SUM(gender="FEMALE") AS Female'), 'caste', 'groups.group_name')
                ->whereHas('enrollment', function($q) use ($request){
                    $q->where('is_fees_paid', 1)
                    ->where('academic_year_id', $request->get('academic_year_id'))
                    ->where('course_id', $request->get('course_id'))
                    ->where('semester_id', $request->get('semester_id'));
                })
                ->join('student_enrollments', 'users.id', '=', 'student_enrollments.user_id')
                ->join('groups', 'student_enrollments.group_id', '=', 'groups.group_id')
                ->groupBy('groups.group_name')
                ->where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, ])->groupBy('caste')
                ->orderBy('id','DESC')
                ->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['student' => $student,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.sem_cast_all_student_admitted_only_report')->with($arr);
    }

    public function dueFeesReport(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $students = StudentEnrollment::whereDoesntHave('paidFee')->with('user')->whereNull('deleted_at')->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['students' => $students,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.due_fees_report')->with($arr);
    }

    public function dueFeesReportPrint(Request $request){
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $students = StudentEnrollment::whereDoesntHave('paidFee')->with('user')->whereNull('deleted_at')->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['students' => $students,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }
        return view('admin.report.due_fees_report_print')->with($arr);
    }

    public function forfeitReport1(Request $request){
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $students = StudentEnrollment::whereDoesntHave('paidFee')->with('user')->whereNull('deleted_at')->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['students' => $students,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        return view('admin.report.forfeit_report_1')->with($arr);
    }

    public function forfeitReport1Print(Request $request){
        $selectedData = $this->getSelectedData($request);
        $arr = [];
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        $arr = array_merge($arr, $selectedData);
        return view('admin.report.forfeit_report_1_print')->with($arr);
    }

    public function feeHeadDegreeAuditReport(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null && $request->get('group_id') !== null&& $request->get('from_date') !== null && $request->get('to_date') !== null){
            $feesData = PaidFees::select(
                    'gender',
                    DB::raw('Count(*) as total'),
                    DB::raw('SUM(fee_tut) as total_fee_tut'),
                    DB::raw('SUM(fee_lib) as total_fee_lib'),
                    DB::raw('SUM(fee_sport_gim) as total_fee_sport_gim'),
                    DB::raw('SUM(fee_sport_clg) as total_fee_sport_clg'),
                    DB::raw('SUM(fee_clgexam_stat) as total_fee_clgexam_stat'),
                    DB::raw('SUM(fee_student_rahat) as total_fee_student_rahat'),
                    DB::raw('SUM(fee_clg_dev) as total_fee_clg_dev'),
                    DB::raw('SUM(fee_you_fas) as total_fee_you_fas'),
                    DB::raw('SUM(fee_med) as total_fee_med'),
                    DB::raw('SUM(fee_hb_rasi) as total_fee_hb_rasi'),
                    DB::raw('SUM(fee_union) as total_fee_union'),
                    DB::raw('SUM(fee_reg) as total_fee_reg'),
                    DB::raw('SUM(fee_enroll) as total_fee_enroll'),
                    DB::raw('SUM(fee_icard) as total_fee_icard'),
                    DB::raw('SUM(fee_uniother) as total_fee_uniother'),
                    DB::raw('SUM(fee_theal) as total_fee_theal'),
                    DB::raw('SUM(fee_lab) as total_fee_lab'),
                    DB::raw('SUM(fee_uni_exam_form) as total_fee_uni_exam_form'),
                    DB::raw('SUM(fee_uniexam) as total_fee_uniexam'),
                    DB::raw('SUM(fee_comp) as total_fee_comp'),
                    DB::raw('SUM(fee_ele) as total_fee_ele'),
                    DB::raw('SUM(fee_other) as total_fee_other'),
                    DB::raw('SUM(fee_late) as total_fee_late'),
                    DB::raw('SUM(total_fee) as total_total_fee'),
                )
                ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
                ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
                ->where('academic_year_id', $request->get('academic_year_id'))
                ->where('course_id', $request->get('course_id'))
                ->where('semester_id', $request->get('semester_id'))
                ->where('group_id', $request->get('group_id'))
                ->groupBy('gender')->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['feesData' => $feesData,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.fee_head_degree_audit_report')->with($arr);
    }

    public function feeHeadDegreeAuditReportPrint(Request $request){
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null && $request->get('group_id') !== null&& $request->get('from_date') !== null && $request->get('to_date') !== null){
            $feesDataQuery = PaidFees::select(
                    'gender',
                    DB::raw('Count(*) as total'),
                    DB::raw('SUM(fee_tut) as total_fee_tut'),
                    DB::raw('SUM(fee_lib) as total_fee_lib'),
                    DB::raw('SUM(fee_sport_gim) as total_fee_sport_gim'),
                    DB::raw('SUM(fee_sport_clg) as total_fee_sport_clg'),
                    DB::raw('SUM(fee_clgexam_stat) as total_fee_clgexam_stat'),
                    DB::raw('SUM(fee_student_rahat) as total_fee_student_rahat'),
                    DB::raw('SUM(fee_clg_dev) as total_fee_clg_dev'),
                    DB::raw('SUM(fee_you_fas) as total_fee_you_fas'),
                    DB::raw('SUM(fee_med) as total_fee_med'),
                    DB::raw('SUM(fee_hb_rasi) as total_fee_hb_rasi'),
                    DB::raw('SUM(fee_union) as total_fee_union'),
                    DB::raw('SUM(fee_reg) as total_fee_reg'),
                    DB::raw('SUM(fee_enroll) as total_fee_enroll'),
                    DB::raw('SUM(fee_icard) as total_fee_icard'),
                    DB::raw('SUM(fee_uniother) as total_fee_uniother'),
                    DB::raw('SUM(fee_theal) as total_fee_theal'),
                    DB::raw('SUM(fee_lab) as total_fee_lab'),
                    DB::raw('SUM(fee_uni_exam_form) as total_fee_uni_exam_form'),
                    DB::raw('SUM(fee_uniexam) as total_fee_uniexam'),
                    DB::raw('SUM(fee_comp) as total_fee_comp'),
                    DB::raw('SUM(fee_ele) as total_fee_ele'),
                    DB::raw('SUM(fee_other) as total_fee_other'),
                    DB::raw('SUM(fee_late) as total_fee_late'),
                    DB::raw('CASE WHEN is_late_fees_paid = 0 THEN 0 ELSE SUM(fee_late) END as total_fee_late'),
                    DB::raw('SUM(total_fee) as total_total_fee'),
                    // 'is_late_fees_paid'
                )
                ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
                ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
                ->where('academic_year_id', $request->get('academic_year_id'))
                ->where('course_id', $request->get('course_id'))
                ->where('semester_id', $request->get('semester_id'))
                ->where('group_id', $request->get('group_id'));
            $feesDataMale = clone $feesDataQuery;
            $feesDataMale = $feesDataMale->where('gender', 'male')->get()->toArray();
            $feesDataFemale = clone $feesDataQuery;
            $feesDataFemale = $feesDataFemale->where('gender', 'female')->get()->toArray();
            $selectedData = $this->getSelectedData($request);
            $arr = ['feesDataMale' => $feesDataMale, 'feesDataFemale' => $feesDataFemale];
            $arr = array_merge($arr, $selectedData);
            // dd($arr);
            return view('admin.report.fee_head_degree_audit_report_print', $arr);
        }else{
            return back()->with('error', 'Something went wrong');
        }
    }

    public function feeHeadDegreeAuditWithoutCancelReport(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null && $request->get('group_id') !== null&& $request->get('from_date') !== null && $request->get('to_date') !== null){
            $feesData = PaidFees::select(
                    'gender',
                    DB::raw('Count(*) as total'),
                    DB::raw('SUM(fee_tut) as total_fee_tut'),
                    DB::raw('SUM(fee_lib) as total_fee_lib'),
                    DB::raw('SUM(fee_sport_gim) as total_fee_sport_gim'),
                    DB::raw('SUM(fee_sport_clg) as total_fee_sport_clg'),
                    DB::raw('SUM(fee_clgexam_stat) as total_fee_clgexam_stat'),
                    DB::raw('SUM(fee_student_rahat) as total_fee_student_rahat'),
                    DB::raw('SUM(fee_clg_dev) as total_fee_clg_dev'),
                    DB::raw('SUM(fee_you_fas) as total_fee_you_fas'),
                    DB::raw('SUM(fee_med) as total_fee_med'),
                    DB::raw('SUM(fee_hb_rasi) as total_fee_hb_rasi'),
                    DB::raw('SUM(fee_union) as total_fee_union'),
                    DB::raw('SUM(fee_reg) as total_fee_reg'),
                    DB::raw('SUM(fee_enroll) as total_fee_enroll'),
                    DB::raw('SUM(fee_icard) as total_fee_icard'),
                    DB::raw('SUM(fee_uniother) as total_fee_uniother'),
                    DB::raw('SUM(fee_theal) as total_fee_theal'),
                    DB::raw('SUM(fee_lab) as total_fee_lab'),
                    DB::raw('SUM(fee_uni_exam_form) as total_fee_uni_exam_form'),
                    DB::raw('SUM(fee_uniexam) as total_fee_uniexam'),
                    DB::raw('SUM(fee_comp) as total_fee_comp'),
                    DB::raw('SUM(fee_ele) as total_fee_ele'),
                    DB::raw('SUM(fee_other) as total_fee_other'),
                    DB::raw('SUM(fee_late) as total_fee_late'),
                    DB::raw('SUM(total_fee) as total_total_fee'),
                )
                ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
                ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
                ->where('academic_year_id', $request->get('academic_year_id'))
                ->where('course_id', $request->get('course_id'))
                ->where('semester_id', $request->get('semester_id'))
                ->where('group_id', $request->get('group_id'))
                ->groupBy('gender')->get();
            $selectedData = $this->getSelectedData($request);
            $arr = ['feesData' => $feesData,'year'=>$year, 'course'=>$course];
            $arr = array_merge($arr, $selectedData);
        }else{
            $arr = ['year'=>$year, 'course'=>$course];
        }

        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null){
        $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        $arr['semesters'] = $semesters;
        }
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null){
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
            $arr['groups'] = $groups;
        }
        return view('admin.report.fee_head_degree_audit_without_cancel_report')->with($arr);
        
    }

    public function feeHeadDegreeAuditWithoutCancelReportPrint(Request $request){
        if($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null && $request->get('group_id') !== null&& $request->get('from_date') !== null && $request->get('to_date') !== null){
            $feesDataQuery = PaidFees::select(
                    'gender',
                    DB::raw('Count(*) as total'),
                    DB::raw('SUM(fee_tut) as total_fee_tut'),
                    DB::raw('SUM(fee_lib) as total_fee_lib'),
                    DB::raw('SUM(fee_sport_gim) as total_fee_sport_gim'),
                    DB::raw('SUM(fee_sport_clg) as total_fee_sport_clg'),
                    DB::raw('SUM(fee_clgexam_stat) as total_fee_clgexam_stat'),
                    DB::raw('SUM(fee_student_rahat) as total_fee_student_rahat'),
                    DB::raw('SUM(fee_clg_dev) as total_fee_clg_dev'),
                    DB::raw('SUM(fee_you_fas) as total_fee_you_fas'),
                    DB::raw('SUM(fee_med) as total_fee_med'),
                    DB::raw('SUM(fee_hb_rasi) as total_fee_hb_rasi'),
                    DB::raw('SUM(fee_union) as total_fee_union'),
                    DB::raw('SUM(fee_reg) as total_fee_reg'),
                    DB::raw('SUM(fee_enroll) as total_fee_enroll'),
                    DB::raw('SUM(fee_icard) as total_fee_icard'),
                    DB::raw('SUM(fee_uniother) as total_fee_uniother'),
                    DB::raw('SUM(fee_theal) as total_fee_theal'),
                    DB::raw('SUM(fee_lab) as total_fee_lab'),
                    DB::raw('SUM(fee_uni_exam_form) as total_fee_uni_exam_form'),
                    DB::raw('SUM(fee_uniexam) as total_fee_uniexam'),
                    DB::raw('SUM(fee_comp) as total_fee_comp'),
                    DB::raw('SUM(fee_ele) as total_fee_ele'),
                    DB::raw('SUM(fee_other) as total_fee_other'),
                    DB::raw('SUM(fee_late) as total_fee_late'),
                    DB::raw('CASE WHEN is_late_fees_paid = 0 THEN 0 ELSE SUM(fee_late) END as total_fee_late'),
                    DB::raw('SUM(total_fee) as total_total_fee'),
                    // 'is_late_fees_paid'
                )
                ->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))))
                ->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))))
                ->where('academic_year_id', $request->get('academic_year_id'))
                ->where('course_id', $request->get('course_id'))
                ->where('semester_id', $request->get('semester_id'))
                ->where('group_id', $request->get('group_id'));
            $feesDataMale = clone $feesDataQuery;
            $feesDataMale = $feesDataMale->where('gender', 'male')->get()->toArray();
            $feesDataFemale = clone $feesDataQuery;
            $feesDataFemale = $feesDataFemale->where('gender', 'female')->get()->toArray();
            $selectedData = $this->getSelectedData($request);
            $arr = ['feesDataMale' => $feesDataMale, 'feesDataFemale' => $feesDataFemale];
            $arr = array_merge($arr, $selectedData);
            // dd($arr);
            return view('admin.report.fee_head_degree_audit_without_cancel_report_print', $arr);
        }else{
            return back()->with('error', 'Something went wrong');
        }
    }
}
