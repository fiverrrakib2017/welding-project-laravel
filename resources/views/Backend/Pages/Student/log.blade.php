@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
<style>
    .dataTables_filter {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 600;
        color: #333;
    }

    .dataTables_filter input,
    .dataTables_filter select {
        height: 35px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 5px;
    }

    .select2-container--default .select2-selection--single {
        height: 35px !important;
        line-height: 35px !important;
        border-radius: 5px;
    }
</style>

@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="tableStyle">
                        <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Student Name</th>
                                <th>Ip Address</th>
                                <th>Operation By</th>
                                <th>Type</th>
                                <th>Description</th>
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

<script type="text/javascript">
    var baseUrl = "{{ url('/') }}";
       $(document).ready(function() {
           /* From Date */
           var from_date = `<label>
                            <span>From:</span>
                            <input class="from_date form-control" type="date" value="">
                        </label>`;

           /* To Date */
           var to_date = `<label>
                            <span>To:</span>
                            <input class="to_date form-control" type="date" value="">
                        </label>`;

           setTimeout(() => {
               let filterContainer = $('.dataTables_filter');
               let lengthContainer = $('.dataTables_length');

               lengthContainer.parent().removeClass('col-sm-12 col-md-6');
               filterContainer.parent().removeClass('col-sm-12 col-md-6');

               filterContainer.append(from_date);
               filterContainer.append(to_date);

               $('.status_filter').select2({
                   width: '150px'
               });
               $('.bill_collect').select2({
                   width: '150px'
               });
           }, 1000);

           var table = $("#datatable1").DataTable({
               "processing": true,
               "responsive": true,
               "serverSide": true,
               ajax: {
                   url: "{{ route('admin.student.log.get_all_data') }}",
                   data: function(d) {
                       d.start = d.start || 0;
                       d.length = d.length || 10;
                       d.from_date = $('.from_date').val();
                       d.to_date = $('.to_date').val();

                   },
               },
               language: {
                   searchPlaceholder: 'Search...',
                   sSearch: '',
                   lengthMenu: '_MENU_ items/page',
               },
               "columns": [{
                       "data": "id"
                   },
                   {
                       "data": "created_at",
                       "render": function(data, type, row) {
                           var date = new Date(data);

                           var dateOptions = {
                               year: 'numeric',
                               month: 'short',
                               day: '2-digit'
                           };
                           var formattedDate = date.toLocaleDateString('en-GB', dateOptions);

                           var timeOptions = {
                               hour: '2-digit',
                               minute: '2-digit',
                               second: '2-digit',
                               hour12: true
                           };
                           var formattedTime = date.toLocaleTimeString('en-GB', timeOptions);

                           return formattedDate + "<br><span class='text-success'>" + formattedTime + "</span>";
                       }
                   },

                   {
                       "data": "student.name",
                   },
                   {
                       "data": "ip_address"
                   },
                   {
                       "data": "user.name"
                   },
                   {
                       "data": "action_type",
                       "render": function(data, type, row) {
                           if (data == 'add') {
                               return '<span class="badge bg-success">Add</span>';
                           } else if (data == 'edit') {
                               return '<span class="badge bg-danger">Edit</span>';
                           } else if (data == 'delete') {
                               return '<span class="badge bg-danger">Deleted</span>';
                           } else {
                               return '<span class="badge bg-danger">N/A</span>';
                           }
                       }
                   },
                   {
                       "data": "description",
                   },

               ],
               order: [
                   [0, "desc"]
               ],
           });
           /* Filter Change Event*/
           $(document).on('change', '.from_date, .to_date', function() {
               $('#datatable1').DataTable().ajax.reload();
           });
       });
   </script>

@endsection
