<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EnrollmentsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    private $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function headings(): array
    {
        return [
            'Academic Year',
            'Course',
            'Semester',
            'Group',
            'Gr No',
            'Roll No',
            'Name',
            'Email',
            'Contact No',
            '12th Marksheet No',
            'Current Address',
            'Current City',
            'Current Taluko',
            'Current District',
            'Current Pincode',
            'Permenent Address',
            'Permenent City',
            'Permenent Taluko',
            'Permenent District',
            'Permenent Pincode',
            'Obtained Marks',
            'Passing Month',
            'Passing Year',
            'Exam Center',
            'Leaving Date',
            'Join Date',
            'School Name',
            'Student Sign',
            'Student Photo',
            'Aadhar Card No',
            'Caste',
            'Birth Date',
            'Gender',
            'Fees Status'
        ];
    }

    public function collection(){
        return $this->reportData;
    }

    public function map($row): array
    {
        if($row->user['caste'] == 1):
            $cast = 'General';
        elseif($row->user['caste'] == 2):
            $cast = 'OBC';
        elseif($row->user['caste'] == 3):
            $cast = 'SC';
        else:
            $cast = 'ST';
        endif;
        return [
            $row->academicyear->year ?? '-',
            $row->course->course_name ?? '-',
            $row->semester->semester_name ?? '-',
            $row->group->group_name ?? '-',
            $row->user->gr_no ?? '-',
            $row->roll_no ?? '-',
            $row->user['name'],
            $row->user['email'],
            $row->user['contact_no'],
            $row->user['marksheet_no_12'],
            $row->user['address'],
            $row->user['cur_city'],
            $row->user['cur_taluko'],
            $row->user['cur_district'],
            $row->user['cur_pincode'],
            $row->user['per_address'],
            $row->user['per_city'],
            $row->user['per_taluko'],
            $row->user['per_district'],
            $row->user['per_pincode'],
            $row->user['obtained_marks'],
            $row->user['passing_month'],
            $row->user['passing_year'],
            $row->user['exam_center'],
            $row->user['leaving_date'],
            $row->user['join_date'],
            $row->user['school_name'],
            asset('uploads/student_sign/' . $row->user['student_sign']),
            asset('uploads/student_photo/' . $row->user['student_photo']),
            $row->user['aadhar_card_no'],
            $cast,
            $row->user['birth_date'],
            $row->user['gender'],
            ($row->is_fees_paid == 1) ? 'Paid' : 'Not Paid'
            
        ];
    }
    
}