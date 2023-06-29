@extends('admin.layouts.app')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">							
            <div class="col-lg-12">
            <!-- start page title -->
            <!-- <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                        <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                </div>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                    <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-1">
                                    <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div> -->
            <!-- end page title -->
            {{-- 
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card-heading bg-primary text-white p-2">
                    HNSB Science College Admission & Fee's Management System<br><br>
                        <form role="form" name="studentform" action="" method="post">
                            <button type="submit" id="search" name="search" value="search" class="btn btn-success" style="float: right">Show</button>
                            <div style="overflow: hidden;">
                                <select class="form-select" name="academic_year_id">
                                    <option value="" selected="">Please Select Year</option>
                                    @foreach($academicYears as $y)
                                        <option value="{{ $y->academic_year_id}}" {{request()->get('academic_year_id') == $y->academic_year_id ? 'selected' : ''}}>{{ $y->year}}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </form>      
                    </div>
                </div>
            </div>
            --}}
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <select class="form-select" name="academic_year_id">
                                    <option value="" selected="">Academic Year</option>
                                        @foreach($academicYears as $y)
                                            <option value="{{ $y->academic_year_id}}" {{request()->get('academic_year_id') == $y->academic_year_id ? 'selected' : ''}}>{{ $y->year}}</option>
                                        @endforeach
                                    </select>
                                    </li>
                            </ol>
                        </div>
                        <h4 class="page-title">HNSB Science College Admission & Fee's Management System</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 
            <!-- Dashboard Data -->
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card" id="tooltip-container">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Students</h4>
                            <h2 class="text-primary my-3 text-center">{{$totalStudents}}</span></h2>
                            <p class="text-muted mb-0">Male: {{$totalMaleStudents}} <span class="float-end">Female: {{ $totalFemaleStudents }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card" id="tooltip-container">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Fee Collection</h4>
                            <h2 class="text-primary my-3 text-center">₹<span data-plugin="counterup">{{ $totalFeeCollection }}</span></h2>
                            <p class="text-muted mb-0">Male: ₹{{ $totalFeeCollectionMale }} <span class="float-end">Female: ₹{{ $totalFeeCollectionFemale }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card" id="tooltip-container">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Today's Fee Collection</h4>
                            <h2 class="text-primary my-3 text-center">₹<span data-plugin="counterup">{{ $totalFeeCollectionToday }}</span></h2>
                            <p class="text-muted mb-0">Male: ₹{{ $totalFeeCollectionMaleToday }} <span class="float-end">Female: ₹{{ $totalFeeCollectionFemaleToday }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if(isset($totalRegisteredStudents) && !empty($totalRegisteredStudents))
                    @foreach($totalRegisteredStudents as $row)
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 font-16">Registered Students in {{$row->course_name}}, {{$row->semester_name}}</h4>
                                    <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{ $row->total }}</span></h2>
                                    <p class="text-muted mb-0">Male: {{ $row->maleTotal }} <span class="float-end">Female: {{ $row->femaleTotal }}</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Cancelled Students</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">{{ $totalCancelledStudents }}</span></h2>
                            <p class="text-muted mb-0">Male: {{ $totalCancelledMaleStudents }} <span class="float-end">Female: {{ $totalCancelledFemaleStudents }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Fee Returns</h4>
                            <h2 class="text-primary my-3 text-center">₹<span data-plugin="counterup">{{ $totalFeeReturns }}</span></h2>
                            <p class="text-muted mb-0">Male: ₹{{ $totalFeeReturnsMale }} <span class="float-end">Female: ₹{{ $totalFeeReturnsFemale }}</span></p>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Register Students in B.SC.SEM - 3</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="">{{ '$totalRegistredInBscSem3' }}</span></h2>
                            <p class="text-muted mb-0">Total Male :- </p>
                            <p class="text-muted mb-0">Total Female :- </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Register Students in B.SC.SEM - 5</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="">{{ '$totalRegistredInBscSem5' }}</span></h2>
                            <p class="text-muted mb-0">Total Male :- </p>
                            <p class="text-muted mb-0">Total Female :- </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Register Students in M.SC.SEM - 1</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="">{{ '$totalRegistredInMscSem1' }}</span></h2>
                            <p class="text-muted mb-0">Total Male :- </p>
                            <p class="text-muted mb-0">Total Female :- </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Register Students in M.SC.SEM - 3</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="">{{ '$totalRegistredInMscSem3' }}</span></h2>
                            <p class="text-muted mb-0">Total Male :- </p>
                            <p class="text-muted mb-0">Total Female :- </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Cancel Students</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="">{{ '$totalCancelledStudents' }}</span></h2>
                            <p class="text-muted mb-0">Total Cancel Male :- </p>
                            <p class="text-muted mb-0">Total Cancel Female :- </p>
                        </div>
                    </div>
                </div>
            </div>--}}

            {{--<div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Fee Returns in </br>( Male:  +  Female: )</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="">{{ '$totalFeeReturns' }}</span></h2>
                            <p class="text-muted mb-0">TILL </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Enrolled Students</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="">{{ '$totalEnrolledStudents' }}</span></h2>
                            <p class="text-muted mb-0">Total Male :- </p>
                            <p class="text-muted mb-0">Total Female :- </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 font-16">Total Un-Enrolled Students</h4>
                            <h2 class="text-primary my-3 text-center"><span data-plugin="">{{ '$totalUnenrolledStudents' }}</span></h2>
                            <p class="text-muted mb-0">Total Male :- </p>
                            <p class="text-muted mb-0">Total Female :- </p>
                        </div>
                    </div>
                </div>
            </div>--}}
            <div class="alert alert-danger mt-2  text-center" role="alert">
                FEE COLLECTION BY ALL USERS
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td rowspan="2"><strong>User Name</strong></td>
                                            @foreach($allSemesters as $semester)
                                                <td colspan="{{ $semester->groups->count()+1 }}"><strong>{{ $semester->course->course_name .' SEM-'.$semester->semester_name }}</strong></td>
                                            @endforeach
                                            <td rowspan="2"><strong>TOTAL</strong></td>
                                        </tr>
                                        <tr>
                                            @foreach($allGroups as $group)
                                                @if(isset($previousSemester) && $previousSemester != $group->semester_id)
                                                    <td><strong>TOTAL</strong></td>
                                                @endif
                                                <td>{{ $group->group_name }}</td>
                                                @php
                                                    $previousSemester = $group->semester_id;
                                                @endphp
                                                @if($loop->last)
                                                    <td><strong>TOTAL</strong></td>
                                                @endif
                                            @endforeach
                                            @php
                                                unset($previousSemester)
                                            @endphp
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($admins as $admin)
                                            @php
                                                $prevTotal = 0;
                                                unset($previousSemesterId);
                                                $finalTotal = 0;
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $admin->name ?? '' }}</th>
                                                @foreach($allGroups as $group)
                                                    @if(isset($previousSemesterId) && $previousSemesterId != $group->semester_id)
                                                        <td><strong>{{ $prevTotal }}</strong></td>
                                                        @php
                                                        $finalTotal += $prevTotal;
                                                        $prevTotal = 0;
                                                        @endphp
                                                    @endif
                                                    @php
                                                    $feeTotal = \App\Models\PaidFees::where('group_id', $group->group_id)->whereHas('transaction', function($q) use ($admin){
                                                            $q->where('admin_id', $admin->admin_id)
                                                                ->where('payment_type', '2');
                                                        })->sum('total_fee');
                                                    @endphp
                                                    <td>{{ $feeTotal }}</td>
                                                    @php
                                                        $previousSemesterId = $group->semester_id;
                                                        $prevTotal += $feeTotal;
                                                    @endphp
                                                    @if($loop->last)
                                                        <td><strong>{{ $prevTotal }}</strong></td>
                                                        <td><strong>{{ $finalTotal }}</strong></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th scope="row">Payment Gateway</th>
                                            @foreach($allGroups as $group)
                                                @if(isset($previousSemesterIdForPaymentGateway) && $previousSemesterIdForPaymentGateway != $group->semester_id)
                                                    <td><strong>{{ $prevTotal }}</strong></td>
                                                    @php
                                                    $finalTotal += $prevTotal;
                                                    $prevTotal = 0;
                                                    @endphp
                                                @endif
                                                @php
                                                $feeTotal = \App\Models\PaidFees::where('group_id', $group->group_id)->whereHas('transaction', function($q){
                                                        $q->where('admin_id', '0')
                                                            ->where('payment_type', '2');
                                                    })->sum('total_fee');
                                                @endphp
                                                <td>{{ $feeTotal }}</td>
                                                @php
                                                    $previousSemesterIdForPaymentGateway = $group->semester_id;
                                                    $prevTotal += $feeTotal;
                                                @endphp
                                                @if($loop->last)
                                                    <td><strong>{{ $prevTotal }}</strong></td>
                                                    <td><strong>{{ $finalTotal }}</strong></td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        {{--@foreach($paidFees as $fee)
                                            <tr>
                                                <th scope="row">{{ $fee->transaction->admin->name ?? '' }}</th>
                                            </tr>
                                        @endforeach--}}
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                        </div>
                    </div> <!-- end card -->
                </div>
            </div>

            <div class="alert alert-danger mt-2  text-center" role="alert">
                CATEGORY WISE STATISTICAL INFORMATION OF ADMITTED STUDENTS
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td rowspan="3"><strong>CASTE</strong></td>
                                            @foreach($allSemesters as $semester)
                                                <td colspan="{{ ($semester->groups->count()+1)*2 }}"><strong>{{ $semester->course->course_name .' SEM-'.$semester->semester_name }}</strong></td>
                                            @endforeach
                                        <td rowspan="2" colspan="3"><strong>GRAND TOTAL</strong></td>
                                    </tr>
                                    <tr>
                                        @foreach($allGroups as $group)
                                            @if(isset($previousSemester) && $previousSemester != $group->semester_id)
                                                <td colspan="2"><strong>TOTAL</strong></td>
                                            @endif
                                            <td colspan="2">{{ $group->group_name }}</td>
                                            @php
                                                $previousSemester = $group->semester_id;
                                            @endphp
                                            @if($loop->last)
                                                <td colspan="2"><strong>TOTAL</strong></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach($allGroups as $group)
                                            @if(isset($previousSemester) && $previousSemester != $group->semester_id)
                                                <td><strong>M</strong></td>
                                                <td><strong>F</strong></td>
                                            @endif
                                            <td><strong>M</strong></td>
                                            <td><strong>F</strong></td>
                                            @php
                                                $previousSemester = $group->semester_id;
                                            @endphp
                                            @if($loop->last)
                                                <td><strong>M</strong></td>
                                                <td><strong>F</strong></td>
                                                <td><strong>TOTAL</strong></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $prevMaleTotal = 0;
                                        $prevFemaleTotal = 0;
                                        unset($previousSemesterId);
                                        $maleTotalCastGroupWise = [];
                                        $femaleTotalCastGroupWise = [];
                                    @endphp
                                    @foreach($casts as $cast)
                                        @php
                                            $finalMaleTotal = 0;
                                            $finalFemaleTotal = 0;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $cast->cast ?? '' }}</th>
                                            @foreach($allGroups as $key=>$group)
                                                @if(isset($previousSemesterId) && $previousSemesterId != $group->semester_id)
                                                    @if($key != 0)
                                                    <td><strong>{{ $prevMaleTotal}}</strong></td>
                                                    <td><strong>{{ $prevFemaleTotal}}</strong></td>
                                                    @endif
                                                    @php
                                                        $finalMaleTotal += $prevMaleTotal;
                                                        $finalFemaleTotal += $prevFemaleTotal;
                                                        $maleTotalCastGroupWise['SEM-'.$previousSemesterId][] = $prevMaleTotal;
                                                        $femaleTotalCastGroupWise['SEM-'.$previousSemesterId][] = $prevFemaleTotal;
                                                        $prevMaleTotal = 0;
                                                        $prevFemaleTotal = 0;
                                                    @endphp
                                                @endif
                                                @php
                                                    if($cast->cast == 'GENERAL'){
                                                        $castId = '1';
                                                    } else if($cast->cast == 'OBC'){
                                                        $castId = '2';
                                                    } else if($cast->cast == 'SC'){
                                                        $castId = '3';
                                                    } else if($cast->cast == 'ST'){
                                                        $castId = '4';
                                                    }
                                                $totalMale = \App\Models\User::where(['caste' => $castId, 'gender' => 'Male', 'is_cancelled' => '0'])->whereHas('enrollment', function($q) use ($group){
                                                        $q->where('group_id', $group->group_id);
                                                    })->count();
                                                $totalFemale = \App\Models\User::where(['caste' => $castId, 'gender' => 'Female', 'is_cancelled' => '0'])->whereHas('enrollment', function($q) use ($group){
                                                        $q->where('group_id', $group->group_id);
                                                    })->count();
                                                $maleTotalCastGroupWise[$group->group_id][] = $totalMale;
                                                $femaleTotalCastGroupWise[$group->group_id][] = $totalFemale;
                                                @endphp
                                                <td>{{ $totalMale }}</td>
                                                <td>{{ $totalFemale }}</td>
                                                @php
                                                    $previousSemesterId = $group->semester_id;
                                                    $prevMaleTotal += $totalMale;
                                                    $prevFemaleTotal += $totalFemale;
                                                @endphp
                                                @if($loop->last)
                                                    <td><strong>{{ $prevMaleTotal}}</strong></td>
                                                    <td><strong>{{ $prevFemaleTotal}}</strong></td>
                                                    @php
                                                        $maleTotalCastGroupWise['SEM-'.$previousSemesterId][] = $prevMaleTotal;
                                                        $femaleTotalCastGroupWise['SEM-'.$previousSemesterId][] = $prevFemaleTotal;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <td><strong>{{ $finalMaleTotal}}</strong></td>
                                            <td><strong>{{ $finalFemaleTotal}}</strong></td>
                                            <td><strong>{{ $finalMaleTotal + $finalFemaleTotal}}</strong></td>
                                            @php
                                                $maleTotalCastGroupWise['male-grand-total'][] = $finalMaleTotal;
                                                $femaleTotalCastGroupWise['female-grand-total'][] = $finalFemaleTotal;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    @php
                                        unset($previousSemesterId);
                                    @endphp
                                    <tr>
                                        <th scope="row">TOTAL</th>
                                        @foreach($allGroups as $group)
                                            @if(isset($previousSemesterId) && $previousSemesterId != $group->semester_id)
                                                <td><strong>{{ isset($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0 }}</strong></td>
                                                <td><strong>{{ isset($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0 }}</strong></td>
                                                @php
                                                    $grandTotalRow['SEM-'.$previousSemesterId] = (isset($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0) + (isset($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0);
                                                @endphp
                                            @endif
                                            <td><strong>{{ isset($maleTotalCastGroupWise[$group->group_id]) ? array_sum($maleTotalCastGroupWise[$group->group_id]) : 0 }}</strong></td>
                                            <td><strong>{{ isset($femaleTotalCastGroupWise[$group->group_id]) ? array_sum($femaleTotalCastGroupWise[$group->group_id]) : 0 }}</strong></td>
                                            @php
                                                $previousSemesterId = $group->semester_id;
                                                $grandTotalRow[$group->group_id] = (isset($maleTotalCastGroupWise[$group->group_id]) ? array_sum($maleTotalCastGroupWise[$group->group_id]) : 0) + (isset($femaleTotalCastGroupWise[$group->group_id]) ? array_sum($femaleTotalCastGroupWise[$group->group_id]) : 0);
                                            @endphp
                                            @if($loop->last)
                                                <td><strong>{{ isset($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0 }}</strong></td>
                                                <td><strong>{{ isset($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0 }}</strong></td>
                                                @php
                                                    $grandTotalRow['SEM-'.$previousSemesterId] = (isset($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0) + (isset($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0);
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td><strong>{{ isset($maleTotalCastGroupWise['male-grand-total']) ? array_sum($maleTotalCastGroupWise['male-grand-total']) : 0 }}</strong></td>
                                        <td><strong>{{ isset($femaleTotalCastGroupWise['female-grand-total']) ? array_sum($femaleTotalCastGroupWise['female-grand-total']) : 0 }}</strong></td>
                                        <td><strong>{{ (isset($maleTotalCastGroupWise['male-grand-total']) ? array_sum($maleTotalCastGroupWise['male-grand-total']) : 0) + (isset($femaleTotalCastGroupWise['female-grand-total']) ? array_sum($femaleTotalCastGroupWise['female-grand-total']) : 0) }}</strong></td>
                                        @php
                                            $grandTotalRow['GRAND-TOTAL-COLUMN'] = (isset($maleTotalCastGroupWise['male-grand-total']) ? array_sum($maleTotalCastGroupWise['male-grand-total']) : 0) + (isset($femaleTotalCastGroupWise['female-grand-total']) ? array_sum($femaleTotalCastGroupWise['female-grand-total']) : 0);
                                        @endphp
                                    </tr>
                                    @php
                                        unset($previousSemesterId);
                                    @endphp
                                    <tr>
                                        <th scope="row">GRAND TOTAL</th>
                                        @foreach($allGroups as $group)
                                            @if(isset($previousSemesterId) && $previousSemesterId != $group->semester_id)
                                                <td colspan="2"><strong>{{ $grandTotalRow['SEM-'.$previousSemesterId] }}</strong></td>
                                            @endif
                                            <td colspan="2"><strong>{{ $grandTotalRow[$group->group_id] }}</strong></td>
                                            @php
                                                $previousSemesterId = $group->semester_id;
                                            @endphp
                                            @if($loop->last)
                                                <td colspan="2"><strong>{{ $grandTotalRow['SEM-'.$previousSemesterId] }}</strong></td>
                                            @endif
                                        @endforeach
                                        <td colspan="2"><strong>{{ (isset($maleTotalCastGroupWise['male-grand-total']) ? array_sum($maleTotalCastGroupWise['male-grand-total']) : 0) + (isset($femaleTotalCastGroupWise['female-grand-total']) ? array_sum($femaleTotalCastGroupWise['female-grand-total']) : 0) }}</strong></td>
                                        <td><strong>{{ $grandTotalRow['GRAND-TOTAL-COLUMN'] }}</strong></td>
                                    </tr>
                                </tbody>    
                            </table>
                        </div> <!-- end table-responsive-->
                    </div>
                </div> <!-- end card -->
            </div>
        </div>
        @php
            unset($previousSemester);    
            unset($previousSemesterId);
            unset($grandTotalRow);
            unset($maleTotalCastGroupWise);
            unset($femaleTotalCastGroupWise);
        @endphp
        <div class="alert alert-danger mt-2  text-center" role="alert">
            FEE RETURNS BY ALL USER'S
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0 table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td rowspan="2"><strong>User Name</strong></td>
                                        @foreach($allSemesters as $semester)
                                            <td colspan="{{ $semester->groups->count()+1 }}"><strong>{{ $semester->course->course_name .' SEM-'.$semester->semester_name }}</strong></td>
                                        @endforeach
                                        <td rowspan="2"><strong>TOTAL</strong></td>
                                    </tr>
                                    <tr>
                                        @foreach($allGroups as $group)
                                            @if(isset($returnFeePreviousSemester) && $returnFeePreviousSemester != $group->semester_id)
                                                <td><strong>TOTAL</strong></td>
                                            @endif
                                            <td>{{ $group->group_name }}</td>
                                            @php
                                                $returnFeePreviousSemester = $group->semester_id;
                                            @endphp
                                            @if($loop->last)
                                                <td><strong>TOTAL</strong></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                        @php
                                            $returnFeePrevTotal = 0;
                                            unset($returnFeePreviousSemesterId);
                                            $returnFeeFinalTotal = 0;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $admin->name ?? '' }}</th>
                                            @foreach($allGroups as $group)
                                                @if(isset($returnFeePreviousSemesterId) && $returnFeePreviousSemesterId != $group->semester_id)
                                                    <td><strong>{{ $returnFeePrevTotal }}</strong></td>
                                                    @php
                                                    $returnFeeFinalTotal += $returnFeePrevTotal;
                                                    $returnFeePrevTotal = 0;
                                                    @endphp
                                                @endif
                                                @php
                                                $feeTotal = \App\Models\PaidFees::where('group_id', $group->group_id)->whereHas('transaction', function($q) use ($admin){
                                                        $q->where('admin_id', $admin->admin_id)
                                                            ->where('payment_type', '3');
                                                    })->sum('total_fee');
                                                @endphp
                                                <td>{{ $feeTotal }}</td>
                                                @php
                                                    $returnFeePreviousSemesterId = $group->semester_id;
                                                    $returnFeePrevTotal += $feeTotal;
                                                @endphp
                                                @if($loop->last)
                                                    <td><strong>{{ $returnFeePrevTotal }}</strong></td>
                                                    <td><strong>{{ $returnFeeFinalTotal }}</strong></td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
                    </div>
                </div> <!-- end card -->
            </div>
        </div>
    </div>

    <div class="alert alert-danger mt-2  text-center" role="alert">
        CATEGORY WISE STATISTICAL INFORMATION OF CANCELLED STUDENTS
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 table-bordered table-hover">
                        <thead>
                            <tr>
                                <td rowspan="3"><strong>CASTE</strong></td>
                                    @foreach($allSemesters as $semester)
                                        <td colspan="{{ ($semester->groups->count()+1)*2 }}"><strong>{{ $semester->course->course_name .' SEM-'.$semester->semester_name }}</strong></td>
                                    @endforeach
                                <td rowspan="2" colspan="3"><strong>GRAND TOTAL</strong></td>
                            </tr>
                            <tr>
                                @foreach($allGroups as $group)
                                    @if(isset($previousSemester) && $previousSemester != $group->semester_id)
                                        <td colspan="2"><strong>TOTAL</strong></td>
                                    @endif
                                    <td colspan="2">{{ $group->group_name }}</td>
                                    @php
                                        $previousSemester = $group->semester_id;
                                    @endphp
                                    @if($loop->last)
                                        <td colspan="2"><strong>TOTAL</strong></td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($allGroups as $group)
                                    @if(isset($previousSemester) && $previousSemester != $group->semester_id)
                                        <td><strong>M</strong></td>
                                        <td><strong>F</strong></td>
                                    @endif
                                    <td><strong>M</strong></td>
                                    <td><strong>F</strong></td>
                                    @php
                                        $previousSemester = $group->semester_id;
                                    @endphp
                                    @if($loop->last)
                                        <td><strong>M</strong></td>
                                        <td><strong>F</strong></td>
                                        <td><strong>TOTAL</strong></td>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($casts as $cast)
                                @php
                                    $prevMaleTotal = 0;
                                    $prevFemaleTotal = 0;
                                    unset($previousSemesterId);
                                    $finalMaleTotal = 0;
                                    $finalFemaleTotal = 0;
                                    $maleTotalCastGroupWise = [];
                                    $femaleTotalCastGroupWise = [];
                                @endphp
                                <tr>
                                    <th scope="row">{{ $cast->cast ?? '' }}</th>
                                    @foreach($allGroups as $group)
                                        @if(isset($previousSemesterId) && $previousSemesterId != $group->semester_id)
                                            <td><strong>{{ $prevMaleTotal}}</strong></td>
                                            <td><strong>{{ $prevFemaleTotal}}</strong></td>
                                            @php
                                                $finalMaleTotal += $prevMaleTotal;
                                                $finalFemaleTotal += $prevFemaleTotal;
                                                $maleTotalCastGroupWise['SEM-'.$previousSemesterId][] = $prevMaleTotal;
                                                $femaleTotalCastGroupWise['SEM-'.$previousSemesterId][] = $prevFemaleTotal;
                                                $prevMaleTotal = 0;
                                                $prevFemaleTotal = 0;
                                            @endphp
                                        @endif
                                        @php
                                            if($cast->cast == 'GENERAL'){
                                                $castId = '1';
                                            } else if($cast->cast == 'OBC'){
                                                $castId = '2';
                                            } else if($cast->cast == 'SC'){
                                                $castId = '3';
                                            } else if($cast->cast == 'ST'){
                                                $castId = '4';
                                            }
                                            $totalMale = \App\Models\User::where(['caste' => $castId, 'gender' => 'Male', 'is_cancelled' => '1'])->whereHas('enrollment', function($q) use ($group){
                                                $q->where('group_id', $group->group_id);
                                            })->count();
                                            $totalFemale = \App\Models\User::where(['caste' => $castId, 'gender' => 'Female', 'is_cancelled' => '1'])->whereHas('enrollment', function($q) use ($group){
                                                $q->where('group_id', $group->group_id);
                                            })->count();
                                            $maleTotalCastGroupWise[$group->group_id][] = $totalMale;
                                            $femaleTotalCastGroupWise[$group->group_id][] = $totalFemale;
                                        @endphp
                                        <td>{{ $totalMale }}</td>
                                        <td>{{ $totalFemale }}</td>
                                        @php
                                            $previousSemesterId = $group->semester_id;
                                            $prevMaleTotal += $totalMale;
                                            $prevFemaleTotal += $totalFemale;
                                        @endphp
                                        @if($loop->last)
                                            <td><strong>{{ $prevMaleTotal}}</strong></td>
                                            <td><strong>{{ $prevFemaleTotal}}</strong></td>
                                            @php
                                                $maleTotalCastGroupWise['SEM-'.$previousSemesterId][] = $prevMaleTotal;
                                                $femaleTotalCastGroupWise['SEM-'.$previousSemesterId][] = $prevFemaleTotal;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <td><strong>{{ $finalMaleTotal}}</strong></td>
                                    <td><strong>{{ $finalFemaleTotal}}</strong></td>
                                    <td><strong>{{ $finalMaleTotal + $finalFemaleTotal}}</strong></td>
                                    @php
                                        $maleTotalCastGroupWise['male-grand-total'][] = $finalMaleTotal;
                                        $femaleTotalCastGroupWise['female-grand-total'][] = $finalFemaleTotal;
                                    @endphp
                                </tr>
                            @endforeach
                            @php
                                unset($previousSemesterId);
                            @endphp
                            <tr>
                                <th scope="row">TOTAL</th>
                                @foreach($allGroups as $group)
                                    @if(isset($previousSemesterId) && $previousSemesterId != $group->semester_id)
                                        <td><strong>{{ isset ($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0 }}</strong></td>
                                        <td><strong>{{ isset($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0 }}</strong></td>
                                        @php
                                            $grandTotalRow['SEM-'.$previousSemesterId] = (isset($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0) + (isset($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0);
                                        @endphp
                                    @endif
                                    <td><strong>{{ isset($maleTotalCastGroupWise[$group->group_id]) ? array_sum($maleTotalCastGroupWise[$group->group_id]) : 0 }}</strong></td>
                                    <td><strong>{{ isset($femaleTotalCastGroupWise[$group->group_id]) ? array_sum($femaleTotalCastGroupWise[$group->group_id]) : 0 }}</strong></td>
                                    @php
                                        $previousSemesterId = $group->semester_id;
                                        $grandTotalRow[$group->group_id] = (isset($maleTotalCastGroupWise[$group->group_id]) ? array_sum($maleTotalCastGroupWise[$group->group_id]) : 0) + (isset($femaleTotalCastGroupWise[$group->group_id]) ? array_sum($femaleTotalCastGroupWise[$group->group_id]) : 0);
                                    @endphp
                                    @if($loop->last)
                                        <td><strong>{{ isset($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0 }}</strong></td>
                                        <td><strong>{{ isset($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0 }}</strong></td>
                                        @php
                                            $grandTotalRow['SEM-'.$previousSemesterId] = (isset($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($maleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0) + (isset($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) ? array_sum($femaleTotalCastGroupWise['SEM-'.$previousSemesterId]) : 0);
                                        @endphp
                                    @endif
                                @endforeach
                                <td><strong>{{ isset($maleTotalCastGroupWise['male-grand-total']) ? array_sum($maleTotalCastGroupWise['male-grand-total']) : 0 }}</strong></td>
                                <td><strong>{{ isset($femaleTotalCastGroupWise['female-grand-total']) ? array_sum($femaleTotalCastGroupWise['female-grand-total']) : 0 }}</strong></td>
                                <td><strong>{{ (isset($maleTotalCastGroupWise['male-grand-total']) ? array_sum($maleTotalCastGroupWise['male-grand-total']) : 0) + (isset($femaleTotalCastGroupWise['female-grand-total']) ? array_sum($femaleTotalCastGroupWise['female-grand-total']) : 0) }}</strong></td>
                                @php
                                    $grandTotalRow['GRAND-TOTAL-COLUMN'] = (isset($maleTotalCastGroupWise['male-grand-total']) ? array_sum($maleTotalCastGroupWise['male-grand-total']) : 0) + (isset($femaleTotalCastGroupWise['female-grand-total']) ? array_sum($femaleTotalCastGroupWise['female-grand-total']) : 0);
                                @endphp
                            </tr>
                            @php
                                unset($previousSemesterId);
                            @endphp
                            <tr>
                                <th scope="row">GRAND TOTAL</th>
                                @foreach($allGroups as $group)
                                    @if(isset($previousSemesterId) && $previousSemesterId != $group->semester_id)
                                        <td colspan="2"><strong>{{ $grandTotalRow['SEM-'.$previousSemesterId] }}</strong></td>
                                    @endif
                                    <td colspan="2"><strong>{{ $grandTotalRow[$group->group_id] }}</strong></td>
                                    @php
                                        $previousSemesterId = $group->semester_id;
                                    @endphp
                                    @if($loop->last)
                                        <td colspan="2"><strong>{{ $grandTotalRow['SEM-'.$previousSemesterId] }}</strong></td>
                                    @endif
                                @endforeach
                                <td colspan="2"><strong>{{ (isset($maleTotalCastGroupWise['male-grand-total']) ? array_sum($maleTotalCastGroupWise['male-grand-total']) : 0) + (isset($femaleTotalCastGroupWise['female-grand-total']) ? array_sum($femaleTotalCastGroupWise['female-grand-total']) : 0) }}</strong></td>
                                <td><strong>{{ $grandTotalRow['GRAND-TOTAL-COLUMN'] }}</strong></td>
                            </tr>
                        </tbody>    
                    </table>
                </div> <!-- end table-responsive-->
            </div>
        </div> <!-- end card -->
    </div>
</div>
</div>
</div> <!-- container -->

</div> <!-- content -->
@endsection
