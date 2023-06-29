@extends('admin.layouts.app')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        @if(Auth::guard('admin')->user()->hasPermissionTo('academic-year-create'))
                        <div class="page-title-right">
                            <a href="{{ route('admin.academic_year_add') }}"
                                class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add
                                New</a>
                        </div>
                        @endif
                        <h4 class="page-title">Academic Year</h4>
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
                                            <th>Year</th>
                                            <th>Is Default</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($academicYearData))
                                            @foreach ($academicYearData as $key => $academicYear)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $academicYear->year }}</td>
                                                    @if($academicYear->is_default == 1)
                                                    <td> <span class="badge bg-success">Yes</span></td>
                                                    @else
                                                    <td> <span class="badge bg-danger">No</span></td>
                                                    @endif
                                                    <td id="tooltip-container">
                                                        @if(Auth::guard('admin')->user()->hasPermissionTo('academic-year-edit'))
                                                        <a href="{{ URL::to('admin/edit-academic-year') . '/' . $academicYear->academic_year_id }}"
                                                            class="action-icon" data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <i class="mdi mdi-square-edit-outline"></i></a>
                                                        @endif
                                                        @if(Auth::guard('admin')->user()->hasPermissionTo('academic-year-delete') && $academicYear->is_default != 1)
                                                        <button id="delete" data-id="{{$academicYear->academic_year_id }}" class="btn btn-link action-icon"
                                                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Delete"> <i
                                                                class="mdi mdi-delete"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Academic Year Found!</td>
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
    <link href="{{ asset('/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                var academic_year_id = $(this).attr("data-id");
                Swal.fire({
                    title: "Are you sure?",
                    html: "You want to delete this academic year! </br> This will delete all the records releted to this acedemic year.",
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
                                url: site_url + "/admin/delete-academic-year",
                                type: 'POST',
                                data: {academic_year:academic_year_id},
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
                                    window.location = site_url;
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
