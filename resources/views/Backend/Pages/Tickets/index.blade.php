@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
                <button data-toggle="modal" data-target="#ticketModal" type="button" class=" btn btn-success mb-2"><i class="mdi mdi-account-plus"></i>
                    Add New Ticket</button>

                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Priority</th>
                                <th>Student Name</th>
                                <th>Phone Number</th>
                                <th>Issues</th>
                                <th>Assigned To</th>
                                <th>Ticket For</th>
                                <th>Acctual Work</th>
                                <th>Percentage</th>
                                <th>Note</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@include('Backend.Modal.Tickets.ticket_modal')
@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/custom_select.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
    custom_select2('#ticketModal');
    handleSubmit('#ticketForm','#ticketModal');
    var table=$("#datatable1").DataTable({
    "processing":true,
    "responsive": true,
    "serverSide":true,
    beforeSend: function () {},
    complete: function(){},
    ajax: "{{ route('admin.tickets.get_all_data') }}",
    language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
    },
    "columns":[
          {
            "data":"id"
          },
          {
            "data":"status",
            render:function(data,type,row){
                if(row.status == 0){
                    return '<span class="badge bg-danger">Active</span>';
                }else if(row.status == 2){
                    return '<span class="badge bg-warning">Pending</span>';
                }else if(row.status==1){
                    return '<span class="badge bg-success">Completed</span>';
                }
            }
          },
          {
            "data":"created_at",
            render: function (data, type, row) {
                return moment(row.created_at).format('D MMMM YYYY');
            }
          },
          {
            "data": "priority_id",
            render: function (data, type, row) {
                let priorityLabel = '';
                switch (row.priority_id) {
                    case 1:
                        priorityLabel = 'Low';
                        break;
                    case 2:
                        priorityLabel = 'Normal';
                        break;
                    case 3:
                        priorityLabel = 'Standard';
                        break;
                    case 4:
                        priorityLabel = 'Medium';
                        break;
                    case 5:
                        priorityLabel = 'High';
                        break;
                    case 6:
                        priorityLabel = 'Very High';
                        break;
                    default:
                        priorityLabel = 'Unknown';
                        break;
                }
                return priorityLabel;
            }

          },
          {
            "data":"student.name"
          },
          {
            "data":"student.phone"
          },
          {
            "data":"complain_type.name"
          },
          {
            "data":"assign.name"
          },
          {
            "data":"ticket_for",
            render: function (data, type, row) {
                if (row.ticket_for == 1) {
                    return `Default`;
                }
            }
          },
          {
            "data":null,
            render: function (data, type, row) {
                if(row.updated_at == row.created_at){
                    return 'N/A';
                }
                if (row.updated_at && row.created_at) {
                    let start = moment(row.created_at);
                    let end = moment(row.updated_at);

                    return end.from(start);
                } else {
                    return 'N/A';
                }
            }
          },
          {
            "data":"percentage"
          },
          {
            "data":"note"
          },

          {
            data:null,
            render: function (data, type, row) {
              return `<button  class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>

                <button class="btn btn-danger btn-sm mr-3 delete-btn"  data-id="${row.id}"><i class="fa fa-trash"></i></button>`;
            }

          },
        ],
    order:[
        [0, "desc"]
    ],

    });

    });








    /** Handle Edit button click **/
    $('#datatable1 tbody').on('click', '.edit-btn', function () {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.tickets.edit', ':id') }}".replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#ticketForm').attr('action', "{{ route('admin.tickets.update', ':id') }}".replace(':id', id));
                    $('#ticketModalLabel').html('<span class="mdi mdi-account-edit mdi-18px"></span> &nbsp;Edit Ticket');
                    $('#ticketForm select[name="student_id"]').val(response.data.student_id);
                    $('#ticketForm select[name="ticket_for"]').val(response.data.ticket_for);
                    $('#ticketForm select[name="ticket_assign_id"]').val(response.data.ticket_assign_id);
                    $('#ticketForm select[name="ticket_complain_id"]').val(response.data.ticket_complain_id);
                    $('#ticketForm select[name="priority_id"]').val(response.data.priority_id);
                    $('#ticketForm input[name="subject"]').val(response.data.subject);
                    $('#ticketForm textarea[name="description"]').val(response.data.description);
                    $('#ticketForm input[name="note"]').val(response.data.note);
                    $('#ticketForm select[name="status_id"]').val(response.data.status);
                    $('#ticketForm select[name="percentage"]').val(response.data.percentage);

                    // Show the modal
                    $('#ticketModal').modal('show');
                } else {
                    toastr.error('Failed to fetch Supplier data.');
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
        var deleteUrl = "{{ route('admin.tickets.delete', ':id') }}".replace(':id', id);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').find('input[name="id"]').val(id);
        $('#deleteModal').modal('show');
    });





  </script>
@endsection
