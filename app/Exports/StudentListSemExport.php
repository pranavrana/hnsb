<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentListSemExport implements FromCollection, WithMapping, WithHeadings
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
            'Gender',
            'Name',
            'Caste',
            'Admission No.',
            'GR No',
        ];
    }

    public function collection(){
        return $this->reportData;
    }

    public function map($row): array
    {
        if($row->caste == 1):
        $caste = 'General';
        elseif($row->caste == 2):
        $caste = 'OBC';
        elseif($row->caste == 3):
        $caste = 'SC';
        else:
        $caste = 'ST';
        endif;
        return [
            $row->enrollment()->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id'), 'group_id' => request()->get('group_id')])->first()->roll_no ?? "",
            $row->gender,
            $row->name,
            $caste,
            $row->admission_no,
            $row->gr_no,
        ];
    }
    
}