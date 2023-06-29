<!-- Topbar Start -->
<div class="navbar-custom">

    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-end mb-0">

            {{-- <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-bell noti-icon"></i>
                    <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                            <span class="float-end">
                                <a href="#" class="text-dark">
                                    <small>Clear All</small>
                                </a>
                            </span>Notification
                        </h5>
                    </div>

                    <div class="noti-scroll" data-simplebar>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item active">
                            <div class="notify-icon">
                                <img src="{{ asset('/assets/images/no-profile.png') }}" class="img-fluid rounded-circle" alt="" />
                            </div>
                            <p class="notify-details">Cristina Pride</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>Hi, How are you? What about our next meeting</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Caleb Flakelar commented on Admin
                                <small class="text-muted">1 min ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon">
                                <img src="assets/images/users/user-4.jpg" class="img-fluid rounded-circle" alt="" />
                            </div>
                            <p class="notify-details">Karen Robinson</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>Wow ! this admin looks good and awesome design</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-warning">
                                <i class="mdi mdi-account-plus"></i>
                            </div>
                            <p class="notify-details">New user registered.
                                <small class="text-muted">5 hours ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-info">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Caleb Flakelar commented on Admin
                                <small class="text-muted">4 days ago</small>
                            </p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-secondary">
                                <i class="mdi mdi-heart"></i>
                            </div>
                            <p class="notify-details">Carlos Crouch liked
                                <b>Admin</b>
                                <small class="text-muted">13 days ago</small>
                            </p>
                        </a>
                    </div>

                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                        View all
                        <i class="fe-arrow-right"></i>
                    </a>

                </div>
            </li> --}}

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @php
                    $profileImage = asset('/assets/images/no-profile.png');
                    if(!empty(Auth::guard('admin')->user()->profile_image)) {
                    $profileImage = asset('/uploads/profile_image/'.Auth::guard('admin')->user()->profile_image);
                    }
                    @endphp
                    <img src="{{ $profileImage }}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ms-1">
                        {{Auth::guard('admin')->user()->name}} <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome ! {{Auth::guard('admin')->user()->name}}</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('admin.account')}}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    @if(Auth::guard('admin')->user()->hasPermissionTo('setting-list'))
                    <a href="{{ route('admin.general_setting')}}" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>Settings</span>
                    </a>
                    @endif
                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="{{ route('admin.logout') }}" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>

            {{-- <li class="dropdown notification-list">
                <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                    <i class="fe-settings noti-icon"></i>
                </a>
            </li> --}}

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{ route('admin.dashboard')}}" class="logo logo-dark text-center">
                <span class="logo-sm">
                    <span class="logo-lg-text-light"><img src="{{ asset('/assets/images/ins_logo.png') }}" alt="" height="22">&nbsp;HNSB</span>
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('/assets/images/ins_logo.png') }}" alt="" height="20">
                </span>
            </a>

            <a href="{{ route('admin.dashboard')}}" class="logo logo-light text-center">
                <span class="logo-sm">
                    <img src="{{ asset('/assets/images/ins_logo.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <span class="logo-lg-text-light"><img src="{{ asset('/assets/images/ins_logo.png') }}" alt="" height="22">&nbsp;HNSB</span>
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<!-- end Topbar -->

<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{ route('admin.dashboard')}}">
                        <i data-feather="airplay"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                @if(Auth::guard('admin')->user()->hasPermissionTo('admission-request-list') || Auth::guard('admin')->user()->hasPermissionTo('rejected-admission-list') || Auth::guard('admin')->user()->hasPermissionTo('student-list'))
                <li>
                    <a href="#sidebarStudent" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Student Master </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarStudent">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.registed_students')}}">
                                @php
                                    $registeredStudentsCount = getRegisteredStudentsCount();
                                @endphp
                                @if ($registeredStudentsCount > 0) 
                                    <span class="badge bg-success rounded-pill float-end">{{$registeredStudentsCount}}</span>
                                @endif
                                Registered Students</a>
                            </li>
                            @if(Auth::guard('admin')->user()->hasPermissionTo('admission-request-list'))
                            <li>
                                <a href="{{ route('admin.admission_requests')}}">
                                    @php
                                    $admisisonRequestsCount = getAdmissionRequestCount();
                                    @endphp
                                    @if ($admisisonRequestsCount > 0)
                                    <span class="badge bg-success rounded-pill float-end">{{$admisisonRequestsCount}}</span>
                                    @endif
                                    Admission Requests</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('rejected-admission-list'))
                            <li>
                                <a href="{{ route('admin.rejected_admissions')}}">Rejected Admissions</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('student-list'))
                            <li>
                                <a href="{{ route('admin.students')}}">Students</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('admin.enrollments')}}">Enrollments</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.cancelled_students')}}">Cancelled Students</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if(Auth::guard('admin')->user()->hasPermissionTo('academic-year-list'))
                <li>
                    <a href="{{ route('admin.academic_year')}}">
                        <i data-feather="calendar"></i>
                        <span> Academic Year </span>
                    </a>
                </li>
                @endif
                @if(Auth::guard('admin')->user()->hasPermissionTo('course-list'))
                <li>
                    <a href="{{ route('admin.course')}}">
                        <i data-feather="book-open"></i>
                        <span> Course </span>
                    </a>
                </li>
                @endif
                @if(Auth::guard('admin')->user()->hasPermissionTo('semester-list'))
                <li>
                    <a href="{{ route('admin.semester')}}">
                        <i data-feather="sidebar"></i>
                        <span> Semester </span>
                    </a>
                </li>
                @endif
                @if(Auth::guard('admin')->user()->hasPermissionTo('group-list'))
                <li>
                    <a href="{{ route('admin.group')}}">
                        <i data-feather="grid"></i>
                        <span> Group </span>
                    </a>
                </li>
                @endif
                {{-- @if(Auth::guard('admin')->user()->hasPermissionTo('fees-master-list'))
                <li>
                    <a href="{{ route('admin.fees_master')}}">
                        <i data-feather="calendar"></i>
                        <span> Fees Master </span>
                    </a>
                </li>
                @endif --}}
                @if(Auth::guard('admin')->user()->hasPermissionTo('admission-fees-list') || Auth::guard('admin')->user()->hasPermissionTo('college-fees-list'))
                <li>
                    <a href="#feesManagement" data-bs-toggle="collapse">
                        <i data-feather="archive"></i>
                        <span> Fees Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="feesManagement">
                        <ul class="nav-second-level">
                            @if(Auth::guard('admin')->user()->hasPermissionTo('admission-fees-list'))
                            <li>
                                <a href="{{ route('admin.admission_fees_list') }}">Admission Fees</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('college-fees-list'))
                            <li>
                                <a href="{{ route('admin.fees_master') }}">College Fees</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                @if(Auth::guard('admin')->user()->hasPermissionTo('paid-admission-fees-list'))
                <li>
                    <a href="{{ route('admin.paid_admission_fees')}}">
                        <i data-feather="calendar"></i>
                        <span> Paid Admission Fees </span>
                    </a>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->hasPermissionTo('admission-fees-transactions-list') || Auth::guard('admin')->user()->hasPermissionTo('college-fees-transactions-list'))
                <li>
                    <a href="#transactions" data-bs-toggle="collapse">
                        <i data-feather="dollar-sign"></i>
                        <span> Transactions </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="transactions">
                        <ul class="nav-second-level">
                            @if(Auth::guard('admin')->user()->hasPermissionTo('admission-fees-transactions-list'))
                            <li>
                                <a href="{{ route('admin.admission_fees') }}">Admission Fees</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('college-fees-transactions-list'))
                            <li>
                                <a href="{{ route('admin.college_fees') }}">College Fees</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                @if(Auth::guard('admin')->user()->hasPermissionTo('student-list-enrolment-report-semester-and-group-wise') || Auth::guard('admin')->user()->hasPermissionTo('student-list-semester-report') || Auth::guard('admin')->user()->hasPermissionTo('consolidated-report') || Auth::guard('admin')->user()->hasPermissionTo('semester-and-group-fees-collection-report') || Auth::guard('admin')->user()->hasPermissionTo('semester-and-group-fees-collection-all-user-report') || Auth::guard('admin')->user()->hasPermissionTo('group-and-semester-wise-caste-report-all-student') || Auth::guard('admin')->user()->hasPermissionTo('group-and-semester-wise-caste-report-all-student-admitted-only') || Auth::guard('admin')->user()->hasPermissionTo('fee-head-degree-audit-report') || Auth::guard('admin')->user()->hasPermissionTo('fee-head-degree-audit-report-without-cancel'))
                <li>
                    <a href="#sidebarReport" data-bs-toggle="collapse">
                        <i data-feather="list"></i>
                        <span> Reports </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarReport">
                        <ul class="nav-second-level">

                            @if(Auth::guard('admin')->user()->hasPermissionTo('student-list-enrolment-report-semester-and-group-wise'))
                            <li>
                                <a href="{{ route('admin.student_list_enrolment_report')}}">1. Student List For Enrolment (Sem Wise & Group Wise)</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('student-list-semester-report'))
                            <li>
                                <a href="{{ route('admin.student_list_sem_report')}}">2. Student List (Sem Wise)</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('consolidated-report'))
                            <li>
                                <a href="{{ route('admin.consolidated_report')}}">3. Consolidated Report</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('semester-and-group-fees-collection-report'))
                            <li>
                                <a href="{{ route('admin.sem_group_fees_collection_report')}}">4. Sem Wise & Group Wise Fees Collection Report</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('semester-and-group-fees-collection-all-user-report'))
                            <li>
                                <a href="{{ route('admin.sem_group_fees_collection_all_user_report')}}">5. Sem Wise & Group Fees Collection Report All User</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('group-and-semester-wise-caste-report-all-student'))
                            <li>
                                <a href="{{ route('admin.group_sem_cast_all_student_report')}}">6. Group & Sem Wise Caste Report All Student </a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('group-and-semester-wise-caste-report-all-student-admitted-only'))
                            <li>
                                <a href="{{ route('admin.group_sem_cast_all_student_admitted_only_report')}}">7. Group & Sem Wise Caste Report All Student (Admitted Only)</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('group-and-semester-wise-caste-report-all-student-admitted-only'))
                            <li>
                                <a href="{{ route('admin.sem_cast_all_student_report')}}">8. Sem - Wise Cast Report All Student</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('group-and-semester-wise-caste-report-all-student-admitted-only'))
                            <li>
                                <a href="{{ route('admin.sem_cast_all_student_admitted_only_report')}}">9. Sem - Wise & Cast Report All Student(Admitted Only) </a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('forfeit-report-1'))
                            <li>
                                <a href="{{ route('admin.forfeit_report_1')}}">10. Forfeit Report - 1</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('due-fee'))
                            <li>
                                <a href="{{ route('admin.due_fees_report')}}">11. Due Fee</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('fee-head-degree-audit-report'))
                            <li>
                                <a href="{{ route('admin.fee_head_degree_audit_report')}}">12. Fee Head-Wise Degree-Wise Audit Report.</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('fee-head-degree-audit-report-without-cancel'))
                            <li>
                                <a href="{{ route('admin.fee_head_degree_audit_without_cancel_report')}}">13. Fee Head-Wise Degree-Wise Audit Report \ Without Cancel And Un-Enroll) </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                @if(Auth::guard('admin')->user()->hasPermissionTo('role-list') || Auth::guard('admin')->user()->hasPermissionTo('user-list'))
                <li>
                    <a href="#sidebarUser" data-bs-toggle="collapse">
                        <i data-feather="user-plus"></i>
                        <span> User Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarUser">
                        <ul class="nav-second-level">
                            @if(Auth::guard('admin')->user()->hasPermissionTo('role-list'))
                            <li>
                                <a href="{{ route('admin.roles_and_permission')}}">Roles & Permission</a>
                            </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasPermissionTo('user-list'))
                            <li>
                                <a href="{{ route('admin.admin_user')}}">User</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                @if(Auth::guard('admin')->user()->hasPermissionTo('academic-year-list'))
                {{-- <li>
                    <a href="{{ route('admin.activity_log')}}">
                        <i data-feather="server"></i>
                        <span> Activity Log </span>
                    </a>
                </li> --}}
                @endif
            </ul>

        </div>

        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->