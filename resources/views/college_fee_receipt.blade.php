<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Print</title>
	<style>
		table {
			width: 100%;
			border: 1px solid black !important;
		}
		th, td {
			text-align: left;
			padding: 0px;
			vertical-align: 'center';
		}
		.center {
			text-align: center;
		}
		td.right {
			text-align: right;
		}
		hr
		{
			border: 1px solid rgb(128, 128, 128) !important;
		}
		.border-none {
			border: none !important;
		}
		.border-solid {
			border: 1px solid !important;
		}
		table.border-solid th,table.border-solid td {
			border: 1px solid !important;
			vertical-align: 'center';
		} 
		/* @font-face {
			font-family: 'AnekGujarati';
			font-style: normal;
			font-weight: normal;
			src: url({{storage_path('fonts/AnekGujarati-VariableFont_wdth,wght.ttf')}}) format('truetype');
		} */
		body {
			font-family: "AnekGujarati";
		}
		.page_break { page-break-before: always; }
	</style>
</head>
<body >
{{--@if($degree == 'B.Sc.')
    @for($i = 0;$i < 2;$i++) --}}
	<div class="center">
            <table>
               	<tr>
				<td colspan="6" class="center">
					<img src="{{ url('/assets/images/hnsb sci rec.png') }}" height="70px" width="100%" /><u><strong>::Fee Receipt::</strong></u>
				</td></tr>
				<tr>
					<td colspan="6" class="center">
						<span style="font-size:11px"><b>Academic Year :</b> {{ $feeDetails->academicYear->year }}
						&nbsp;&nbsp;||&nbsp;&nbsp;<b>Receipt No: </b>{{ $feeDetails->transaction->order_id }}	
						&nbsp;&nbsp;||&nbsp;&nbsp;<b>Receipt Date: </b>{{ date('d-m-Y', strtotime($feeDetails->created_at)) }}
						<!-- &nbsp;&nbsp;||&nbsp;&nbsp;<b>Admission No: </b>{{ 'adm_no' }} -->
						&nbsp;&nbsp;||&nbsp;&nbsp;<b>Roll No: </b>{{ $feeDetails->studentEnrollment->roll_no }}
						&nbsp;&nbsp;||&nbsp;&nbsp;<b><u>GR. No: </b>{{ $feeDetails->student->gr_no }}</u></strong></span>
					</td>
				</tr>
				<tr>
					<td colspan="6"><hr></td>	
				</tr>
				<tr>
					<td colspan="6" class="center">
					<span style="font-size:11px"><b>Student Name: </b> {{ $feeDetails->student->name }}
					&nbsp;&nbsp;||&nbsp;&nbsp;
					<b>Gender: </b> {{ $feeDetails->student->gender }}
					&nbsp;&nbsp;||&nbsp;&nbsp;
					<b>Sem: </b> {{ $feeDetails->semester->semester_name }}
					&nbsp;&nbsp;||&nbsp;&nbsp;
					<b>Degree: </b>{{ $feeDetails->course->course_name }}
					&nbsp;&nbsp;||&nbsp;&nbsp;
					<b>Group: </b>{{ $feeDetails->group->group_name }}
					</span>
					</td>
				</tr>
				
				<tr>
					<td colspan="6" class="center">
					<table class="border-solid">
						<tr>
							<td><span style="font-size:14px">Tuition Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_tut }}</span>/-</td>
							<td><span style="font-size:14px">Laboratory Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_lab }}</span>/-</td>
							<td><span style="font-size:14px">Hepatitis-B Vaccine Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_hb_rasi }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Sports Games Fee(Gymkhana)</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_sport_gim }}</span>/-</td>
							<td><span style="font-size:14px">Uni.Exam Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_uniexam }}</span>/-</td>
							<td><span style="font-size:14px">Admission Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_reg }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">College Exam Stationary Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_clgexam_stat }}</span>/-</td>
							<td><span style="font-size:14px">Ele.Gen.Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_ele }}</span>/-</td>
							<td><span style="font-size:14px">I-Card Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_icard}}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">College Campus Development Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_clg_dev }}</span>/-</td>
							<td><span style="font-size:14px">Late Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->is_late_fees_paid ? $feeDetails->fee_late : 0 }}</span>/-</td>
							<td><span style="font-size:14px">Thalassemia Testing Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_theal }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Medical Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_med }}</span>/-</td>
							<td><span style="font-size:14px">Library Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_lib }}</span>/-</td>
							<td><span style="font-size:14px">Uni.Exam Form Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_uni_exam_form }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Student Union Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_union }}</span>/-</td>
							<td><span style="font-size:14px">Sports Fee(College)</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_sport_clg }}</span>/-</td>
							<td><span style="font-size:14px">Computer Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_comp }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Enrolment Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_enroll }}</span>/-</td>
							<td><span style="font-size:14px">Student Relief Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_union }}</span>/-</td>
							<td><span style="font-size:14px">On-line Computer S/W Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_other }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Uni.Other Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_uniother }}</span>/-</td>
							<td><span style="font-size:14px">Youth Festival &amp; Cult.Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_you_fas }}</span>/-</td>
							<td><span style="font-size:14px">Scope Exam Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->scope_exam_fee }}</span>/-</td>
						</tr>	
						<tr>	
							<td colspan="5" class="right"><span style="font-size:14px">Total Amount: </span><span style="font-size:14px">(₹ <span style="font-size:14px">{{ convertNumberToWords($feeDetails->total_fee) }} Only)</span></td>
							<td align="left"> ₹ {{ $feeDetails->is_late_fees_paid ? $feeDetails->total_fee + $feeDetails->fee_late : $feeDetails->total_fee }}/- </td>
						</tr>
						
					</table>
					</td>
				</tr>
				
				<tr>
				<td class="border-none">
				&nbsp;
				</td>
				</tr>
				<tr>
					<td colspan="3" align="left"><span style="font-size: 11px">
					Print By : {{ auth()->guard('web')->user()->name }}<br/>
					Print Date & Time: {{ date('l, F d, Y h:i:s A', time()) }} </span>
					</td>
					<td colspan="3" class="right">
						<span style="font-size: 11px">
							This receipt is digitally generated hance no signature is required.
						</span>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="left">
						<span style="font-size: 11px">
							Transaction Date & Time : {{ date('l, F d, Y h:i:s A', strtotime($feeDetails->created_at)) }}<br/>
							Payment Mode: {{ 'To be cleared' }}
						</span>
					</td>
					<td colspan="3" class="right">
						<span style="font-size: 11px">Transaction Id: #{{ $feeDetails->transaction_id }}</span>
					</td>
				</tr>
				
				
				
            </table>
			
       {{-- @if($i <= 0) --}}
				<br/>------------------  <span style="font-size: 11px">અહિયાં થી કાપો </span> ------------------ </br></br>
				{{-- @endif --}}
	</div>
		{{-- @endfor --}}
{{-- @else  --}}
	{{-- @for($i = 0;$i < 2;$i++)  --}}
	<div class="center page_break">
            <table>
               	<tr>
				<td colspan="6" class="center">
					<img src="{{ url('/assets/images/hnsb sci rec.png') }}" height="70px" width="100%" /><u><strong>::Fee Receipt::</strong></u>
				</td>
				</tr>
				
				<tr>
					<td colspan="6" class="center">
					<span style="font-size:11px"><b>Academic Year :</b> {{ $feeDetails->academicYear->year }}
						&nbsp;&nbsp;||&nbsp;&nbsp;<b>Receipt No: </b>{{ $feeDetails->transaction->order_id }}	
						&nbsp;&nbsp;||&nbsp;&nbsp;<b>Receipt Date: </b>{{ date('d-m-Y', strtotime($feeDetails->created_at)) }}
						<!-- &nbsp;&nbsp;||&nbsp;&nbsp;<b>Admission No: </b>{{ 'adm_no' }} -->
						&nbsp;&nbsp;||&nbsp;&nbsp;<b>Roll No: </b>{{ $feeDetails->studentEnrollment->roll_no }}
						&nbsp;&nbsp;||&nbsp;&nbsp;<b><u>GR. No: </b>{{ $feeDetails->student->gr_no }}</u></strong></span>
					</td>
				</tr>
				<tr>
					<td colspan="6"><hr></td>	
				</tr>
				<tr>
					<td colspan="6" class="center">
					<span style="font-size:11px"><b>Student Name: </b> {{ $feeDetails->student->name }}
					&nbsp;&nbsp;||&nbsp;&nbsp;
					<b>Gender: </b> {{ $feeDetails->student->gender }}
					&nbsp;&nbsp;||&nbsp;&nbsp;
					<b>Sem: </b> {{ $feeDetails->semester->semester_name }}
					&nbsp;&nbsp;||&nbsp;&nbsp;
					<b>Degree: </b>{{ $feeDetails->course->course_name }}
					&nbsp;&nbsp;||&nbsp;&nbsp;
					<b>Group: </b>{{ $feeDetails->group->group_name }}
					</span>
					</td>
				</tr>
				
				<tr>
					<td colspan="6" class="center">
					<table class="border-solid">					
						<tr>
						<td><span style="font-size:14px">Tuition Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_tut }}</span>/-</td>
							<td><span style="font-size:14px">Laboratory Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_lab }}</span>/-</td>
							<td><span style="font-size:14px">Uni.Sports Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_hb_rasi }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Sports Games Fee(Gymkhana)</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_sport_gim }}</span>/-</td>
							<td><span style="font-size:14px">Uni.Exam Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_uniexam }}</span>/-</td>
							<td><span style="font-size:14px">Admission Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_reg }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">College Exam Stationary Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_clgexam_stat }}</span>/-</td>
							<td><span style="font-size:14px">Ele.Gen.Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_ele }}</span>/-</td>
							<td><span style="font-size:14px">I-Card Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_icard}}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Uni.Library Development Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_clg_dev }}</span>/-</td>
							<td><span style="font-size:14px">Late Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->is_late_fees_paid ? $feeDetails->fee_late : 0 }}</span>/-</td>
							<td><span style="font-size:14px">Thalassemia Testing Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_theal }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Medical Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_med }}</span>/-</td>
							<td><span style="font-size:14px">Library Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_lib }}</span>/-</td>
							<td><span style="font-size:14px">Uni.Exam Form Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_uni_exam_form }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Sport Sankul Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_union }}</span>/-</td>
							<td><span style="font-size:14px">Sports Fee(College)</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_sport_clg }}</span>/-</td>
							<td><span style="font-size:14px">Computer Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_comp }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Enrolment Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_enroll }}</span>/-</td>
							<td><span style="font-size:14px">Student Relief Fund Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_student_rahat }}</span>/-</td>
							<td><span style="font-size:14px">Other Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_other }}</span>/-</td>
						</tr>
						<tr>
							<td><span style="font-size:14px">Uni.Other Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_uniother }}</span>/-</td>
							<td><span style="font-size:14px">Youth Festival &amp; Cult.Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->fee_you_fas }}</span>/-</td>
							<td><span style="font-size:14px">Scope Exam Fee</span></td>
							<td><span style="font-size:14px"> ₹ {{ $feeDetails->scope_exam_fee }}</span>/-</td>
						</tr>	
						<tr>	
							<td colspan="5" class="right"><span style="font-size:14px">Total Amount: </span><span style="font-size:14px">(₹ <span style="font-size:14px">{{ convertNumberToWords($feeDetails->total_fee) }} Only)</span></td>
							<td align="left"> ₹ {{ $feeDetails->is_late_fees_paid ? $feeDetails->total_fee + $feeDetails->fee_late : $feeDetails->total_fee }}/- </td>
						</tr>
						
					</table>
					</td>
				</tr>
				
				<tr>
				<td class="border-none">
				&nbsp;
				</td>
				</tr>
				<tr>
					<td colspan="3" align="left"><span style="font-size: 11px">
					Print By : {{ auth()->guard('web')->user()->name }}<br/>
					Print Date & Time: {{ date('l, F d, Y h:i:s A', time()) }} </span>
					</td>
					<td colspan="3" class="right">
						<span style="font-size: 11px">
							This receipt is digitally generated hance no signature is required.
						</span>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="left">
						<span style="font-size: 11px">
							Transaction Date & Time : {{ date('l, F d, Y h:i:s A', strtotime($feeDetails->created_at)) }}<br/>
							Payment Mode: {{ 'To be cleared' }}
						</span>
					</td>
					<td colspan="3" class="right">
						<span style="font-size: 11px">Transaction Id: #{{ $feeDetails->transaction_id }}</span>
					</td>
				</tr>
				
				
				
            </table>
			
{{--@if($i <= 0)--}}
				<br/>------------------  <span style="font-size: 11px">અહિયાં થી કાપો </span> ------------------ </br></br>
			{{--@endif--}}
		</div>
    {{-- @endfor
@endif  --}}
    </div>
</body>
</html>