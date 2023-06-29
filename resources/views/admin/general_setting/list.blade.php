@extends('admin.layouts.app')

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        @if (Auth::guard('admin')->user()->hasPermissionTo('setting-create'))
                            <div class="page-title-right">
                                <a href="{{ route('admin.general_setting_add') }}"
                                    class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i>
                                    Add New</a>
                            </div>
                        @endif
                        <h4 class="page-title">Setting</h4>
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
                                            <th>Setting Name</th>
                                            <th>Setting Value</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($generalSettingData))
                                            @foreach ($generalSettingData as $key => $setting)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $setting->label }}</td>
                                                    <td>{{ $setting->value }}</td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input status"
                                                                id="{{ $setting->general_setting_id }}" @if($setting->status == 0){{'checked'}}@endif>
                                                        </div>
                                                    </td>
                                                    <td id="tooltip-container">
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="View"> <i
                                                                class="mdi mdi-eye"></i></a>
                                                        @if (Auth::guard('admin')->user()->hasPermissionTo('setting-edit'))
                                                            <a href="{{ URL::to('admin/edit-general-setting') . '/' . $setting->general_setting_id }}"
                                                                class="action-icon" data-bs-container="#tooltip-container"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Edit"> <i
                                                                    class="mdi mdi-square-edit-outline"></i></a>
                                                        @endif
                                                        @if (Auth::guard('admin')->user()->hasPermissionTo('setting-delete') && $setting->is_default == 0)
                                                            <a href="javascript:void(0);" class="action-icon"> <i
                                                                    class="mdi mdi-delete"
                                                                    data-bs-container="#tooltip-container"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Delete"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Settings found!</td>
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
    <script>
        $(document).ready(function() {
            $('.status').on('change', function(event, state) {
                var check = $(this).is(':checked');
                console.log(check);
                var id = $(this).attr('id');
                if (check) {
                    // ON
                    status = 0;
                } else {
                    // OFF
                    status = 1;
                }

                try {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: site_url + "/admin/update-general-setting-status",
                        dataType: "json",
                        data: {
                            setting: id,
                            status: status
                        },
                        beforeSend: function() {
                            $('body').css('opacity', '0.5');
                        },
                        success: function(data) {
                            $('body').css('opacity', '1');

                            if (data.status_code == 200 && data.message != '') {
                                $.toast({
                                    text: data.message,
                                    icon: 'success',
                                    position: "top-right",
                                    loaderBg: '#008b70',
                                });
                            } else {
                                $.toast({
                                    text: data.message,
                                    icon: 'error',
                                    position: "top-right",
                                    loaderBg: '#bf441d',
                                });
                            }

                        }
                    });
                } catch (e) {
                    console.log(e);
                }
            });
        });
    </script>
@endpush
