<?php

namespace App\Imports;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Group;
use App\Models\Semester;
use App\Models\User;
use App\Models\StudentEnrollment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudentImport implements ToCollection, WithStartRow, WithHeadingRow
{
    
    private $importSelection;

    public function __construct($importSelection)
    {
        $this->importSelection = $importSelection;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(collection $rows)
    {
        return $rows;
        /*foreach ($rows as $row) 
        {
            // dd($this->importSelection);
            $year = $this->importSelection['academic_year'] ?? 0;
            $course = $this->importSelection['course'] ?? 0;
            $semester = $this->importSelection['semester'] ?? 0;
            $group = $this->importSelection['group'] ?? 0;
            // $year = AcademicYear::where('year', $this->importSelection['year'])->first();
            // $course = Course::where('course_name', $this->importSelection['course'])->first();
            // $semester = Semester::where('semester_name', $this->importSelection['semester'])->first();
            // $group = Group::where('group_name', $this->importSelection['group'])->first();
            if (!empty($year) && !empty($course) && !empty($semester) && !empty($group)) {
                // dd(2);
                // $existingStudentData = Student::where('academic_year_id' ,$year->academic_year_id)->where('course_id' ,$course->course_id)->where('semester_id', $semester->semester_id)->where('group_id', $group->group_id)->where('roll_no', $row[4])->count();
                // if (empty($existingStudentData)) {
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
                    $user->markEmailAsVerified();
                    $user->save();
                    // dd($user);
                    if ($user) {
                        // $acedemicYear = AcademicYear::where('is_default', 1)->first();
                        $enrollment = StudentEnrollment::create([
                            'academic_year_id' => $year,
                            'course_id' => $course ?? 0,
                            'semester_id' => $semester ?? 0,
                            'group_id' => $group ?? NULL,
                            'user_id' => $user->id,
                            'roll_no' => $row['roll_no'],
                            'is_fees_paid' => 0
                        ]);
                        // dd($enrollment);
                        $var = "success";
                        // $redirect = route('admin.students');
                        // $arr = array("redirect" => $redirect);
                        // _json(200, 'Student added successfully', $arr);
                    } else {
                        $var = "fail";

                        // _json(201, 'Something went wrong plase try again!');
                    }

                // }
            }
        }
        dd($var);*/
    }
}
