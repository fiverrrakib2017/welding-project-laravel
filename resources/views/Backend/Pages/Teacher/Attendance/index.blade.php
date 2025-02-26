@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<style>
   @media (min-width: 768px) {
    .col-md-6{
        width: 100% !important;
    }
   }
</style>

@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
        <div class="card-header">
          </div>
            <div class="card-body">
                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-striped table-bordered    " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="Custom Checkbox" id="selectAll"> </th>
                                <th class="">Teacher Name </th>
                                <th class="">Phone Number</th>
                                <th class="">Subject</th>
                                <th class="">Designation</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="button" id="submitAttendance" class="btn btn-success">Submit Attendance</button>
            </div>
        </div>

    </div>
</div>




@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){


    // Initialize DataTable
    var table = $("#datatable1").DataTable({
        "processing": true,
        "responsive": true,
        "serverSide": true,
        ajax: {
            url: "{{ route('admin.teacher.attendence.all_data') }}",
            type: 'GET',
            data: function(d) {
                // d.class_id = $('#search_class_id').val();
                // d.section_id = $('#search_section_id').val();
            },
            beforeSend: function(request) {
                request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            }
        },
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        "columns": [
            {
                "data": "id",
                render: function(data, type, row) {
                    return '<input type="checkbox" name="teacher_ids[]" value="' + row.id + '" class="teacher-checkbox Custom Checkbox" ' + (row.attendance_status === 'Present' ? 'checked' : '') + '>';
                }
            },
            {
                "data": "name",
                render: function(data, type, row) {
                    return '<a href="{{ route('admin.teacher.view', '') }}/' + row.id + '">' + data + '</a>';
                }
            },
            { "data": "phone" },
            { "data": "subject" },
            { "data": "designation" },
            {
                "data": null,
                render: function(data, type, row) {
                    var viewUrl = "{{ route('admin.teacher.view', ':id') }}".replace(':id', row.id);
                    return `
                        <a href="${viewUrl}" class="btn btn-success btn-sm mr-3 edit-btn"><i class="fa fa-eye"></i></a>
                    `;
                }
            },
        ],
        order: [
            [0, "desc"]
        ],
    });

    // /*** Class filter changes */
    // $(document).on('change', '#search_class_id', function() {
    //     table.ajax.reload(null, false);
    // });
    // /*section filter changes*/
    // $(document).on('change', '#search_section_id', function() {
    //     table.ajax.reload(null, false);
    // });

    /* Select or Deselect All Checkboxes*/
    $(document).on('click', '#selectAll', function() {
        if ($(this).is(':checked')) {
            $('.teacher-checkbox').prop('checked', true);
        } else {
            $('.teacher-checkbox').prop('checked', false);
        }
    });

    /*** Select or Deselect Individual Checkboxes ***/
    table.on('draw.dt', function() {
        if ($('#selectAll').is(':checked')) {
            $('.teacher-checkbox').prop('checked', true);
        } else {
            $('.teacher-checkbox').prop('checked', false);
        }
    });
    $(document).on('click', '#submitAttendance', function() {
        $('#submitAttendance').prop('disabled', true).html(
            '<i class="fa fa-spinner fa-spin"></i> Submitting...'
        );
        var selectedTeachers = [];
        $('.teacher-checkbox:checked').each(function() {
            selectedTeachers.push($(this).val());
        });
        if(selectedTeachers.length > 0) {
            $.ajax({
                url: "{{ route('admin.teacher.attendence.store') }}",
                type: "POST",
                data: {
                    teacher_ids: selectedTeachers,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred. Please try again.');
                },
                complete: function() {
                    $('#submitAttendance').prop('disabled', false).html('Submit Attendance');
                }
            });
        } else {
            toastr.error('Please select at least one student!');
        }
    });
});
</script>
@endsection

