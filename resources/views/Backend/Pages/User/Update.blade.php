@extends('Backend.Layout.App')
@section('title', 'User Create || Admin Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card  ">
                <form action="{{ route('admin.user.update',$data->id) }}" method="post" id="addStudentForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body ">
                        <!-- Personal Information -->
                        <fieldset class="border p-4 shadow-sm rounded mb-4" style="border:2px #c9c9c9 dotted !important;">
                            <legend class="w-auto px-3 text-primary fw-bold">User Information</legend>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter  Name" value="{{ $data->name }}" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control"
                                        placeholder="Enter Username" value="{{ $data->username }}" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="gmail" name="email" class="form-control"
                                        placeholder="Enter Email" value="{{ $data->email }}" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_number" class="form-control"
                                        placeholder="Enter Mobile Number" value="{{ $data->phone }}" required>
                                </div>


                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input name="password"  class="form-control" placeholder="Enter Password">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input name="confirm_password"  class="form-control" placeholder="Enter Confirm Password">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
                        <button type="submit" class="btn btn-success">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            /* Initialize the Select2  */
            $('select').select2({
                placeholder: "---Select---",
                allowClear: false
            });
            $('#addStudentForm').submit(function(e) {
                e.preventDefault();

                /* Get the submit button */
                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnText = submitBtn.html();

                submitBtn.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>'
                    );
                submitBtn.prop('disabled', true);

                var form = $(this);
                var url = form.attr('action');
                /*Change to FormData to handle file uploads*/
                var formData = new FormData(this);

                /* Use Ajax to send the request */
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        /* Disable the Form input */
                        form.find(':input').prop('disabled', true);
                        submitBtn.prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            submitBtn.html(originalBtnText);
                            submitBtn.prop('disabled', false);
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            toastr.error(response.message);
                            submitBtn.html(originalBtnText);
                            submitBtn.prop('disabled', false);
                        }
                    },

                    error: function(xhr, status, error) {
                        submitBtn.html(originalBtnText);
                        submitBtn.prop('disabled', false);

                        let errorMessage = 'An error occurred while processing the request.';

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            for (var error in errors) {
                                toastr.error(errors[error][0]);
                            }
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                            toastr.error(errorMessage);
                        } else if (xhr.responseText) {
                            toastr.error(xhr.responseText);
                        } else {
                            toastr.error(errorMessage);
                        }
                    },
                    complete: function() {
                        /* Reset button text and enable the button */
                        submitBtn.html(originalBtnText);
                        submitBtn.prop('disabled', false);
                    }
                });
            });


        });

    </script>


@endsection
