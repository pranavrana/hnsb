<?php

namespace App\Traits;

use App\Models\AcademicYear;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Group;
use App\Models\Semester;
use App\Models\User;

trait Activitylog
{

    public function setActivityLogColumns($properties, $event, $model = "")
    {
        $newProperties = [];
        $keyColumnArr = [
            "is_default" => "is Default",
            "course_id" => "Course Name",
            "semester_id" => "Semester Name",
            "academic_year_id" => "Academic Year",
            "group_id" => "Group Name",
            "fee_tut" => "Tution Fee",
            "fee_lib" => "Library Fee",
            "fee_sport_gim" => "Sports Games Fee (Gymkhana)",
            "fee_sport_clg" => "Sports Fee (College)",
            'fee_clgexam_stat' => "College Exam Stationary Fee",
            "fee_student_rahat" => "Student Relief Fee",
            "fee_clg_dev" => "College Campus Development Fee",
            "fee_you_fas" => "Youth Festival & Cult Fee",
            "fee_med" => "Medical Fee",
            "fee_hb_rasi" => "Vaccine Fee",
            "fee_union" => "Student Union fee",
            "fee_reg" => " Admission Fee",
            "fee_enroll" => "Enrollment Fee",
            "fee_icard" => "I-card Fee",
            "fee_uniother" => "Uni. Other Fee",
            "fee_theal" => "Thalassemia Testing Fee",
            "fee_lab" => "Laboratory Fee",
            "fee_uni_exam_form" => "Uni. Exam Form Fee",
            "fee_uniexam" => "Uni. Form Fee",
            "fee_comp" => "Computer Fee",
            "fee_ele" => "Ele. Gen. Fee",
            "fee_other" => "Online Computer S/W Fee",
            "scope_exam_fee" => "Scope Exam Fee",
            "fee_late" => "Late Fee",
            'address' => "Current Address",
            'cur_city' => "Current City",
            'cur_taluko' => "Current Taluko",
            'cur_district' => "Current District",
            'cur_pincode' => "Current Pincode",
            'per_address' => "Permanent Address",
            'per_city' => "Permanent City",
            'per_taluko' => "Permanent Taluko",
            'per_district' => "Permanent District",
            'per_pincode' => "Permanent Pincode"

        ];

        if (!empty($properties)) {
            foreach ($properties as $columnKey => $columnValue) {

                if ($columnKey == "is_default") {
                    $columnValue = ($columnValue == 0) ? 'No' : 'Yes';
                }

                if ($columnKey == "status") {
                    $columnValue = ($columnValue == 0) ? 'No' : 'Yes';
                }


                if ($columnKey == "academic_year_id") {
                    $columnValue = AcademicYear::where('academic_year_id', $columnValue)->pluck('year')->first();
                }

                if ($columnKey == "course_id") {
                    $columnValue = Course::where('course_id', $columnValue)->pluck('course_name')->first();
                }

                if ($columnKey == "semester_id") {
                    $columnValue = Semester::where('semester_id', $columnValue)->pluck('semester_name')->first();
                }

                if ($columnKey == "group_id") {
                    $columnValue = Group::where('group_id', $columnValue)->pluck('group_name')->first();
                }

                if ($columnKey == "user_id") {
                    $columnValue = User::where('id', $columnValue)->pluck('name')->first();
                }

                if ($columnKey == "is_fees_paid") {
                    $columnValue = ($columnValue == 0) ? 'No' : 'Yes';
                }

                if ($columnKey == "is_admission_approved") {
                    if ($columnValue == 0) {
                        $columnValue = "Pending";
                    } else if ($columnValue == 1) {
                        $columnValue = "Approved";
                    } else {
                        $columnValue = "Rejected";
                    }
                }

                if ($columnKey == "is_form_fees_paid") {
                    $columnValue = ($columnValue == 0) ? 'No' : 'Yes';
                }

                if ($columnKey == "is_completed_registration") {
                    $columnValue = ($columnValue == 0) ? 'Pending' : 'Completed';
                }

                if ($columnKey == "is_initial_college_fees_paid") {
                    if ($columnValue == 0) {
                        $columnValue = "Pending";
                    } else if ($columnValue == 1) {
                        $columnValue = "Paid";
                    } else {
                        $columnValue = "Cut Off Time Over";
                    }
                }

                if ($columnKey == "admission_processed_by") {
                    $columnValue = Admin::where('admin_id', $columnValue)->pluck('name')->first();
                }


                if (array_key_exists($columnKey, $keyColumnArr)) {
                    $newProperties[$keyColumnArr[$columnKey]] = $columnValue;
                } else {
                    $newProperties[ucwords(str_replace("_", " ", $columnKey))] = $columnValue;
                }
            }
        }
        # code...
        return $newProperties;
    }
}
