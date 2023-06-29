<?php

namespace App\Exports;

use App\Models\StudentEnrollment;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdmissionRequestsExport implements FromCollection, WithMapping, WithHeadings
{

    private $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'Email',
            'Contact No.',
            '12th Marksheet No.',
            'Paasing Year',
            'Exam center',
            'School Name',
            'Course',
            'Semester',
            'Group',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $request = $this->reportData;
        return User::where(['is_admission_approved' => 0, 'is_completed_registration' => 1])
        ->whereHas('enrollment', function ($q) use ($request) {
            $q->when((isset($request['from_date']) && !empty($request['from_date'])), function ($q) use ($request) {
                return $q->whereDate('updated_at','>=', date('y-m-d', strtotime($request['from_date'])));
            })
            ->when((isset($request['to_date']) && !empty($request['to_date'])), function ($q) use ($request) {
                return $q->whereDate('updated_at','<=', date('y-m-d', strtotime($request['to_date'])));
            });
        })
        ->orderBy('obtained_marks', 'DESC')->get();
        // return User::where(['is_admission_approved' => 0, 'is_completed_registration' => 1])->orderBy('obtained_marks', 'DESC')->get();
        // return User::where('is_admission_approved', 0)->orderBy('id','DESC')->get();
    }

    public function map($row): array
    {
        
        $enrollmentData = StudentEnrollment::where('user_id', $row->id)->where('is_fees_paid', 0)->where('is_cancelled', 0)->first();
        return [
            $row->name,
            $row->email,
            $row->contact_no,
            $row->marksheet_no_12,
            $row->passing_year,
            $row->exam_center,
            $row->school_name,
            $enrollmentData->course->course_name ?? '',
            $enrollmentData->semester->semester_name ?? '',
            $enrollmentData->group->group_name,
        ];
    }
}
