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
                        <a href="{{ route('admin.roles_and_permission') }}" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
                    </div>
                    <h4 class="page-title">Edit Roles</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form id="editGeneralSettingForm" method="post" action="{{ route('admin.roles_and_permission_update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$role->id}}" class="form-control">
                        <div class="card-body">
                            <!-- <div class="row"> -->
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" value="{{$role->name}}" name="name" class="form-control" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <!-- <label for="setting_key" class="form-label">Permission</label> -->
                                    <div class="row">
                                        @foreach($permission as $key=>$group)
                                        <div class="col-md-4 mb-3">
                                            <h4 class="header-title">{{$key}}</h4>
                                            @foreach($group as $key=>$permission)
                                            <div class="form-check mb-2 form-check-primary">
                                                <input name="permission[]" class="form-check-input rounded-circle" type="checkbox" value="{{$permission['id']}}" id="permission_{{$permission['id']}}" {{in_array($permission['id'], $rolePermissions) ? 'checked' : ''}}>
                                                <label class="form-check-label" for="permission_{{$permission['id']}}">{{$permission['name']}}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- </div> -->
                        <!-- end row -->
                        <div class="row mt-1 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i> Save</button>
                                <a href="{{ route('admin.roles_and_permission') }}" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
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
        $('#editGeneralSettingForm').validate({
            errorClass: 'error text-danger',
            rules: {
                name: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter name.",
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
                                } else if (data.status_code == 200 && data.message == '') {
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
    });
</script>
@endpush