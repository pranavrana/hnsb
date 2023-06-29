<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaidAdmissionFeesExport implements FromCollection, WithMapping, WithHeadings
{

    public function headings(): array
    {
        return [
            'Student Name',
            'Email',
            'Contact No.',
            '12th Marksheet No.',
            'Address',
            'Fees Paid Date',
            'Status',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::with('student')->whereHas('student', function($q){
            $q->where(['users.is_form_fees_paid' => '1','users.is_completed_registration' => '0']);
        })->where('payment_type', '1')->orderBy('transaction_id','DESC')->get();
    }

    public function map($row): array
    {
        return [
            $row->student->name,
            $row->student->email,
            $row->student->contact_no,
            $row->student->marksheet_no_12,
            $row->student->address,
            $row->txn_date,
            $row->txn_status,
        ];
    }
}
