@extends('admin.layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    @if(Auth::guard('admin')->user()->hasPermissionTo('role-create'))
                    <div class="page-title-right">
                        <a href="{{ route('admin.roles_and_permission_add') }}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add New</a>
                    </div>
                    @endif
                    <h4 class="page-title">Roles</h4>
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
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($rolesData))
                                @foreach ($rolesData as $key => $role)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td id="tooltip-container">
                                        <a href="javascript:void(0);" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="View"> <i class="mdi mdi-eye"></i></a>
                                        @if(Auth::guard('admin')->user()->hasPermissionTo('role-edit'))
                                        <a href="{{ URL::to('admin/edit-roles-and-permission').'/'.$role->id }}" class="action-icon" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"> <i class="mdi mdi-square-edit-outline"></i></a>
                                        @endif
                                        @if(Auth::guard('admin')->user()->hasPermissionTo('role-delete'))
                                        <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No Roles found!</td>
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