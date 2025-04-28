@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card  ">
            <form action="{{ route('admin.student.store') }}" method="post" id="addStudentForm" enctype="multipart/form-data">
                @csrf
            <div class="card-body ">


                    <!-- Personal Information -->
                    <fieldset class="border p-4 shadow-sm rounded mb-4" style="border:2px #c9c9c9 dotted !important;">
                        <legend class="w-auto px-3 text-primary fw-bold">Personal Information</legend>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Enter Fullname" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter Phone" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">NID</label>
                                <input type="text" name="nid" class="form-control" placeholder="Enter NID">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Address</label>
                                <input name="address" class="form-control" placeholder="Enter Address">
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="card-footer">
                <button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
                <button type="submit" class="btn btn-success">Add Student</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
    $(document).ready(function(){

        $('#addStudentForm').submit(function(e) {
            e.preventDefault();

            /* Get the submit button */
            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();

            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
            submitBtn.prop('disabled', true);

            var form = $(this);
            var url = form.attr('action');
            /*Change to FormData to handle file uploads*/
            var formData = new FormData(this);

            /* Use Ajax to send the request */
            $.ajax({
                type: 'POST',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                    }
                    if(success == false){
                        toastr.error(response.message);
                        submitBtn.html(originalBtnText);
                        submitBtn.prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    /* Handle errors */
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        for (var error in errors) {
                            toastr.error(errors[error][0]);
                        }
                    } else {
                        toastr.error('An error occurred while processing the request.');
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
