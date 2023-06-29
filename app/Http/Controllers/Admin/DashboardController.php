<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PaidFees;
use App\Models\AcademicYear;
use App\Models\StudentEnrollment;
use App\Models\Semester;
use App\Models\Group;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    { 
        $academicYears = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        
        $totalStudents = User::where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, 'is_cancelled' => '0'])->count();
        $totalMaleStudents = User::where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, 'gender' => 'Male', 'is_cancelled' => '0'])->count();
        $totalFemaleStudents = User::where(['is_admission_approved'=>1, 'is_completed_registration'=>1, 'is_form_fees_paid' => 1, 'gender' => 'Female', 'is_cancelled' => '0'])->count();
        
        $totalFeeCollection = PaidFees::sum('total_fee');
        $totalFeeCollectionMale = PaidFees::where('gender', 'Male')->sum('total_fee');
        $totalFeeCollectionFemale = PaidFees::where('gender', 'Female')->sum('total_fee');


        $totalFeeCollectionToday = PaidFees::whereDate('created_at', date('y-m-d'))->sum('total_fee');
        $totalFeeCollectionMaleToday = PaidFees::where('gender', 'Male')->whereDate('created_at', date('y-m-d'))->sum('total_fee');
        $totalFeeCollectionFemaleToday = PaidFees::where('gender', 'Female')->whereDate('created_at', date('y-m-d'))->sum('total_fee');

        $totalRegisteredStudents = StudentEnrollment::select(DB::raw('Count(*) as total'), DB::raw('Count(case when users.gender="male" then 1 end) as maleTotal'), DB::raw('Count(case when users.gender="female" then 1 end) as femaleTotal'), 'courses.course_name', 'semesters.semester_name')->join('users', 'users.id', '=', 'student_enrollments.user_id')->join('courses', 'courses.course_id', '=', 'student_enrollments.course_id')->join('semesters', 'semesters.semester_id', '=', 'student_enrollments.semester_id')->where('is_fees_paid', '1')->groupBy(['student_enrollments.course_id', 'student_enrollments.semester_id'])->get();

        $totalCancelledStudents = User::where('is_cancelled', 1)->count();
        $totalCancelledMaleStudents = User::where(['is_cancelled' => 1, 'gender' => 'Male'])->count();
        $totalCancelledFemaleStudents = User::where(['is_cancelled' => 1, 'gender' => 'Female'])->count();

        $totalFeeReturns = PaidFees::whereHas('transaction', function($q){
                                        $q->where('payment_type', '3');
                                    })->sum('total_fee');
        $totalFeeReturnsMale = PaidFees::whereHas('transaction', function($q){
                                        $q->where('payment_type', '3');
                                    })->where('gender', 'Male')->sum('total_fee');
        $totalFeeReturnsFemale = PaidFees::whereHas('transaction', function($q){
                                        $q->where('payment_type', '3');
                                    })->where('gender', 'Female')->sum('total_fee');

        $allSemesters = Semester::whereHas('groups')->with('course')->get();
        $allGroups = Group::all();
        $admins = Admin::all();
        $casts = User::select(DB::raw('CASE WHEN CASTE = "1" THEN "GENERAL" WHEN CASTE  = "2" THEN "OBC" WHEN CASTE="3" THEN "SC" ELSE "ST" END as cast'))->groupBy('caste')->get();

        $arr = [
            'academicYears' => $academicYears,
            'totalStudents' => $totalStudents,
            'totalMaleStudents' => $totalMaleStudents,
            'totalFemaleStudents' => $totalFemaleStudents,
            'totalFeeCollection' => $totalFeeCollection,
            'totalFeeCollectionMale' => $totalFeeCollectionMale,
            'totalFeeCollectionFemale' => $totalFeeCollectionFemale,
            'totalFeeCollectionToday' => $totalFeeCollectionToday,
            'totalFeeCollectionMaleToday' => $totalFeeCollectionMaleToday,
            'totalFeeCollectionFemaleToday' => $totalFeeCollectionFemaleToday,
            'totalRegisteredStudents' => $totalRegisteredStudents,
            'totalCancelledStudents' => $totalCancelledStudents,
            'totalCancelledMaleStudents' => $totalCancelledMaleStudents,
            'totalCancelledFemaleStudents' => $totalCancelledFemaleStudents,
            'totalFeeReturns' => $totalFeeReturns,
            'totalFeeReturnsMale' => $totalFeeReturnsMale,
            'totalFeeReturnsFemale' => $totalFeeReturnsFemale,
            'allSemesters' => $allSemesters,
            'allGroups' => $allGroups,
            // 'paidFees' => $paidFees,
            'admins' => $admins,
            'casts' => $casts
            // 'totalFeeGroupWiseCollection' => $totalFeeGroupWiseCollection
        ];
        return view('admin.dashboard', $arr);
    }
}
