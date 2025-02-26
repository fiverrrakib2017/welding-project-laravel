@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Create Exam Result</h5>
                    <button type="button" onclick="history.back();" class="btn btn-danger btn-sm">
                        <i class="fa fa-arrow-left"></i> Back
                    </button>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.student.exam.result.store') }}" method="POST" id="examResultForm">
                        @csrf

                        <ul class="nav nav-tabs mb-3" id="formTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="exam-tab" data-toggle="tab" data-target="#exam" type="button" role="tab" aria-controls="exam" aria-selected="true">Exam Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="student-tab" data-toggle="tab" data-target="#student" type="button" role="tab" aria-controls="student" aria-selected="false">Student Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="marks-tab" data-toggle="tab" data-target="#marks" type="button" role="tab" aria-controls="marks" aria-selected="false">Marks & Remarks</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="formTabsContent">
                            <!-- Exam Details -->
                            <div class="tab-pane fade show active" id="exam" role="tabpanel" aria-labelledby="exam-tab">
                                <div class="mb-3">
                                    <label for="exam_id" class="form-label">Exam <span class="text-danger">*</span></label>
                                    <select name="exam_id" id="exam_id" class="form-control" required>
                                        <option value="" selected disabled>Select an Exam</option>
                                        @foreach(\App\Models\Student_exam::latest()->get() as $exam)
                                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_id" class="form-control" required>
                                        <option value="">---Select---</option>
                                        @foreach(\App\Models\Student_class::latest()->get() as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="section_id" class="form-label">Section <span class="text-danger">*</span></label>
                                    <select name="section_id" id="section_id" class="form-control" required>
                                        <option value="">---Select---</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Student Details -->
                            <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                                <div class="mb-3">
                                    <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                                    <select name="student_id" id="student_id" class="form-control" style="width: 100%" required>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                                    <select name="subject_id" id="subject_id" class="form-control" style="width: 100%" required>
                                        <option value="">---Select---</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Marks & Remarks -->
                            <div class="tab-pane fade" id="marks" role="tabpanel" aria-labelledby="marks-tab">
                                <div class="mb-3">
                                    <label for="marks_obtained" class="form-label">Marks Obtained <span class="text-danger">*</span></label>
                                    <input type="number" name="marks_obtained" id="marks_obtained" class="form-control" placeholder="Enter Marks Obtained" required>
                                </div>
                                <div class="mb-3">
                                    <label for="total_marks" class="form-label">Total Marks <span class="text-danger">*</span></label>
                                    <input type="number" name="total_marks" id="total_marks" class="form-control" placeholder="Enter Total Marks" required>
                                </div>
                                <div class="mb-3">
                                    <label for="grade" class="form-label">Grade</label>
                                    <input type="text" name="grade" id="grade" class="form-control" placeholder="Enter Grade (Optional)">
                                </div>
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea name="remarks" id="remarks" rows="3" class="form-control" placeholder="Enter Remarks (Optional)"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="reset" class="btn btn-danger me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Save Result</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script  src="{{ asset('Backend/assets/js/custom_select.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('select').select2({
            placeholder: "---Select---",
            allowClear: false
        });

    });


    $(document).on('change','select[name="class_id"]',function(){
        var sections = @json($sections);
        var subjects = @json($subjects);
        var students = @json($students);
        /*Get Class ID*/
        var selectedClassId = $(this).val();

        var filteredStudents = students.filter(function(student) {
            /*Filter class by class_id*/
            return student.current_class  == selectedClassId;
        });
        var filteredSections = sections.filter(function(section) {
            /*Filter sections by class_id*/
            return section.class_id == selectedClassId;
        });
        /* Update Subject dropdown*/
        var filteredSubjects = subjects.filter(function(subject) {
            /*Filter subject by class_id*/
            return subject.class_id == selectedClassId;
        });

        /* Update Student dropdown*/
        var studentOptions = '<option value="">--Select--</option>';
        filteredStudents.forEach(function(student) {
            studentOptions += '<option value="' + student.id + '">' + student.name + '</option>';
        });
        /* Update Section dropdown*/
        var sectionOptions = '<option value="">--Select--</option>';
        filteredSections.forEach(function(section) {
            sectionOptions += '<option value="' + section.id + '">' + section.name + '</option>';
        });
        /* Update Subject dropdown*/
        var subjectOptions = '<option value="">--Select--</option>';
        filteredSubjects.forEach(function(subject) {
            subjectOptions += '<option value="' + subject.id + '">' + subject.name + '</option>';
        });

        $('select[name="student_id"]').html(studentOptions);
        $('select[name="student_id"]').select2();

        $('select[name="section_id"]').html(sectionOptions);
        $('select[name="section_id"]').select2();

        $('select[name="subject_id"]').html(subjectOptions);
        $('select[name="subject_id"]').select2();

    });



    $("#examResultForm").submit(function(e) {
            e.preventDefault();

            /* Get the submit button */
            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();

            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden"></span>');
            submitBtn.prop('disabled', true);

            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success==true) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 500);

                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        /* Validation error*/
                        var errors = xhr.responseJSON.errors;

                        /* Loop through the errors and show them using toastr*/
                        $.each(errors, function(field, messages) {
                            $.each(messages, function(index, message) {
                                /* Display each error message*/
                                toastr.error(message);
                            });
                        });
                    } else {
                        /*General error message*/
                        toastr.error('An error occurred. Please try again.');
                    }
                },
                complete: function() {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                }
            });
        });

  </script>
@endsection
