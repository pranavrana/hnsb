<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionFee;
use App\Models\Course;
use App\Models\FeesMaster;
use App\Models\Group;
use App\Models\PaidFees;
use App\Models\Semester;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class SemesterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:semester-list|semester-create|semester-edit|semester-delete', ['only' => ['index']]);
        $this->middleware('permission:semester-create', ['only' => ['add','insert']]);
        $this->middleware('permission:semester-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:semester-delete', ['only' => ['delete']]);
    }

    /**
     * Show the students listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = Semester::with('course')->orderBy('semester_id', 'DESC')->get();
        return view('admin.semester.list')->with(['semesterData' => $result]);
    }

    /**
     * Show the add students page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        $courseData = Course::get();
        return view('admin.semester.add')->with(['courseData' => $courseData]);;
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
                'course_id' => ['required'],
                'semester_name' => ['required'],
            ],
            [
                'course_id.required' => "Please select course.",
                'semester_name.required' => 'Please enter semester name.',
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
            $semester = Semester::create([
                'course_id' => $request['course_id'],
                'semester_name' => $request['semester_name'],
            ]);

            if ($semester) {
                $redirect = route('admin.semester');
                $arr = array("redirect" => $redirect);
                _json(200, 'Semester added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function edit($id)
    {
        $courseData = Course::get();
        $semesterData = Semester::where('semester_id', $id)->first();
        if ($semesterData) {
            return view('admin.semester.edit')->with(['semesterData' => $semesterData, 'courseData' => $courseData]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'course_id' => ['required'],
                'semester_name' => ['required'],
            ],
            [
                'course_id.required' => "Please select course.",
                'semester_name.required' => 'Please enter semester name.',
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

            $semester = Semester::findOrFail($request->id);
            $semester->course_id = $request['course_id'];
            $semester->semester_name = $request['semester_name'];
            $semester->save();

            if ($semester) {
                $redirect = route('admin.semester');
                $arr = array("redirect" => $redirect);
                _json(200, 'Semester name updated successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    /**
     * Get semesters by course id.
     *
     * @param \Illuminate\Http\Request
     * @return json
     */
    public function getSemesterByCourseID(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'CourseID' => ['required'],
            ],
            [
                'CourseID.required' => "Please select course.",
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
            $result = Semester::where('course_id', $request->CourseID)->orderBy('semester_id', 'DESC')->get();
            _json(200, '', $result
        );
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'semester' => ['required'],
            ],
            [
                'semester.required' => 'Something went wrong, please try again!.',
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
            $semester = Semester::where("semester_id", $request->semester)->delete();
            if ($semester) {
                Group::where("semester_id", $request->semester)->delete();
                StudentEnrollment::where("semester_id", $request->semester)->delete();
                AdmissionFee::where("semester_id", $request->semester)->delete();
                FeesMaster::where("semester_id", $request->semester)->delete();
                PaidFees::where("semester_id", $request->semester)->delete();
                $redirect = route('admin.semester');
                $arr = array("redirect" => $redirect);
                _json(200, 'Semester deleted successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
