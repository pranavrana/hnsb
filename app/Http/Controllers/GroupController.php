<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{

    

    /**
     * Get group by semester id.
     *
     * @param \Illuminate\Http\Request
     * @return json
     */
    public function getGroupBySemesterID(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'CourseID' => ['required'],
                'SemesterID' => ['required'],
            ],
            [
                'CourseID.required' => "Please Select Course",
                'SemesterID.required' => "Please Select Semester",
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
            $result = Group::where('course_id', $request->CourseID)->where('semester_id', $request->SemesterID)->orderBy('group_id', 'ASC')->get();
            // $result = Group::orderBy('group_id', 'ASC')->get();
            _json(200, '', $result);
        }
    }
}
