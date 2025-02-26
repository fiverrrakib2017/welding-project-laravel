@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
                                <th class="">Id</th>
                                <th class="">Teacher Name </th>
                                <th class="">Phone Number</th>
                                <th class="">Subject</th>
                                <th class="">Designation</th>
                                <th class="">Status</th>
                                <th class="">Date</th>
                                <th class="">Time In</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>




@endsection

@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    /* Create Date Range Filter*/
     var date_filter = '<label style="margin-left: 10px;">';
    date_filter += '<input type="text" id="search_date_range" class="form-control" placeholder="Select Date Range" autocomplete="off" />';
    date_filter += '</label>';

    setTimeout(() => {
        $('.dataTables_length').append(date_filter);

        // Initialize Date Picker
        $('#search_date_range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            autoUpdateInput: false
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            table.ajax.reload(null, false); 
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            table.ajax.reload(null, false); 
        });

    }, 100);


    /* Initialize DataTable*/
    var table = $("#datatable1").DataTable({
        "processing": true,
        "responsive": true,
        "serverSide": true,
        ajax: {
            url: "{{ route('admin.teacher.attendence.log.all_data') }}",
            type: 'GET',
            data: function(d) {
                d.date_range = $('#search_date_range').val(); 
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
            { "data": "id" },
            {
                "data": "teacher.name",
                render: function(data, type, row) {
                    return `<a href="{{ route('admin.student.view', '') }}/${row.teacher.id}">${data}</a>`;
                }
            },
            { 
                "data": "teacher.phone", 
                render: function(data, type, row) {
                    return data ? data : 'N/A';
                }
            },
            { 
                "data": "teacher.subject", 
                render: function(data, type, row) {
                    return data ? data : 'N/A';
                }
            },
            { 
                "data": "teacher.designation", 
                render: function(data, type, row) {
                    return data ? data : 'N/A';
                }
            },
            {
                "data": "status",
               render:function(data,type,row){
                   return `<span class="badge bg-${data === 'Present' ? 'success' : 'danger'}">${data}</span>`
                  
               }
            },
            {
                "data": "attendance_date",
                render:function(data,type,row){
                    return moment(data).format("DD MMMM YYYY");
               }
            },
            { "data": "time_in",
                render:function(data,type,row){
                    if (data) {
                        let date = new Date(`1970-01-01T${data}Z`); 
                        let hours = date.getUTCHours();
                        let minutes = date.getUTCMinutes();
                        let ampm = hours >= 12 ? 'PM' : 'AM';
                        hours = hours % 12; 
                        hours = hours ? hours : 12; 
                        minutes = minutes < 10 ? '0' + minutes : minutes;
                        let strTime = hours + ':' + minutes + ' ' + ampm;
                        return strTime;
                    }
                return 'N/A';
               }
               
            },
            
        ],
        order: [
            [0, "desc"]
        ],
    });



    /*** Class filter changes */ 
    $(document).on('change', '#search_class_id', function() {
        table.ajax.reload(null, false);
    });
    /*section filter changes*/
    $(document).on('change', '#search_section_id', function() {
        table.ajax.reload(null, false);
    });

    
    
});
</script>
@endsection

