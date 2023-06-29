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
                                <a href="{{ route('transactions') }}" class="btn btn-secondary waves-effect waves-light">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back
                                </a>
                                @if($transaction->payment_type == 2)
                                    <a href="{{ route('download_college_fee_receipt', ['id' => $transaction->transaction_id]) }}" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-download me-1"></i> Download
                                    </a>
                                @endif
                        </div>
                        <h4 class="page-title">Transaction Details</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <!-- project card -->
                        <div class="card d-block">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="mt-2 mb-1">Payment Type :</label>
                                        <p>
                                            <i class='mdi mdi-ticket font-18 text-success me-1 align-middle'></i> 
                                            @if($transaction->payment_type == 1)
                                                {{'Admission Form Fees'}}
                                            @elseif($transaction->payment_type == 2)
                                                {{'College Fees'}}
                                            @endif
                                        </p>
                                    </div>
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="mt-2 mb-1">Order ID :</label>
                                        <div class="d-flex align-items-start">
                                            <p> {{$transaction->order_id}} </p>
                                        </div> <!-- end col -->
                                    </div> <!-- end col -->

                                    <div class="col-md-4">
                                        <!-- assignee -->
                                        <label class="mt-2 mb-1">Email :</label>
                                        <div class="d-flex align-items-start">
                                            <div class="w-100">
                                                <p> {{$transaction->email}} </p>
                                            </div>
                                        </div>
                                        <!-- end assignee -->
                                    </div> <!-- end col -->
                                    <div class="col-md-4">
                                        <label class="mt-2 mb-1">Contact No :</label>
                                        <div class="d-flex align-items-start">
                                            <p> {{$transaction->contact_no}} </p>
                                        </div> <!-- end col -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- assignee -->
                                        <label class="mt-2 mb-1">Amount :</label>
                                        <div class="d-flex align-items-start">
                                            <div class="w-100">
                                                <p> {{$transaction->amount}} </p>
                                            </div>
                                        </div>
                                        <!-- end assignee -->
                                    </div> <!-- end col -->
                                    <div class="col-md-4">
                                        <label class="mt-2 mb-1">Transaction ID :</label>
                                        <div class="d-flex align-items-start">
                                            <p> {{$transaction->txn_id}} </p>
                                        </div> <!-- end col -->
                                    </div> <!-- end col -->

                                    <div class="col-md-4">
                                        <!-- assignee -->
                                        <label class="mt-2 mb-1">Transaction Amount :</label>
                                        <div class="d-flex align-items-start">
                                            <div class="w-100">
                                                <p> {{$transaction->txn_amount}} </p>
                                            </div>
                                        </div>
                                        <!-- end assignee -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="mt-2 mb-1">Payment Mode :</label>
                                        <div class="d-flex align-items-start">
                                            <p> {{$transaction->txn_payment_mode}} </p>
                                        </div> <!-- end col -->
                                    </div> <!-- end col -->

                                    <div class="col-md-4">
                                        <!-- assignee -->
                                        <label class="mt-2 mb-1">Transaction Status :</label>
                                        <div class="d-flex align-items-start">
                                            <div class="w-100">
                                                <p> {{$transaction->txn_status}} </p>
                                            </div>
                                        </div>
                                        <!-- end assignee -->
                                    </div> <!-- end col -->
                                    
                                    <div class="col-md-4">
                                        <!-- assignee -->
                                        <label class="mt-2 mb-1">Transaction Date Time :</label>
                                        <p>{{\Carbon\Carbon::parse($transaction->created_at)->format('Y/m/d')}} <small class="text-muted">{{\Carbon\Carbon::parse($transaction->created_at)->format('h:i A')}}</small></p>
                                        <!-- end assignee -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                {{-- <label class="mt-4 mb-1">Overview :</label>

                                <p class="text-muted mb-0">
                                    This is a wider card with supporting text below as a natural lead-in to additional
                                    content. This content is a little bit longer. Some quick example text to build on the
                                    card title and make up the bulk of the card's content. Some quick example text to build
                                    on the card title and make up.
                                </p> --}}

                            </div> <!-- end card-body-->

                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
@endsection
@push('style')
@endpush
@push('scripts')
@endpush
