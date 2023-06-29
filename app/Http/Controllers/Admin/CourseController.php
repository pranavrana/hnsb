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

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:course-list|course-create|course-edit|course-delete', ['only' => ['index']]);
        $this->middleware('permission:course-create', ['only' => ['add','insert']]);
        $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:course-delete', ['only' => ['delete']]);
    }

    /**
     * Show the course listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = Course::orderBy('course_id', 'DESC')->get();
        return view('admin.course.list')->with(['courseData' => $result]);
    }

    /**
     * Show the add course page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        return view('admin.course.add');
    }

    /**
     * Show the add course page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'course_name' => ['required','unique:courses'],
            ],
            [
                'course_name.required' => 'Please enter course name.',
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
            $course = Course::create([
                'course_name' => $request['course_name'],
            ]);

            if ($course) {
                $redirect = route('admin.course');
                $arr = array("redirect" => $redirect);
                _json(200, 'Course added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function edit($id)
    {
        $courseData = Course::where('course_id', $id)->first();
        if ($courseData) {
            return view('admin.course.edit')->with(['courseData' => $courseData]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'course_name' => ['required'],
            ],
            [
                'course_name.required' => 'Please enter course name.',
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
            $course = Course::findOrFail($request->id);
            $course->course_name = $request['course_name'];
            $course->save();

            if ($course) {
                $redirect = route('admin.course');
                $arr = array("redirect" => $redirect);
                _json(200, 'Course name added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'course' => ['required'],
            ],
            [
                'course.required' => 'Something went wrong, please try again!.',
            ]
        );

        if ($validator->fails()) {
            $return = '';
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                $return .= $message . "<br>";
            }
            // _json(201, $return);
            Session::flash('error', $return);
        } else {
            $course = Course::findOrFail($request->course)->delete();
            if ($course) {
                Semester::where("course_id", $request->course)->delete();
                Group::where("course_id", $request->course)->delete();
                StudentEnrollment::where("course_id", $request->course)->delete();
                AdmissionFee::where("course_id", $request->course)->delete();
                FeesMaster::where("course_id", $request->course)->delete();
                PaidFees::where("course_id", $request->course)->delete();
                $redirect = route('admin.course');
                $arr = array("redirect" => $redirect);
                _json(200, 'Course deleted successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
