@extends('admin.layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    @if(Auth::guard('admin')->user()->hasPermissionTo('college-fees-transactions-export'))
                    <div class="page-title-right">
                        <a href="{{ route('admin.college_fees_export', request()->all()) }}" class="btn btn-danger waves-effect waves-light">
                            <i class="mdi mdi-download-circle me-1"></i> Download
                        </a>
                    </div>
                    @endif
                    <h4 class="page-title">College Fees</h4>
                </div>
            </div>
        </div>
        @include('admin.include.filters')
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Academic Year</th>
                                        <th>Course</th>
                                        <th>Sem</th>
                                        <th>Group</th>
                                        <th>Student Details</th>
                                        {{-- <th>Roll No.</th>
                                        <th>Email</th>
                                        <th>Contact No.</th> --}}
                                        {{-- <th>Address</th> --}}
                                        <th>Amount</th>
                                        <th>Payment Datetime</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($transactionsData))
                                    @foreach ($transactionsData as $key => $transaction)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @php
                                                if (strpos(strtoupper(($transaction->txn_status)), 'SUCCESS') !== false) {
                                                    echo '<span class="badge bg-success">Success</span>';
                                                } else if (strpos(strtoupper(($transaction->txn_status)), 'FAILURE') !== false) {
                                                    echo '<span class="badge bg-danger">Failure</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning">Pending</span>';
                                                }
                                            @endphp
                                        </td>
                                        <td>{{ $transaction->paidFees->academicYear->year ?? "" }}</td>
                                        <td>{{ $transaction->paidFees->course->course_name ?? "" }}</td>
                                        <td>{{ $transaction->paidFees->semester->semester_name ?? "" }}</td>
                                        <td>{{ $transaction->paidFees->group->group_name ?? "" }}</td>
                                        <td>
                                            {{ $transaction->student->name }}
                                            <p class="mb-0"><b>Roll No:</b> {{ $transaction->paidFees->studentEnrollment->roll_no ?? "" }}</p>
                                            <p class="mb-0"><b>Email:</b> {{ $transaction->student->email }}</p>
                                            <p class="mb-0"><b>Contact No:</b> {{ $transaction->student->contact_no }}</p>
                                        </td>
                                        {{-- <td>{{ $transaction->paidFees->studentEnrollment->roll_no ?? "" }}</td> --}}
                                        {{-- <td>{{ $transaction->student->email }}</td>
                                        <td>{{ $transaction->student->contact_no }}</td>
                                        <td>{{ $transaction->student->address }}</td> --}}
                                        <td>
                                            <p class="mb-0"><b>Fees:</b> {{ $transaction->amount }}</p>
                                            <p class="mb-0"><b>Transaction Amount:</b> {{$transaction->txn_amount}}</p>
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($transaction->txn_date)->format('Y/m/d H:i A')}}</td>
                                        <td id="tooltip-container">
                                            <a href="{{ route('admin.download_college_fee_receipt', ['id' => $transaction->transaction_id]) }}" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Print" target="_blank"> <i class="mdi mdi-printer"></i></a>    
                                            <a href="{{ route('admin.transaction_details', ['id' => $transaction->transaction_id]) }}" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="View"> <i class="mdi mdi-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No Transaction Found!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
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