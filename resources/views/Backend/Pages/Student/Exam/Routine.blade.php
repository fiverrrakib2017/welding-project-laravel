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
                    <div class="form-group">
                        <label for="">Class</label>
                        <select name="find_class_id"  class="form-control" style="width: 100%">
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
                    <div class="form-group">
                        <label for="">Examination Name</label>
                        <select name="find_exam_id"  class="form-control" style="width: 100%">
                            <option value="">---Select---</option>
                            @php
                                $exams = \App\Models\Student_exam::latest()->get();
                            @endphp
                            @if($exams->isNotEmpty())
                                @foreach($exams as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mt-4">
                    <button type="button" name="submit_btn" class="btn btn-success mt-1"><i class="mdi mdi-magnify"></i> Find Examination Routine</button>

                </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mt-4">
                    <button  type="button" data-toggle="modal" data-target="#routineModal" type="button" class="btn btn-primary ">Create Examination Routine</button>
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

                                <th>Subject Name</th>
                                <th>Exam Date</th>

                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Room Number</th>
                                <th>Invigilator</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="routine_data">
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
@include('Backend.Modal.Student.routine_modal')
@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/custom_select.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $("select[name='find_class_id']").select2();
        $("select[name='find_exam_id']").select2();
        custom_select2('#routineModal');
        _handleSubmit('#routineForm','#routineModal');
        $("#datatable1").DataTable();

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
        var deleteUrl = "{{ route('admin.student.exam.routine.delete', ':id') }}".replace(':id', id);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').find('input[name="id"]').val(id);
        $('#deleteModal').modal('show');
    });

    $(document).on('change','select[name="class_id"]',function(){
        var class_id = $(this).val();
        $.ajax({
            url: "{{ route('admin.student.subject.get_subject_by_class') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                class_id: class_id
            },
            success: function(response) {
                var subjectOptions = '<option value="">--Select Subject--</option>';
                response.data.forEach(function(subject) {
                    subjectOptions += '<option value="' + subject.id + '">' + subject.name + '</option>';
                });
                $('select[name="subject_id"]').html(subjectOptions);
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    $("button[name='submit_btn']").on('click',function(e){
        e.preventDefault();
        var class_id = $("select[name='find_class_id']").val();
        var exam_id = $("select[name='find_exam_id']").val();
        fetch_exam_routine_data(class_id,exam_id)
    });
    function _time_formate(time) {
        let [hour, minute, second] = time.split(':');
        hour = parseInt(hour);
        let ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12 || 12; // 12-hour format
        return `${hour}:${minute} ${ampm}`;
    }

    function _handleSubmit(formSelector, modalSelector) {
        $(formSelector).submit(function(e) {
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
                        /* Hide the modal */
                        $(modalSelector).modal('hide');
                        /* Reload the Page */
                        let class_id = $("select[name='find_class_id']").val();
                        let exam_id = $("select[name='find_exam_id']").val();

                        if (class_id && exam_id && class_id.trim() !== '' && exam_id.trim() !== '') {
                            fetch_exam_routine_data(class_id, exam_id);
                        } else {
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }

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
  function fetch_exam_routine_data(class_id,exam_id){
    var submitBtn =  $('#search_box').find('button[name="submit_btn"]');
        submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);
        submitBtn.prop('disabled', true);
    $.ajax({
            type: 'POST',
            url: "{{ route('admin.student.exam.routine.get_exam_routine') }}",
            cache: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                class_id: class_id,
                exam_id: exam_id,
            },
            success: function(response) {
            var _number = 1;
            var html = '';

            /*Check if the response data is an array*/
            if (Array.isArray(response.data) && response.data.length > 0) {
                response.data.forEach(function(data) {

                    html += '<tr data-id="' + data.id + '">';
                    html += '<td>' + (_number++) + '</td>';
                    html += '<td>' + (data.subject ? data.subject.name : 'N/A') + '</td>';
                    html += '<td>' + data.exam_date + '</td>';
                    html += '<td>' + _time_formate(data.start_time) + '</td>';
                    html += '<td>' +_time_formate( data.end_time) + '</td>';
                    html += '<td>' + data.room_number + '</td>';
                    html += '<td>' + data.invigilator + '</td>';
                    html += '<td>';
                    html += '<button class="btn btn-primary btn-sm me-2 edit-btn" data-id="' + data.id + '" style="margin-right:5px"><i class="fa fa-edit"></i></button>';
                    html += '<button class="btn btn-danger btn-sm delete-btn" data-id="' + data.id + '"><i class="fa fa-trash"></i></button>';
                    html += '</td>';
                    html += '</tr>';
                });
            } else {
                html += '<tr>';
                html += '<td colspan="10" style="text-align: center;">No Data Available</td>';
                html += '</tr>';
            }

            $("#routine_data").html(html);
        },
        error: function() {
            toastr.error('An error occurred. Please try again.');
        },
        complete:function(){
            submitBtn.html('<i class="mdi mdi-magnify"></i> Find Examination Routine');
            submitBtn.prop('disabled', false);
        }

        });
  }

    $('#routineModal').on('shown.bs.modal', function () {
        $('#routineForm select').trigger('change.select2');
    });
  </script>
@endsection
