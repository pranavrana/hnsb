<?php

use App\Models\AcademicYear;
use App\Models\FeesMaster;
use App\Models\User;
use App\Models\GeneralSetting;
use App\Models\StudentEnrollment;

if (!function_exists('_json')) {
	function _json($code, $msg = "", $data = array())
	{
		@http_response_code($code);
		$result['status_code'] = $code;
		$result['message'] = $msg;
		$result['data'] = $data;
		echo json_encode($result);
		die;
	}
}

if (!function_exists('getUserField')) {
	function getUserField($field = '', $userID = null)
	{
		$field = ($field == '') ? "email" : $field;
		$userID = ($userID == '') ? Auth::id() : $userID;
		$result = User::select($field)->where('id', $userID)->first();
		if (!empty($result)) {
			return $result->$field;
		} else {
			return null;
		}
	}
}

if (!function_exists('getUserData')) {
	function getUserData($userID = null)
	{
		$userID = ($userID == '') ? Auth::id() : $userID;
		$result = User::where('id', $userID)->first();
		if (!empty($result)) {
			return $result;
		} else {
			return null;
		}
	}
}

if (!function_exists('getGeneralSettingByKey')) {
	function getGeneralSettingByKey($key = null, $row = false)
	{
		if (!empty($key)) {
			$result = GeneralSetting::where('key', $key)->first();
			if (!empty($result)) {
				if ($row) {
					return $result;
				} else {
					return $result->value;
				}
			} else {
				return null;
			}
		}
	}
}

if (!function_exists('getAdmissionRequestCount')) {
	function getAdmissionRequestCount()
	{
		return User::where(['is_admission_approved' => 0, 'is_completed_registration' => 1])->count();
	}
}

if (!function_exists('getRegisteredStudentsCount')) {
	function getRegisteredStudentsCount()
	{
		return User::where(['is_completed_registration' => 0])->count();
	}
}

if (!function_exists('getCurrentAcademicYear')) {
	function getCurrentAcademicYear()
	{
		return AcademicYear::where('is_default', 1)->first();
	}
}

if (!function_exists('getCollegeFees')) {
	function getCollegeFees($userID = null)
	{
		$user = getUserData($userID);
        $studentDetails = StudentEnrollment::where('user_id',$user->id)->where('is_fees_paid', 0)->latest('enrollment_id')->first();
		$feesDetails = [];
		if (!empty($studentDetails)) {
			$feesDetails = FeesMaster::where(['academic_year_id' => $studentDetails->academic_year_id, 'course_id' =>  $studentDetails->course_id, 'semester_id' =>  $studentDetails->semester_id, 'group_id' =>  $studentDetails->group_id, 'gender' => $user->gender])->first();
		}
		return array('total' => $feesDetails->total_fee ?? 0, 'late_fees'=> $feesDetails->fee_late ?? 0, 'cutoff_date' => $feesDetails->cutoff_date ?? '', 'cutoff_extension_date' => $feesDetails->cutoff_extension_date ?? '', 'cutoff_extension_status' => $feesDetails->cutoff_extension_status ?? 0);
	}
}

if(!function_exists('convertNumberToWords')){
	function convertNumberToWords($number) {
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);
	   
		if (!is_numeric($number)) {
			return false;
		}
	   
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . convertNumberToWords(abs($number));
		}
	   
		$string = $fraction = null;
	   
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
	   
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . convertNumberToWords($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= convertNumberToWords($remainder);
				}
				break;
		}
	   
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
	   
		return ucwords($string);
	}

	function calculatePaymentAmount($receivableAmount) {
		$chargesPercentage = 2.35;
		// Calculate the payment amount needed for receiver to get desired amount
		$paymentAmount = $receivableAmount / (1 - ($chargesPercentage/100));
		$paymentAmount = round($paymentAmount, 2); // Round off to 2 decimal places
		return $paymentAmount;
	}
	   
}