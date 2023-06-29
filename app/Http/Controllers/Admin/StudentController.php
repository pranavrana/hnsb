<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdmissionRejected;
use App\Mail\AdmissionApproved;
use App\Jobs\SendAdmissionApprovedEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Exports\AdmissionRequestsExport;
use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\FeesMaster;
use App\Models\Group;
use App\Models\PaidFees;
use App\Models\Semester;
use App\Models\StudentEnrollment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exports\EnrollmentsExport;
use App\Exports\RegisteredStudentsExport;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:student-list|student-create|student-edit|student-delete', ['only' => ['index']]);
        $this->middleware('permission:student-create', ['only' => ['add', 'insert']]);
        $this->middleware('permission:student-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:student-delete', ['only' => ['delete']]);
        $this->middleware('permission:admission-request-list', ['only' => ['admissionRequests']]);
        $this->middleware('permission:rejected-admission-list', ['only' => ['rejectedAdmissions']]);
    }

    /**
     * Show the students listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = User::where('is_admission_approved', 1)->where('is_cancelled', 0)->orderBy('id', 'DESC')->get();
        return view('admin.student.list')->with(['studentsData' => $result]);
    }

    /**
     * Show the add students page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        return view('admin.student.add');
    }

    /**
     * Show the add students page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student_name' => ['required', 'string', 'max:255'],
                'father_name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'contact_no' => ['required'],
                'marksheet_no' => ['required'],
                'course' => ['required'],
                'semester' => ['required'],
                'address' => ['required'],
                'cur_city' => ['required', 'string', 'max:255'],
                'cur_taluko' => ['required', 'string', 'max:255'],
                'cur_district' => ['required', 'string', 'max:255'],
                'cur_pincode' => ['required', 'string', 'max:255'],
            ],
            [
                'student_name.required' => 'Please enter student name.',
                'father_name.required' => 'Please enter father name.',
                'surname.required' => 'Please enter surname.',
                'email.required' => 'Please enter email.',
                'password.required' => 'Please enter password.',
                'contact_no.required' => 'Please enter contact no.',
                'marksheet_no.required' => 'Please enter 12th marksheet no.',
                'course' => 'Please select course.',
                'semester' => 'Please select semester.',
                'address.required' => 'Please enter address.',
                'cur_city.required' => 'Please enter current city.',
                'cur_taluko.required' => 'Please enter current taluko.',
                'cur_district.required' => 'Please enter current district.',
                'cur_pincode.required' => 'Please enter current pincode.',
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
            // Session::flash('error', $return);

        } else {
            $user = User::create([
                'name' => $request['student_name'] . ' ' . $request['father_name'] . ' ' . $request['surname'],
                'student_name' => $request['student_name'],
                'father_name' => $request['father_name'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'contact_no' => $request['contact_no'],
                'marksheet_no_12' => $request['marksheet_no'],
                'address' => $request['address'],
                'password' => Hash::make($request['password']),
                'cur_city' => $request['cur_city'],
                'cur_taluko' => $request['cur_taluko'],
                'cur_district' => $request['cur_district'],
                'cur_pincode' => $request['cur_pincode'],
            ]);
            $user->markEmailAsVerified();

            if ($user) {
                $acedemicYear = AcademicYear::where('is_default', 1)->first();
                $enrollment = StudentEnrollment::create(
                    [
                    'academic_year_id' => $acedemicYear->academic_year_id,
                    'course_id' => $request['course'] ?? 0,
                    'semester_id' => $request['semester'] ?? 0,
                    'user_id' => $user->id,
                    'group_id' => NULL,
                    ]
                );
                $redirect = route('admin.students');
                $arr = array("redirect" => $redirect);
                _json(200, 'Student added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function edit($id)
    {
        $studentData = User::where('id', $id)->first();
        if ($studentData) {
            return view('admin.student.edit')->with(['studentData' => $studentData]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student_name' => ['required', 'string', 'max:255'],
                'father_name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'email' => "required|email|max:255|unique:users,email," . $request->id . ",id",
                // 'password' => ['required', 'string', 'min:8'],
                'contact_no' => ['required'],
                'marksheet_no' => ['required'],
                'address' => ['required'],
                'cur_city' => ['required', 'string', 'max:255'],
                'cur_taluko' => ['required', 'string', 'max:255'],
                'cur_district' => ['required', 'string', 'max:255'],
                'cur_pincode' => ['required', 'string', 'max:255'],
            ],
            [
                'student_name.required' => 'Please enter student name.',
                'father_name.required' => 'Please enter father name.',
                'surname.required' => 'Please enter surname.',
                'email.required' => 'Please enter email.',
                // 'password.required' => 'Please enter password.',
                'contact_no.required' => 'Please enter contact no.',
                'marksheet_no.required' => 'Please enter 12th marksheet no.',
                'address.required' => 'Please enter address.',
                'cur_city.required' => 'Please enter current city.',
                'cur_taluko.required' => 'Please enter current taluko.',
                'cur_district.required' => 'Please enter current district.',
                'cur_pincode.required' => 'Please enter current pincode.',
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {

            $result = User::findOrFail($request->id);
            $result->name = $request['student_name'] . ' ' . $request['father_name'] . ' ' . $request['surname'];
            $result->student_name = $request['student_name'];
            $result->father_name = $request['father_name'];
            $result->surname = $request['surname'];
            $result->email = $request['email'];
            $result->contact_no = $request['contact_no'];
            $result->marksheet_no_12 = $request['marksheet_no'];
            $result->address = $request['address'];
            $result->cur_city = $request['cur_city'];
            $result->cur_taluko = $request['cur_taluko'];
            $result->cur_district = $request['cur_district'];
            $result->cur_pincode = $request['cur_pincode'];
            $result->save();

            if ($result) {
                $redirect = route('admin.students');
                $arr = array("redirect" => $redirect);
                _json(200, 'Student updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong please try again!');
            }
        }
    }

    /**
     * Show the admission request listing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admissionRequests(Request $request)
    {
        $result = User::where(['is_admission_approved' => 0, 'is_completed_registration' => 1])
        ->whereHas('enrollment', function ($q) use ($request) {
            $q->when($request->get('from_date') !== null, function ($q) use ($request) {
                return $q->whereDate('updated_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
            })
            ->when($request->get('to_date') !== null, function ($q) use ($request) {
                return $q->whereDate('updated_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
            });
        })
        ->orderBy('obtained_marks', 'DESC')->get();
        return view('admin.student.admission_list')->with(['studentsData' => $result]);
    }

    /**
     * Show the admission request details.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewAdmissionRequest(Request $request)
    {
        $result = User::where('is_admission_approved', 0)->where('id', $request->id)->firstOrFail();
        return view('admin.student.admission_details')->with(['studentData' => $result]);
    }

    public function approveAdmission(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student' => ['required']
            ],
            [
                'student.required' => 'Something went wrong, please try again!'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $result = User::findOrFail($request->student);
            $result->is_admission_approved = 1;
            $result->admission_processed_at = now();
            $result->admission_processed_by = \Auth::id();
            $result->save();
            if ($result) {
                $user = User::where('id', $request->student)->firstOrFail();
                // Mail::to($user->email)->send(new AdmissionApproved($user));
                $details['email'] = $user->email;
                $details['user'] = $user;
                SendAdmissionApprovedEmailJob::dispatch($details);
                $redirect = route('admin.students');
                $arr = array("redirect" => $redirect);
                _json(200, 'Admission approved successfully', $arr);
            } else {
                _json(201, 'Something went wrong please try again!');
            }
        }
    }

    public function rejectAdmission(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student' => ['required'],
                'rejection_reason' => ['required']
            ],
            [
                'student.required' => 'Something went wrong, please try again!',
                'rejection_reason.required' => 'Please enter rejection reason.'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $result = User::where('id', $request->student)->update([
                'is_admission_approved' => 2,
                'admission_rejection_reason' => $request->rejection_reason,
            ]);
            if ($result) {
                $user = User::where('id', $request->student)->firstOrFail();
                Mail::to($user->email)->send(new AdmissionRejected($user));
                $redirect = route('admin.rejected_admissions');
                $arr = array("redirect" => $redirect);
                _json(200, 'Admission rejected successfully', $arr);
            } else {
                _json(201, 'Something went wrong please try again!');
            }
        }
    }

    public function rejectedAdmissions()
    {
        $result = User::where('is_admission_approved', 2)->orderBy('id', 'DESC')->get();
        return view('admin.student.rejected_admissions_list')->with(['studentsData' => $result]);
    }

    public function viewRejectedAdmission(Request $request)
    {
        $result = User::where('is_admission_approved', 2)->where('id', $request->id)->firstOrFail();
        return view('admin.student.rejected_admission_details')->with(['studentData' => $result]);
    }

    public function viewStudentDetails(Request $request)
    {
        $result = User::where('is_admission_approved', 1)->where('id', $request->id)->firstOrFail();
        return view('admin.student.student_details')->with(['studentData' => $result]);
    }

    public function admissionRequestsExport(Request $request)
    {
        return Excel::download(new AdmissionRequestsExport($request->all()), 'admission-requests.xlsx');
    }

    public function registedStudents(Request $request)
    {
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        $semesters = [];
        if ($request->get('course_id') !== null) {
            $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        }
        $result = User::where('is_completed_registration', 0)
        ->whereHas('enrollment', function ($q) use ($request) {
            $q->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                return $q->where('academic_year_id', $request->get('academic_year_id'));
            })
            ->when($request->get('course_id') !== null, function ($q) use ($request) {
                return $q->where('course_id', $request->get('course_id'));
            })
            ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                return $q->where('semester_id', $request->get('semester_id'));
            });
        })
        ->when($request->get('from_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
        })
        ->when($request->get('to_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
        })
        ->orderBy('id', 'DESC')->get();
        return view('admin.student.registed_students')->with(['studentsData' => $result, 'year' => $year, 'course' => $course, 'semesters' => $semesters]);
    }

    public function registeredStudentsExport(Request $request)
    {
        $result = User::where('is_completed_registration', 0)->with(['enrollment','enrollment.academicYear','enrollment.course','enrollment.semester'])
        ->whereHas('enrollment', function ($q) use ($request) {
            $q->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                return $q->where('academic_year_id', $request->get('academic_year_id'));
            })
            ->when($request->get('course_id') !== null, function ($q) use ($request) {
                return $q->where('course_id', $request->get('course_id'));
            })
            ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                return $q->where('semester_id', $request->get('semester_id'));
            });
        })
        ->when($request->get('from_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
        })
        ->when($request->get('to_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
        })
        ->orderBy('id', 'DESC')->get();
        return Excel::download(new RegisteredStudentsExport($result), 'Registered_Students_Export_'.date('d_m_Y_h_i_A').'.xlsx');
    }

    public function enrollments(Request $request)
    {
        $groups = $semesters = null;
        $courses = Course::orderBy('course_id', 'ASC')->get();
        $academicYear = AcademicYear::get();
        if ($request->get('course') !== null) {
            $semesters = Semester::where('course_id', $request->course)->orderBy('semester_id', 'ASC')->get();
        }
        if ($request->get('course') !== null && $request->get('semester') !== null) {
            $groups = Group::where('course_id', $request->course)->where('semester_id', $request->semester)->orderBy('group_id', 'ASC')->get();
        }
        $query = StudentEnrollment::where('group_id', '!=' , 0)->where('is_cancelled', 0);
        if ($request->get('academic_year') !== null) {
            $query->where('academic_year_id', $request->get('academic_year'));
        }
        if ($request->get('course') !== null) {
            $query->where('course_id', $request->get('course'));
        }
        if ($request->get('semester') !== null) {
            $query->where('semester_id', $request->get('semester'));
        }
        if ($request->get('group') !== null) {
            $query->where('group_id', $request->get('group'));
        }
        $result = $query->orderBy('roll_no', 'ASC')->get();
        return view('admin.student.enrollments')->with(['studentsData' => $result, 'academicYear' => $academicYear, 'courses' => $courses, 'semesters' => $semesters, 'groups' => $groups]);
    }

    public function enrollmentsExport(Request $request)
    {
        // $groups = $semesters = null;
        // $courses = Course::orderBy('course_id', 'ASC')->get();
        // $academicYear = AcademicYear::get();
        // if ($request->get('course') !== null) {
        //     $semesters = Semester::where('course_id', $request->course)->orderBy('semester_id', 'ASC')->get();
        // }
        // if ($request->get('course') !== null && $request->get('semester') !== null) {
        //     $groups = Group::where('course_id', $request->course)->where('semester_id', $request->semester)->orderBy('group_id', 'ASC')->get();
        // }
        $query = StudentEnrollment::where('group_id', '!=' , 0)->where('is_cancelled', 0);
        if ($request->get('academic_year') !== null) {
            $query->where('academic_year_id', $request->get('academic_year'));
        }
        if ($request->get('course') !== null) {
            $query->where('course_id', $request->get('course'));
        }
        if ($request->get('semester') !== null) {
            $query->where('semester_id', $request->get('semester'));
        }
        if ($request->get('group') !== null) {
            $query->where('group_id', $request->get('group'));
        }
        $result = $query->orderBy('roll_no', 'ASC')->get();
        return Excel::download(new EnrollmentsExport($result), 'Enrollments_Export_'.date('d_m_Y_h_i_A').'.xlsx');
    }

    public function enrollmentDetails(Request $request)
    {
        $result = StudentEnrollment::where('enrollment_id', $request->id)->first();
        return view('admin.student.enrollment_details')->with(['studentData' => $result]);
    }

    public function manualAdmissionFees($id)
    {
        $studentData = User::where('id', $id)->firstorFail();
        return view('admin.student.pay_admission_fees_manually')->with(['studentData' => $studentData]);
    }

    public function collectAdmissionFees(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student' => ['required'],
            ],
            [
                'student.required' => 'Something went wrong please try again!'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }

            _json(201, $return);
        } else {
            $admissionFees = getGeneralSettingByKey('admissionfees');
            if (empty($admissionFees)) {
                _json(201, 'Admission fees not configured! Please contact Admin');
            }
            $studentData = User::where('id', $request->student)->firstorFail();

            $transaction = Transaction::create([
                'user_id' => $studentData->id,
                'admin_id' => \Auth::id(),
                'order_id' => rand(),
                'email' => $studentData->email,
                'contact_no' => $studentData->contact_no,
                'amount' => $admissionFees,
                'txn_id' => date('Ymdhis'),
                'txn_amount' => $admissionFees,
                'txn_date' => date('Y-m-d h:i:s'),
                'txn_payment_mode' => "Cash",
                'txn_bank_txn_id' => null,
                'txn_status' => 'Success',
                'txn_response_code' => null,
                'txn_response_msg' => null,
                'response' => null,
            ]);

            if ($transaction) {
                $studentData->is_form_fees_paid = 1;
                $studentData->save();
                _json(200, 'Admission fees collected!', array("redirect" => route('admin.registed_students')));
            } else {
                _json(201, 'Something went wrong please try again!');
            }
        }
    }

    public function admissionForm($id)
    {
        $studentData = User::where('id', $id)->firstorFail();
        $courses = Course::get();
        $enrollmentDetails = StudentEnrollment::with(['academicYear', 'course', 'semester', 'group', 'user'])->where('user_id',$id)->latest()->firstOrFail();
        $semesters = Semester::where('course_id', $enrollmentDetails->course_id ?? 0)->get();
        $group = Group::where('course_id', $enrollmentDetails->course_id)->where('semester_id', $enrollmentDetails->semester_id)->get();
        return view('admin.student.admission_form')->with(['courses' => $courses, 'studentData' => $studentData, 'semesters' => $semesters, 'groups' => $group, 'enrollmentDetails' => $enrollmentDetails]);
    }

    public function manualAdmission(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student' => ['required'],
                'student_name' => ['required', 'string', 'max:255'],
                'father_name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'contact_no' => ['required'],
                'gender' => ['required'],
                'birth_date' => ['required'],
                'caste' => ['required'],
                'aadhar_card_no' => ['required'],
                'student_photo' => ['image', 'mimes:jpg', 'max:2048'],
                'student_sign' => ['image', 'mimes:jpg', 'max:2048'],
                'school_name' => ['required'],
                'join_date' => ['required'],
                'leaving_date' => ['required'],
                'marksheet_no' => ['required', 'alpha_num'],
                'exam_center' => ['required'],
                'passing_month' => ['required'],
                'passing_year' => ['required'],
                'obtained_marks' => ['required'],
                'course' => ['required'],
                'semester' => ['required'],
                'group' => ['required'],
                'address' => ['required', 'string', 'max:255'],
                'cur_city' => ['required', 'string', 'max:255'],
                'cur_taluko' => ['required', 'string', 'max:255'],
                'cur_district' => ['required', 'string', 'max:255'],
                'cur_pincode' => ['required', 'string', 'max:255'],
                'per_address' => ['required', 'string', 'max:255'],
                'per_city' => ['required', 'string', 'max:255'],
                'per_taluko' => ['required', 'string', 'max:255'],
                'per_district' => ['required', 'string', 'max:255'],
                'per_pincode' => ['required', 'string', 'max:255'],
            ],
            [
                'student.required' => 'Something went wrong please refresh the page and try again!',
                'student_name.required' => 'Please enter student name.',
                'father_name.required' => 'Please enter father name.',
                'surname.required' => 'Please enter surname.',
                'contact_no.required' => 'Please enter contact no.',
                'gender' => 'Please select gender.',
                'birth_date' => 'Please select birth date.',
                'caste' => 'Please select caste.',
                'aadhar_card_no' => 'Please enter aadhar card no.',
                'student_photo' => 'Please select student photo.',
                'student_sign' => 'Please select student sign.',
                'school_name' => 'Please enter school name.',
                'join_date' => 'Please select join date.',
                'leaving_date' => 'Please select leaving date.',
                'marksheet_no.required' => 'Please enter 12th marksheet no.',
                'exam_center' => 'Please enter exam center.',
                'passing_month'=> 'Please select passing month.',
                'passing_year' => 'Please select passing year.',
                'obtained_marks' => 'Please enter obtained marks.',
                'course' => 'Please select course.',
                'semester' => 'Please select semester.',
                'group' => 'Please select group.',
                'address.required' => 'Please enter current address.',
                'cur_city.required' => 'Please enter current city.',
                'cur_taluko.required' => 'Please enter current taluko.',
                'cur_district.required' => 'Please enter current district.',
                'cur_pincode.required' => 'Please enter current pincode.',
                'per_address.required' => 'Please enter permanent address.',
                'per_city.required' => 'Please enter permanent city.',
                'per_taluko.required' => 'Please enter permanent taluko.',
                'per_district.required' => 'Please enter permanent district.',
                'per_pincode.required' => 'Please enter permanent pincode.',
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $student_sign = $student_photo = '';
            if ($request->hasFile('student_photo')) {
                $student_photo = 'student_photo_' . time() . '.' . $request->student_photo->extension();
                $request->student_photo->move(public_path('uploads/student_photo'), $student_photo);
            }
            if ($request->hasFile('student_sign')) {
                $student_sign = 'student_sign_' . time() . '.' . $request->student_sign->extension();
                $request->student_sign->move(public_path('uploads/student_sign'), $student_sign);
            }

            $user = User::findOrFail($request['student']);
            $user->name = $request['student_name'] . ' ' . $request['father_name'] . ' ' . $request['surname'];
            $user->student_name = $request['student_name'];
            $user->father_name = $request['father_name'];
            $user->surname = $request['surname'];
            $user->contact_no = $request['contact_no'];
            $user->gender = $request['gender'];
            $user->birth_date = $request['birth_date'];
            $user->caste = $request['caste'];
            $user->aadhar_card_no = $request['aadhar_card_no'];
            $user->student_photo = $student_photo;
            $user->student_sign = $student_sign;
            $user->school_name = $request['school_name'];
            $user->join_date = $request['join_date'];
            $user->leaving_date = $request['leaving_date'];
            $user->marksheet_no_12 = $request['marksheet_no'];
            $user->exam_center = $request['exam_center'];
            $user->passing_month = $request['passing_month'];
            $user->passing_year = $request['passing_year'];
            $user->obtained_marks = $request['obtained_marks'];
            $user->address = $request['address'];
            $user->cur_city = $request['cur_city'];
            $user->cur_taluko = $request['cur_taluko'];
            $user->cur_district = $request['cur_district'];
            $user->cur_pincode = $request['cur_pincode'];
            $user->per_address = $request['per_address'];
            $user->per_city = $request['per_city'];
            $user->per_taluko = $request['per_taluko'];
            $user->per_district = $request['per_district'];
            $user->per_pincode = $request['per_pincode'];
            $user->is_completed_registration = 1;
            $user->save();

            if ($user) {
                $acedemicYear = AcademicYear::where('is_default', 1)->first();
                $enrollment = StudentEnrollment::create([
                    'academic_year_id' => $acedemicYear->academic_year_id,
                    'course_id' => $request['course'] ?? 0,
                    'semester_id' => $request['semester'] ?? 0,
                    'group_id' => $request['group'] ?? NULL,
                    'user_id' => $request['student']
                ]);
                $arr = array("redirect" => route('admin.registed_students'));
                _json(200, 'Admission details successfully submitted! you will receive notification when admission will be approved', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function manualCollegeFees($id)
    {
        $enrollment = [];
        $studentData = User::where('id', $id)->firstorFail();
        if (!empty($studentData)) {
            $enrollment = StudentEnrollment::with(['academicYear', 'course', 'semester', 'group'])->where('user_id', $studentData->id)->where('is_fees_paid', 0)->latest('enrollment_id')->first();
        }
        return view('admin.student.pay_college_fees_manually')->with(['studentData' => $studentData, 'enrollmentData' => $enrollment]);
    }

    public function collectCollegeFees(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'enrollment_id' => ['required'],
            ],
            [
                'enrollment_id.required' => 'Something went wrong please try again!'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $studentDetails = StudentEnrollment::where('user_id', $request->enrollment_id)->where('is_fees_paid', 0)->latest('enrollment_id')->first();
            if (!empty($studentDetails)) {
                $feesDetails = FeesMaster::where('academic_year_id', $studentDetails->academic_year_id)->where('course_id', $studentDetails->course_id)->where('semester_id', $studentDetails->semester_id)->where('group_id', $studentDetails->group_id)->where('gender', $studentDetails->user->gender)->first();
                if (!empty($feesDetails)) {
                    if (!isset($feesDetails->total_fee) && empty($feesDetails->total_fee)) {
                        _json(201, 'College fees not configured!');
                    }
                    $lateFees = $feesDetails->fee_late;
                    $fees = $feesDetails->total_fee;
                    $lateFeesPaid = 0;
                    // $collegeFeesCutOffDate = getGeneralSettingByKey('collegefeescutoffdate');
                    // $cutOffExtentionDate = getGeneralSettingByKey('collegefeescutoffextentiondate', true);
                    $collegeFeesCutOffDate = $feesDetails->cutoff_date ?? '';
                    $cutOffExtentionDate = $feesDetails->cutoff_extension_date ?? '';
                    $cutOffExtentionDateStatus = $feesDetails->cutoff_extension_status ?? 0;

                    if (empty($collegeFeesCutOffDate)) {
                        _json(201, 'College fees cut off date not configured. Please contact admin!');
                    } else if ((\Carbon\Carbon::parse($collegeFeesCutOffDate)->startOfDay()  >= \Carbon\Carbon::now()->startOfDay()) === false) {
                        if (!empty($cutOffExtentionDate) && $cutOffExtentionDateStatus == 1 && \Carbon\Carbon::parse($cutOffExtentionDate)  >= \Carbon\Carbon::now()->startOfDay()) {
                            $fees = $fees + $lateFees;
                            $lateFeesPaid = 1;
                        } else {
                            _json(201, 'Collage fees payment cut off date is over!');
                        }
                    }
                    DB::beginTransaction();
                    try {

                        $transactionData = Transaction::create([
                            'user_id' => $studentDetails->user_id,
                            'admin_id' => \Auth::id(),
                            'order_id' => rand(),
                            'payment_type' => 2,
                            'email' => $studentDetails->user->email,
                            'contact_no' => $studentDetails->user->contact_no,
                            'amount' => $fees,
                            'txn_id' => date('Ymdhis'),
                            'txn_amount' => $fees,
                            'txn_date' => date('Y-m-d h:i:s'),
                            'txn_payment_mode' => "Cash",
                            'txn_bank_txn_id' => null,
                            'txn_status' => 'Success',
                            'txn_response_code' => null,
                            'txn_response_msg' => null,
                            'response' => null,
                        ]);
                        if ($transactionData) {
                            
                            $group = Str::upper(substr($studentDetails->group->group_name, 0, 2));
                            $year = $year = date("y", strtotime('-1 year'));;
                            if (date("m") >= 05) {
                                $year = date("y", strtotime('+1 year'));
                            }
                            $gr_no = $group . $year . sprintf("%'.05d\n", $studentDetails->user_id);

                            User::where('id', $studentDetails->user_id)->update([
                                'is_initial_college_fees_paid' => 1,
                                'gr_no' => $gr_no
                            ]);
                            $fees = $feesDetails->replicate();
                            $paidFeesArray = $fees->toArray();
                            $paidFeesArray['user_id'] = $studentDetails->user_id;
                            $paidFeesArray['enrollment_id'] = $studentDetails->enrollment_id;
                            $paidFeesArray['transaction_id'] = $transactionData->transaction_id;
                            $paidFeesArray['is_late_fees_paid'] = $lateFeesPaid;
                            unset($paidFeesArray['created_at'], $paidFeesArray['updated_at'], $paidFeesArray['deleted_at']);
                            PaidFees::create($paidFeesArray);
                            $enrolledStudents = StudentEnrollment::where('academic_year_id', $studentDetails->academic_year_id)->where('course_id', $studentDetails->course_id)->where('semester_id', $studentDetails->semester_id)->where('group_id', $studentDetails->group_id)->where('is_fees_paid', 1)->count();
                            $group = Group::where('group_id', $studentDetails->group_id)->first();
                            $rollNo = $enrolledStudents + 1;
                            if(!empty($group) && isset($group->range_for_roll_no) && !empty($group->range_for_roll_no)) {
                                $rollNo = ($group->range_for_roll_no + ($enrolledStudents + 1)); 
                            }
                            $studentDetails->roll_no = $rollNo;
                            $studentDetails->is_fees_paid = 1;
                            $studentDetails->save();
                            DB::commit();
                            _json(200, 'College fees collected!', array("redirect" => route('admin.enrollments')));
                        } else {
                            DB::rollback();
                            _json(201, 'Something went wrong please try again!');
                        }
                    } catch (\Exception $e) {
                        DB::rollback();
                        _json(201, 'Something went wrong please try again!');
                    }
                } else {
                    _json(201, 'Fees details not found, please contact admin!');
                }
            } else {
                _json(201, 'Enrollment details not found, please try again!');
            }
        }
    }

    public function cancelAdmission(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'enrollment' => ['required'],
                'cancellation_note' => ['required']
            ],
            [
                'enrollment.required' => 'Something went wrong, please try again!',
                'cancellation_note.required' => 'Please enter cancellation note.'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $enrollment = StudentEnrollment::where('enrollment_id', $request->enrollment)->firstOrFail();
            $userId = $enrollment->user_id;
            $enrollment->is_cancelled = 1;
            $result = $enrollment->update();
            if ($result) {
                $user = User::where('id', $userId)->firstOrFail();
                $studentDetails = $user;
                $user->cancellation_note = $request->cancellation_note;
                $user->cancelled_at = date('Y-m-d h:i:s');
                $user->cancelled_by = \Auth::id();
                $user->is_cancelled = 1;
                $user->save();
                if (isset($request->refund) && !empty($request->refund)) {
                    Transaction::create([
                        'user_id' => $userId,
                        'admin_id' => \Auth::id(),
                        'order_id' => rand(),
                        'payment_type' => 3,
                        'email' => $studentDetails->email,
                        'contact_no' => $studentDetails->contact_no,
                        'amount' => $request->refund,
                        'txn_id' => date('Ymdhis'),
                        'txn_amount' => $request->refund,
                        'txn_date' => date('Y-m-d h:i:s'),
                        'txn_payment_mode' => "Manual",
                        'txn_bank_txn_id' => null,
                        'txn_status' => 'Success',
                        'txn_response_code' => null,
                        'txn_response_msg' => null,
                        'response' => null,
                    ]);
                }
                
                $redirect = route('admin.enrollments');
                $arr = array("redirect" => $redirect);
                _json(200, 'Admission cancelled successfully', $arr);
            } else {
                _json(201, 'Something went wrong please try again!');
            }
        }
    }

    /**
     * Show the cancelled students listing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cancelledStudents()
    {
        $result = User::where('is_admission_approved', 1)->where('is_cancelled', 1)->orderBy('id', 'DESC')->get();
        return view('admin.student.cancelled_students')->with(['studentsData' => $result]);
    }

    public function enrollmentEdit(Request $request, $id)
    {
        $result = StudentEnrollment::where('enrollment_id', $id)->first();
        $academicYears = AcademicYear::get();
        $courses = Course::orderBy('course_id', 'ASC')->get();
        $semesters = Semester::where('course_id', $result->course_id)->get();
        $groups = Group::where('course_id', $result->course_id)->where('semester_id', $result->semester_id)->get();

        return view('admin.student.enrollment_edit')->with(['studentData' => $result, 'academicYearData' => $academicYears, 'courseData' => $courses, 'semesterData' => $semesters, 'groupData' => $groups]);
    }

    public function enrollmentUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'academic_year' => ['required'],
                'course' => ['required'],
                'semester' => ['required'],
                'group' => ['required']
            ],
            [
                'academic_year' => 'Please select academic year.',
                'course' => 'Please select course.',
                'semester' => 'Please select semester.',
                'group' => 'Please select group.'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $enrollment = StudentEnrollment::findOrFail($request['enrollment']);
            $enrollment->academic_year_id = $request['academic_year'];
            $enrollment->course_id = $request['course'];
            $enrollment->semester_id = $request['semester'];
            $enrollment->group_id = $request['group'];
            $enrollment->save();
            if ($enrollment) {
                $arr = array("redirect" => route('admin.enrollments'));
                _json(200, 'Enrollment details updated successfully.', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function transferStudents(Request $request)
    {
        $result = $groups = $semesters = null;
        $courses = Course::orderBy('course_id', 'ASC')->get();
        $academicYear = AcademicYear::get();
        if ($request->get('course') !== null) {
            $semesters = Semester::where('course_id', $request->course)->orderBy('semester_id', 'ASC')->get();
        }
        if ($request->get('course') !== null && $request->get('semester') !== null) {
            $groups = Group::where('course_id', $request->course)->where('semester_id', $request->semester)->orderBy('group_id', 'ASC')->get();
        }
        if ($request->get('academic_year') !== null || $request->get('course') !== null || $request->get('semester') !== null || $request->get('group') !== null) {
            $query = StudentEnrollment::where('is_fees_paid', 1)->where('is_cancelled', 0);
            if ($request->get('academic_year') !== null) {
                $query->where('academic_year_id', $request->get('academic_year'));
            }
            if ($request->get('course') !== null) {
                $query->where('course_id', $request->get('course'));
            }
            if ($request->get('semester') !== null) {
                $query->where('semester_id', $request->get('semester'));
            }
            if ($request->get('group') !== null) {
                $query->where('group_id', $request->get('group'));
            }
            $result = $query->orderBy('roll_no', 'ASC')->get();
        }
        return view('admin.student.transfer_student')->with(['studentsData' => $result, 'academicYear' => $academicYear, 'courses' => $courses, 'semesters' => $semesters, 'groups' => $groups]);
    }

    public function transfer(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'student' => ['required'],
            ],
            [
                // 'student.required' => 'Something went wrong please refresh the page and try again!',
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            if (isset($request->selected) && !empty($request->selected)) {
                foreach ($request->selected as $enrollment_id) {
                    $enrollmentData = StudentEnrollment::where('enrollment_id', $enrollment_id)->first();
                    if (!empty($enrollmentData)){
                        StudentEnrollment::create([
                            'academic_year_id' => $request['trf_academic_year'] ?? 0,
                            'course_id' => $request['trf_course'] ?? 0,
                            'semester_id' => $request['trf_semester'] ?? 0,
                            'group_id' => $request['trf_group'] ?? 0,
                            'user_id' => $enrollmentData->user_id
                        ]);
                    }
                }
            }
            $arr = array("redirect" => route('admin.enrollments'));
            _json(200, 'Student transferred successfully!', $arr);
        }
    }

    public function generateId(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'enrollment' => ['required'],
            ],
            [
                'enrollment.required' => 'Something went wrong, please try again!',
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $enrollment = StudentEnrollment::where('enrollment_id', $request->enrollment)->firstOrFail();
            $enrollment->is_id_card_generated = 1;
            $result = $enrollment->update();
            if ($result) {
                _json(200, 'ID card generated successfully', []);
            } else {
                _json(201, 'Something went wrong please try again!');
            } 
        }
    }
    
    public function import()
    {
        $courses = Course::orderBy('course_id', 'ASC')->get();
        $academicYear = AcademicYear::get();
        return view('admin.student.import')->with(['academicYear' => $academicYear, 'courses' => $courses]);
    }

    public function studentImport(Request $request)
    {
        try {
            $data = Excel::toArray(new StudentImport($request->except(['excel', '_token'])), $request->file('excel'));
            foreach ($data[0] as $row) 
        {
            if (!empty($request->academic_year) && !empty($request->course) && !empty($request->semester) && !empty($request->group)) {
                    $user = new User();
                    $user->name = $row['student_name'] . ' ' . $row['father_name'] . ' ' . $row['surname'];
                    $user->student_name = $row['student_name'];
                    $user->father_name = $row['father_name'];
                    $user->surname = $row['surname'];
                    $user->email = $row['email'] ?? $row['student_name'] . $row['father_name'] . $row['surname'] . '@dummy.com';
                    $user->contact_no = $row['contact_no'];
                    $user->gender = $row['gender'];
                    $user->birth_date = $row['birth_date'];
                    $user->caste = $row['caste'];
                    $user->aadhar_card_no = $row['aadhar_card_no'];
                    $user->student_photo = null;
                    $user->student_sign = null;
                    $user->school_name = $row['school_name'];
                    $user->join_date = $row['join_date'];
                    $user->leaving_date = $row['leaving_date'];
                    $user->marksheet_no_12 = $row['marksheet_no_12'];
                    $user->exam_center = $row['exam_center'];
                    $user->passing_month = $row['passing_month'];
                    $user->passing_year = $row['passing_year'];
                    $user->obtained_marks = $row['obtained_marks'];
                    $user->address = $row['address'];
                    $user->cur_city = $row['cur_city'];
                    $user->cur_taluko = $row['cur_taluko'];
                    $user->cur_district = $row['cur_district'];
                    $user->cur_pincode = $row['cur_pincode'];
                    $user->per_address = $row['per_address'];
                    $user->per_city = $row['per_city'];
                    $user->per_taluko = $row['per_taluko'];
                    $user->per_district = $row['per_district'];
                    $user->per_pincode = $row['per_pincode'];
                    $user->is_completed_registration = 1;
                    $user->is_admission_approved = 1;
                    $user->is_admission_approved = 1;
                    $user->is_form_fees_paid = 1;
                    $user->is_initial_college_fees_paid = 1;
                    $user->admission_processed_at = now();
                    $user->admission_processed_by = \Auth::id();
                    $user->password = Hash::make('password');
                    $user->markEmailAsVerified();
                    $user->save();
                    if ($user) {
                        // $acedemicYear = AcademicYear::where('is_default', 1)->first();
                        $enrolledStudents = StudentEnrollment::where('academic_year_id', $request->academic_year)->where('course_id', $request->course)->where('semester_id', $request->semester)->where('group_id', $request->group)->where('is_fees_paid', 1)->count();
                            $group = Group::where('group_id', $request->group)->first();
                            $rollNo = $enrolledStudents + 1;
                            if(!empty($group) && isset($group->range_for_roll_no) && !empty($group->range_for_roll_no)) {
                                $rollNo = ($group->range_for_roll_no + ($enrolledStudents + 1)); 
                            }

                        $enrollment = StudentEnrollment::create([
                            'academic_year_id' => $request->academic_year,
                            'course_id' => $request->course ?? 0,
                            'semester_id' => $request->semester ?? 0,
                            'group_id' => $request->group ?? NULL,
                            'user_id' => $user->id,
                            'roll_no' => $rollNo,
                            'is_fees_paid' => 0
                        ]);
                        $var = "success";
                        // $redirect = route('admin.students');
                        // $arr = array("redirect" => $redirect);
                        // _json(200, 'Student added successfully', $arr);
                    } else {
                        $var = "fail";

                        // _json(201, 'Something went wrong plase try again!');
                    }

            }
        }
            $redirect = route('admin.students');
            $arr = array("redirect" => $redirect);
            _json(200, 'Student imported successfully', $arr);
        } catch (\Exception $e) {
            _json(201, $e->getMessage());
        }
    }

    public function resetStudentLoginCredentials($id)
    {
        $studentData = User::where('id', $id)->first();
        if ($studentData) {
            return view('admin.student.reset_credentials')->with(['studentData' => $studentData]);
        } else {
            return redirect()->route('home');
        }
    }

    public function credentialsReset(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => "required|email|max:255|unique:users,email," . $request->student_id . ",id"
            ],
            [
                'email.required' => 'Please enter email.'
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $result = User::findOrFail($request->student_id);
            $result->email = $request['email'];
            if (isset($request['password']) && !empty($request['password'])) {
                $result->password = Hash::make($request['password']);
            }
            
            $result->save();
            if ($result) {
                $arr = array("redirect" => route('admin.students'));
                _json(200, 'Credentials updated successfully.', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function downloadEnrolledStudentsFiles(Request $request)
    {
        $query = StudentEnrollment::with(['user'])->where('group_id', '!=', 0)->where('is_cancelled', 0);
        if ($request->get('academic_year') !== null) {
            $query->where('academic_year_id', $request->get('academic_year'));
        }
        if ($request->get('course') !== null) {
            $query->where('course_id', $request->get('course'));
        }
        if ($request->get('semester') !== null) {
            $query->where('semester_id', $request->get('semester'));
        }
        if ($request->get('group') !== null) {
            $query->where('group_id', $request->get('group'));
        }
        $query->where('is_fees_paid', 1);
        $result = $query->get();
        if ($result->count() > 0) {
            // Create a zip file
            $zipFileName = 'student_files_'.date('d-m-Y H:i:s').'.zip';
            $zip = new ZipArchive;
            $zip->open($zipFileName, ZipArchive::CREATE);

            // Loop through each user
            foreach ($result as $enrollment) {
                if (isset($enrollment->user->student_photo) && !empty($enrollment->user->student_photo)) {
                    // Add the photo to the zip file
                    $photoPath = public_path('/uploads/student_photo/' . $enrollment->user->student_photo);
                    if (file_exists($photoPath) && is_file($photoPath)) {
                        $extension = pathinfo($photoPath, PATHINFO_EXTENSION);
                        $zip->addFile($photoPath, $enrollment->course->course_name . '/' . $enrollment->semester->semester_name . '/photo/' . $enrollment->roll_no . '.' . $extension);
                    }

                    // Add the sign to the zip file
                    $signPath = public_path('/uploads/student_sign/' . $enrollment->user->student_sign);
                    if (file_exists($signPath) && is_file($signPath)) {
                        $extension = pathinfo($signPath, PATHINFO_EXTENSION);
                        $zip->addFile($signPath, $enrollment->course->course_name . '/' . $enrollment->semester->semester_name . '/sign/' . $enrollment->roll_no . '.' . $extension);
                    }
                }
            }

            // Close the zip file
            $zip->close();

            // Download the zip file
            if (file_exists($zipFileName)) {
                return response()->download($zipFileName)->deleteFileAfterSend(true);
            } else {
                return response('Unable to create zip file', 500);
            }
        } else {
            return response('No enrollments found', 500);
        }
    }

    /**
     * Show the admission request details.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editAdmissionRequest(Request $request)
    {
        $result = User::where('is_admission_approved', 0)->where('id', $request->id)->firstOrFail();
        $courses = Course::get();
        $enrollmentDetails = StudentEnrollment::with(['academicYear', 'course', 'semester', 'group', 'user'])->where('user_id',$result->id)->latest()->firstOrFail();
        $semesters = Semester::where('course_id', $enrollmentDetails->course_id ?? 0)->get();
        $group = Group::where('course_id', $enrollmentDetails->course_id)->where('semester_id', $enrollmentDetails->semester_id)->get();
        return view('admin.student.admission_form_edit')->with(['courses' => $courses, 'studentData' => $result, 'semesters' => $semesters, 'groups' => $group, 'enrollmentDetails' => $enrollmentDetails]);
    }

    public function editAdmissionRequestData(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student' => ['required'],
                'student_name' => ['required', 'string', 'max:255'],
                'father_name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'contact_no' => ['required'],
                'gender' => ['required'],
                'birth_date' => ['required'],
                'caste' => ['required'],
                'aadhar_card_no' => ['required'],
                // 'student_photo' => ['image', 'mimes:jpg', 'max:2048'],
                // 'student_sign' => ['image', 'mimes:jpg', 'max:2048'],
                'school_name' => ['required'],
                'join_date' => ['required'],
                'leaving_date' => ['required'],
                'marksheet_no' => ['required', 'alpha_num'],
                'exam_center' => ['required'],
                'passing_month' => ['required'],
                'passing_year' => ['required'],
                'obtained_marks' => ['required'],
                'course' => ['required'],
                'semester' => ['required'],
                'group' => ['required'],
                'address' => ['required', 'string', 'max:255'],
                'cur_city' => ['required', 'string', 'max:255'],
                'cur_taluko' => ['required', 'string', 'max:255'],
                'cur_district' => ['required', 'string', 'max:255'],
                'cur_pincode' => ['required', 'string', 'max:255'],
                'per_address' => ['required', 'string', 'max:255'],
                'per_city' => ['required', 'string', 'max:255'],
                'per_taluko' => ['required', 'string', 'max:255'],
                'per_district' => ['required', 'string', 'max:255'],
                'per_pincode' => ['required', 'string', 'max:255'],
            ],
            [
                'student.required' => 'Something went wrong please refresh the page and try again!',
                'student_name.required' => 'Please enter student name.',
                'father_name.required' => 'Please enter father name.',
                'surname.required' => 'Please enter surname.',
                'contact_no.required' => 'Please enter contact no.',
                'gender' => 'Please select gender.',
                'birth_date' => 'Please select birth date.',
                'caste' => 'Please select caste.',
                'aadhar_card_no' => 'Please enter aadhar card no.',
                // 'student_photo' => 'Please select student photo.',
                // 'student_sign' => 'Please select student sign.',
                'school_name' => 'Please enter school name.',
                'join_date' => 'Please select join date.',
                'leaving_date' => 'Please select leaving date.',
                'marksheet_no.required' => 'Please enter 12th marksheet no.',
                'exam_center' => 'Please enter exam center.',
                'passing_month'=> 'Please select passing month.',
                'passing_year' => 'Please select passing year.',
                'obtained_marks' => 'Please enter obtained marks.',
                'course' => 'Please select course.',
                'semester' => 'Please select semester.',
                'group' => 'Please select group.',
                'address.required' => 'Please enter current address.',
                'cur_city.required' => 'Please enter current city.',
                'cur_taluko.required' => 'Please enter current taluko.',
                'cur_district.required' => 'Please enter current district.',
                'cur_pincode.required' => 'Please enter current pincode.',
                'per_address.required' => 'Please enter permanent address.',
                'per_city.required' => 'Please enter permanent city.',
                'per_taluko.required' => 'Please enter permanent taluko.',
                'per_district.required' => 'Please enter permanent district.',
                'per_pincode.required' => 'Please enter permanent pincode.',
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            _json(201, $return);
        } else {
            $student_sign = $student_photo = '';
            if ($request->hasFile('student_photo')) {
                $student_photo = 'student_photo_' . time() . '.' . $request->student_photo->extension();
                $request->student_photo->move(public_path('uploads/student_photo'), $student_photo);
            }
            if ($request->hasFile('student_sign')) {
                $student_sign = 'student_sign_' . time() . '.' . $request->student_sign->extension();
                $request->student_sign->move(public_path('uploads/student_sign'), $student_sign);
            }

            $user = User::findOrFail($request['student']);
            $user->name = $request['student_name'] . ' ' . $request['father_name'] . ' ' . $request['surname'];
            $user->student_name = $request['student_name'];
            $user->father_name = $request['father_name'];
            $user->surname = $request['surname'];
            $user->contact_no = $request['contact_no'];
            $user->gender = $request['gender'];
            $user->birth_date = $request['birth_date'];
            $user->caste = $request['caste'];
            $user->aadhar_card_no = $request['aadhar_card_no'];
            if ($request->hasFile('student_photo')) {
                $user->student_photo = $student_photo;
            }
            if ($request->hasFile('student_sign')) {
                $user->student_sign = $student_sign;
            }
            $user->school_name = $request['school_name'];
            $user->join_date = $request['join_date'];
            $user->leaving_date = $request['leaving_date'];
            $user->marksheet_no_12 = $request['marksheet_no'];
            $user->exam_center = $request['exam_center'];
            $user->passing_month = $request['passing_month'];
            $user->passing_year = $request['passing_year'];
            $user->obtained_marks = $request['obtained_marks'];
            $user->address = $request['address'];
            $user->cur_city = $request['cur_city'];
            $user->cur_taluko = $request['cur_taluko'];
            $user->cur_district = $request['cur_district'];
            $user->cur_pincode = $request['cur_pincode'];
            $user->per_address = $request['per_address'];
            $user->per_city = $request['per_city'];
            $user->per_taluko = $request['per_taluko'];
            $user->per_district = $request['per_district'];
            $user->per_pincode = $request['per_pincode'];
            $user->is_completed_registration = 1;
            $user->save();

            if ($user) {
                $enrollment = StudentEnrollment::where('user_id', $request['student'])->firstOrFail();
                $enrollment->course_id = $request['course'] ?? 0;
                $enrollment->semester_id = $request['semester'] ?? 0;
                $enrollment->group_id = $request['group'] ?? NULL;
                $result = $enrollment->update();
                // $acedemicYear = AcademicYear::where('is_default', 1)->first();
                // $enrollment = StudentEnrollment::create([
                //     'academic_year_id' => $acedemicYear->academic_year_id,
                //     'course_id' => $request['course'] ?? 0,
                //     'semester_id' => $request['semester'] ?? 0,
                //     'group_id' => $request['group'] ?? NULL,
                //     'user_id' => $request['student']
                // ]);
                $arr = array("redirect" => route('admin.admission_requests'));
                _json(200, 'Admission details updated successfully!', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
