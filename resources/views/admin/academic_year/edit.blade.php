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
                        <a href="{{ route('admin.academic_year') }}" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
                    </div>
                    <h4 class="page-title">Edit Academic Year</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form id="editAcademicYearForm" method="post" action="{{ route('admin.academic_year_update') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <input type="hidden" name="id" value="{{$academicYearData->academic_year_id}}" class="form-control">
                                        <label for="year" class="form-label">Academic Year <span class="text-danger">*</span></label>
                                        <input type="text" id="year" value="{{$academicYearData->year}}" name="year" class="form-control" placeholder="Enter Academic Year Name">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Is Default?</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="is_default" class="form-check-input status"
                                            @if($academicYearData->is_default == 1){{'checked'}}@endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mt-1 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i> Save</button>
                                <a href="{{ route('admin.academic_year') }}" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
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
        $('#editAcademicYearForm').validate({
            errorClass: 'error text-danger',
            rules: {
                year: {
                    required: true,
                }
            },
            messages: {
                year: {
                    required: "Please enter academic year.",
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
                            console.log(data);

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
                                } else if (data.status_code == 200 && data.message == '') {
                                    window.location = data.data.redirect;
                                } else {
                                    $.toast({
                                        text: data.message,
                                        icon: 'error',
                                        position: "top-right",
                                        loaderBg: '#bf441d',
                                    });
                                    //$(form).find('button[type="submit"]').prop('disabled', false);
                                    //$(form).find('button[type="submit"]').removeClass('btn-spinner');
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
                return false;
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
@endpush