<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionFee;
use App\Models\Course;
use App\Models\FeesMaster;
use App\Models\Group;
use App\Models\PaidFees;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:group-list|group-create|group-edit|group-delete', ['only' => ['index']]);
        $this->middleware('permission:group-create', ['only' => ['add','insert']]);
        $this->middleware('permission:group-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:group-delete', ['only' => ['delete']]);
    }


    /**
     * Show the Group listing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = Group::orderBy('group_id', 'DESC')->get();
        return view('admin.group.list')->with(['groupData' => $result]);
    }

    /**
     * Show the add Group page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        $course = Course::get();
        return view('admin.group.add')->with(['courseData' => $course]);
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
                'group_name' => ['required'],
            ],
            [
                'group_name.required' => 'Please enter group name.',
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
            $existingGroupData = Group::where('course_id', $request['course_id'])->where('semester_id', $request['semester_id'])->where('group_name', $request['group_name'])->count();
            if(!empty($existingGroupData) && $existingGroupData > 0) {
                _json(201, 'The group name has already been taken.');
            }
            $group = Group::create([
                'course_id' => $request['course_id'],
                'semester_id' => $request['semester_id'],
                'group_name' => $request['group_name'],
                'range_for_roll_no' => $request['range_for_roll_no'],
                'combination_code' => $request['combination_code'],
            ]);

            if ($group) {
                $redirect = route('admin.group');
                $arr = array("redirect" => $redirect);
                _json(200, 'Group added successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }

    public function edit($id)
    {
        $course = Course::get();
        $groupData = Group::where('group_id', $id)->first();
        if ($groupData) {
            return view('admin.group.edit')->with(['groupData' => $groupData,'courseData' => $course]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'group_name' => ['required'],
            ],
            [
                'group_name.required' => 'Please enter group name.',
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
            $existingGroupData = Group::where('group_id','!=' ,$request->id)->where('course_id', $request['course_id'])->where('semester_id', $request['semester_id'])->where('group_name', $request['group_name'])->count();
            if(!empty($existingGroupData) && $existingGroupData > 0) {
                _json(201, 'The group name has already been taken.');
            }
            $group = Group::findOrFail($request->id);
            $group->group_name = $request['group_name'];
            $group->semester_id = $request['semester_id'];
            $group->group_name = $request['group_name'];
            $group->range_for_roll_no = $request['range_for_roll_no'];
            $group->combination_code = $request['combination_code'];
            $group->save();
           

            if ($group) {
                $redirect = route('admin.group');
                $arr = array("redirect" => $redirect);
                _json(200, 'Group name added successfully', $arr);
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
                'group' => ['required'],
            ],
            [
                'group.required' => 'Something went wrong, please try again!.',
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
            $group = Group::where("group_id", $request->group)->delete();
            if ($group) {
                StudentEnrollment::where("group_id", $request->group)->delete();
                FeesMaster::where("group_id", $request->group)->delete();
                PaidFees::where("group_id", $request->group)->delete();
                $redirect = route('admin.group');
                $arr = array("redirect" => $redirect);
                _json(200, 'Group deleted successfully', $arr);
            } else {
                _json(201, 'Something went wrong plase try again!');
            }
        }
    }
}
