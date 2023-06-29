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
                            <u><strong>::HNSB Forfeit Report 1::</strong></u><br />
                            <u><strong>::{{ $selectedCourse }}::</strong></u><br />
                            <table cellpadding="0" width="100%">
                                <tr>
                                    <td align="left">
                                        <font size="2">Date {{ date('l, F d, Y h:i:s A') }}</font>
                                    </td>
                                    <td align="right">
                                        <font size="2">Academic Year {{ $selectedYear }}</font>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellpadding="0" border="1" class="table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th rowspan='2'></th>
                                        @if(isset($groups) && count($groups))
                                            @foreach($groups as $group)
                                                <th colspan='2'>{{ $group->group_name }}</th>
                                            @endforeach
                                        @endif
                                        <th rowspan='2'>TOTAL (In Rs)</th>
                                    </tr>
                                    <tr>
                                        @if(isset($groups) && count($groups))
                                            @foreach($groups as $group)
                                                <th>M</th>
                                                <th>F</th>
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                        Approved Admission
                                        </td>
                                        @if(isset($groups) && count($groups))
                                            @foreach($groups as $group)
                                                @php
                                                $approvedAdmissionQuery = \App\Models\User::whereHas('enrollment', function($q) use ($group){
                                                    $q->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id'), 'group_id' => $group->group_id]);
                                                })->where('is_admission_approved', '1');
                                                @endphp
                                                <th>{{ $approvedAdmissionQuery->where('gender', 'Male')->count() }}</th>
                                                <th>{{ $approvedAdmissionQuery->where('gender', 'Female')->count() }}</th>
                                            @endforeach
                                            @php
                                                $approvedTotal = \App\Models\PaidFees::whereHas('student', function($q){
                                                                $q->where('is_cancelled', '0');
                                                            })->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id')])->sum('total_fee');
                                            @endphp
                                            <th>{{ $approvedTotal.'/-' }}</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>
                                            Cancelled Fee
                                        </td>
                                        @if(isset($groups) && count($groups))
                                            @foreach($groups as $group)
                                            @php
                                                $cancelledFee = \App\Models\User::whereHas('enrollment', function($q) use ($group){
                                                    $q->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id'), 'group_id' => $group->group_id]);
                                                })->where('is_cancelled', '1');
                                                @endphp
                                                <th>{{ $cancelledFee->where('gender', 'Male')->count() }}</th>
                                                <th>{{ $cancelledFee->where('gender', 'Female')->count() }}</th>
                                            @endforeach
                                            @php
                                                $cancelledFeedTotal = \App\Models\PaidFees::whereHas('student', function($q){
                                                                $q->where('is_cancelled', '1');
                                                            })->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id')])->sum('total_fee');
                                            @endphp
                                            <th>{{ $cancelledFeedTotal.'/-' }}</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>
                                            Enrolled
                                        </td>
                                        @if(isset($groups) && count($groups))
                                            @foreach($groups as $group)
                                                @php
                                                $enrolled = \App\Models\User::whereHas('enrollment', function($q) use ($group){
                                                    $q->where(['academic_year_id' => request()->get('academic_year_id'), 'course_id' => request()->get('course_id'), 'semester_id' => request()->get('semester_id'), 'group_id' => $group->group_id]);
                                                })->where('is_cancelled', '0');
                                                @endphp
                                                <th>{{ $enrolled->where('gender', 'Male')->count() }}</th>
                                                <th>{{ $enrolled->where('gender', 'Female')->count() }}</th>
                                            @endforeach
                                            <th>{{ $approvedTotal-$cancelledFeedTotal.'/-' }}</th>
                                        @endif
                                    </tr>
                                    <!-- <tr>
                                        <td>
                                            Unenrolled
                                        </td>
                                        @if(isset($groups) && count($groups))
                                            @foreach($groups as $group)
                                                <th>M</th>
                                                <th>F</th>
                                            @endforeach
                                        @endif
                                    </tr> -->
                                </tbody>
                            </table>
                        </center>
                    </div> <!-- end card body-->
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