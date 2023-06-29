<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CollegeFeesExport implements FromCollection, WithMapping, WithHeadings
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
            'Sem',
            'Group',
            'Student Name',
            'Roll No.',
            'Email',
            'Contact No.',
            'Address',
            'Fees Paid Date',
            'Status',
            'Transaction ID',
            'Bank Transaction ID',
            'Transaction Amount',
            'Payment Mode',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Transaction::with('student')->where('payment_type', '2')->orderBy('transaction_id','DESC')->get();
        return $this->reportData;
    }

    public function map($row): array
    {
        return [
            $row->paidFees->academicYear->year ?? "",
            $row->paidFees->course->course_name ?? "",
            $row->paidFees->semester->semester_name ?? "",
            $row->paidFees->group->group_name ?? "",
            $row->student->name,
            $row->paidFees->studentEnrollment->roll_no ?? "",
            $row->student->email,
            $row->student->contact_no,
            $row->student->address,
            $row->txn_date,
            $row->txn_status,
            $row->txn_id,
            $row->txn_bank_txn_id,
            $row->txn_amount,
            $row->txn_payment_mode
        ];
    }
}
