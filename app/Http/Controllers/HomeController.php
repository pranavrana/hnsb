<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\AdmissionFee;
use App\Models\Contact;
use App\Models\Course;
use App\Models\FeesMaster;
use App\Models\Group;
use App\Models\PaidFees;
use App\Models\Semester;
use App\Models\StudentEnrollment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['termsAndConditions', 'aboutUs', 'contactUs', 'submitContact', 'privacyPolicy', 'paymentNotification']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $courses = Course::get();
        $user = User::where('id', Auth::guard('web')->user()->id)->firstOrFail();
        // $enrollmentDetails = [];
        // if($user->is_form_fees_paid == 1 && $user->is_completed_registration == 1 && $user->is_admission_approved == 1 && $user->is_initial_college_fees_paid == 1){
        $enrollmentDetails = StudentEnrollment::with(['academicYear', 'course', 'semester', 'group', 'user'])->where('user_id', Auth::guard('web')->user()->id)->latest()->firstOrFail();
        // }
        $semesters = Semester::where('course_id', $enrollmentDetails->course_id ?? 0)->get();
        $group = Group::where('course_id', $enrollmentDetails->course_id)->where('semester_id', $enrollmentDetails->semester_id)->get();

        return view('home')->with(['courses' => $courses, 'semesters' => $semesters, 'groups' => $group, 'enrollmentDetails' => $enrollmentDetails]);
    }

    /**
     * Insert the admission data.
     *
     * @return  
     */
    public function admission(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
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
                'passing_month' => 'Please select passing month.',
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
            // Session::flash('error', $return);

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
            $user = User::where('id', \Auth::id())->update([
                'name' => $request['student_name'] . ' ' . $request['father_name'] . ' ' . $request['surname'],
                'student_name' => $request['student_name'],
                'father_name' => $request['father_name'],
                'surname' => $request['surname'],
                'contact_no' => $request['contact_no'],
                'gender' => $request['gender'],
                'birth_date' => $request['birth_date'],
                'caste' => $request['caste'],
                'aadhar_card_no' => $request['aadhar_card_no'],
                'student_photo' => $student_photo,
                'student_sign' => $student_sign,
                'school_name' => $request['school_name'],
                'join_date' => $request['join_date'],
                'leaving_date' => $request['leaving_date'],
                'marksheet_no_12' => $request['marksheet_no'],
                'exam_center' => $request['exam_center'],
                'passing_month' => $request['passing_month'],
                'passing_year' => $request['passing_year'],
                'obtained_marks' => $request['obtained_marks'],
                'address' => $request['address'],
                'cur_city' => $request['cur_city'],
                'cur_taluko' => $request['cur_taluko'],
                'cur_district' => $request['cur_district'],
                'cur_pincode' => $request['cur_pincode'],
                'per_address' => $request['per_address'],
                'per_city' => $request['per_city'],
                'per_taluko' => $request['per_taluko'],
                'per_district' => $request['per_district'],
                'per_pincode' => $request['per_pincode'],
                'is_completed_registration' => 1
            ]);

            if ($user) {
                $acedemicYear = AcademicYear::where('is_default', 1)->first();
                $enrollment = StudentEnrollment::updateOrCreate(
                    [
                        'academic_year_id' => $acedemicYear->academic_year_id,
                        'course_id' => $request['course'] ?? 0,
                        'semester_id' => $request['semester'] ?? 0,
                        'user_id' => \Auth::id()
                    ],
                    [
                        'group_id' => $request['group'] ?? 0,
                    ]
                );
                $redirect = route('home');
                $arr = array("redirect" => $redirect);
                _json(200, 'Admission details successfully submitted! you will receive notification when admission will be approved', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function termsAndConditions()
    {
        return view('terms-and-conditions');
    }

    public function aboutUs()
    {
        return view('about-us');
    }

    public function contactUs()
    {
        return view('contact-us');
    }

    /**
     * Submit contact details.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function submitContact(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'email' => ['required'],
                'phone' => ['required'],
                'message' => ['required'],
            ],
            [
                'name.required' => 'Please enter name.',
                'email.required' => 'Please enter email.',
                'phone.required' => 'Please enter phone.',
                'message.required' => 'Please enter message.',
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
            $contact = Contact::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'message' => $request['message']
            ]);

            if ($contact) {
                $arr = array();
                _json(200, 'Contact details submitted successfully, we will get back to you shortly!', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    /**
     * Paytm payment webhook call.
     *
     * @return void
     */
    public function paymentNotification(Request $request)
    {
        $request = $request->all();
        \Log::info($request);
        if (isset($request['ORDERID']) && isset($request['RESPCODE']) && isset($request['STATUS']) && isset($request['TXNID']) && isset($request['CUSTID']) && isset($request['TXNAMOUNT']) && !empty($request['ORDERID']) && !empty($request['STATUS']) && !empty($request['TXNID'])) {
            $orderData = explode('_', $request['ORDERID']);
            if (isset($orderData[0]) && $orderData[0] == 'ADMF') {
                $existingTransaction = Transaction::where('user_id', $request['CUSTID'])->where('order_id', $request['ORDERID'])->where('txn_id', $request['TXNID'])->first();
                if (empty($existingTransaction)) {
                    $user = User::where('id', $request['CUSTID'])->first();
                    if (!empty($user)) {
                        $enrollmentDetails = StudentEnrollment::where('user_id', $user->id)->firstOrFail();
                        $admissionFee = AdmissionFee::where('academic_year_id', $enrollmentDetails->academic_year_id)->where('course_id', $enrollmentDetails->course_id)->where('semester_id', $enrollmentDetails->semester_id)->first();
                        $admissionFees = $admissionFee->admission_fees ?? 0;
    
                        $transactionData = Transaction::create([
                            'user_id' => $user->id,
                            'order_id' => $request['ORDERID'] ?? null,
                            'email' => $request['email'] ?? $user->email,
                            'contact_no' => $request['contact_no'] ?? $user->contact_no,
                            'amount' => $admissionFees,
                            'txn_id' => $request['TXNID'] ?? null,
                            'txn_amount' => $request['TXNAMOUNT'] ?? null,
                            'txn_date' => $request['TXNDATETIME'] ?? null,
                            'txn_payment_mode' => $request['PAYMENTMODE'] ?? null,
                            'txn_bank_txn_id' => $request['BANKTXNID'] ?? null,
                            'txn_status' => $request['STATUS'] ?? null,
                            'txn_response_code' => $request['RESPCODE'] ?? null,
                            'txn_response_msg' => $request['RESPMSG'] ?? null,
                            'response' => $request ?? null,
                        ]);
    
                        if ($request['STATUS'] == 'TXN_SUCCESS' && $request['TXNAMOUNT'] >= $admissionFees) {
                            User::where('id', $request['CUSTID'])->update([
                                'is_form_fees_paid' => 1
                            ]);
                        }
                    } else {
                        \Log::info(['Invalid User!', [$request]]);
                    }
                } else {
                    \Log::info(['existingAdmissionFeestransaction'=>$existingTransaction,'Request'=>$request]);
                }
            }
            if (isset($orderData[0]) && $orderData[0] == 'CLGF') {
                $existingTransaction = Transaction::where('user_id', $request['CUSTID'])->where('order_id', $request['ORDERID'])->where('txn_id', $request['TXNID'])->where('txn_amount', $request['TXNAMOUNT'])->first();
                if (empty($existingTransaction)) {
                    \DB::beginTransaction();
                    try {
                        $user = User::where('id', $request['CUSTID'])->first();
                        if (!empty($user)) {
                            $studentDetails = StudentEnrollment::where('user_id', $user->id)->latest('enrollment_id')->first();
                            if (!empty($studentDetails)) {
                                $feesDetails = FeesMaster::where('academic_year_id', $studentDetails->academic_year_id)->where('course_id', $studentDetails->course_id)->where('semester_id', $studentDetails->semester_id)->where('group_id', $studentDetails->group_id)->where('gender', $studentDetails->user->gender)->first();

                                if (!empty($feesDetails)) {
                                    $lateFees = $feesDetails->fee_late;
                                    $fees = $feesDetails->total_fee;
                                    $lateFeesPaid = 0;

                                    $collegeFeesCutOffDate = $feesDetails->cutoff_date ?? '';
                                    $cutOffExtentionDate = $feesDetails->cutoff_extension_date ?? '';

                                    if (empty($collegeFeesCutOffDate)) {
                                        \Log::info(['College fees cut off date not configured. Please contact college!', [$request]]);
                                    } else if ((\Carbon\Carbon::parse($collegeFeesCutOffDate)  >= \Carbon\Carbon::now()) === false) {
                                        if (!empty($cutOffExtentionDate) && $feesDetails->cutoff_extension_status == 1 && \Carbon\Carbon::parse($cutOffExtentionDate)  >= \Carbon\Carbon::now()) {
                                            $fees = $fees + $lateFees;
                                            $lateFeesPaid = 1;
                                        } else {
                                            \Log::info(['Collage fees payment cut off date is over!', [$request]]);
                                        }
                                    }

                                    $transactionData = Transaction::create([
                                        'user_id' => $user->id,
                                        'order_id' => $request['ORDERID'] ?? null,
                                        'payment_type' => 2,
                                        'email' => $request['email'] ?? $user->email,
                                        'contact_no' => $request['contact_no'] ?? $user->contact_no,
                                        'amount' => $fees ?? 0,
                                        'txn_id' => $request['TXNID'] ?? null,
                                        'txn_amount' => $request['TXNAMOUNT'] ?? null,
                                        'txn_date' => $request['TXNDATETIME'] ?? null,
                                        'txn_payment_mode' => $request['PAYMENTMODE'] ?? null,
                                        'txn_bank_txn_id' => $request['BANKTXNID'] ?? null,
                                        'txn_status' => $request['STATUS'] ?? null,
                                        'txn_response_code' => $request['RESPCODE'] ?? null,
                                        'txn_response_msg' => $request['RESPMSG'] ?? null,
                                        'response' => $request ?? null,
                                    ]);
                                    if ($request['STATUS'] == 'TXN_SUCCESS' && $request['TXNAMOUNT'] >= $fees) {
                                        $group = Str::upper(substr($studentDetails->group->group_name, 0, 2));
                                        $year = $year = date("y", strtotime('-1 year'));;
                                        if (date("m") >= 05) {
                                            $year = date("y", strtotime('+1 year'));
                                        }
                                        $gr_no = $group . $year . sprintf("%'.05d\n", $user->id);

                                        User::where('id', $user->id)->update([
                                            'is_initial_college_fees_paid' => 1,
                                            'gr_no' => $gr_no
                                        ]);

                                        $fees = $feesDetails->replicate();
                                        $paidFeesArray = $fees->toArray();
                                        $paidFeesArray['user_id'] = $user->id;
                                        $paidFeesArray['enrollment_id'] = $studentDetails->enrollment_id;
                                        $paidFeesArray['transaction_id'] = $transactionData->transaction_id;
                                        $paidFeesArray['is_late_fees_paid'] = $lateFeesPaid;
                                        unset($paidFeesArray['created_at'], $paidFeesArray['updated_at'], $paidFeesArray['deleted_at']);
                                        PaidFees::create($paidFeesArray);

                                        $enrolledStudents = StudentEnrollment::where('academic_year_id', $studentDetails->academic_year_id)->where('course_id', $studentDetails->course_id)->where('semester_id', $studentDetails->semester_id)->where('group_id', $studentDetails->group_id)->where('is_fees_paid', 1)->count();
                                        $group = Group::where('group_id', $studentDetails->group_id)->first();
                                        $rollNo = $enrolledStudents + 1;
                                        if (!empty($group) && isset($group->range_for_roll_no) && !empty($group->range_for_roll_no)) {
                                            $rollNo = ($group->range_for_roll_no + ($enrolledStudents + 1));
                                        }
                                        $studentDetails->roll_no = $rollNo;
                                        $studentDetails->is_fees_paid = 1;
                                        $studentDetails->save();
                                    }
                                }
                            }
                            \DB::commit();
                        }
                    } catch (\Exception $e) {
                        \DB::rollback();
                        \Log::info($e->getMessage());
                    }
                } else {
                    \Log::info(['existingCollageFeesTransaction'=>$existingTransaction,'Request'=>$request]);
                }
            }
        } else {
            \Log::info(['Invalid Webhook Call!', [$request]]);
        }
    }
}
