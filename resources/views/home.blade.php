@extends('layouts.app')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            {{-- <form class="d-flex align-items-center mb-3">
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
                            </form> --}}
                        </div>
                        <h4 class="page-title">Welcome, {{ auth()->guard('web')->user()->name }}</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            @if (getUserField('is_form_fees_paid') == 1 &&
                getUserField('is_completed_registration') == 1 &&
                getUserField('is_admission_approved') == 1 && getUserField('is_initial_college_fees_paid') == 1 && $enrollmentDetails->is_fees_paid == 1)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mb-3">Acedemic Details</h4>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <h5 class="mt-0">Academic Year:</h5>
                                            <p>{{ $enrollmentDetails->academicYear->year ?? "" }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <h5 class="mt-0">Course:</h5>
                                            <p>{{ $enrollmentDetails->course->course_name ?? "" }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <h5 class="mt-0">Semester:</h5>
                                            <p>{{ $enrollmentDetails->semester->semester_name ?? "" }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <h5 class="mt-0">Group:</h5>
                                            <p>{{ $enrollmentDetails->group->group_name ?? "" }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <h5 class="mt-0">Roll No:</h5>
                                            <p>{{ $enrollmentDetails->roll_no ?? "" }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <h5 class="mt-0">Fees Status:</h5>
                                            <p>
                                                @if ($enrollmentDetails->is_fees_paid == 1)
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif ($enrollmentDetails->is_fees_paid == 0)
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="fe-heart font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">$<span data-plugin="counterup">58,947</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Total Revenue</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">127</span></h3>
                                            <p class="text-muted mb-1 text-truncate">Today's Sales</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="fe-bar-chart-line- font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">0.58</span>%</h3>
                                            <p class="text-muted mb-1 text-truncate">Conversion</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                            <i class="fe-eye font-22 avatar-title text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup">78.41</span>k</h3>
                                            <p class="text-muted mb-1 text-truncate">Today's Visits</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->
                </div>
                <!-- end row-->

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                    </div>
                                </div>

                                <h4 class="header-title mb-0">Total Revenue</h4>

                                <div class="widget-chart text-center" dir="ltr">

                                    <div id="total-revenue" class="mt-0" data-colors="#f1556c"></div>

                                    <h5 class="text-muted mt-0">Total sales made today</h5>
                                    <h2>$178</h2>

                                    <p class="text-muted w-75 mx-auto sp-line-2">Traditional heading elements are designed
                                        to
                                        work best in the meat of your page content.</p>

                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                            <h4><i class="fe-arrow-down text-danger me-1"></i>$7.8k</h4>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                            <h4><i class="fe-arrow-up text-success me-1"></i>$1.4k</h4>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                            <h4><i class="fe-arrow-down text-danger me-1"></i>$15k</h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col-->

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body pb-2">
                                <div class="float-end d-none d-md-inline-block">
                                    <div class="btn-group mb-2">
                                        <button type="button" class="btn btn-xs btn-light">Today</button>
                                        <button type="button" class="btn btn-xs btn-light">Weekly</button>
                                        <button type="button" class="btn btn-xs btn-secondary">Monthly</button>
                                    </div>
                                </div>

                                <h4 class="header-title mb-3">Sales Analytics</h4>

                                <div dir="ltr">
                                    <div id="sales-analytics" class="mt-4" data-colors="#1abc9c,#4a81d4"></div>
                                </div>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                    </div>
                                </div>

                                <h4 class="header-title mb-3">Top 5 Users Balances</h4>

                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-nowrap table-centered m-0">

                                        <thead class="table-light">
                                            <tr>
                                                <th colspan="2">Profile</th>
                                                <th>Currency</th>
                                                <th>Balance</th>
                                                <th>Reserved in orders</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width: 36px;">
                                                    <img src="assets/images/users/user-2.jpg" alt="contact-img"
                                                        title="contact-img" class="rounded-circle avatar-sm" />
                                                </td>

                                                <td>
                                                    <h5 class="m-0 fw-normal">Tomaslau</h5>
                                                    <p class="mb-0 text-muted"><small>Member Since 2017</small></p>
                                                </td>

                                                <td>
                                                    <i class="mdi mdi-currency-btc text-primary"></i> BTC
                                                </td>

                                                <td>
                                                    0.00816117 BTC
                                                </td>

                                                <td>
                                                    0.00097036 BTC
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-plus"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-danger"><i
                                                            class="mdi mdi-minus"></i></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 36px;">
                                                    <img src="assets/images/users/user-3.jpg" alt="contact-img"
                                                        title="contact-img" class="rounded-circle avatar-sm" />
                                                </td>

                                                <td>
                                                    <h5 class="m-0 fw-normal">Erwin E. Brown</h5>
                                                    <p class="mb-0 text-muted"><small>Member Since 2017</small></p>
                                                </td>

                                                <td>
                                                    <i class="mdi mdi-currency-eth text-primary"></i> ETH
                                                </td>

                                                <td>
                                                    3.16117008 ETH
                                                </td>

                                                <td>
                                                    1.70360009 ETH
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-plus"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-danger"><i
                                                            class="mdi mdi-minus"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 36px;">
                                                    <img src="assets/images/users/user-4.jpg" alt="contact-img"
                                                        title="contact-img" class="rounded-circle avatar-sm" />
                                                </td>

                                                <td>
                                                    <h5 class="m-0 fw-normal">Margeret V. Ligon</h5>
                                                    <p class="mb-0 text-muted"><small>Member Since 2017</small></p>
                                                </td>

                                                <td>
                                                    <i class="mdi mdi-currency-eur text-primary"></i> EUR
                                                </td>

                                                <td>
                                                    25.08 EUR
                                                </td>

                                                <td>
                                                    12.58 EUR
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-plus"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-danger"><i
                                                            class="mdi mdi-minus"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 36px;">
                                                    <img src="assets/images/users/user-5.jpg" alt="contact-img"
                                                        title="contact-img" class="rounded-circle avatar-sm" />
                                                </td>

                                                <td>
                                                    <h5 class="m-0 fw-normal">Jose D. Delacruz</h5>
                                                    <p class="mb-0 text-muted"><small>Member Since 2017</small></p>
                                                </td>

                                                <td>
                                                    <i class="mdi mdi-currency-cny text-primary"></i> CNY
                                                </td>

                                                <td>
                                                    82.00 CNY
                                                </td>

                                                <td>
                                                    30.83 CNY
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-plus"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-danger"><i
                                                            class="mdi mdi-minus"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 36px;">
                                                    <img src="assets/images/users/user-6.jpg" alt="contact-img"
                                                        title="contact-img" class="rounded-circle avatar-sm" />
                                                </td>

                                                <td>
                                                    <h5 class="m-0 fw-normal">Luke J. Sain</h5>
                                                    <p class="mb-0 text-muted"><small>Member Since 2017</small></p>
                                                </td>

                                                <td>
                                                    <i class="mdi mdi-currency-btc text-primary"></i> BTC
                                                </td>

                                                <td>
                                                    2.00816117 BTC
                                                </td>

                                                <td>
                                                    1.00097036 BTC
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-plus"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-danger"><i
                                                            class="mdi mdi-minus"></i></a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                    </div>
                                </div>

                                <h4 class="header-title mb-3">Revenue History</h4>

                                <div class="table-responsive">
                                    <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                        <thead class="table-light">
                                            <tr>
                                                <th>Marketplaces</th>
                                                <th>Date</th>
                                                <th>Payouts</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">Themes Market</h5>
                                                </td>

                                                <td>
                                                    Oct 15, 2018
                                                </td>

                                                <td>
                                                    $5848.68
                                                </td>

                                                <td>
                                                    <span class="badge bg-soft-warning text-warning">Upcoming</span>
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">Freelance</h5>
                                                </td>

                                                <td>
                                                    Oct 12, 2018
                                                </td>

                                                <td>
                                                    $1247.25
                                                </td>

                                                <td>
                                                    <span class="badge bg-soft-success text-success">Paid</span>
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">Share Holding</h5>
                                                </td>

                                                <td>
                                                    Oct 10, 2018
                                                </td>

                                                <td>
                                                    $815.89
                                                </td>

                                                <td>
                                                    <span class="badge bg-soft-success text-success">Paid</span>
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">Envato's Affiliates</h5>
                                                </td>

                                                <td>
                                                    Oct 03, 2018
                                                </td>

                                                <td>
                                                    $248.75
                                                </td>

                                                <td>
                                                    <span class="badge bg-soft-danger text-danger">Overdue</span>
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">Marketing Revenue</h5>
                                                </td>

                                                <td>
                                                    Sep 21, 2018
                                                </td>

                                                <td>
                                                    $978.21
                                                </td>

                                                <td>
                                                    <span class="badge bg-soft-warning text-warning">Upcoming</span>
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="m-0 fw-normal">Advertise Revenue</h5>
                                                </td>

                                                <td>
                                                    Sep 15, 2018
                                                </td>

                                                <td>
                                                    $358.10
                                                </td>

                                                <td>
                                                    <span class="badge bg-soft-success text-success">Paid</span>
                                                </td>

                                                <td>
                                                    <a href="javascript: void(0);" class="btn btn-xs btn-light"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div> <!-- end .table-responsive-->
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div> --}}
                <!-- end row -->
            @elseif(getUserField('is_form_fees_paid') == 1 && getUserField('is_completed_registration') == 0)
                @php
                    $userData = getUserData();
                @endphp
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-3 text-center">Admission Form</h3>
                                <form id="admissionForm" method="post" action="{{ route('admission') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Student Information</h5>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="student_name" class="form-label">Student Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="student_name" name="student_name"
                                                        class="form-control" placeholder="Enter Student Name"
                                                        value="{{ $userData->student_name }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="father_name" class="form-label">Father Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="father_name" name="father_name"
                                                        class="form-control" placeholder="Enter Father Name"
                                                        value="{{ $userData->father_name }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="surname" class="form-label">Surname <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="surname" name="surname"
                                                        class="form-control" placeholder="Enter Surname"
                                                        value="{{ $userData->surname }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" id="email" class="form-control"
                                                        placeholder="Enter Email" value="{{ $userData->email }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="contact_no" class="form-label">Contact No <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="contact_no" name="contact_no"
                                                        class="form-control" placeholder="Enter Contact No"
                                                        value="{{ $userData->contact_no }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label">Gender <span
                                                            class="text-danger">*</span></label>
                                                    <div class="row">
                                                        <div class="col-xl-3">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender" id="male" value="Male"
                                                                    checked="">
                                                                <label class="form-check-label"
                                                                    for="male">Male</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender" id="female" value="Female">
                                                                <label class="form-check-label"
                                                                    for="female">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="birth_date" class="form-label">Birth Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control datepicker"
                                                        name="birth_date" data-provide="datepicker"
                                                        placeholder="DD-MM-YYYY" data-date-autoclose="true"
                                                        data-date-format="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="caste" class="form-label">Caste <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="caste" name="caste">
                                                        <option value="" selected="">Please Select Caste</option>
                                                        <option value="1">General</option>
                                                        <option value="2">OBC</option>
                                                        <option value="3">SC</option>
                                                        <option value="4">ST</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="aadhar_card_no" class="form-label">Aadhar Card No <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="aadhar_card_no" name="aadhar_card_no"
                                                        class="form-control" placeholder="Enter Aadhar Card No"
                                                        value="{{ $userData->aadhar_card_no }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="student_photo" class="form-label">Student Photo <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" id="student_photo" name="student_photo"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="student_sign" class="form-label">Student Sign <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" id="student_sign" name="student_sign"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Current Address</h5>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="address" name="address" placeholder="Enter Address" value="{{ $userData->address }}" required>
                                                @error('address')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="cur_city" class="form-label">City <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="cur_city" name="cur_city" placeholder="Enter City" value="{{ $userData->cur_city }}" required>
                                                @error('cur_city')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="cur_taluko" class="form-label">Taluko <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="cur_taluko" name="cur_taluko" placeholder="Enter Taluko" value="{{ $userData->cur_taluko }}" required>
                                                @error('cur_taluko')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="cur_district" class="form-label">District <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="cur_district" name="cur_district" placeholder="Enter District" value="{{ $userData->cur_district }}" required>
                                                @error('cur_district')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="cur_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="cur_pincode" name="cur_pincode" placeholder="Enter Pincode" value="{{ $userData->cur_district }}" required>
                                                @error('cur_pincode')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>

                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Permanent Address</h5>
                                        <div class="row mb-3">
                                            <div class="col-lg-6">
                                                <div class="form-check pt-1">
                                                    <input type="checkbox" class="form-check-input current_address" id="checkbox-current-address">
                                                    <label class="form-check-label current_address" for="checkbox-current-address">Same As Current Address</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="per_address" class="form-label">Address <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="per_address" name="per_address" placeholder="Enter Address" value="{{ $userData->per_address }}" required>
                                                @error('per_address')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="per_city" class="form-label">City <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="per_city" name="per_city" placeholder="Enter City" value="{{ $userData->per_city }}" required>
                                                @error('per_city')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="per_taluko" class="form-label">Taluko <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="per_taluko" name="per_taluko" placeholder="Enter Taluko" value="{{ $userData->per_taluko }}" required>
                                                @error('per_taluko')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="per_district" class="form-label">District <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="per_district" name="per_district" placeholder="Enter District" value="{{ $userData->per_district }}" required>
                                                @error('per_district')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="per_pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" id="per_pincode" name="per_pincode" placeholder="Enter Pincode" value="{{ $userData->per_pincode }}" required>
                                                @error('per_pincode')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>

                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Admission Information</h5>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="course" class="form-label">Course <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="course" name="course">
                                                        <option value="" selected="">Please Select Course</option>
                                                        @if(!empty($courses))
                                                            @foreach ($courses as $course)
                                                            <option value="{{$course->course_id}}" @if($course->course_id == $enrollmentDetails->course_id) {{'selected="selected"'}} @endif>{{$course->course_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="semester" class="form-label">Semester <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="semester" name="semester">
                                                        <option value="" selected="">Please Select Semester</option>
                                                        @if(!empty($semesters) && count($semesters) > 0)
                                                            @foreach ($semesters as $semester)
                                                                <option value="{{ $semester->semester_id }}" @if($semester->semester_id == $enrollmentDetails->semester_id) {{"selected='selected'"}}@endif> {{ $semester->semester_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="group" class="form-label">Group <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" id="group" name="group">
                                                        <option value="" selected="">Please Select Group</option>
                                                        @if(!empty($groups) && count($groups) > 0)
                                                            @foreach ($groups as $group)
                                                                <option value="{{$group->group_id}}" @if($group->group_id == $enrollmentDetails->group_id){{"selected='selected'"}}@endif> {{$group->group_name}}</option>                                                            
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">12th School Information</h5>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="school_name" class="form-label">School Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="school_name" name="school_name"
                                                        class="form-control" placeholder="Enter School Name"
                                                        value="{{ $userData->school_name }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="join_date" class="form-label">School Join Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control datepicker"
                                                        name="join_date" data-provide="datepicker"
                                                        placeholder="DD-MM-YYYY" data-date-autoclose="true"
                                                        data-date-format="dd-mm-yyyy">

                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="leaving_date" class="form-label">School Leaving Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control datepicker"
                                                        name="leaving_date" data-provide="datepicker"
                                                        placeholder="DD-MM-YYYY" data-date-autoclose="true"
                                                        data-date-format="dd-mm-yyyy">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="marksheet_no" class="form-label">12th Marksheet Seat No <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="marksheet_no" name="marksheet_no"
                                                        class="form-control" placeholder="Enter 12th Marksheet Seat No"
                                                        value="{{ $userData->marksheet_no_12 }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="exam_center" class="form-label">Exam Center <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="exam_center" name="exam_center"
                                                        class="form-control" placeholder="Enter Exam Center"
                                                        value="{{ $userData->exam_center }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="passing_month" class="form-label">Passing Month<span class="text-danger">*</span></label>
                                                    <input type='text' class="form-control"  id='datepicker' name="passing_month" name="datepicker" placeholder="MM" value="{{ $userData->passing_month }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="passing_year" class="form-label">Passing Year<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="passing_year"
                                                        data-provide="datepicker" placeholder="YYYY"
                                                        data-date-format="yyyy" data-date-min-view-mode="2"
                                                        data-date-autoclose="true">

                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="mb-3">
                                                    <label for="obtained_marks" class="form-label"> Total Obtained Marks
                                                        Out of Total Theory Marks <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="obtained_marks" name="obtained_marks"
                                                        class="form-control" placeholder="Enter Obtained Marks"
                                                        value="{{ $userData->obtained_marks }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row mt-1 mb-2">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                    class="fe-check-circle me-1"></i> Save</button>
                                            <a href="{{ route('admin.students') }}"
                                                class="btn btn-light waves-effect waves-light m-1"><i
                                                    class="fe-x me-1"></i>
                                                Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(getUserField('is_form_fees_paid') == 1 &&
                getUserField('is_completed_registration') == 1 &&
                getUserField('is_admission_approved') == 0)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h4 class="mb-2 mt-5">Your admission is under review you will be notified once the review
                                    process is completed.</h4>
                                <h4 class="mb-5 mt-5"><b>ડોક્યુમેન્ટ વેરિફિકેશન કરાવવા માટે ત્રણ દિવસમાં કોલેજમાં રૂબરૂ આવી ડોક્યુમેન્ટ માર્કશીટ વેરિફિકેશન કરાવું ત્યારબાદ કોલેજમાંથી એડમિશન એપ્રુવલ મળશે.</b></h4>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(getUserField('is_form_fees_paid') == 1 && getUserField('is_completed_registration') == 1 && getUserField('is_admission_approved') == 1 && getUserField('is_initial_college_fees_paid') == 0 && $enrollmentDetails->is_fees_paid == 0 )
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="mb-3 mt-5">Welcome to The HNSB Ltd Science College, Himatnagar.</h3>
                                <h4 class="mb-3">Congratulations! Your admission has been approved.
                                </h4>
                                <h4 class="mb-3">Please pay college fees before the cut off time.</h4>
                                    @php
                                        // $cutOffDate = getGeneralSettingByKey('collegefeescutoffdate');
                                        // $cutOffExtentionDate = getGeneralSettingByKey('collegefeescutoffextentiondate', true);
                                        $collegeFees = getCollegeFees();
                                        $cutOffDate = $collegeFees['cutoff_date'] ?? '';
                                    @endphp
                                    @if (!empty($cutOffDate))
                                        <h5 class="mb-1"><b>Last day to pay college fees is: {{$cutOffDate}}.</b></h5>
                                    @endif
                                    @if (empty($cutOffDate))
                                        <button type="button"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Pay College Fees</button>
                                        <p class="mb-0 text-muted"><small>Cut off time is not configured yet. Please contact HNSB for more information!</small></p>
                                    @elseif (\Carbon\Carbon::parse($cutOffDate)->startOfDay()  >= \Carbon\Carbon::now()->startOfDay())
                                        <form method="post" action="{{ route('payCollegeFees') }}">
                                            @csrf
                                        <h5 class="mb-3"><b>Fees Amount: {{$collegeFees['total'] ?? ''}}.</b></h5>
                                            <div class="form-check">
                                                <label class="form-check-label" for="checkbox-signup">By clicking "Pay College Fees" button, I agree to the <a href="{{URL::to('terms-and-condions')}}" class="text-dark" target="_blank">Terms and Conditions</a>.</label>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-5">Pay College Fees</button>
                                        </form>
                                    @else
                                        @if(!empty($collegeFees['cutoff_extension_date']) && $collegeFees['cutoff_extension_status'] == 1 && \Carbon\Carbon::parse($collegeFees['cutoff_extension_date']->startOfDay())  >= \Carbon\Carbon::now()->startOfDay())
                                        <h5 class=""><b>Fees Amount: Rs.{{$collegeFees['total'].'/-' ?? ''}}</b></h5>
                                        <h5 class=""><b>Extended date to pay college fees is: {{$collegeFees['cutoff_extension_date']}}.</b></h5>
                                        <h5 class="mb-3"><b>Late Fees Amount: Rs.{{$collegeFees['late_fees'].'/-' ?? ''}}</b></h5>
                                        <h5 class="mb-3"><b>Total Payable Fees Amount: Rs.{{$collegeFees['total'] + $collegeFees['late_fees'].'/-' ?? ''}}</b></h5>

                                            <form method="post" action="{{ route('payCollegeFees') }}">
                                            @csrf
                                            <div class="form-check">
                                                <label class="form-check-label" for="checkbox-signup">By clicking "Pay College Fees with Late Fees" button, I agree to the <a href="{{URL::to('terms-and-condions')}}" class="text-dark" target="_blank">Terms and Conditions</a>.</label>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-5">Pay College Fees with Late Fees</button>
                                        </form>
                                        @else
                                         <button type="button"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Pay College Fees</button>
                                        <p class="mb-0 text-muted"><small>Cut off time is over</small></p>
                                        @endif
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(getUserField('is_form_fees_paid') == 1 && getUserField('is_completed_registration') == 1 && getUserField('is_admission_approved') == 1 && getUserField('is_initial_college_fees_paid') == 1 && $enrollmentDetails->is_fees_paid == 0 )
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="mb-3 mt-5">Welcome to The HNSB Ltd Science College, Himatnagar.</h3>
                                <h4 class="mb-3">Please pay college fees for {{ $enrollmentDetails->course->course_name ?? '' }}, {{ $enrollmentDetails->semester->semester_name ?? '' }}, {{ $enrollmentDetails->group->group_name ?? '' }} ({{ $enrollmentDetails->academicYear->year ?? '' }}).
                                </h4>
                                <h4 class="mb-3">Please pay college fees before the cut off time.</h4>
                                    @php
                                        // $cutOffDate = getGeneralSettingByKey('collegefeescutoffdate');
                                        // $cutOffExtentionDate = getGeneralSettingByKey('collegefeescutoffextentiondate', true);
                                        $collegeFees = getCollegeFees();
                                        $cutOffDate = $collegeFees['cutoff_date'] ?? '';
                                    @endphp
                                    @if (!empty($cutOffDate))
                                        <h5 class="mb-1"><b>Last day to pay college fees is: {{$cutOffDate}}.</b></h5>
                                    @endif
                                    @if (empty($collegeFees['total']))
                                        <button type="button"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Pay College Fees</button>
                                        <p class="mb-0 text-muted"><small>College fee is not configured yet. Please contact HNSB for more information!</small></p>
                                    @elseif (empty($cutOffDate))
                                        <button type="button"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Pay College Fees</button>
                                        <p class="mb-0 text-muted"><small>Cut off time is not configured yet. Please contact HNSB for more information!</small></p>
                                    @elseif (\Carbon\Carbon::parse($cutOffDate)->startOfDay()  >= \Carbon\Carbon::now()->startOfDay())
                                        <form method="post" action="{{ route('payCollegeFees') }}">
                                            @csrf
                                        <h5 class="mb-3"><b>Fees Amount: {{$collegeFees['total'] ?? ''}}.</b></h5>
                                            <button type="submit"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-5">Pay College Fees</button>
                                        </form>
                                    @else
                                        @if(!empty($collegeFees['cutoff_extension_date']) && $collegeFees['cutoff_extension_status'] == 1 && \Carbon\Carbon::parse($collegeFees['cutoff_extension_date'])->startOfDay()  >= \Carbon\Carbon::now()->startOfDay())
                                        <h5 class=""><b>Fees Amount: Rs.{{$collegeFees['total'].'/-' ?? ''}}</b></h5>
                                        <h5 class=""><b>Extended date to pay college fees is: {{$collegeFees['cutoff_extension_date']}}.</b></h5>
                                        <h5 class="mb-3"><b>Late Fees Amount: Rs.{{$collegeFees['late_fees'].'/-' ?? ''}}</b></h5>
                                        <h5 class="mb-3"><b>Total Payable Fees Amount: Rs.{{$collegeFees['total'] + $collegeFees['late_fees'].'/-' ?? ''}}</b></h5>

                                            <form method="post" action="{{ route('payCollegeFees') }}">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-5">Pay College Fees with Late Fees</button>
                                        </form>
                                        @else
                                         <button type="button"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Pay College Fees</button>
                                        <p class="mb-0 text-muted"><small>Cut off time is over</small></p>
                                        @endif
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(getUserField('is_form_fees_paid') == 1 && getUserField('is_completed_registration') == 1 && getUserField('is_admission_approved') == 2)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h4 class="mb-5 mt-5">Your admission application has been rejected and below is the reason for rejection.</h4>
                                <p>{{getUserField('admission_rejection_reason')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="mb-3 mt-5">Welcome to The HNSB Ltd Science College, Himatnagar.</h3>
                                <h4 class="mb-3">Thank you for registering the and showing your interest in our college.
                                </h4>
                                <h4 class="mb-3">You can continue with the admission process by paying admission form
                                    fees by clicking the below button.</h4>
                                    @php
                                        $admissionFee = App\Models\AdmissionFee::where('academic_year_id', $enrollmentDetails->academic_year_id)->where('course_id', $enrollmentDetails->course_id)->where('semester_id', $enrollmentDetails->semester_id)->first();
                                        $admissionCutOffDate = $admissionFee->cutoff_date ?? '';
                                        $admissionFees = $admissionFee->admission_fees ?? 0;
                                    @endphp
                                    @if (!empty($admissionCutOffDate))
                                        <h5 class="mb-3"><b>Last day to pay admission fees is: {{$admissionCutOffDate}}.</b></h5>
                                        <h5 class="mb-3"><b>Admission fees is: ₹{{$admissionFees}}.</b></h5>
                                    @endif
                                    @if (empty($admissionCutOffDate))
                                        <button type="button"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Admission Form Fees</button>
                                        <p class="mb-0 text-muted"><small>Cut off time is not configured yet. Please contact HNSB for more information!</small></p>
                                    @elseif (\Carbon\Carbon::parse($admissionCutOffDate)->startOfDay()  >= \Carbon\Carbon::now()->startOfDay())
                                        <form method="post" action="{{ route('payAdmissionFees') }}">
                                            @csrf
                                            <div class="form-check">
                                                <label class="form-check-label" for="checkbox-signup">By clicking "Pay Admission Form Fees" button, I agree to the <a href="{{URL::to('terms-and-condions')}}" class="text-dark" target="_blank">Terms and Conditions</a>.</label>
                                            </div>
                                            <button type="submit" class="btn btn-success width-xl waves-effect waves-light mt-3 mb-5">Pay Admission Form Fees</button>
                                        </form>
                                    @else
                                         <button type="button"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Pay Admission Form Fees</button>
                                        <p class="mb-0 text-muted"><small>Cut off time is over</small></p>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div> <!-- container -->

    </div> <!-- content -->
@endsection
@push('style')
    <link href="{{ asset('/assets/libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush
@push('scripts')

    <script src="{{ asset('/assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>

    <script src="{{ asset('/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $.validator.addMethod('Email', function(value) {
            return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
        }, 'Please enter a valid email.');
        $.validator.addMethod("lettersonly2", function(value, element) {
            return this.optional(element) || /^\S+[a-z]+$/i.test(value);
        }, "Please enter valid full name.");
        $.validator.addMethod("alphanumeric_space", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "");
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-z0-9]+$/i.test(value);
        }, "");
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "");
        $('#admissionForm').validate({
            errorClass: 'error text-danger',
            rules: {
                student_name: {
                    required: true,
                    lettersonly2: true,
                    lettersonly: true,
                    //noSpace: true
                },
                father_name: {
                    required: true,
                    lettersonly2: true,
                    lettersonly: true,
                    //noSpace: true
                },
                surname: {
                    required: true,
                    lettersonly2: true,
                    lettersonly: true,
                    //noSpace: true
                },
                contact_no: {
                    required: true,
                    //matches:"[0-9]+",
                    //min:16,
                },
                gender: {
                    required: true,
                },
                birth_date: {
                    required: true,
                },
                caste: {
                    required: true,
                },
                aadhar_card_no: {
                    required: true,
                    digits:true,
                    minlength:12, 
                    maxlength:12
                },
                address: {
                    required: true
                },
               
                course: {
                    required: true
                },
                semester: {
                    required: true
                },
                group: {
                    required: true
                },
                school_name: {
                    required: true,
                   // alphanumeric_space:true
                },
                join_date: {
                    required: true
                },
                leaving_date: {
                    required: true
                },
                marksheet_no: {
                    required: true,
                    alphanumeric:true
                },
                exam_center: {
                    required: true
                },
                passing_month:{
                    required: true
                },
                passing_year: {
                    required: true
                },
                obtained_marks: {
                    required: true,
                    //digits:true
                },
            },
            messages: {
                student_name: {
                    required: "Please enter student name.",
                    lettersonly2: "Please enter valid student name.",
                    lettersonly: "Please enter valid student name."
                },
                father_name: {
                    required: "Please enter father name.",
                    lettersonly2: "Please enter valid father name.",
                    lettersonly: "Please enter valid father name."
                },
                surname: {
                    required: "Please enter surname.",
                    lettersonly2: "Please enter valid surname.",
                    lettersonly: "Please enter valid surname."
                },
                contact_no: {
                    required:"Please enter contact no.",
                    //min:"Please enter valid contact number (ex. (91) 98988-98988)"
                },
                gender: {
                    required: "Please select gender.",
                },
                birth_date: {
                    required: "Please select birth date.",
                },
                caste: {
                    required: "Please select caste.",
                },
                aadhar_card_no: {
                    required: "Please enter aadhar card no.",
                    digits:"Please enter only digits.",
                    minlength:"Adhar card number must be 12 digit.", 
                    maxlength:"Adhar card number must be 12 digit."
                },
                 student_photo: {
                    required: "Please select student photo.",
                    extension: "Please select valid student photo.(.jpg)"
                },
                student_sign: {
                    required: "Please select student sign",
                    extension: "Please select valid student sign.(.jpg)"
                },
                course: {
                    required: "Please select course.",
                },
                semester: {
                    required: "Please select semester.",
                },
                group: {
                    required: "Please select group.",
                },
                school_name: {
                    required: "Please enter school name.",
                    //alphanumeric_space:"Please enter latters, numbers only"
                },
                join_date: {
                    required: "Please select join date.",
                },
                leaving_date: {
                    required: "Please select leaving date.",
                },
                marksheet_no: {
                    required: "Please enter 12th marksheet seat no.",
                    alphanumeric: "Please enter only alphanumeric (ex. G1234)."
                },
                address: {
                    required: "Please enter address.",
                },
                exam_center: {
                    required: "Please enter exam center.",
                },
                passing_month: {
                    required: "Please select passing month.",
                },
                passing_year: {
                    required: "Please select passing year.",
                },
                obtained_marks: {
                    required: "Please enter total obtained marks out of total theory marks.",
                    //digits: "Please enter only numbers."
                },
            },
             submitHandler: function(form){
             	try{
             		$.ajax({
             			url:$(form).attr("action"),
						type:'POST',
						data:new FormData(form),
						processData: false,
						cache: false,
      					contentType: false,
						datatype : "application/json",
             			beforeSend:function(){
             				$(form).find('button[type="submit"]').prop('disabled', true);
             				//$(form).find('button[type="submit"]').addClass('btn-spinner');
             			},
             			success:function(data){
             				if(data != '')
             				{
             					data=JSON.parse(data);
             					if(data.status_code ==200 && data.message != ''){
             						$.toast({
                                            text: data.message,
                                            icon: 'success',
                                            position: "top-right",
                                            loaderBg: '#008b70',
                                        })
                                        setTimeout(function() {
                                            window.location = data.data.redirect;
                                        }, 3000);
             					}
             					else if(data.status_code ==200 && data.message == ''){
             						window.location = data.data.redirect;
             					}
             					else{
             						$.toast({
                                            text: data.message,
                                            icon: 'error',
                                            position: "top-right",
                                            loaderBg: '#bf441d',
                                        });
             						$(form).find('button[type="submit"]').prop('disabled', false);
             						//$(form).find('button[type="submit"]').removeClass('btn-spinner');
             					}
             				}
             			},
             			// complete:function(){ },
             			error: function (jqXHR, exception) {
             				//window.location = site_url;
             			},
             		});
             	}
             	catch(e)
             	{
             		console.log(e);
             	}
             	return false;
             },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "country") {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "state") {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "city") {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "agreement") {
                    error.insertAfter(element.parent().parent('div'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#course').on('change', function() {
		    if($(this).val()!='')
			{
				var CourseID=$(this).val();
				try{
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						type: "POST",
						url: site_url+"/get-semesters",
						dataType: "json",
						data:{CourseID:CourseID},
						beforeSend:function(){
							$('body').css('opacity','0.5');
						},
						success: function(data)
						{
							$('body').css('opacity','1');
                            $('#semester').html('<option value="">Please Select Semester</option>');
                            $('#group').html('<option value="">Please Select Group</option>');
                            if(data.data && data.data != '')
							{
                                $.each(data.data, function(key, value){
                                    $('#semester').append('<option value="'+ value.semester_id +'">'+ value.semester_name +'</option>');
                                });
							}
						}
					});
				}
				catch(e)
				{
					console.log(e);
				}
			}
			else
			{
                $('#semester').html('<option value="">Please Select Semester</option>');
                $('#group').html('<option value="">Please Select Group</option>');
			}
		});
        $('#semester').on('change', function() {
		    if($(this).val()!='')
			{
				var SemesterID=$(this).val();
				var CourseID=$('#course').val();
				try{
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						type: "POST",
						url: site_url+"/get-groups",
						dataType: "json",
						data:{CourseID:CourseID,SemesterID:SemesterID},
						beforeSend:function(){
							$('body').css('opacity','0.5');
						},
						success: function(data)
						{
							$('body').css('opacity','1');
                            $('#group').html('<option value="">Please Select Group</option>');
                            if(data.data && data.data != '')
							{
                                $.each(data.data, function(key, value){
                                    $('#group').append('<option value="'+ value.group_id +'">'+ value.group_name +'</option>');
                                });
							}
						}
					});
				}
				catch(e)
				{
					console.log(e);
				}
			}
			else
			{
                $('#group').html('<option value="">Please Select Group</option>');
			}
		});
        $(function () {
             $('#datepicker').datepicker({			    
                 format: 'M',
                 minViewMode: 'months',
                 maxViewMode: 'months',
                 startView: 'months'
             });
         });
        $('#checkbox-current-address').on('change', function() {
            isChecked = $(this).prop('checked');
            if (isChecked === true) {
                $('#per_address').val($('#address').val());
                $('#per_city').val($('#cur_city').val());
                $('#per_taluko').val($('#cur_taluko').val());
                $('#per_district').val($('#cur_district').val());
                $('#per_pincode').val($('#cur_pincode').val());
            }
        });
         </script>
@endpush
