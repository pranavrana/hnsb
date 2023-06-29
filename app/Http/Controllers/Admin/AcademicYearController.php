<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AcademicYearController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:academic-year-list|academic-year-create|academic-year-edit|academic-year-delete', ['only' => ['index']]);
        $this->middleware('permission:academic-year-create', ['only' => ['add','insert']]);
        $this->middleware('permission:academic-year-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:academic-year-delete', ['only' => ['delete']]);
    }

    /**
     * Show the Academic Year listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        return view('admin.academic_year.list')->with(['academicYearData' => $result]);
    }

    /**
     * Show the add Academic Year page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        return view('admin.academic_year.add');
    }

    /**
     * Show the add Academic Year page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'year' => ['required','unique:academic_years'],
            ],
            [
                'year.required' => 'Please enter academic year.',
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
            $isDefault = 0;
            if(isset($request['is_default']) && $request['is_default'] == "on"){
                AcademicYear::where('is_default',1)->update(['is_default'=>0]);
                $isDefault = 1;
            }
            $academicYear = AcademicYear::create([
                'year' => $request['year'],
                'is_default' => $isDefault
            ]);

            if ($academicYear) {
                $redirect = route('admin.academic_year');
                $arr = array("redirect" => $redirect);
                _json(200, 'Academic year added successfully.', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function edit($id)
    {
        $academicYearData = AcademicYear::where('academic_year_id', $id)->first();
        if ($academicYearData) {
            return view('admin.academic_year.edit')->with(['academicYearData' => $academicYearData]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'year' => ['required'],
            ],
            [
                'year.required' => 'Please enter academic year.',
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
            $isDefault = 0;
            if(isset($request['is_default']) && $request['is_default'] == "on"){
                AcademicYear::where('is_default',1)->update(['is_default'=>0]);
                $isDefault = 1;
            }

            $academicYear = AcademicYear::findOrFail($request->id);
            $academicYear->year = $request['year'];
            $academicYear->is_default = $isDefault;
            $academicYear->save();

            if ($academicYear) {
                $redirect = route('admin.academic_year');
                $arr = array("redirect" => $redirect);
                _json(200, 'Academic year added successfully', $arr);
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
                'academic_year' => ['required'],
            ],
            [
                'academic_year.required' => 'Something went wrong, please try again!.',
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
            $academicYear = AcademicYear::findOrFail($request->academic_year)->delete();
            if ($academicYear) {
                $redirect = route('admin.academic_year');
                $arr = array("redirect" => $redirect);
                _json(200, 'Academic year deleted successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
