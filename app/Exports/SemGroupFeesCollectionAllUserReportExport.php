<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SemGroupFeesCollectionAllUserReportExport implements FromCollection, WithMapping, WithHeadings
{
    private $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function headings(): array
    {
        return [
            'Gender',
            'Total Nos.',
            'Tuition Fee ',
            'Library Fee',
            'Sports Games Fee(Gymkhana)',
            'Sports Fee(College)',
            'College Exam Stationary Fee',
            'Student Relief Fee',
            'College Campus Development Fee',
            'Youth Festival & Cult.Fee',
            'Medical Fee',
            'Hepatitis B Vaccine  Fee',
            'Student Union Fee',
            'Admission Fee',
            'Enrolment Fee',
            'I-Card Fee',
            'Uni.Other Fee',
            'Thalassemia Testing Fee',
            'Laboratory Fee',
            'Uni.Exam Form Fee',
            'Uni.Exam Fee',
            'Computer Fee',
            'Ele.Gen.Fee',
            'Other Fee',
            'Late Fee',
            'Total Fee',
        ];
    }

    public function collection(){
        return $this->reportData;
    }

    public function map($row): array
    {
        return [
            $row->gender,
            $row->total,
            $row->total_fee_tut,
            $row->total_fee_lib,
            $row->total_fee_sport_gim,
            $row->total_fee_sport_clg,
            $row->total_fee_clgexam_stat,
            $row->total_fee_student_rahat,
            $row->total_fee_clg_dev,
            $row->total_fee_you_fas,
            $row->total_fee_med,
            $row->total_fee_hb_rasi,
            $row->total_fee_union,
            $row->total_fee_reg,
            $row->total_fee_enroll,
            $row->total_fee_icard,
            $row->total_fee_uniother,
            $row->total_fee_theal,
            $row->total_fee_lab,
            $row->total_fee_uni_exam_form,
            $row->total_fee_uniexam,
            $row->total_fee_comp,
            $row->total_fee_ele,
            $row->total_fee_other,
            $row->total_fee_late,
            $row->total_total_fee,
        ];
    }
    
}