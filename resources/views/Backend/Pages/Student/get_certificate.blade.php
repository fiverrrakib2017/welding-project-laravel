<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Student Certificate</title>

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('Backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('Backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('Backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('Backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('Backend/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('Backend/dist/css/adminlte.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('Backend/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('Backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('Backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Toast Message -->
    <link rel="stylesheet" href="{{ asset('Backend/dist/css/toastr.min.css') }}">

    <style>
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-image: url('{{ asset('Backend/images/Asset_two.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.6;
            z-index: -1;
        }
        </style>
</head>

<body >


    <div class="container" id="formContainer">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title">Student Certificate</h3>
                    </div>
                    <!-- Search Form -->
                    <div class="card-header">
                        <form action="{{ route('website.student.certificate') }}" method="post" class="row g-3"
                            id="addStudentForm">
                            @csrf
                            <div class="col-md-5 mb-2">
                                <label for="nid_or_passport">NID Or Passport</label>
                                <input type="text" name="nid_or_passport" class="form-control"
                                    placeholder="Enter NID Or Passport No" required>
                            </div>
                            <div class="col-md-5 mb-2">
                                <label for="">Mobile Number</label>
                                <input type="text" name="mobile_number" class="form-control"
                                    placeholder="Enter Mobile No" required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary w-100"
                                    style="margin-top: 30px;">Search</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="card-body d-none" id="certificateContainer">


            </div>
        </div>
    </div>




    <script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Toast Message -->
    <script src="{{ asset('Backend/dist/js/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
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

                            submitBtn.html(originalBtnText);
                            submitBtn.prop('disabled', false);
                            $("#certificateContainer").removeClass('d-none');
                            $('#certificateContainer').html(response.data);
                            /* Print the certificate */

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
                        /* Enable the Form input */
                        form.find(':input').prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>

</html>
