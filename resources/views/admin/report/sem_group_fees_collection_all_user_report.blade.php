@extends('admin.layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                    </div>
                    <h4 class="page-title">Sem Wise & Group Fees Collection Report All User</h4>
                </div>
            </div>
        </div>
        @include('admin.include.filters')
        <!-- end page title -->
        <div class="row" style="margin-top:10px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if(request()->get('academic_year_id') !== null && request()->get('course_id') !== null && request()->get('semester_id') !== null && request()->get('group_id') !== null && request()->get('from_date') !== null && request()->get('to_date') !== null)
                            <div class="alert alert-primary">
                                Fees Head Details of Academic Year: {{ $selectedYear ?? '-' }} - Degree: {{ $selectedCourse ?? '-' }} - Semester: {{ $selectedSemester ?? '-' }} - Group: {{ $selectedGroup ?? '-' }} 
                                <!-- - User: {{ request()->get('academic_year_id') }} -->
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Gender</th>
                                        <th>Total Nos.</th>
                                        <th>Tuition Fee </th>
                                        <th>Library Fee</th>
                                        <th>Sports Games Fee(Gymkhana)</th>
                                        <th>Sports Fee(College)</th>
                                        <th>College Exam Stationary Fee</th>
                                        <th>Student Relief Fee</th>
                                        <th>College Campus Development Fee</th>
                                        <th>Youth Festival & Cult.Fee</th>
                                        <th>Medical Fee</th>
                                        <th>Hepatitis B Vaccine  Fee</th>
                                        <th>Student Union Fee</th>
                                        <th>Admission Fee</th>
                                        <th>Enrolment Fee</th>
                                        <th>I-Card Fee</th>
                                        <th>Uni.Other Fee</th>
                                        <th>Thalassemia Testing Fee</th>
                                        <th>Laboratory Fee</th>
                                        <th>Uni.Exam Form Fee</th>
                                        <th>Uni.Exam Fee</th>
                                        <th>Computer Fee</th>
                                        <th>Ele.Gen.Fee</th>
                                        <th>Other Fee</th>
                                        <th>Late Fee</th>
                                        <th>Total Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($feesData) && count($feesData))
                                        @php
                                            $total = 0;
                                            $total_fee_tut = 0;
                                            $total_fee_lib = 0;
                                            $total_fee_sport_gim = 0;
                                            $total_fee_sport_clg = 0;
                                            $total_fee_clgexam_stat = 0;
                                            $total_fee_student_rahat = 0;
                                            $total_fee_clg_dev = 0;
                                            $total_fee_you_fas = 0;
                                            $total_fee_med = 0;
                                            $total_fee_hb_rasi = 0;
                                            $total_fee_union = 0;
                                            $total_fee_reg = 0;
                                            $total_fee_enroll = 0;
                                            $total_fee_icard = 0;
                                            $total_fee_uniother = 0;
                                            $total_fee_theal = 0;
                                            $total_fee_lab = 0;
                                            $total_fee_uni_exam_form = 0;
                                            $total_fee_uniexam = 0;
                                            $total_fee_comp = 0;
                                            $total_fee_ele = 0;
                                            $total_fee_other = 0;
                                            $total_fee_late = 0;
                                            $total_total_fee = 0;
                                        @endphp
                                        @foreach ($feesData as $feeData)
                                        @php
                                            $total = $total + $feeData->total;
                                            $total_fee_tut = $total_fee_tut + $feeData->total_fee_tut;
                                            $total_fee_lib = $total_fee_lib + $feeData->total_fee_lib;
                                            $total_fee_sport_gim = $total_fee_sport_gim + $feeData->total_fee_sport_gim;
                                            $total_fee_sport_clg = $total_fee_sport_clg + $feeData->total_fee_sport_clg;
                                            $total_fee_clgexam_stat = $total_fee_clgexam_stat + $feeData->total_fee_clgexam_stat;
                                            $total_fee_student_rahat = $total_fee_student_rahat + $feeData->total_fee_student_rahat;
                                            $total_fee_clg_dev = $total_fee_clg_dev + $feeData->total_fee_clg_dev;
                                            $total_fee_you_fas = $total_fee_you_fas + $feeData->total_fee_you_fas;
                                            $total_fee_med = $total_fee_med + $feeData->total_fee_med;
                                            $total_fee_hb_rasi = $total_fee_hb_rasi + $feeData->total_fee_hb_rasi;
                                            $total_fee_union = $total_fee_union + $feeData->total_fee_union;
                                            $total_fee_reg = $total_fee_reg + $feeData->total_fee_reg;
                                            $total_fee_enroll = $total_fee_enroll + $feeData->total_fee_enroll;
                                            $total_fee_icard = $total_fee_icard + $feeData->total_fee_icard;
                                            $total_fee_uniother = $total_fee_uniother + $feeData->total_fee_uniother;
                                            $total_fee_theal = $total_fee_theal + $feeData->total_fee_theal;
                                            $total_fee_lab = $total_fee_lab + $feeData->total_fee_lab;
                                            $total_fee_uni_exam_form = $total_fee_uni_exam_form + $feeData->total_fee_uni_exam_form;
                                            $total_fee_uniexam = $total_fee_uniexam + $feeData->total_fee_uniexam;
                                            $total_fee_comp = $total_fee_comp + $feeData->total_fee_comp;
                                            $total_fee_ele = $total_fee_ele + $feeData->total_fee_ele;
                                            $total_fee_other = $total_fee_other + $feeData->total_fee_other;
                                            $total_fee_late = $total_fee_late + $feeData->total_fee_late;
                                            $total_total_fee = $total_total_fee + $feeData->total_total_fee;
                                        @endphp
                                        <tr>
                                            <td>{{ $feeData->gender ?? 'No Data Available' }}</td>    
                                            <td>{{ $feeData->total ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_tut ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_lib ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_sport_gim ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_sport_clg ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_clgexam_stat ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_student_rahat ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_clg_dev ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_you_fas ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_med ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_hb_rasi ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_union ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_reg ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_enroll ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_icard ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_uniother ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_theal ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_lab ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_uni_exam_form ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_uniexam ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_comp ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_ele ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_other ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_fee_late ?? 'No Data Available' }}</td>
                                            <td>{{ $feeData->total_total_fee ?? 'No Data Available' }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>Total</td>    
                                            <td>{{ $total }}</td>
                                            <td>{{ $total_fee_tut }}</td>
                                            <td>{{ $total_fee_lib }}</td>
                                            <td>{{ $total_fee_sport_gim }}</td>
                                            <td>{{ $total_fee_sport_clg }}</td>
                                            <td>{{ $total_fee_clgexam_stat }}</td>
                                            <td>{{ $total_fee_student_rahat }}</td>
                                            <td>{{ $total_fee_clg_dev }}</td>
                                            <td>{{ $total_fee_you_fas }}</td>
                                            <td>{{ $total_fee_med }}</td>
                                            <td>{{ $total_fee_hb_rasi }}</td>
                                            <td>{{ $total_fee_union }}</td>
                                            <td>{{ $total_fee_reg }}</td>
                                            <td>{{ $total_fee_enroll }}</td>
                                            <td>{{ $total_fee_icard }}</td>
                                            <td>{{ $total_fee_uniother }}</td>
                                            <td>{{ $total_fee_theal }}</td>
                                            <td>{{ $total_fee_lab }}</td>
                                            <td>{{ $total_fee_uni_exam_form }}</td>
                                            <td>{{ $total_fee_uniexam }}</td>
                                            <td>{{ $total_fee_comp }}</td>
                                            <td>{{ $total_fee_ele }}</td>
                                            <td>{{ $total_fee_other }}</td>
                                            <td>{{ $total_fee_late }}</td>
                                            <td>{{ $total_total_fee }}</td>
                                        </tr>
                                    @else
                                    <tr>
                                        <td colspan="9" class="text-center">No Transaction Found!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if (!empty($feesData) && count($feesData))
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.sem_group_fees_collection_all_user_report_export', request()->all()) }}" class="btn btn-success">Export to Excel</a>
                            </div>
                        @endif
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

</div> <!-- content -->
@endsection
@push('style')
<!-- third party css -->
<link href="{{ asset('/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
@endpush
@push('scripts')
<!-- third party js -->
<script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
{{-- <script src="{{ asset('/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script> --}}
<!-- third party js ends -->

<!-- Datatables init -->
<script src="{{ asset('/assets/js/pages/datatables.init.js') }}"></script>
@endpush