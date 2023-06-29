<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\PaidFees;
use App\Exports\PaidAdmissionFeesExport;
use App\Exports\AdmissionFeesExport;
use App\Exports\CollegeFeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Group;
use App\Models\Course;
class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:paid-admission-fees-list', ['only' => ['paidAdmissionFees']]);
        $this->middleware('permission:admission-fees-transactions-list', ['only' => ['admissionFees']]);
        $this->middleware('permission:college-fees-transactions-list', ['only' => ['collegeFees']]);
        $this->middleware('permission:paid-admission-fees-export', ['only' => ['paidAdmissionFeesExport']]);
        $this->middleware('permission:admission-fees-transactions-export', ['only' => ['admissionFeesExport']]);
        $this->middleware('permission:college-fees-transactions-export', ['only' => ['collegeFeesExport']]);
    }

    /**
     * Show the transaction listing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paidAdmissionFees()
    {
        $transactions = Transaction::with('student')->whereHas('student', function ($q) {
            $q->where(['users.is_form_fees_paid' => '1']);
        })->where('payment_type', '1')->orderBy('transaction_id', 'DESC')->get();
        return view('admin.paid_admission_fees')->with(['transactionsData' => $transactions]);
    }

    public function paidAdmissionFeesExport()
    {
        return Excel::download(new PaidAdmissionFeesExport, 'paid-admission-fees.xlsx');
    }
    /**
     * Show the transaction details.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function details($id)
    {
        $transaction = Transaction::where('transaction_id', $id)->firstorfail();
        return view('admin.transactions.details')->with(['transaction' => $transaction]);
    }

    // public function downloadFeeReceipt($id)
    // {
    //     $transaction = Transaction::where('transaction_id', $id)->firstorfail();
    //     $data = [
    //         'transaction' => $transaction
    //     ];
    //     Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
    //     $pdf = PDF::loadView('admin.transactions.fee_receipt', $data);
    //     return $pdf->download('Fee-Receipt.pdf');
    // }

    public function downloadCollegeFeeReceipt($id)
    {
        $feeDetails = PaidFees::with(['transaction', 'student', 'academicYear', 'studentEnrollment'])->where('transaction_id', $id)->firstorfail();
        $data = [
            'feeDetails' => $feeDetails
        ];
        // Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // $pdf = PDF::loadView('admin.transactions.college_fee_receipt', $data);
        // return $pdf->download('College-Fee-Receipt.pdf');
        return view('admin.transactions.college_fee_receipt', $data);
    }


    public function admissionFees(Request $request)
    {
        $transactions = Transaction::with('student')->whereHas('student', function ($q) {
            $q->where(['users.is_form_fees_paid' => '1']);
        })
        ->where('payment_type', '1')
        ->when($request->get('from_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
        })
        ->when($request->get('to_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
        })
        ->orderBy('transaction_id', 'DESC')->get();
        return view('admin.transactions.admission_fees')->with(['transactionsData' => $transactions]);
    }

    public function admissionFeesExport(Request $request)
    {
        $transactions = Transaction::with('student')->whereHas('student', function ($q) {
            $q->where(['users.is_form_fees_paid' => '1']);
        })
        ->where('payment_type', '1')
        ->when($request->get('from_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
        })
        ->when($request->get('to_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
        })
        ->orderBy('transaction_id', 'DESC')->get();
        return Excel::download(new AdmissionFeesExport($transactions), 'Admission_Fees_Export_'.date('d_m_Y_h_i_A').'.xlsx');
    }

    public function collegeFees(Request $request)
    {
        $transactions = Transaction::with('student')->whereHas('paidFees', function ($q) use ($request) {
            $q->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                return $q->where('academic_year_id', $request->get('academic_year_id'));
            })
                ->when($request->get('course_id') !== null, function ($q) use ($request) {
                    return $q->where('course_id', $request->get('course_id'));
                })
                ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                    return $q->where('semester_id', $request->get('semester_id'));
                })
                ->when($request->get('group_id') !== null, function ($q) use ($request) {
                    return $q->where('group_id', $request->get('group_id'));
                });
        })
        ->when($request->get('from_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
        })
        ->when($request->get('to_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
        })
        ->where('payment_type', '2')->orderBy('transaction_id', 'DESC')->get();
        $year = AcademicYear::orderBy('academic_year_id', 'DESC')->get();
        $course = Course::orderBy('course_id', 'ASC')->get();
        $groups = $semesters = [];
        if ($request->get('academic_year_id') !== null && $request->get('course_id') !== null) {
            $semesters = Semester::where('course_id', $request->course_id)->orderBy('semester_id', 'ASC')->get();
        }
        if ($request->get('academic_year_id') !== null && $request->get('course_id') !== null && $request->get('semester_id') !== null) {
            $groups = Group::where('course_id', $request->course_id)->where('semester_id', $request->semester_id)->orderBy('group_id', 'ASC')->get();
        }
        return view('admin.transactions.college_fees')->with(['transactionsData' => $transactions, 'year' => $year, 'course' => $course, 'semesters' => $semesters, 'groups' => $groups]);
    }

    public function collegeFeesExport(Request $request)
    {
        $transactions = Transaction::with('student')->whereHas('paidFees', function ($q) use ($request) {
            $q->when($request->get('academic_year_id') !== null, function ($q) use ($request) {
                return $q->where('academic_year_id', $request->get('academic_year_id'));
            })
            ->when($request->get('course_id') !== null, function ($q) use ($request) {
                return $q->where('course_id', $request->get('course_id'));
            })
            ->when($request->get('semester_id') !== null, function ($q) use ($request) {
                return $q->where('semester_id', $request->get('semester_id'));
            })
            ->when($request->get('group_id') !== null, function ($q) use ($request) {
                return $q->where('group_id', $request->get('group_id'));
            });
        })
        ->when($request->get('from_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','>=', date('y-m-d', strtotime($request->get('from_date'))));
        })
        ->when($request->get('to_date') !== null, function ($q) use ($request) {
            return $q->whereDate('created_at','<=', date('y-m-d', strtotime($request->get('to_date'))));
        })
        ->where('payment_type', '2')->orderBy('transaction_id', 'DESC')->get();
        return Excel::download(new CollegeFeesExport($transactions), 'College_Fees_Export_'.date('d_m_Y_h_i_A').'.xlsx');
    }
}
