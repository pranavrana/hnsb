@extends('admin.layouts.app')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                                <a href="{{ route('admin.registed_students') }}" class="btn btn-secondary waves-effect waves-light">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back
                                </a>
                        </div>
                        <h4 class="page-title">Collect Admission Fees Manually</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <!-- project card -->
                    <div class="card d-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">12 Marksheet No:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{$studentData->marksheet_no_12}} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Name:</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <p> {{$studentData->name}} </p>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Email:</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <p> {{$studentData->email}} </p>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-md-4">
                                    <!-- assignee -->
                                    <label class="mt-2 mb-1">Contact No:</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <p> {{$studentData->contact_no}} </p>
                                        </div>
                                    </div>
                                    <!-- end assignee -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Address:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{$studentData->address}} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">City:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{$studentData->cur_city}} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Taluko:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{$studentData->cur_taluko}} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">District:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{$studentData->cur_district}} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                                <div class="col-md-4"> 
                                    <label class="mt-2 mb-1">Pincode:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{$studentData->cur_pincode}} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            @php
                                $enrollmentData = App\Models\StudentEnrollment::where('user_id', $studentData->id)->where('group_id', 0)->orWhere('group_id', null)->first();
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <!-- assignee -->
                                    <label class="mt-2 mb-1">Course:</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <p> {{ $enrollmentData->course->course_name ?? '--' }} </p>
                                        </div>
                                    </div>
                                    <!-- end assignee -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Semester:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{ $enrollmentData->semester->semester_name ?? '--' }} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            @php
                                $enrollmentDetails = App\Models\StudentEnrollment::with(['academicYear', 'course', 'semester', 'group', 'user'])->where('user_id', $studentData->id)->latest()->firstOrFail();
                                // $admissionCutOffDate = getGeneralSettingByKey('admissioncutoffdate');
                                $admissionFee = App\Models\AdmissionFee::where('academic_year_id', $enrollmentDetails->academic_year_id)->where('course_id', $enrollmentDetails->course_id)->where('semester_id', $enrollmentDetails->semester_id)->first();
                                $admissionCutOffDate = $admissionFee->cutoff_date ?? '';
                                $admissionFees = $admissionFee->admission_fees ?? 0;
                            @endphp
                            <div class="row">
                                <div class="col-md-4">
                                @if (!empty($admissionCutOffDate))
                                    <h5 class="mb-1"><b>Last day to pay admission fees is: {{$admissionCutOffDate}}.</b></h5>
                                    <h5 class="mb-3"><b>Admission fees is: ₹{{$admissionFees}}.</b></h5>
                                @endif
                                @if (empty($admissionCutOffDate))
                                    <button type="button"
                                            class="btn btn-success waves-effect waves-light mt-3 mb-0" disabled>Collect Admission Form Fees</button>
                                    <p class="mb-0 text-muted"><small>Cut off time is not configured yet. Please contact HNSB for more information!</small></p>
                                @elseif (\Carbon\Carbon::parse($admissionCutOffDate)->startOfDay()  >= \Carbon\Carbon::now()->startOfDay())
                                    <button type="button" data-id="{{$studentData->id}}" id="collect_admission_fees" class="btn btn-success waves-effect waves-light mt-3 mb-5">Collect Admission Form Fees</button>
                                @else
                                    <button type="button" class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Collect Admission Form Fees</button>
                                    <p class="mb-0 text-muted"><small>Cut off time is over</small></p>
                                @endif
                            </div>
                            </div> <!-- end row -->

                        </div> <!-- end card-body-->

                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
@endsection
@push('style')
<!-- Sweet Alert-->
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
<!-- Sweet Alerts js -->
    <script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on("click", "#collect_admission_fees", function() {
                var student_id = $(this).attr("data-id");
                Swal.fire({
                    title: "Are you sure you want to collect fees manually?",
                    text: "By this transaction admission fees will be collected by manually mode(Cash)!",
                    icon: "success",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Yes, Collect Admission Fees!",
                }).then(function(e) {
                    if (e.value) {
                        try {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: site_url + "/admin/collect-admission-fees",
                                type: 'POST',
                                data: {student:student_id},
                                datatype: "application/json",
                                success: function(data) {
                                    if (data != '') {
                                        data = JSON.parse(data);
                                        if (data.status_code == 200 && data.message != '') {
                                            $.toast({
                                                text: data.message,
                                                icon: 'success',
                                                position: "top-right",
                                                loaderBg: '#008b70',
                                            })
                                            setTimeout(function() {
                                                window.location = data.data
                                                    .redirect;
                                            }, 3000);
                                        } else if (data.status_code == 200 && data.message == '') {
                                            //window.location = data.data.redirect;
                                        } else {
                                            $.toast({
                                                text: data.message,
                                                icon: 'error',
                                                position: "top-right",
                                                loaderBg: '#bf441d',
                                            });
                                        }
                                    }
                                },
                                // complete:function(){ },
                                error: function(jqXHR, exception) {
                                    console.log(exception);
                                    //window.location = site_url;
                                },
                            });
                        } catch (e) {
                            console.log(e);
                        }
                    }
                });
            });
        });
    </script>
@endpush
