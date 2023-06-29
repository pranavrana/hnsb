<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
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
                'CourseID.required' => "Please Select Course",
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
            $result = Semester::where('course_id', $request->CourseID)->orderBy('semester_id', 'ASC')->get();
            _json(200, '', $result
        );
        }
    }
}
