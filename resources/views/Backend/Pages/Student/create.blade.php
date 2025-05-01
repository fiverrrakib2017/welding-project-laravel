@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card  ">
                <form action="{{ route('admin.student.store') }}" method="post" id="addStudentForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body ">


                        <!-- Personal Information -->
                        <fieldset class="border p-4 shadow-sm rounded mb-4" style="border:2px #c9c9c9 dotted !important;">
                            <legend class="w-auto px-3 text-primary fw-bold">Personal Information</legend>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter Student Name" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Father's Name <span class="text-danger">*</span></label>
                                    <input type="text" name="father_name" class="form-control"
                                        placeholder="Enter Father's Name" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Nid Or Passport <span class="text-danger">*</span></label>
                                    <input type="text" name="nid_or_passport" class="form-control"
                                        placeholder="Enter Nid Or Passport" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_number" class="form-control"
                                        placeholder="Enter Mobile Number" required>
                                </div>


                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Permanent Address</label>
                                    <input name="permanent_address" class="form-control"
                                        placeholder="Enter Permanent Address">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Present Address</label>
                                    <input name="present_address" class="form-control" placeholder="Enter Present Address">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Course</label>
                                    <select name="courses[]" class="form-control" multiple required>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->name }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Duration</label>
                                    <select name="course_duration" class="form-control" required>
                                        <option value="">Select Course</option>
                                        @for ($i = 0; $i < 10; $i++)
                                            <option value="{{ $i }}">{{ $i }} Month</option>
                                        @endfor
                                    </select>
                                </div>
                                @php
                                    use Carbon\Carbon;

                                    $months = [];
                                    $year = 2025;
                                    $currentMonth = Carbon::now()->format('F Y');

                                    for ($m = 1; $m <= 12; $m++) {
                                        $date = Carbon::create($year, $m, 1);
                                        if ($date->format('F Y') != $currentMonth) {
                                            $months[] = $date;
                                        }
                                    }
                                @endphp

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">End Course</label>
                                    <select name="course_end" class="form-control" required>
                                        @foreach ($months as $month)
                                            <option value="{{ $month->format('Y-m') }}">{{ $month->format('F Y') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3 d-none">
                                    <label class="form-label">Regestration No.</label>
                                    <input type="text" name="regestration_no"  id="regestration_no" class="form-control"  placeholder="Enter Regestration No." readonly>
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


        function _generate_unique_code() {
            let code = Math.floor(10000000 + Math.random() * 90000000);
            document.getElementById('regestration_no').value = code;
        }
        window.onload = _generate_unique_code;
    </script>


@endsection
