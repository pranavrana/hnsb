<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Transaction;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('payment-notification', '\App\Http\Controllers\HomeController@paymentNotification')->name('paymentNotification');
Route::post('refund-notification', function() {
	$json = file_get_contents('php://input');
	\Log::info([$json]);
	$data = $_REQUEST;
	\Log::info([$data]);
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('privacy-policy', '\App\Http\Controllers\HomeController@privacyPolicy')->name('privacyPolicy');
Route::get('terms-and-condions', '\App\Http\Controllers\HomeController@termsAndConditions')->name('termsAndConditions');
Route::get('about-us', '\App\Http\Controllers\HomeController@aboutUs')->name('aboutUs');
Route::get('contact-us', '\App\Http\Controllers\HomeController@contactUs')->name('contactUs');
Route::post('submit-contact', '\App\Http\Controllers\HomeController@submitContact')->name('submitContact');
Route::get('temp-pay', function() {
	$payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order' => "TEST_ADM_01_".rand(),
            'user' => 01,
            'mobile_number' => '9724733119',
            'email' => 'priyankpatel.dev@gmail.com',
            'amount' => '10',
			'callback_url' => route('callbackAdmissionFees')
        ]);
        return $payment->receive();
		// \Log::info($var);
		// dd($var);
});
Route::get('check-status', function() {
	// $refundAmt = '10.24';
	// $refund = PaytmWallet::with('refund');
	// $refund->prepare([
	// 	'order' => '459979962',
	// 	'reference' => '459979962' . "Full refund", // provide refund reference for your future reference (should be unique for each order)
	// 	'amount' => $refundAmt, // refund amount 
	// 	'transaction' => '20230518010990000866106032009533457' // provide paytm transaction id referring to this order 
	// ]);
	// $refund->initiate();
	// $refResponse = $refund->response(); // To get raw response as array
	// Transaction::where('transaction_id', 5)->update([
	// 		'ref_amount' => $refundAmt,
	// 		'ref_type' => 'Charges Refund For UPI',
	// 		'ref_response' => $refResponse,
	// 	]);
	// 	\Log::info([$refResponse]);
	// 	dd($refResponse);
	// 	// dd($refund);
	strtolower('Absc');
});

Route::get('ref-status', function() {
	dd(strtolower('Absc@GmAil.com'));
$refundStatus = PaytmWallet::with('refund_status');
$refundStatus->prepare([
	'order' => '459979962',
	'reference' => "459979962Full refund", // provide reference number (the same which you have entered for initiating refund)
]);
$refundStatus->check();

$response = $refundStatus->response(); // To get raw response as array
		\Log::info([$response]);
		dd($response);

});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/get-semesters', 'App\Http\Controllers\SemesterController@getSemesterByCourseID');
Route::post('/get-groups', 'App\Http\Controllers\GroupController@getGroupBySemesterID');
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/admission', [App\Http\Controllers\HomeController::class, 'admission'])->name('admission');
Route::post('/pay-admission-fees', [App\Http\Controllers\PaymentController::class, 'payAdmissionFees'])->name('payAdmissionFees');
Route::post('/callback-admission-fees', [App\Http\Controllers\PaymentController::class, 'callbackAdmissionFees'])->name('callbackAdmissionFees');	
Route::get('/transactions', [App\Http\Controllers\PaymentController::class, 'transactions'])->name('transactions');
Route::get('/transactions/details/{id}', [App\Http\Controllers\PaymentController::class, 'details'])->name('transaction_details');
Route::post('/pay-college-fees', [App\Http\Controllers\PaymentController::class, 'payCollegeFees'])->name('payCollegeFees');
Route::post('/callback-college-fees', [App\Http\Controllers\PaymentController::class, 'callbackCollegeFees'])->name('callbackCollegeFees');

//College fee receipt
Route::get('/download-college-fee-receipt/{id}', [App\Http\Controllers\PaymentController::class, 'downloadCollegeFeeReceipt'])->name('download_college_fee_receipt');

//Studnet my account routes
Route::get('account', [App\Http\Controllers\StudentController::class, 'editProfile'])->name('account');
Route::post('/update-account', [App\Http\Controllers\StudentController::class, 'updateProfile'])->name('account_update');
Route::post('/change-password', [App\Http\Controllers\StudentController::class, 'changePassword'])->name('change_password');

Route::namespace("App\Http\Controllers\Admin")->prefix('admin')->name('admin.')->group(function () {
	Route::namespace('Auth')->group(function () {
		Route::get('/login', 'LoginController@index')->name('login');
		Route::post('/login', 'LoginController@login')->name('postlogin');
		Route::get('logout', 'LoginController@logout')->name('logout');
	});
	Route::get('account', 'AdminController@editProfile')->name('account');
	Route::post('/update-account', 'AdminController@updateProfile')->name('account_update');
	Route::post('/change-password', 'AdminController@changePassword')->name('change_password');
	
	Route::get('/', 'DashboardController@dashboard')->name('dashboard');

	Route::get('/students', 'StudentController@index')->name('students');
	Route::get('/registed-students', 'StudentController@registedStudents')->name('registed_students');
	Route::get('/registered-students-export', 'StudentController@registeredStudentsExport')->name('registered_students_export');
	Route::get('/manual-admission-fees/{id}', 'StudentController@manualAdmissionFees')->name('manual_admission_fees');
	Route::get('/admission-form/{id}', 'StudentController@admissionForm')->name('admission_form');
	Route::post('/manual-admission', 'StudentController@manualAdmission')->name('manual_admission');
	Route::get('/manual-college-fees/{id}', 'StudentController@manualCollegeFees')->name('manual_college_fees');
	Route::post('/collect-admission-fees', 'StudentController@collectAdmissionFees')->name('collect_admission_fees');
	Route::post('/collect-college-fees', 'StudentController@collectCollegeFees')->name('collect_college_fees');
	Route::get('/student/{id}', 'StudentController@viewStudentDetails')->name('student_details');
	Route::get('/add-student', 'StudentController@add')->name('student_add');
	Route::post('/insert-student', 'StudentController@insert')->name('student_insert');
	Route::get('/edit-student/{id}', 'StudentController@edit')->name('student_edit');
	Route::post('/update-student', 'StudentController@update')->name('student_update');
	Route::get('/admission-requests', 'StudentController@admissionRequests')->name('admission_requests');
	Route::get('/admission-requests-view/{id}', 'StudentController@viewAdmissionRequest')->name('admission_request_view');
	Route::get('/admission-requests-export', 'StudentController@admissionRequestsExport')->name('admission_requests_export');
	Route::post('/approve-admission', 'StudentController@approveAdmission')->name('approve_admission');
	Route::post('/reject-admission', 'StudentController@rejectAdmission')->name('reject_admission');
	Route::get('/enrollments', 'StudentController@enrollments')->name('enrollments');
	Route::get('/enrollments_export', 'StudentController@enrollmentsExport')->name('enrollment_export');
	Route::post('/generate-id', 'StudentController@generateId')->name('generate_id');
	Route::post('/cancel-admission', 'StudentController@cancelAdmission')->name('cancel_admission');
	Route::get('/cancelled-students', 'StudentController@cancelledStudents')->name('cancelled_students');
	Route::get('/enrollment-details/{id}', 'StudentController@enrollmentDetails')->name('enrollment_details');
	Route::get('/enrollment-edit/{id}', 'StudentController@enrollmentEdit')->name('enrollment_edit');
	Route::post('/enrollment-update', 'StudentController@enrollmentUpdate')->name('enrollment_update');
	Route::get('/transfer-students', 'StudentController@transferStudents')->name('transfer_students');	
	Route::post('/transfer', 'StudentController@transfer')->name('transfer');	
	Route::get('/reset-student-login-credentials/{id}', 'StudentController@resetStudentLoginCredentials')->name('resetStudentLoginCredentials');
	Route::post('/credentials-reset', 'StudentController@credentialsReset')->name('credentialsReset');	
	Route::get('/download-files', 'StudentController@downloadEnrolledStudentsFiles')->name('downloadEnrolledStudentsFiles');
	Route::get('/edit-admission-request/{id}', 'StudentController@editAdmissionRequest')->name('editAdmissionRequest');
	Route::post('/edit-admission-request-data', 'StudentController@editAdmissionRequestData')->name('editAdmissionRequestData');
	Route::get('/admission-rejected', function () {
		$user = App\Models\User::find(3);
		return new App\Mail\AdmissionRejected($user);
	});
	Route::get('/admission-approved', function () {
		$user = App\Models\User::find(2);
		return new App\Mail\AdmissionApproved($user);
	});
	Route::get('/rejected-admissions', 'StudentController@rejectedAdmissions')->name('rejected_admissions');
	Route::get('/rejected-admission-view/{id}', 'StudentController@viewRejectedAdmission')->name('rejected_admission_view');
	Route::get('/import', 'StudentController@import')->name('import');
	Route::post('/student-import', 'StudentController@studentImport')->name('studentImport');

	Route::get('/academic-year', 'AcademicYearController@index')->name('academic_year');
	Route::get('/add-academic-year', 'AcademicYearController@add')->name('academic_year_add');
	Route::post('/insert-academic-year', 'AcademicYearController@insert')->name('academic_year_insert');
	Route::get('/edit-academic-year/{id}', 'AcademicYearController@edit')->name('academic_year_edit');
	Route::post('/update-academic-year', 'AcademicYearController@update')->name('academic_year_update');
	Route::post('/delete-academic-year', 'AcademicYearController@delete')->name('academic_year_delete');

	Route::get('/activity-log', 'ActivityLogController@index')->name('activity_log');

	Route::get('/course', 'CourseController@index')->name('course');
	Route::get('/add-course', 'CourseController@add')->name('course_add');
	Route::post('/insert-course', 'CourseController@insert')->name('course_insert');
	Route::get('/edit-course/{id}', 'CourseController@edit')->name('course_edit');
	Route::post('/update-course', 'CourseController@update')->name('course_update');
	Route::post('/delete-course', 'CourseController@delete')->name('course_delete');

	Route::get('/semester', 'SemesterController@index')->name('semester');
	Route::get('/add-semester', 'SemesterController@add')->name('semester_add');
	Route::post('/insert-semester', 'SemesterController@insert')->name('semester_insert');
	Route::get('/edit-semester/{id}', 'SemesterController@edit')->name('semester_edit');
	Route::post('/update-semester', 'SemesterController@update')->name('semester_update');
	Route::post('/delete-semester', 'SemesterController@delete')->name('semester_delete');

	Route::get('/group', 'GroupController@index')->name('group');
	Route::get('/add-group', 'GroupController@add')->name('group_add');
	Route::post('/insert-group', 'GroupController@insert')->name('group_insert');
	Route::get('/edit-group/{id}', 'GroupController@edit')->name('group_edit');
	Route::post('/update-group', 'GroupController@update')->name('group_update');
	Route::post('/delete-group', 'GroupController@delete')->name('group_delete');

	Route::get('/admission-fees-list', 'FeesMasterController@admissionFees')->name('admission_fees_list');
	Route::get('/admission-fees-add', 'FeesMasterController@admissionFeesAdd')->name('admission_fees_add');
	Route::post('/admission-fees-insert', 'FeesMasterController@admissionFeesInsert')->name('admission_fees_insert');
	Route::get('/admission-fees-edit/{id}', 'FeesMasterController@admissionFeesEdit')->name('admission_fees_edit');
	Route::post('/admission-fees-update', 'FeesMasterController@admissionFeesUpdate')->name('admission_fees_update');
	Route::post('/delete-admission-fees', 'FeesMasterController@admissionFeesDelete')->name('admission_fees_delete');
	
	// Route::get('/college-fees-list', 'FeesMasterController@collegeFees')->name('college_fees_list');
	
	Route::get('/college-fees-list', 'FeesMasterController@index')->name('fees_master');
	Route::get('/add-college-fees', 'FeesMasterController@add')->name('fees_master_add');
	Route::post('/insert-fees-master', 'FeesMasterController@insert')->name('fees_master_insert');
	Route::get('/edit-college-fees/{id}', 'FeesMasterController@edit')->name('fees_master_edit');
	Route::post('/update-fees-master', 'FeesMasterController@update')->name('fees_master_update');
	Route::get('/get_semester_by_course_id', 'FeesMasterController@getSemesterByCourseId');
	Route::post('/delete-college-fees', 'FeesMasterController@collegeFeesDelete')->name('college_fees_delete');

	Route::get('/general-setting', 'GeneralSettingController@index')->name('general_setting');
	Route::get('/add-general-setting', 'GeneralSettingController@add')->name('general_setting_add');
	Route::post('/insert-general-setting', 'GeneralSettingController@insert')->name('general_setting_insert');
	Route::get('/edit-general-setting/{id}', 'GeneralSettingController@edit')->name('general_setting_edit');
	Route::post('/update-general-setting', 'GeneralSettingController@update')->name('general_setting_update');
	Route::post('/update-general-setting-status', 'GeneralSettingController@updateStatus')->name('general_setting_update_status');

	Route::get('/paid-admission-fees', 'TransactionController@paidAdmissionFees')->name('paid_admission_fees');
	Route::get('/paid-admission-fees-export', 'TransactionController@paidAdmissionFeesExport')->name('paid_admission_fees_export');

	Route::get('/admission-fees', 'TransactionController@admissionFees')->name('admission_fees');
	Route::get('/admission-fees-export', 'TransactionController@admissionFeesExport')->name('admission_fees_export');

	Route::get('/college-fees', 'TransactionController@collegeFees')->name('college_fees');
	Route::get('/college-fees-export', 'TransactionController@collegeFeesExport')->name('college_fees_export');
	Route::get('/transactions', 'TransactionController@index')->name('transactions');
	Route::get('/transactions/details/{id}', 'TransactionController@details')->name('transaction_details');
	// Route::get('/download-fee-receipt/{id}', 'TransactionController@downloadFeeReceipt')->name('download_fee_receipt');
	Route::get('/download-college-fee-receipt/{id}', 'TransactionController@downloadCollegeFeeReceipt')->name('download_college_fee_receipt');
	Route::get('/print-fee-receipt', function(){
		return view('admin.transactions.college_fee_receipt');
	});

	Route::get('/student-list-enrolment-report', 'ReportsController@studentListEnrolment')->name('student_list_enrolment_report');
	Route::get('/student-list-enrolment-report-export', 'ReportsController@studentListEnrolmentExport')->name('student_list_enrolment_export');
	Route::get('/student-list-sem-report', 'ReportsController@studentListSem')->name('student_list_sem_report');
	Route::get('/student-list-sem-report-export', 'ReportsController@studentListSemExport')->name('student_list_sem_report_export');

	Route::get('/consolidated-report', 'ReportsController@consolidatedReport')->name('consolidated_report');
	Route::get('/consolidated-report-print', 'ReportsController@consolidatedReportPrint')->name('consolidated_report_print');
	
	Route::get('/forfeit-report-1', 'ReportsController@forfeitReport1')->name('forfeit_report_1');
	Route::get('/forfeit-report-1-print', 'ReportsController@forfeitReport1Print')->name('forfeit_report_1_print');

	Route::get('/due-fees-report', 'ReportsController@dueFeesReport')->name('due_fees_report');
	Route::get('/due-fees-report-print', 'ReportsController@dueFeesReportPrint')->name('due_fees_report_print');
	
	Route::get('/fee-head-degree-audit-report', 'ReportsController@feeHeadDegreeAuditReport')->name('fee_head_degree_audit_report');
	Route::get('/fee-head-degree-audit-report-print', 'ReportsController@feeHeadDegreeAuditReportPrint')->name('fee_head_degree_audit_report_print');

	Route::get('/fee-head-degree-audit-without-cancel-report', 'ReportsController@feeHeadDegreeAuditWithoutCancelReport')->name('fee_head_degree_audit_without_cancel_report');
	Route::get('/fee-head-degree-audit-without-cancel-report-print', 'ReportsController@feeHeadDegreeAuditWithoutCancelReportPrint')->name('fee_head_degree_audit_without_cancel_report_print');

	Route::get('/group-sem-cast-all-student-report', 'ReportsController@groupSemCastAllStudentReport')->name('group_sem_cast_all_student_report');
	Route::get('/group-sem-cast-report-all-student-admitted-only', 'ReportsController@groupSemCastReportAllStudentAdmittedOnly')->name('group_sem_cast_all_student_admitted_only_report');
	Route::get('/sem-cast-all-student-admitted-only-report', 'ReportsController@semCastAllStudentAdmittedOnlyReport')->name('sem_cast_all_student_admitted_only_report');
	Route::get('/sem-cast-all-student-report', 'ReportsController@semCastAllStudentReport')->name('sem_cast_all_student_report');
	
	Route::get('/sem-group-fees-collection-all-user-report', 'ReportsController@semGroupFeesCollectionAllUserReport')->name('sem_group_fees_collection_all_user_report');
	Route::get('/sem-group-fees-collection-all-user-report-export', 'ReportsController@semGroupFeesCollectionAllUserReportExport')->name('sem_group_fees_collection_all_user_report_export');

	Route::get('/sem-group-fees-collection-report', 'ReportsController@semGroupFeesCollectionReport')->name('sem_group_fees_collection_report');
	Route::get('/sem-group-fees-collection-report-export', 'ReportsController@semGroupFeesCollectionReportExport')->name('sem_group_fees_collection_report_export');

	Route::get('/roles-and-permission', 'RoleController@index')->name('roles_and_permission');
	Route::get('/add-roles-and-permission', 'RoleController@add')->name('roles_and_permission_add');
	Route::post('/insert-roles-and-permission', 'RoleController@insert')->name('roles_and_permission_insert');
	Route::get('/edit-roles-and-permission/{id}', 'RoleController@edit')->name('roles_and_permission_edit');
	Route::post('/update-roles-and-permission', 'RoleController@update')->name('roles_and_permission_update');


	Route::get('/user', 'AdminController@index')->name('admin_user');
	Route::get('/add-user', 'AdminController@add')->name('admin_user_add');
	Route::post('/insert-user', 'AdminController@insert')->name('admin_user_insert');
	Route::get('/edit-user/{id}', 'AdminController@edit')->name('admin_user_edit');
	Route::post('/update-user', 'AdminController@update')->name('admin_user_update');

	
});
