<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>HNSB Report</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
    <!-- Bootstrap css -->
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
</head>
    <body onload="window.print();">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div>
                        <center>
                            <img src="{{ url('public/assets/images/hnsb sci rec.png') }}" cellpadding="2" width="500px" /><br />
                            <u><strong>::HNSB Day-Book of Fee Collection::</strong></u><br />
                            {{-- <u><strong>::{{ $selectedCourse }}::</strong></u><br /> --}}
                            <table cellpadding="0" width="100%">
                                <tr>
                                    <td align="left">
                                        <font size="2">From Date: {{request()->get('from_date')}} To Date: {{request()->get('to_date')}}</font>
                                    </td>
                                    <td align="right">
                                        <font size="2">Academic Year {{ $selectedYear }}</font>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellpadding="0" border="1" class="table-bordered text-center">
                                <tbody>
                                    @if (!empty($semesters))
                                        @php
                                            $maleTotal = $femaleTotal = $total = $totalAmount = $grandTotalMale = $grandTotalFemale = $grandTotal = $grandTotalAmount = 0;
                                        @endphp
                                        @foreach ($semesters as $semester)
                                            @if(isset($previousSemester) && $previousSemester != $semester->semester_id)
                                                <tr>
                                                    <td colspan="3"><strong>TOTAL</strong></td>
                                                    <td><strong>{{ $maleTotal }}</strong></td>
                                                    <td><strong>{{ $femaleTotal }}</strong></td>
                                                    <td><strong>{{ $total }}</strong></td>
                                                    <td><strong>{{ $totalAmount.'/-' }}</strong></td>
                                                </tr>
                                                @php
                                                    $maleTotal = $femaleTotal = $total = $totalAmount = 0;
                                                @endphp
                                            @endif
                                            <tr>
                                                <th colspan="7" class="text-center">{{ ($semester->course->course_name ?? '' ).' SEM-'.$semester->semester_name }}</th>
                                            </tr>
                                            <tr colspan="7">
                                                <th><strong>DEGREE</strong></th>
                                                <th><strong>SEM</strong></th>
                                                <th><strong>GROUP</strong></th>
                                                <th><strong>MALE</strong></th>
                                                <th><strong>FEMALE</strong></th>
                                                <th><strong>TOTAL</strong></th>
                                                <th><strong>Total Amount</strong></th>
                                            </tr>
                                            @if(isset($semester->groups) && count($semester->groups))
                                                @foreach($semester->groups as $group)
                                                    <tr>
                                                        <td>{{ $semester->course->course_name ?? '' }}</td>
                                                        <td>{{ $semester->semester_name }}</td>
                                                        <td>{{ $group->group_name }}</td>
                                                        @php

                                                            $maleEnrolled = \App\Models\User::whereHas('enrollment', function($q) use ($group, $semester){
                                                                $q->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => $semester->course_id, 'semester_id' => $semester->semester_id, 'group_id' => $group->group_id, 'is_fees_paid' => 1]);
                                                            })->whereHas('transactions', function($q) use ($group, $semester){
                                                                $q->whereDate('created_at','>=', date('y-m-d', strtotime(request()->get('from_date'))))
                                                                ->whereDate('created_at','<=', date('y-m-d', strtotime(request()->get('to_date'))));
                                                            });
                                                            $maleCount = $maleEnrolled->where('gender', 'Male')->count();
                                                            $femaleEnrolled = \App\Models\User::whereHas('enrollment', function($q) use ($group, $semester){
                                                                $q->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => $semester->course_id, 'semester_id' => $semester->semester_id, 'group_id' => $group->group_id, 'is_fees_paid' => 1]);
                                                            })->whereHas('transactions', function($q) use ($group, $semester){
                                                                $q->whereDate('created_at','>=', date('y-m-d', strtotime(request()->get('from_date'))))
                                                                ->whereDate('created_at','<=', date('y-m-d', strtotime(request()->get('to_date'))));
                                                            });
                                                            $femaleCount = $femaleEnrolled->where('gender', 'Female')->count();

                                                            $totalFee = \App\Models\PaidFees::whereHas('student')->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => $semester->course_id, 'semester_id' => $semester->semester_id, 'group_id' => $group->group_id])->whereDate('created_at','>=', date('y-m-d', strtotime(request()->get('from_date'))))->whereDate('created_at','<=', date('y-m-d', strtotime(request()->get('to_date'))))->sum('total_fee');
                                                            
                                                            $maleTotal += $maleCount;
                                                            $femaleTotal += $femaleCount;
                                                            $total += $maleCount + $femaleCount;
                                                            $totalAmount += $totalFee;
                                                            $grandTotalMale += $maleCount;
                                                            $grandTotalFemale += $femaleCount;
                                                            $grandTotal += $maleCount + $femaleCount;
                                                            $grandTotalAmount += $totalFee; 
                                                        @endphp
                                                        <td>{{ $maleCount }}</td>
                                                        <td>{{ $femaleCount }}</td>
                                                        <td>{{ $maleCount + $femaleCount }} </td>
                                                        <td>{{ $totalFee }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            @php
                                                $previousSemester = $semester->semester_id;
                                            @endphp
                                            @if($loop->last)
                                                <tr>
                                                    <td colspan="3"><strong>TOTAL</strong></td>
                                                    <td><strong>{{ $maleTotal }}</strong></td>
                                                    <td><strong>{{ $femaleTotal }}</strong></td>
                                                    <td><strong>{{ $total }}</strong></td>
                                                    <td><strong>{{ $totalAmount.'/-' }}</strong></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td colspan="3"><strong>GRAND TOTAL</strong></td>
                                            <td><strong>{{ $grandTotalMale }}</strong></td>
                                            <td><strong>{{ $grandTotalFemale }}</strong></td>
                                            <td><strong>{{ $grandTotal }}</strong></td>
                                            <td><strong>{{ $grandTotalAmount.'/-' }}</strong></td>
                                        </tr>
                                        @php
                                            unset($previousSemester)
                                        @endphp
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No Transaction Found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </center>
                    </div> <!-- end card body-->
                    <div>
                        <p align="right"> <strong>Total Amount ₹{{ $grandTotalAmount }}/- <br>₹ {{ ucwords(convertNumberToWords($grandTotalAmount)) }} Only </strong></p>
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
                </div><!-- end col-->
            </div>
        </div> <!-- container -->
    </body>
</html>