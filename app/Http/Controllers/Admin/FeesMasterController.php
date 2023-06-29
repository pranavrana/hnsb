<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AdmissionFee;
use App\Models\Course;
use App\Models\FeesMaster;
use App\Models\Group;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class FeesMasterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:college-fees-list|college-fees-create|college-fees-edit|college-fees-delete', ['only' => ['index']]);
        $this->middleware('permission:college-fees-create', ['only' => ['add','insert']]);
        $this->middleware('permission:college-fees-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:college-fees-delete', ['only' => ['delete']]);

        $this->middleware('permission:admission-fees-list|admission-fees-create|admission-fees-edit|admission-fees-delete', ['only' => ['admissionFees']]);
        $this->middleware('permission:admission-fees-create', ['only' => ['admissionFeesAdd','admissionFeesInsert']]);
        $this->middleware('permission:admission-fees-edit', ['only' => ['admissionFeesEdit','admissionFeesUpdate']]);
        // $this->middleware('permission:admission-fees-delete', ['only' => ['delete']]);

    }

    /**
     * Show the Group listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = FeesMaster::with(['academic_year','semester','course','group'])->orderBy('group_id', 'DESC')->get();
        return view('admin.fees_master.list')->with(['feesMasterData' => $result]);
    }

    /**
     * Show the add Group page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        $academicYear = AcademicYear::get();
        $course = Course::get();
        $group = Group::get();
        return view('admin.fees_master.add')->with(['academicYearData' => $academicYear, 'courseData' => $course, 'groupData' => $group]);;;
    }

    /**
     * Show the add Group page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "academic_year_id" => ['required'],
                "course_id" => ['required'],
                "semester_id" => ['required'],
                "group_id" => ['required'],
                "gender" => ['required'],
                "fee_tut" => ['required','numeric','min:0'],
                "fee_lib" => ['required','numeric','min:0'],
                "fee_sport_gim" => ['required','numeric','min:0'],
                "fee_sport_clg" => ['required','numeric','min:0'],
                "fee_clgexam_stat" => ['required','numeric','min:0'],
                "fee_student_rahat" => ['required','numeric','min:0'],
                "fee_clg_dev" => ['required'],'numeric','min:0',
                "fee_you_fas" => ['required','numeric','min:0'],
                "fee_med" => ['required','numeric','min:0'],
                "fee_hb_rasi" => ['required','numeric','min:0'],
                "fee_union" => ['required','numeric','min:0'],
                "fee_reg" => ['required','numeric','min:0'],
                "fee_enroll" => ['required','numeric','min:0'],
                "fee_icard" => ['required','numeric','min:0'],
                "fee_uniother" => ['required','numeric','min:0'],
                "fee_theal" => ['required','numeric','min:0'],
                "fee_lab" => ['required','numeric','min:0'],
                "fee_uni_exam_form" => ['required','numeric','min:0'],
                "fee_uniexam" => ['required','numeric','min:0'],
                "fee_comp" => ['required','numeric','min:0'],
                "fee_ele" => ['required','numeric','min:0'],
                "fee_other" => ['required','numeric','min:0'],
                "scope_exam_fee" => ['required','numeric','min:0'],
                "fee_late" => ['required','numeric','min:0'],
                "cutoff_date" => ['required']
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
            $existingfees = FeesMaster::where('academic_year_id', $request->academic_year_id)->where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->where('group_id', $request->group_id)->where('gender', $request->gender)->first();
            if(!empty($existingfees)) {
                _json(201, 'Fees with same details already exist!');
            }
            $feesMaster = FeesMaster::create([
                "academic_year_id" => $request['academic_year_id'],
                "course_id" => $request['course_id'],
                "semester_id" => $request['semester_id'],
                "group_id" => $request['group_id'],
                "gender" => $request['gender'],
                "fee_tut" => $request['fee_tut'],
                "fee_lib" => $request['fee_lib'],
                "fee_sport_gim" => $request['fee_sport_gim'],
                "fee_sport_clg" => $request['fee_sport_clg'],
                "fee_clgexam_stat" => $request['fee_clgexam_stat'],
                "fee_student_rahat" => $request['fee_student_rahat'],
                "fee_clg_dev" => $request['fee_clg_dev'],
                "fee_you_fas" => $request['fee_you_fas'],
                "fee_med" => $request['fee_med'],
                "fee_hb_rasi" => $request['fee_hb_rasi'],
                "fee_union" => $request['fee_union'],
                "fee_reg" => $request['fee_reg'],
                "fee_enroll" => $request['fee_enroll'],
                "fee_icard" => $request['fee_icard'],
                "fee_uniother" => $request['fee_uniother'],
                "fee_theal" => $request['fee_theal'],
                "fee_lab" => $request['fee_lab'],
                "fee_uni_exam_form" => $request['fee_uni_exam_form'],
                "fee_uniexam" => $request['fee_uniexam'],
                "fee_comp" => $request['fee_comp'],
                "fee_ele" => $request['fee_ele'],
                "fee_other" => $request['fee_other'],
                "scope_exam_fee" => $request['scope_exam_fee'],
                "fee_late" => $request['fee_late'],
                "total_fee" => $request['total_fee'],
                "cutoff_date" => $request['cutoff_date'],
                "cutoff_extension_date" => $request['cutoff_extension_date'] ?? NULL,
                "cutoff_extension_status" => $request['cutoff_extension_status'] ?? 0
            ]);

            if ($feesMaster) {
                $redirect = route('admin.fees_master');
                $arr = array("redirect" => $redirect);
                _json(200, 'College fees added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function edit($id)
    {

        $feesMasterData = FeesMaster::where('fees_master_id', $id)->first();
        if ($feesMasterData) {
            $academicYear = AcademicYear::get();
            $course = Course::get();
            $semesters = Semester::where('course_id', $feesMasterData->course_id)->get();
            $group = Group::where('course_id', $feesMasterData->course_id)->where('semester_id', $feesMasterData->semester_id)->get();
            return view('admin.fees_master.edit')->with(['feesMasterData' => $feesMasterData, 'academicYearData' => $academicYear, 'courseData' => $course, 'semesterData' => $semesters, 'groupData' => $group]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "academic_year_id" => ['required'],
                "course_id" => ['required'],
                "semester_id" => ['required'],
                "group_id" => ['required'],
                "gender" => ['required'],
                "fee_tut" => ['required','numeric','min:0'],
                "fee_lib" => ['required','numeric','min:0'],
                "fee_sport_gim" => ['required','numeric','min:0'],
                "fee_sport_clg" => ['required','numeric','min:0'],
                "fee_clgexam_stat" => ['required','numeric','min:0'],
                "fee_student_rahat" => ['required','numeric','min:0'],
                "fee_clg_dev" => ['required','numeric','min:0'],
                "fee_you_fas" => ['required','numeric','min:0'],
                "fee_med" => ['required','numeric','min:0'],
                "fee_hb_rasi" => ['required','numeric','min:0'],
                "fee_union" => ['required','numeric','min:0'],
                "fee_reg" => ['required','numeric','min:0'],
                "fee_enroll" => ['required','numeric','min:0'],
                "fee_icard" => ['required','numeric','min:0'],
                "fee_uniother" => ['required','numeric','min:0'],
                "fee_theal" => ['required','numeric','min:0'],
                "fee_lab" => ['required','numeric','min:0'],
                "fee_uni_exam_form" => ['required','numeric','min:0'],
                "fee_uniexam" => ['required','numeric','min:0'],
                "fee_comp" => ['required','numeric','min:0'],
                "fee_ele" => ['required','numeric','min:0'],
                "fee_other" => ['required','numeric','min:0'],
                "scope_exam_fee" => ['required','numeric','min:0'],
                "fee_late" => ['required','numeric','min:0'],
                "cutoff_date" => ['required']
            ],
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
            $existingfees = FeesMaster::where('academic_year_id', $request->academic_year_id)->where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->where('group_id', $request->group_id)->where('gender', $request->gender)->where('fees_master_id', '!=' ,$request->id)->first();
            if(!empty($existingfees)) {
                _json(201, 'Fees with same details already exist!');
            }

            $feesMaster = FeesMaster::findOrFail($request->id);
            $feesMaster->academic_year_id = $request['academic_year_id'];
            $feesMaster->course_id = $request['course_id'];
            $feesMaster->semester_id = $request['semester_id'];
            $feesMaster->group_id = $request['group_id'];
            $feesMaster->gender = $request['gender'];
            $feesMaster->fee_tut = $request['fee_tut'];
            $feesMaster->fee_lib = $request['fee_lib'];
            $feesMaster->fee_sport_gim = $request['fee_sport_gim'];
            $feesMaster->fee_sport_clg = $request['fee_sport_clg'];
            $feesMaster->fee_clgexam_stat = $request['fee_clgexam_stat'];
            $feesMaster->fee_student_rahat = $request['fee_student_rahat'];
            $feesMaster->fee_clg_dev = $request['fee_clg_dev'];
            $feesMaster->fee_you_fas = $request['fee_you_fas'];
            $feesMaster->fee_med = $request['fee_med'];
            $feesMaster->fee_hb_rasi = $request['fee_hb_rasi'];
            $feesMaster->fee_union = $request['fee_union'];
            $feesMaster->fee_reg = $request['fee_reg'];
            $feesMaster->fee_enroll = $request['fee_enroll'];
            $feesMaster->fee_icard = $request['fee_icard'];
            $feesMaster->fee_uniother = $request['fee_uniother'];
            $feesMaster->fee_theal = $request['fee_theal'];
            $feesMaster->fee_lab = $request['fee_lab'];
            $feesMaster->fee_uni_exam_form = $request['fee_uni_exam_form'];
            $feesMaster->fee_uniexam = $request['fee_uniexam'];
            $feesMaster->fee_comp = $request['fee_comp'];
            $feesMaster->fee_ele = $request['fee_ele'];
            $feesMaster->fee_other = $request['fee_other'];
            $feesMaster->scope_exam_fee = $request['scope_exam_fee'];
            $feesMaster->fee_late = $request['fee_late'];
            $feesMaster->total_fee = $request['total_fee'];
            $feesMaster->cutoff_date = $request['cutoff_date'];
            $feesMaster->cutoff_extension_date = $request['cutoff_extension_date'] ?? NULL;
            $feesMaster->cutoff_extension_status = $request['cutoff_extension_status'] ?? 0;
            $feesMaster->save();

            if ($feesMaster) {
                $redirect = route('admin.fees_master');
                $arr = array("redirect" => $redirect);
                _json(200, 'College fees updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function getSemesterByCourseId(Request $request)
    {
        $data = '';
        $courseId     = $request->course_id;
        $semesterId     = $request->semester_id;
        if ($courseId > "0") {
            $semesterData = Semester::where('course_id', $courseId)->get();
            if (!empty($semesterData)) {
                $data .= '<select class="form-select" id="semester_id" name="semester_id">
								<option value="">Select Any Semester</option>';
                foreach ($semesterData as $ts) {
                    $data .= ($semesterId == $ts['semester_id']) ? '<option value="' . $ts["semester_id"] . '" selected>' . $ts["semester_name"] . '</option>' : '<option value="' . $ts["semester_id"] . '">' . $ts["semester_name"] . '</option>';
                }
                $data .= '</select>
						';
            }
        }
        $res = array('content' => $data);
        header('Content-Type:application/json');
        echo json_encode($res);
    }

    /**
     * Show the admission fees listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admissionFees()
    {
        $result = AdmissionFee::with(['academic_year','semester','course'])->orderBy('admission_fees_id', 'DESC')->get();
        return view('admin.fees_master.admission_fees')->with(['data' => $result]);
    }

    /**
     * Show the add admission fees page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admissionFeesAdd()
    {
        $academicYears = AcademicYear::get();
        $courses = Course::get();
        return view('admin.fees_master.admission_fees_add')->with(['academicYears' => $academicYears, 'courses' => $courses]);
    }

    /**
     * Insert admission fees record.
     */
    public function admissionFeesInsert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "academic_year_id" => ['required'],
                "course_id" => ['required'],
                "semester_id" => ['required'],
                "admission_fees" => ['required','numeric','min:0'],
                "cutoff_date" => ['required']
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
            $existingfees = AdmissionFee::where('academic_year_id', $request->academic_year_id)->where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->first();
            if(!empty($existingfees)) {
                _json(201, 'Admission fees already added for this semester!');
            }
            $result = AdmissionFee::create([
                "academic_year_id" => $request['academic_year_id'],
                "course_id" => $request['course_id'],
                "semester_id" => $request['semester_id'],
                "admission_fees" => $request['admission_fees'],
                "cutoff_date" => $request['cutoff_date']
            ]);

            if ($result) {
                $redirect = route('admin.admission_fees_list');
                $arr = array("redirect" => $redirect);
                _json(200, 'Admission fees added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function admissionFeesEdit($id)
    {
        $data = AdmissionFee::where('admission_fees_id', $id)->first();
        if ($data) {
            $academicYears = AcademicYear::get();
            $courses = Course::get();
            $semesters = Semester::where('course_id', $data->course_id)->get();
            return view('admin.fees_master.admission_fees_edit')->with(['data' => $data, 'academicYears' => $academicYears, 'courses' => $courses, 'semesters' => $semesters]);
        } else {
            return redirect()->route('home');
        }
    }
    
    public function admissionFeesUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "academic_year_id" => ['required'],
                "course_id" => ['required'],
                "semester_id" => ['required'],
                "admission_fees" => ['required','numeric','min:0'],
                "cutoff_date" => ['required']
            ],
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
            $existingfees = AdmissionFee::where('academic_year_id', $request->academic_year_id)->where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->where('admission_fees_id', '!=' ,$request->id)->first();
            if(!empty($existingfees)) {
                _json(201, 'Admission fees already added for this semester!');
            }
            $feesMaster = AdmissionFee::findOrFail($request->id);
            $feesMaster->academic_year_id = $request['academic_year_id'];
            $feesMaster->course_id = $request['course_id'];
            $feesMaster->semester_id = $request['semester_id'];
            $feesMaster->admission_fees = $request['admission_fees'];
            $feesMaster->cutoff_date = $request['cutoff_date'];
            $feesMaster->save();

            if ($feesMaster) {
                $redirect = route('admin.admission_fees_list');
                $arr = array("redirect" => $redirect);
                _json(200, 'Admission fees updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function admissionFeesDelete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'admission_fees' => ['required'],
            ],
            [
                'admission_fees.required' => 'Something went wrong, please try again!.',
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
            $fees = AdmissionFee::where("admission_fees_id", $request->admission_fees)->delete();
            if ($fees) {
                $redirect = route('admin.admission_fees_list');
                $arr = array("redirect" => $redirect);
                _json(200, 'Admission fees deleted successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function collegeFeesDelete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fees_master' => ['required'],
            ],
            [
                'fees_master.required' => 'Something went wrong, please try again!.',
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
            $fees = FeesMaster::where("fees_master_id", $request->fees_master)->delete();
            if ($fees) {
                $redirect = route('admin.fees_master');
                $arr = array("redirect" => $redirect);
                _json(200, 'College fees deleted successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
