<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentListEnrolmentExport implements FromCollection, WithMapping, WithHeadings
{
    private $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function headings(): array
    {
        return [
            'Roll No',
            'Surname',
            'Student Name',
            'Father Name',
            'Degree',
            'Combination Code',
            'Student Address',
            'State',
            'District',
            'Taluka',
            'City',
            'Nationality',
            'Date of Birth',
            'Gender',
            'Caste',
            '12th Passing Year',
            '12th Passing Month',
            '12th Exam Seat No.',
            'College Code',
            'Exam Name',
            'Obtain Marks',
            'Total Marks',
            'Semester',
            'Phone No.',
            'Email',
            'HSC Exam Centre',
            'HSC School Name',
            'School Joining Date',
            'School Leaving Date',
        ];
    }

    public function collection(){
        return $this->reportData;
    }

    public function map($row): array
    {
        return [
            $row->enrollment()->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id'), 'group_id' => request()->get('group_id')])->first()->roll_no ?? "",
            $row->surname,
            $row->student_name,
            $row->father_name,
            $row->enrollment()->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id'), 'group_id' => request()->get('group_id')])->first()->course->course_name ?? "",
            $row->combination_code,
            $row->address,
            $row->cur_state,
            $row->cur_district,
            $row->cur_taluko,
            $row->cur_city,
            $row->nationality,
            $row->birth_date,
            $row->gender,
            $row->caste,
            $row->passing_year,
            $row->passing_month,
            $row->marksheet_no_12,
            $row->college_code,
            $row->exam_name,
            $row->obtained_marks,
            $row->total_marks,
            $row->enrollment()->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id'), 'group_id' => request()->get('group_id')])->first()->semester->semester_name,
            $row->contact_no,
            $row->email,
            $row->exam_center,
            $row->school_name,
            $row->join_date,
            $row->leaving_date,
        ];
    }
    
}