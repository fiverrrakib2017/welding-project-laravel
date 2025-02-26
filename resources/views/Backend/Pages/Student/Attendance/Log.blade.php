@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
        <div class="card-header">
          <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Class</label>
                        <select name="class_id"  class="form-control">
                            <option value="">---Select---</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Section </label>
                        <select name="section_id"  class="form-control">
                            <option value="">---Select---</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Type</label>
                        <select name="attendance_type"  class="form-control">
                            <option value="">---Select---</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Date </label>
                        <input type="text" id="date_range" class="form-control" placeholder="Select Date Range" autocomplete="off" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mt-4">
                    <button type="button" name="submit_btn" class="btn btn-success mt-1"><i class="mdi mdi-magnify"></i> Report Find</button>
                    </div>
                </div>
            </div>
        </div>
            <div class="card-body">
                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-striped table-bordered    " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="">Id</th>
                                <th class="">Student Name </th>
                                <th class="">Class </th>
                                <th class="">Section</th>
                                <th class="">Status</th>
                                <th class="">Date</th>
                                <th class="">Time In</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr id="no-data">
                            <td colspan="7" class="text-center">No data available</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>




@endsection

@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("select[name='class_id']").select2();
    $("select[name='section_id']").select2();

    $(document).on('change','select[name="class_id"]', function() {
        var sections = @json($sections);
        var selectedClassId = $(this).val();

        var filteredSections = sections.filter(function(section) {
            return section.class_id == selectedClassId;
        });

        var sectionOptions = '<option value="">--Select Section--</option>';
        filteredSections.forEach(function(section) {
            sectionOptions += '<option value="' + section.id + '">' + section.name + '</option>';
        });

        $('select[name="section_id"]').html(sectionOptions);
        $('select[name="section_id"]').select2();
    });

    $("button[name='submit_btn']").on('click', function(e) {
        e.preventDefault();

        var submitBtn = $('button[name="submit_btn"]');
        var originalBtnText = submitBtn.html();
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
        submitBtn.prop('disabled', true);

        var class_id = $("select[name='class_id']").val();
        var section_id = $("select[name='section_id']").val();
        var attendance_type = $("select[name='attendance_type']").val();
        var date_range = $('#date_range').val();
        var student_id = null;

        if (class_id != '') {
            $.ajax({
                url: "{{ route('admin.student.attendence.report') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { class_id: class_id, section_id: section_id, student_id: student_id, date_range: date_range, attendance_type:attendance_type },
                success: function(data) {
                    if (data.code == 200 && data.data.length > 0 && data.data != null && data.data != undefined && data.data != '' && data.data != 'null' && data.data != 'undefined') {

                        var students = data.data;
                        var html = '';

                        $.each(students, function(index, attendanceArray) {
                            $.each(attendanceArray, function(index, attendance) {
                                var student = attendance.student;
                                var status;
                                if (attendance.status == 'Present') {
                                    status ='<span class="badge bg-success">Present</span>';
                                }else if(attendance.status == 'Absent'){
                                    status ='<span class="badge bg-danger">Absent</span>';
                                }else if(attendance.status == 'Leave'){
                                    status ='<span class="badge bg-warning">Leave</span>';
                                }
                                /*Attendance Time Formate*/
                                var timeIn = 'N/A';
                                if (attendance.time_in) {
                                    let date = new Date(`1970-01-01T${attendance.time_in}Z`);
                                    let hours = date.getUTCHours();
                                    let minutes = date.getUTCMinutes();

                                    let ampm = hours >= 12 ? 'PM' : 'AM';
                                    hours = hours % 12;
                                    hours = hours ? hours : 12;
                                    minutes = minutes < 10 ? '0' + minutes : minutes;
                                    timeIn = hours + ':' + minutes + ' ' + ampm;
                                }
                                html += '<tr>';
                                html += '<td>' + attendance.id + '</td>';
                                html += '<td>' + student.name + '</td>';
                                html += '<td>' + student.current_class.name + '</td>';
                                html += '<td>' + student.section.name + '</td>';
                                html += '<td>' + status + '</td>';
                                html += '<td>' + attendance.attendance_date + '</td>';
                                html += '<td>' + timeIn + '</td>';
                                html += '</tr>';
                            });
                        });

                        $('#datatable1 tbody').html(html);
                        $('#datatable1').DataTable();
                    } else {
                        $('#datatable1 tbody').html('<tr id="no-data"><td colspan="7" class="text-center">No data available</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred. Please try again.');
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                },
                complete:function(){
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                }
            });
        } else {
            toastr.error('Please select class.');
            submitBtn.html(originalBtnText);
            submitBtn.prop('disabled', false);
        }
    });

    // Date Range Picker Initialization
    $('#date_range').daterangepicker({
        locale: { format: 'YYYY-MM-DD' },
        autoUpdateInput: false
    }).on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    }).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>
@endsection

