<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Group;
use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentAcademaicYear = date("Y") .'-'. date("y", strtotime('+1 year')); 
        $academicYear = AcademicYear::create([
            'year' => $currentAcademaicYear,
            'is_default' => 1,
        ]);

        $course1 = Course::create([
            'course_name' => 'B.Sc'
        ]);
        $semestersdata = [
            [
                'course_id' => $course1->course_id,
                'semester_name' => 'Sem 1'
            ],
            [
                'course_id' => $course1->course_id,
                'semester_name' => 'Sem 2'
            ],
            [
                'course_id' => $course1->course_id,
                'semester_name' => 'Sem 3'
            ],
            [
                'course_id' => $course1->course_id,
                'semester_name' => 'Sem 4'
            ],
            [
                'course_id' => $course1->course_id,
                'semester_name' => 'Sem 5'
            ],
            [
                'course_id' => $course1->course_id,
                'semester_name' => 'Sem 6'
            ]
            ];
            foreach ($semestersdata as $semester) {
                $insertedSemester = Semester::create($semester);
                $insertedSemester->semester_id;
            }
        $course2 = Course::create([
            'course_name' => 'M.Sc'
        ]);
        $semestersdata = [
            [
                'course_id' => $course2->course_id,
                'semester_name' => 'Sem 1'
            ],
            [
                'course_id' => $course2->course_id,
                'semester_name' => 'Sem 2'
            ],
            [
                'course_id' => $course2->course_id,
                'semester_name' => 'Sem 3'
            ],
            [
                'course_id' => $course2->course_id,
                'semester_name' => 'Sem 4'
            ],
            [
                'course_id' => $course2->course_id,
                'semester_name' => 'Sem 5'
            ],
            [
                'course_id' => $course2->course_id,
                'semester_name' => 'Sem 6'
            ]
            ];
            foreach ($semestersdata as $semester) {
                $insertedSemester = Semester::create($semester);
                $insertedSemester->semester_id;
            }
    }
}
