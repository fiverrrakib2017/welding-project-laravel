@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
        <div class="card-header">
          <div class="row" id="search_box">
                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label for="exam_id" class="form-label">Examination Name <span class="text-danger">*</span></label>
                        <select name="exam_id" id="exam_id" class="form-control" required>
                            <option value="">---Select---</option>
                            @foreach(\App\Models\Student_exam::latest()->get() as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                        <select name="class_id"  class="form-control" required>
                            <option value="">---Select---</option>
                            @php
                                $classes = \App\Models\Student_class::latest()->get();
                            @endphp
                            @if($classes->isNotEmpty())
                                @foreach($classes as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label for="section_id" class="form-label">Section <span class="text-danger">*</span></label>
                        <select name="section_id" id="section_id" class="form-control" >
                            <option value="">---Select---</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none">
                    <div class="form-group mb-2">
                        <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                        <select name="student_id"  class="form-control" style="width:100%">
                            <option value="">---Select---</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none">
                    <div class="form-group mb-2">
                        <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                        <select name="subject_id" id="subject_id" class="form-control" style="width: 100%" >
                            <option value="">---Select---</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mt-3">
                    <button type="button" name="submit_btn" class="btn btn-success" style="margin-top: 16px"><i class="mdi mdi-magnify"></i> Find Exam Result</button>
                    </div>
                </div>
            </div>
        </div>
            <div class="card-body">
                <div class="table-responsive responsive-table">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead >
                            <tr>
                                <th>No.</th>

                                <th>Examination  Name</th>
                                <th>Student Name</th>
                                <th>Subject Name</th>

                                <th>Marks Obtained</th>
                                <th>Total Marks</th>
                                <th>Grade</th>
                                <th>Remarks</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="_data">
                        <tr id="no-data">
                            <td colspan="10" class="text-center">No data available</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/custom_select.js') }}"></script>
  <script type="text/javascript">
        $('select').select2({
            placeholder: "---Select---",
            allowClear: false
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

    /** Handle Edit button click **/
    $("#datatable1 tbody").on('click', '.edit-btn', function () {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.student.exam.routine.edit', ':id') }}".replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.success) {

                    $('#routineForm').attr('action', "{{ route('admin.student.exam.routine.update', ':id') }}".replace(':id', id));
                    $('#routineModalLabel').html('<span class="mdi mdi-account-edit mdi-18px"></span> &nbsp;Edit Examination Routine');
                    if (!$('#routineForm select[name="class_id"]').hasClass("select2-hidden-accessible")) {
                        $('#routineForm select[name="class_id"]').select2({
                            dropdownParent: $('#routineModal'),
                            placeholder: "---Select---",
                            allowClear: false
                        });
                    }
                    $('#routineForm select[name="class_id"]').val(response.data.class_id);

                    if (!$('#routineForm select[name="exam_id"]').hasClass("select2-hidden-accessible")) {
                        $('#routineForm select[name="exam_id"]').select2({
                            dropdownParent: $('#routineModal'),
                            placeholder: "---Select---",
                            allowClear: false
                        });
                    }
                    $('#routineForm select[name="exam_id"]').val(response.data.exam_id);


                    if (!$('#routineForm select[name="subject_id"]').hasClass("select2-hidden-accessible")) {
                        $('#routineForm select[name="subject_id"]').select2({
                            dropdownParent: $('#routineModal'),
                            placeholder: "---Select---",
                            allowClear: false
                        });
                    }
                    $('#routineForm select[name="subject_id"]').val(response.data.subject_id);


                    $('#routineForm input[name="exam_date"]').val(response.data.exam_date);
                    $('#routineForm input[name="start_time"]').val(response.data.start_time);
                    $('#routineForm input[name="end_time"]').val(response.data.end_time);
                    $('#routineForm input[name="room_number"]').val(response.data.room_number);
                    $('#routineForm input[name="invigilator_name"]').val(response.data.invigilator);

                    /* Show the modal*/
                    $('#routineModal').modal('show');

                } else {
                    toastr.error('Failed to fetch  data.');
                }
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    /** Handle Delete button click**/
    $('#datatable1 tbody').on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        var deleteUrl = "{{ route('admin.student.exam.result.delete', ':id') }}".replace(':id', id);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').find('input[name="id"]').val(id);
        $('#deleteModal').modal('show');
    });

    $("button[name='submit_btn']").on('click',function(e){
        e.preventDefault();
        var exam_id = $("select[name='exam_id']").val();
        var class_id = $("select[name='class_id']").val();
        var section_id = $("select[name='section_id']").val();
        var student_id = $("select[name='student_id']").val();
        var subject_id = $("select[name='subject_id']").val();
        fetch_exam_result_data(exam_id,class_id,section_id,student_id,subject_id);
    });
    function _time_formate(time) {
        let [hour, minute, second] = time.split(':');
        hour = parseInt(hour);
        let ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12 || 12;
        return `${hour}:${minute} ${ampm}`;
    }



     /** Handle form submission for delete **/
   $('#deleteModal form').submit(function(e){
    e.preventDefault();
    /*Get the submit button*/
    var submitBtn =  $('#deleteModal form').find('button[type="submit"]');

    /* Save the original button text*/
    var originalBtnText = submitBtn.html();

    /*Change button text to loading state*/
    submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);

    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();
    /** Use Ajax to send the delete request **/
    $.ajax({
      type:'POST',
      'url':url,
      data: formData,
      success: function (response) {
        $('#deleteModal').modal('hide');
        if (response.success) {
          toastr.success(response.message);
          var rowId = response.data.id;
          $(`#datatable1 tr[data-id="${rowId}"]`).remove();
        }
      },

      error: function (xhr, status, error) {
         /** Handle  errors **/
         toastr.error(xhr.responseText);
      },
      complete: function () {
        submitBtn.html(originalBtnText);
        }
    });
  });
  function fetch_exam_result_data(exam_id,class_id,section_id,student_id,subject_id){
    var submitBtn =  $('#search_box').find('button[name="submit_btn"]');
        submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);
        submitBtn.prop('disabled', true);
    $.ajax({
            type: 'POST',
            url: "{{ route('admin.student.exam.result.get_result') }}",
            cache: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                exam_id: exam_id,
                class_id: class_id,
                section_id: section_id,
                student_id: student_id,
                subject_id: subject_id
            },
            success: function(response) {
            var _number = 1;
            var html = '';

            /*Check if the response data is an array*/
            if (Array.isArray(response.data) && response.data.length > 0) {
                response.data.forEach(function(data) {

                    html += '<tr data-id="' + data.id + '">';
                    html += '<td>' + (_number++) + '</td>';
                    html += '<td>' + (data.exam ? data.exam.name : 'N/A') + '</td>';
                    html += '<td>' + (data.student ? data.student.name : 'N/A') + '</td>';
                    html += '<td>' + (data.subject ? data.subject.name : 'N/A') + '</td>';
                    html += '<td>' + data.marks_obtained + '</td>';
                    html += '<td>' + data.total_marks + '</td>';
                    html += '<td>' + data.grade + '</td>';
                    html += '<td>' + data.remarks + '</td>';
                    html += '<td>';
                    html += '<a href="' + "{{ route('admin.student.exam.result.edit', ':id') }}".replace(':id', data.id) + '" class="btn btn-primary btn-sm me-2"><i class="fa fa-edit"></i></a>';
                    html += '<button class="btn btn-danger btn-sm delete-btn" data-id="' + data.id + '"><i class="fa fa-trash"></i></button>';
                    html += '</td>';
                    html += '</tr>';
                });
            } else {
                html += '<tr>';
                html += '<td colspan="10" style="text-align: center;">No Data Available</td>';
                html += '</tr>';
            }

            $("#_data").html(html);
        },
        error: function() {
            toastr.error('An error occurred. Please try again.');
        },
        complete:function(){
            submitBtn.html('<i class="mdi mdi-magnify"></i> Find Exam Result');
            submitBtn.prop('disabled', false);
        }

        });
  }

    $('#routineModal').on('shown.bs.modal', function () {
        $('#routineForm select').trigger('change.select2');
    });
  </script>
@endsection
