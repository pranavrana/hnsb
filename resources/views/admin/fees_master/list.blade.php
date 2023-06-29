@extends('admin.layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    @if(Auth::guard('admin')->user()->hasPermissionTo('college-fees-create'))
                    <div class="page-title-right">
                        <a href="{{ route('admin.fees_master_add') }}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add New</a>
                    </div>
                    @endif
                    <h4 class="page-title">College Fees</h4>
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
                                    <th>Academic Year</th>
                                    <th>Course</th>
                                    <th>Semester</th>
                                    <th>Group</th>
                                    <th>Gender</th>
                                    <th>Total</th>
                                    <th>CutOff Date</th>
                                    <th>Late Fees</th>
                                    <th>Extension Date</th>
                                    <th>Extension Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($feesMasterData))
                                @foreach ($feesMasterData as $key => $feesMaster)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $feesMaster->academic_year->year }}</td>
                                    <td>{{ $feesMaster->course->course_name }}</td>
                                    <td>{{ $feesMaster->semester->semester_name }}</td>
                                    <td>{{ $feesMaster->group->group_name }}</td>
                                    <td>{{ $feesMaster->gender }}</td>
                                    <td>{{ $feesMaster->total_fee }} RS</td>
                                    <td>{{ $feesMaster->cutoff_date }}</td>
                                    <td>{{ $feesMaster->fee_late }}</td>
                                    <td>{{ $feesMaster->cutoff_extension_date }}</td>
                                    <td>
                                        @if($feesMaster->cutoff_extension_status == 1)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td id="tooltip-container">
                                        <a href="javascript:void(0);" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="View"> <i class="mdi mdi-eye"></i></a>
                                        @if(Auth::guard('admin')->user()->hasPermissionTo('college-fees-edit'))
                                        <a href="{{ URL::to('admin/edit-college-fees').'/'.$feesMaster->fees_master_id }}" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"> <i class="mdi mdi-square-edit-outline"></i></a>
                                        @endif
                                        @if(Auth::guard('admin')->user()->hasPermissionTo('college-fees-delete'))
                                            <button id="delete" data-id="{{$feesMaster->fees_master_id }}" class="btn btn-link action-icon"
                                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete"> <i
                                                    class="mdi mdi-delete"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No Group Found!</td>
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
<script>
    $(document).ready(function() {
        $(document).on("click", "#delete", function() {
            var fees_master_id = $(this).attr("data-id");
            Swal.fire({
                title: "Are you sure?",
                html: "You want to delete this college fees!",
                icon: "error",
                showCancelButton: !0,
                confirmButtonColor: "#28bb4b",
                cancelButtonColor: "#f34e4e",
                confirmButtonText: "Yes, delete it!",
            }).then(function(e) {
                if (e.value) {
                    try {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: site_url + "/admin/delete-college-fees",
                            type: 'POST',
                            data: {fees_master:fees_master_id},
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
                                // window.location = site_url;
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