@extends('admin.layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Activity Log</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title">Basic Data Table</h4> --}}
                        {{-- <p class="text-muted font-13 mb-4">
                                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                                            function:
                                            <code>$().DataTable();</code>.
                                        </p> --}}
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Event</th>
                                        <th>Section</th>
                                        <th>Message</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($activityLogData))
                                    @foreach ($activityLogData as $key => $activity)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $activity->created_at }}</td>
                                        <td>{{ (isset($activity->causer->name) && $activity->causer->name != null) ? $activity->causer->name : '-' }}</td>
                                        <td>
                                            @if($activity->event == "created")
                                            <span class="badge bg-success">Created</span>
                                            @elseif($activity->event == "updated")
                                            <span class="badge bg-warning">Updated</span>
                                            @elseif($activity->event == "deleted")
                                            <span class="badge bg-danger">Deleted</span>
                                            @else
                                            <span class="badge bg-dark">No Event</span>
                                            @endif
                                        </td>
                                        <td>{{ $activity->log_name }}</td>
                                        <td>{{ $activity->description }}</td>
                                        <td id="tooltip-container">
                                            <a href="javascript:void(0);" class="action-icon" data-bs-target="#standard-modal-{{$activity->id}}" data-bs-toggle="modal" title="View"> <i class="mdi mdi-eye"></i></a>
                                        </td>
                                    </tr>

                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No Activity Log Found!</td>
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

<!-- Standard modal content -->
@if (!empty($activityLogData))
@foreach ($activityLogData as $key => $activity)
<div id="standard-modal-{{$activity->id}}" class="modal fade" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Change Log Report - <span class="text-primary me-2">{{ $activity->log_name }}</span>
                    @if($activity->event == "created")
                    <span class="badge bg-success">Created</span>
                    @elseif($activity->event == "updated")
                    <span class="badge bg-warning">Updated</span>
                    @elseif($activity->event == "deleted")
                    <span class="badge bg-danger">Deleted</span>
                    @else
                    <span class="badge bg-dark">No Event</span>
                    @endif
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        @php
                        $activityLogArr = json_decode($activity->properties,true);
                        $attrOldArr = (isset($activityLogArr['attributes'])) ? $activityLogArr['attributes']: $activityLogArr['old'];
                        @endphp
                        <thead>
                            <tr>
                                <th>Column</th>
                                @if((isset($activityLogArr['old'][$key])))
                                <th>Old Value</th>
                                @endif
                                @if((isset($activityLogArr['attributes'][$key])))
                                <th>New Value</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($attrOldArr as $key => $activity)
                            <tr>
                                <td>{{$key}}</td>
                                @if((isset($activityLogArr['old'][$key])))
                                <td>{{($activityLogArr['old'][$key] != "" && $activityLogArr['old'][$key] != null) ? $activityLogArr['old'][$key] : "N/A"}}</td>
                                @endif
                                @if((isset($activityLogArr['attributes'][$key])))
                                <td>{{($activityLogArr['attributes'][$key] != "" && $activityLogArr['attributes'][$key] != null ) ? $activityLogArr['attributes'][$key] : "N/A"}}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endforeach
@endif
@endsection
@push('style')
<!-- third party css -->
<link href="{{ asset('/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
<!-- Sweet Alert-->
<link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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
<!-- Sweet Alerts js -->
<script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
@endpush