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
                            <a href="{{ route('admin.general_setting') }}"
                                class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i>
                                Back</a>
                        </div>
                        <h4 class="page-title">Add Setting</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <form id="addGeneralSettingForm" method="post"
                            action="{{ route('admin.general_setting_insert') }}">
                            @csrf
                            <div class="card-body">
                                <!-- <div class="row"> -->
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="setting_label" class="form-label">Setting Name <span class="text-danger">*</span></label>
                                        <input type="text" id="setting_label" name="setting_label" class="form-control"
                                            placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="setting_key" class="form-label">Setting Key <span class="text-danger">*</span></label>
                                        <input type="text" id="setting_key" name="setting_key" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="setting_value" class="form-label">Setting Value <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="setting_value" id="setting_value" rows="4" placeholder="Enter value..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- end row -->
                            <div class="row mt-1 mb-2">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i> Save</button>
                                    <a href="{{ route('admin.general_setting') }}"
                                        class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
                                        Cancel</a>
                                </div>
                            </div>
                    </div> <!-- end card body-->
                    </form>

                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

    </div> <!-- content -->
@endsection
@push('style')
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#addGeneralSettingForm').validate({
                errorClass: 'error text-danger',
                rules: {
                    setting_label: {
                        required: true,
                    },
                    setting_key: {
                        required: true,
                    },
                    setting_value: {
                        required: true,
                    }
                },
                messages: {
                    setting_label: {
                        required: "Please enter setting name.",
                    },
                    setting_key: {
                        required: "Please enter setting key.",
                    },
                    setting_value: {
                        required: "Please enter setting value.",
                    },
                },
                submitHandler: function(form) {
                    try {
                        $.ajax({
                            url: $(form).attr("action"),
                            type: 'POST',
                            data: $(form).serialize(),
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
                                        });
                                        setTimeout(function() {
                                            window.location = data.data.redirect;
                                        }, 1500);
                                    } else if (data.status_code == 200 && data.message ==
                                        '') {
                                        window.location = data.data.redirect;
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
                            error: function(jqXHR, exception) {
                                // window.location = site_url;
                            },
                        });
                    } catch (e) {
                        console.log(e);
                    }
                    return false;
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
            $('#setting_label').on('change input blur', function() {
                if ($(this).val() != '') {
                    var CourseID = $(this).val();
                    $('#setting_key').val($(this).val().replace(/[^A-Z0-9]/ig, "").toLowerCase());
                } else {
                    $('#setting_key').val("");
                }
            });
        });
    </script>
@endpush
