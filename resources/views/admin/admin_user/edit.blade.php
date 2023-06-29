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
                        <a href="{{ route('admin.admin_user') }}" class="btn btn-secondary waves-effect waves-light"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
                    </div>
                    <h4 class="page-title">Edit User</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <form id="editAdminUserForm" method="post" action="{{ route('admin.admin_user_update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$userData->admin_id}}" class="form-control">
                        <div class="card-body">
                            <!-- <div class="row"> -->
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">User Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" value="{{$userData->name}}" name="name" class="form-control"
                                        placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" value="{{$userData->email}}" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" name="password" id="password" placeholder="Enter password...">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="role_id" class="form-label">Select Role <span class="text-danger">*</span></label>
                                    <select class="form-select" id="role_id" name="role_id">
                                        <option value="">Select role</option>
                                        @foreach ($rolesData as $role)
                                        @if($role->id == $currentRole[0]->id)
                                        <option value="{{$role->id}}" selected> {{$role->name}}</option>
                                        @else
                                        <option value="{{$role->id}}"> {{$role->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- end row -->
                        <div class="row mt-1 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i> Save</button>
                                <a href="{{ route('admin.admin_user') }}" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x me-1"></i>
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
        $('#editAdminUserForm').validate({
            errorClass: 'error text-danger',
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                role_id: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter name.",
                },
                email: {
                    required: "Please enter email.",
                },
                role_id: {
                    required: "Please select the role.",
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