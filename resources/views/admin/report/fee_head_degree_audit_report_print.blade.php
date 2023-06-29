<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>HNSB Report</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
</head>
<body onload="window.print();">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div>
					<center>
						<img src="{{ url('public/assets/images/hnsb sci rec.png') }}" cellpadding="2" width="500px" /><br />
						<u><strong>::HNSB Day-Book of Fee Collection::</strong></u><br />
						<table cellpadding="0" width="100%">
							<tr>
								<td>
									<font size="2">From Date: {{ date('d-m-Y', strtotime(request()->get('from_date'))) }} To Date: {{ date('d-m-Y', strtotime(request()->get('to_date'))) }}</font>
								</td>
								<td align="center">
									<font size="2">
										{{-- @if($group_name == '0')
											<u><strong>::<?php echo $class; ?> - GRANT-IN-AID::</strong></u>
										@else
											<u><strong>::<?php echo $class; ?> - SELF-FINANCE::</strong></u>
										@endif --}}
									</font>(All Sem)
								</td>
								<td align="right">
									<font size="2">Academic Year {{ request()->get('selectedYear') }}</font>
								</td>
							</tr>
						</table>
						<table width="100%" cellpadding="0" border="1">
							<tbody>
								<tr>
									<td>&nbsp;</td>
									<td>Male</td>
									<td>Female</td>
									<td>Total</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>
										{{$feesDataMale[0]['total']}}
									</td>
									<td>
										{{$feesDataFemale[0]['total']}}
									</td>
									<td>
										<strong>
											{{$feesDataMale[0]['total'] + $feesDataFemale[0]['total']}}
										</strong>
									</td>
								</tr>
								<tr>
									<td>Tuition Fee</td>
									<td>
										{{$feesDataMale[0]['total_fee_tut']}}
									</td>
									<td>
										{{$feesDataFemale[0]['total_fee_tut']}}
									</td>

									<td>
										<strong>
											{{$feesDataMale[0]['total_fee_tut'] + $feesDataFemale[0]['total_fee_tut']}}
										</strong>
									</td>
								</tr>
								<tr>
									<td>Library Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_lib'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_lib'] }}
									</td>

									<td>
										<strong>
										{{ $feesDataMale[0]['total_fee_lib'] + $feesDataFemale[0]['total_fee_lib'] }}
										</strong>
									</td>
								</tr>
								<tr>
									<td>Sports Games Fee(Gymkhana)</td>
									<td>
										{{ $feesDataMale[0]['total_fee_sport_gim'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_sport_gim'] }}
									</td>
									<td>
										<strong>
											{{ $feesDataMale[0]['total_fee_sport_gim'] + $feesDataFemale[0]['total_fee_sport_gim'] }}
										</strong>
									</td>
								</tr>
								<tr>
									<td>Sports Fee(College)</td>
									<td>
										{{ $feesDataMale[0]['total_fee_sport_clg'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_sport_clg'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_sport_clg'] + $feesDataFemale[0]['total_fee_sport_clg'] }}</strong></td>
								</tr>
								<tr>
									<td>College Exam Stationary Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_clgexam_stat'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_clgexam_stat'] }}
									</td>
									<td>
										<strong>{{ $feesDataMale[0]['total_fee_clgexam_stat'] + $feesDataFemale[0]['total_fee_clgexam_stat'] }}</strong>
									</td>
								</tr>
								<tr>
									<td>Student Relief Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_student_rahat'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_student_rahat'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_student_rahat'] + $feesDataFemale[0]['total_fee_student_rahat'] }}</strong></td>
								</tr>
								<tr>
									<td>College Campus Development Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_clg_dev'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_clg_dev'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_clg_dev'] + $feesDataFemale[0]['total_fee_clg_dev'] }}</strong></td>
								</tr>
								<tr>
									<td>Youth Festival & Cult.Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_you_fas'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_you_fas'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_you_fas'] + $feesDataFemale[0]['total_fee_you_fas'] }}</strong></td>
								</tr>
								<tr>
									<td>Medical Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_med'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_med'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_med'] + $feesDataFemale[0]['total_fee_med'] }}</strong></td>
								</tr>
								<tr>
									<td>Hepatitis B Vaccine Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_hb_rasi'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_hb_rasi'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_hb_rasi'] + $feesDataFemale[0]['total_fee_hb_rasi'] }}</strong></td>
								</tr>
								<tr>
									<td>Student Union Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_union'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_union'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_union'] + $feesDataFemale[0]['total_fee_union'] }}</strong></td>
								</tr>
								<tr>
									<td>Admission Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_reg'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_reg'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_reg'] + $feesDataFemale[0]['total_fee_reg'] }}</strong></td>
								</tr>
								<tr>
									<td>Enrolment Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_enroll'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_enroll'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_enroll'] + $feesDataFemale[0]['total_fee_enroll'] }}</strong></td>
								</tr>
								<tr>
									<td>I-Card Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_icard'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_icard'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_icard'] + $feesDataFemale[0]['total_fee_icard'] }}</strong></td>
								</tr>
								<tr>
									<td>Uni.Other Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_uniother'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_uniother'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_uniother'] + $feesDataFemale[0]['total_fee_uniother'] }}</strong></td>
								</tr>
								<tr>
									<td>Thalassemia Testing Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_theal'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_theal'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_theal'] + $feesDataFemale[0]['total_fee_theal'] }}</strong></td>
								</tr>
								<tr>
									<td>Laboratory Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_lab'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_lab'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_lab'] + $feesDataFemale[0]['total_fee_lab'] }}</strong></td>
								</tr>
								<tr>
									<td>Uni.Exam Form Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_uni_exam_form'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_uni_exam_form'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_uni_exam_form'] + $feesDataFemale[0]['total_fee_uni_exam_form'] }}</strong></td>
								</tr>
								<tr>
									<td>Uni.Exam Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_uniexam'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_uniexam'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_uniexam'] + $feesDataFemale[0]['total_fee_uniexam'] }}</strong></td>
								</tr>
								<tr>
									<td>Computer Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_comp'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_comp'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_comp'] + $feesDataFemale[0]['total_fee_comp'] }}</strong></td>
								</tr>
								<tr>
									<td>Ele.Gen.Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_ele'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_ele'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_ele'] + $feesDataFemale[0]['total_fee_ele'] }}</strong></td>
								</tr>
								<tr>
									<td>Other Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_other'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_other'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_other'] + $feesDataFemale[0]['total_fee_other'] }}</strong></td>
								</tr>
								<tr>
									<td>Late Fee</td>
									<td>
										{{ $feesDataMale[0]['total_fee_late'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_fee_late'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_fee_late'] + $feesDataFemale[0]['total_fee_late'] }}</strong></td>
								</tr>
								<tr>
									<td>Total Fee</td>
									<td>
										{{ $feesDataMale[0]['total_total_fee'] }}
									</td>
									<td>
										{{ $feesDataFemale[0]['total_total_fee'] }}
									</td>
									<td><strong>{{ $feesDataMale[0]['total_total_fee'] + $feesDataFemale[0]['total_total_fee'] }}</strong></td>
								</tr>
							</tbody>
						</table>
					</center>
				</div>
				<div>
					<p align="right"> <strong>Total Amount ₹{{ $feesDataMale[0]['total_total_fee'] + $feesDataFemale[0]['total_total_fee'] }}/- <br>₹ {{ ucwords(convertNumberToWords($feesDataMale[0]['total_total_fee'] + $feesDataFemale[0]['total_total_fee'])) }} Only </strong></p>
				</div>
				<table width="100%" cellpadding="0" border="0">
					<tr>
						<td colspan="4" align="left">
							<font size="1">
								Print By : {{ auth()->guard('admin')->user()->name }}<br />
								Print Date & Time: {{ date('l, F d, Y h:i:s A', time()) }}</font>
						</td>
						<td colspan="3" align="right">
							<font size="1">
								________________________</br>

								Cashier Sign </font>
						</td>
						<td colspan="3" align="right">
							<font size="1">
								________________________</br>

								Head Clerk Sign </font>
						</td>
						<td colspan="3" align="right">
							<font size="1">
								________________________</br>

								Principal Sign </font>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>