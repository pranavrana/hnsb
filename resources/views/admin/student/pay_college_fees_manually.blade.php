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
                            <a href="{{ route('admin.students') }}"
                                class="btn btn-secondary waves-effect waves-light">
                                <i class="mdi mdi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                        <h4 class="page-title">Collect College Fees Manually</h4>
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
                                    <label class="mt-2 mb-1">12 Marksheet No :</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{ $studentData->marksheet_no_12 }} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Name :</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <p> {{ $studentData->name }} </p>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Email :</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <p> {{ $studentData->email }} </p>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Contact No :</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <p> {{ $studentData->contact_no }} </p>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Address:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{ $studentData->address }} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Academic Year :</label>
                                    <div class="d-flex align-items-start">
                                        <div class="w-100">
                                            <p> {{ $enrollmentData->academicYear->year ?? '' }}</p>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Course:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{ $enrollmentData->course->course_name ?? '' }} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Semester:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{ $enrollmentData->semester->semester_name ?? '' }} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                                <div class="col-md-4">
                                    <label class="mt-2 mb-1">Group:</label>
                                    <div class="d-flex align-items-start">
                                        <p> {{ $enrollmentData->group->group_name ?? '' }} </p>
                                    </div> <!-- end col -->
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            @php
                                // $cutOffDate = getGeneralSettingByKey('collegefeescutoffdate');
                                // $cutOffExtentionDate = getGeneralSettingByKey('collegefeescutoffextentiondate', true);
                                // $collegeFees = getCollegeFees($studentData->id);
                                $collegeFee = App\Models\FeesMaster::where('academic_year_id', $enrollmentData->academic_year_id)->where('course_id', $enrollmentData->course_id)->where('semester_id', $enrollmentData->semester_id)->where('gender', $enrollmentData->user->gender)->first();
                                $cutOffDate = $collegeFee->cutoff_date ?? '';
                                $cutOffExtentionDate = $collegeFee->cutoff_extension_date ?? '';
                                $collegeFees = $collegeFee->total_fee ?? 0;
                                $collegeLateFees = $collegeFee->fee_late ?? 0;
                                $cutOffExtentionDateStatus = $collegeFee->cutoff_extension_status ?? 0;
                            @endphp
                            <div class="row">
                                <div class="col-md-12">
                                    @if (!empty($cutOffDate))
                                        <h5 class="mb-1"><b>Last day to collect college fees is: {{ $cutOffDate }}.</b></h5>
                                    @endif
                                    @if (empty($cutOffDate))
                                        <button type="button"
                                            class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0" disabled>Collect
                                            College Fees</button>
                                        <p class="mb-0 text-muted"><small>Cut off time is not configured yet. Please contact
                                                Admin!</small></p>
                                    @elseif (\Carbon\Carbon::parse($cutOffDate)->startOfDay() >= \Carbon\Carbon::now()->startOfDay())
                                            <h5 class="mb-3"><b>Fees Amount: {{ $collegeFees ?? '' }}.</b></h5>
                                            <button type="submit"  data-id="{{$studentData->id}}" id="collect_college_fees"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-5">Collect
                                                College Fees</button>
                                    @else
                                        @if (!empty($cutOffExtentionDate) &&
                                            $cutOffExtentionDateStatus == 1 &&
                                            \Carbon\Carbon::parse($cutOffExtentionDate)->startOfDay() >= \Carbon\Carbon::now()->startOfDay())
                                            <h5 class=""><b>Extended date to collect college fees is:
                                                    {{ $cutOffExtentionDate }}.</b></h5>
                                            <h5 class=""><b>Fees Amount:
                                                    Rs.{{ $collegeFees . '/-' ?? '' }}</b></h5>
                                            <h5 class="mb-3"><b>Late Fees Amount:
                                                    Rs.{{ $collegeLateFees . '/-' ?? '' }}</b></h5>

                                                <button type="button" data-id="{{$studentData->id}}" id="collect_college_fees" 
                                                    class="btn btn-success width-xl waves-effect waves-light mt-3 mb-5">Collect
                                                    College Fees with Late Fees</button>
                                        @else
                                            <button type="button"
                                                class="btn btn-success width-xl waves-effect waves-light mt-3 mb-0"
                                                disabled>Collect College Fees</button>
                                            <p class="mb-0 text-muted"><small>Cut off time is over</small></p>
                                        @endif
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
            $(document).on("click", "#collect_college_fees", function() {
                var enrollment_id = $(this).attr("data-id");
                Swal.fire({
                    title: "Are you sure you want to collect fees manually?",
                    text: "By this transaction college fees will be collected by manually mode(Cash)!",
                    icon: "success",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Yes, Collect College Fees!",
                }).then(function(e) {
                    if (e.value) {
                        try {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            $.ajax({
                                url: site_url + "/admin/collect-college-fees",
                                type: 'POST',
                                data: {
                                    enrollment_id: enrollment_id
                                },
                                datatype: "application/json",
                                success: function(data) {
                                    console.log(data);
                                    if (data != '') {
                                        data = JSON.parse(data);
                                        if (data.status_code == 200 && data.message !=
                                            '') {
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
                                        } else if (data.status_code == 200 && data
                                            .message == '') {
                                                console.log('error');
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
