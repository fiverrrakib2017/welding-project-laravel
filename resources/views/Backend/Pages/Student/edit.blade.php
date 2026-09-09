@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card  ">
            <form action="{{ route('admin.student.update',$student->id) }}" method="post" id="addStudentForm" enctype="multipart/form-data">
                @csrf
            <div class="card-body ">


                    <!-- Personal Information -->
                    <fieldset class="border p-4 shadow-sm rounded mb-4" style="border:2px #c9c9c9 dotted !important;">
                        <legend class="w-auto px-3 text-primary fw-bold">Personal Information</legend>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Student Name" value="{{ $student->name }}" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Father's Name <span class="text-danger">*</span></label>
                                <input type="text" name="father_name" class="form-control" placeholder="Enter Father's Name" value="{{ $student->father_name }}" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Nid Or Passport <span class="text-danger">*</span></label>
                                <input type="text" name="nid_or_passport" class="form-control" placeholder="Enter Nid Or Passport" value="{{ $student->nid_or_passport }}" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="mobile_number" class="form-control" placeholder="Enter Mobile Number" value="{{ $student->mobile_number }}" required>
                            </div>


                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Permanent Address</label>
                                <input name="permanent_address" value="{{ $student->permanent_address }}" class="form-control" placeholder="Enter Permanent Address">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Present Address</label>
                                <input name="present_address" value="{{ $student->present_address }}" class="form-control" placeholder="Enter Present Address">
                            </div>
                            @php
                                $selectedCourses = !empty($student->course) ? array_map('trim', explode(',', $student->course)) : [];
                            @endphp

                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Course</label>
                                <select name="courses[]" class="form-control" multiple required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->name }}"
                                            {{ in_array($course->name, old('courses', $selectedCourses)) ? 'selected' : '' }}>
                                            {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Duration</label>
                                <select name="course_duration" class="form-control" required>
                                    <option value="">Select Course</option>
                                    @for ($i = 0; $i < 10; $i++)
                                        @for ($i = 0; $i < 10; $i++)
                                            @php $formatted = sprintf('%02d', $i); @endphp
                                            <option value="{{ $formatted }}" {{ $student->course_duration == $i ? 'selected' : '' }}>
                                                {{ $formatted }} Month
                                            </option>
                                        @endfor
                                    @endfor
                                </select>
                            </div>
                            @php
                                use Carbon\Carbon;

                                $months = [];
                                $year = date("Y");

                                for ($m = 1; $m <= 12; $m++) {
                                    $months[] = Carbon::create($year, $m, 1);
                                }
                            @endphp

                            {{-- <div class="col-lg-6 mb-3">
                                <label class="form-label">End Course</label>
                                <select name="course_end" class="form-control" required>
                                    @foreach ($months as $month)
                                        <option value="{{ $month->format('Y-m') }}" @selected($student->course_end == $month->format('Y-m'))>
                                            {{ $month->format('F Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Course Start Date</label>
                                <input type="date" name="course_start_date" class="form-control"
                                    value="{{ old('course_start_date', $student->course_start_date ?? '') }}" required>
                            </div>

                            <!-- Course End Date -->
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Course End Date</label>
                                <input type="date" name="course_end_date" class="form-control"
                                    value="{{ old('course_end_date', $student->course_end_date ?? '') }}" required>
                            </div>

                        </div>
                    </fieldset>
            </div>
            <div class="card-footer">
                <button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
                <button type="submit" class="btn btn-success">Update Student</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
    $(document).ready(function(){
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
