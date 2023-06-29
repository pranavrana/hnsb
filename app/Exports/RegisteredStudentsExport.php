<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RegisteredStudentsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
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
            'Name',
            'Email',
            'Contact No',
            '12th Marksheet No',
            'Current Address',
            'Current City',
            'Current Taluko',
            'Current District',
            'Current Pincode',
            'Form Fees Status'
        ];
    }

    public function collection(){
        return $this->reportData;
    }

    public function map($row): array
    {
        return [
            $row->enrollment[0]->academicYear->year ?? '-',
            $row->enrollment[0]->course->course_name ?? '-',
            $row->enrollment[0]->semester->semester_name ?? '-',
            $row->name,
            $row->email,
            $row->contact_no,
            $row->marksheet_no_12,
            $row->address,
            $row->cur_city,
            $row->cur_taluko,
            $row->cur_district,
            $row->cur_pincode,
            ($row->is_form_fees_paid == 1) ? 'Paid' : 'Not Paid'
            
        ];
    }
    
}