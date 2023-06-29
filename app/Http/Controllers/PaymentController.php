<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFee;
use App\Models\FeesMaster;
use App\Models\Group;
use App\Models\PaidFees;
use App\Models\StudentEnrollment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PaytmWallet;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Process admission fees payment.
     *
     * @param \Illuminate\Http\Request
     * @return object $payment
     */
    public function payAdmissionFees(Request $request)
    {
        $enrollmentDetails = StudentEnrollment::where('user_id', \Auth::guard('web')->user()->id)->firstOrFail();
        $admissionFee = AdmissionFee::where('academic_year_id', $enrollmentDetails->academic_year_id)->where('course_id', $enrollmentDetails->course_id)->where('semester_id', $enrollmentDetails->semester_id)->first();
        $admissionCutOffDate = $admissionFee->cutoff_date ?? '';
        $admissionFees = $admissionFee->admission_fees ?? 0;
        // $admissionFees = getGeneralSettingByKey('admissionfees');
        $admissionFees = calculatePaymentAmount($admissionFees);
        if (empty($admissionFees)) {
            return redirect()->route('home')->with('error', 'Admission fees not configured!');
        }
        // $admissionCutOffDate = getGeneralSettingByKey('admissioncutoffdate');
        if (empty($admissionCutOffDate)) {
            return redirect()->route('home')->with('error', 'Admission cut off date fees not configured. Please contact college!');
        } else if ((\Carbon\Carbon::parse($admissionCutOffDate)  >= \Carbon\Carbon::now()) === false) {
            return redirect()->route('home')->with('error', 'Admission cut off date is over!');
        }
        $user = User::where('id', \Auth::id())->first();
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order' => "ADMF_".$user->id."_".rand(),
            'user' => $user->id,
            'mobile_number' => $user->contact_no,
            'email' => $user->email,
            'amount' => $admissionFees,
            'callback_url' => route('callbackAdmissionFees'),
        ]);
        return $payment->receive();
    }

    /**
     * Handle admission fees payment callback.
     *
     * @return void
     */
    public function callbackAdmissionFees()
    {
        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        $user = User::where('id', \Auth::id())->first();
        $existingTransaction = Transaction::where('user_id', \Auth::id())->where('order_id', $response['ORDERID'])->where('txn_id', $response['TXNID'])->first();
        if (empty($existingTransaction)) {
            $transactionData = Transaction::create([
                'user_id' => \Auth::id(),
                'order_id' => $response['ORDERID'] ?? null,
                'email' => $response['email'] ?? $user->email,
                'contact_no' => $response['contact_no'] ?? $user->contact_no,
                'amount' => $response['amount'] ?? 0,
                'txn_id' => $response['TXNID'] ?? null,
                'txn_amount' => $response['TXNAMOUNT'] ?? null,
                'txn_date' => $response['TXNDATE'] ?? null,
                'txn_payment_mode' => $response['PAYMENTMODE'] ?? null,
                'txn_bank_txn_id' => $response['BANKTXNID'] ?? null,
                'txn_status' => $response['STATUS'] ?? null,
                'txn_response_code' => $response['RESPCODE'] ?? null,
                'txn_response_msg' => $response['RESPMSG'] ?? null,
                'response' => $response ?? null,
            ]);
        }
        if ($transaction->isSuccessful()) {
            //Transaction Successful
            User::where('id', \Auth::id())->update([
                'is_form_fees_paid' => 1
            ]);
            return redirect()->route('home')->with('success', 'Payment success!');
        } else if ($transaction->isFailed()) {
            //Transaction Failed
            return redirect()->route('home')->with('error', 'Payment Failed:' . $response['RESPMSG']);
        } else if ($transaction->isOpen()) {
            //Transaction Open/Processing
            return redirect()->route('home')->with('error', 'Payment in Process:' . $response['RESPMSG']);
        }
        // $transaction->getResponseMessage(); //Get Response Message If Available
        // //get important parameters via public methods
        // $transaction->getOrderId(); // Get order id
        // $transaction->getTransactionId(); // Get transaction id
    }

    /**
     * Show the transaction listing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function transactions()
    {
        $transactions = Transaction::where('user_id', \Auth::id())->orderBy('transaction_id', 'DESC')->get();
        return view('transactions')->with(['transactions' => $transactions]);
    }

    /**
     * Show the transaction details.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function details($id)
    {
        $transaction = Transaction::where('user_id', \Auth::id())->where('transaction_id', $id)->firstorfail();
        return view('transaction_details')->with(['transaction' => $transaction]);
    }

    /**
     * Process college fees payment.
     *
     * @param \Illuminate\Http\Request
     * @return object $payment
     */
    public function payCollegeFees(Request $request)
    {
        $studentDetails = StudentEnrollment::where('user_id', \Auth::id())->latest('enrollment_id')->first();
        if (!empty($studentDetails)) {
            $feesDetails = FeesMaster::where('academic_year_id', $studentDetails->academic_year_id)->where('course_id', $studentDetails->course_id)->where('semester_id', $studentDetails->semester_id)->where('group_id', $studentDetails->group_id)->where('gender', $studentDetails->user->gender)->first();

            if (!empty($feesDetails)) {
                if (!isset($feesDetails->total_fee) && empty($feesDetails->total_fee)) {
                    return redirect()->route('home')->with('error', 'College fees not configured!');
                }
                $lateFees = $feesDetails->fee_late;
                $fees = $feesDetails->total_fee;
                $lateFeesPaid = 0;
                // $collegeFeesCutOffDate = getGeneralSettingByKey('collegefeescutoffdate');
                $collegeFeesCutOffDate = $feesDetails->cutoff_date ?? '';
                // $cutOffExtentionDate = getGeneralSettingByKey('collegefeescutoffextentiondate', true);
                $cutOffExtentionDate = $feesDetails->cutoff_extension_date ?? '';

                if (empty($collegeFeesCutOffDate)) {
                    return redirect()->route('home')->with('error', 'College fees cut off date not configured. Please contact college!');
                } else if ((\Carbon\Carbon::parse($collegeFeesCutOffDate)  >= \Carbon\Carbon::now()) === false) {
                    if (!empty($cutOffExtentionDate) && $feesDetails->cutoff_extension_status == 1 && \Carbon\Carbon::parse($cutOffExtentionDate)  >= \Carbon\Carbon::now()) {
                        $fees = $fees + $lateFees;
                        $lateFeesPaid = 1;
                    } else {
                        return redirect()->route('home')->with('error', 'Collage fees payment cut off date is over!');
                    }
                }
                Session::put('feesMaster', $feesDetails);
                Session::put('studentDetails', $studentDetails);
                Session::put('fees', $fees);
                Session::put('lateFeesPaid', $lateFeesPaid);
                $fees = calculatePaymentAmount($fees);
                $user = User::where('id', \Auth::id())->first();
                $payment = PaytmWallet::with('receive');
                $payment->prepare([
                    'order' => "CLGF_".$user->id."_".rand(),
                    'user' => $user->id,
                    'mobile_number' => $user->contact_no,
                    'email' => $user->email,
                    'amount' => $fees,
                    'callback_url' => route('callbackCollegeFees'),
                ]);
                return $payment->receive();
            } else {
                return redirect()->route('home')->with('error', 'Something went wrong!');
            }
        } else {
            return redirect()->route('home')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Handle college fees payment callback.
     *
     * @return void
     */
    public function callbackCollegeFees()
    {
        if (Session::has('feesMaster')) {
            DB::beginTransaction();
            try {

                $user = User::where('id', \Auth::id())->first();
                $studentDetails = Session::get('studentDetails');
                if (!empty($studentDetails)) {
                    $feesDetails = Session::get('feesMaster');
                }
                $fees = Session::get('fees');
                $transaction = PaytmWallet::with('receive');

                $response = $transaction->response(); // To get raw response as array
                $existingTransaction = Transaction::where('user_id', $user->id)->where('order_id', $response['ORDERID'])->where('txn_id', $response['TXNID'])->first();
                if (empty($existingTransaction)) {
                    //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
                    $transactionData = Transaction::create([
                        'user_id' => $user->id,
                        'order_id' => $response['ORDERID'] ?? null,
                        'payment_type' => 2,
                        'email' => $response['email'] ?? $user->email,
                        'contact_no' => $response['contact_no'] ?? $user->contact_no,
                        'amount' => $fees ?? 0,
                        'txn_id' => $response['TXNID'] ?? null,
                        'txn_amount' => $response['TXNAMOUNT'] ?? null,
                        'txn_date' => $response['TXNDATE'] ?? null,
                        'txn_payment_mode' => $response['PAYMENTMODE'] ?? null,
                        'txn_bank_txn_id' => $response['BANKTXNID'] ?? null,
                        'txn_status' => $response['STATUS'] ?? null,
                        'txn_response_code' => $response['RESPCODE'] ?? null,
                        'txn_response_msg' => $response['RESPMSG'] ?? null,
                        'response' => $response ?? null,
                    ]);
                }
                if ($transaction->isSuccessful()) {
                    //Transaction Successful
                    $group = Str::upper(substr($studentDetails->group->group_name, 0, 2));
                    $year = $year = date("y", strtotime('-1 year'));;
                    if (date("m") >= 05) {
                        $year = date("y", strtotime('+1 year'));
                    }
                    $gr_no = $group . $year . sprintf("%'.05d\n", \Auth::id());

                    User::where('id', $user->id)->update([
                        'is_initial_college_fees_paid' => 1,
                        'gr_no' => $gr_no
                    ]);
                    $fees = $feesDetails->replicate();
                    $paidFeesArray = $fees->toArray();
                    $paidFeesArray['user_id'] = $user->id;
                    $paidFeesArray['enrollment_id'] = $studentDetails->enrollment_id;
                    $paidFeesArray['transaction_id'] = $transactionData->transaction_id;
                    $paidFeesArray['is_late_fees_paid'] = Session::get('lateFeesPaid');
                    unset($paidFeesArray['created_at'], $paidFeesArray['updated_at'], $paidFeesArray['deleted_at']);
                    PaidFees::create($paidFeesArray);
                    $enrolledStudents = StudentEnrollment::where('academic_year_id', $studentDetails->academic_year_id)->where('course_id', $studentDetails->course_id)->where('semester_id', $studentDetails->semester_id)->where('group_id', $studentDetails->group_id)->where('is_fees_paid', 1)->count();
                    $group = Group::where('group_id', $studentDetails->group_id)->first();
                    $rollNo = $enrolledStudents + 1;
                    if(!empty($group) && isset($group->range_for_roll_no) && !empty($group->range_for_roll_no)) {
                        $rollNo = ($group->range_for_roll_no + ($enrolledStudents + 1)); 
                    }
                    $studentDetails->roll_no = $rollNo;
                    $studentDetails->is_fees_paid = 1;
                    $studentDetails->save();
                    $type = 'success';
                    $message = 'Payment success!';
                } else if ($transaction->isFailed()) {
                    //Transaction Failed
                    // return redirect()->route('home')->with('error', 'Payment Failed:' . $response['RESPMSG']);
                    $type = 'error';
                    $message = 'Payment Failed:' . $response['RESPMSG'];
                } else if ($transaction->isOpen()) {
                    //Transaction Open/Processing
                    // return redirect()->route('home')->with('error', 'Payment in Process:' . $response['RESPMSG']);
                    $type = 'error';
                    $message = 'Payment in Process:' . $response['RESPMSG'];
                }
                DB::commit();
                return redirect()->route('home')->with($type, $message);
            } catch (\Exception $e) {
                DB::rollback();
                // dd($e);
                return redirect()->route('home')->with('error', 'Something went wrong please try again!');

                // something went wrong
            }
        } else {
            return redirect()->route('home')->with('error', 'Something went wrong please try again!');
        }

        // $transaction->getResponseMessage(); //Get Response Message If Available
        // //get important parameters via public methods
        // $transaction->getOrderId(); // Get order id
        // $transaction->getTransactionId(); // Get transaction id
    }

    public function downloadCollegeFeeReceipt($id)
    {
        $feeDetails = PaidFees::with(['transaction', 'student', 'academicYear', 'studentEnrollment'])->where(['user_id' => \Auth::id(), 'transaction_id' => $id])->firstorfail();
        $data = [
            'feeDetails' => $feeDetails
        ];
        // Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // $pdf = PDF::loadView('college_fee_receipt', $data);
        // return $pdf->download('College-Fee-Receipt.pdf');
        return view('college_fee_receipt', $data);
    }
}
