@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
                <button data-toggle="modal" data-target="#addModal" type="button" class=" btn btn-success mb-2"><i class="mdi mdi-account-plus"></i>
                    Add New IP Pool</button>

                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-striped table-bordered    " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Router IP</th>
                                <th>Name</th>
                                <th>Start IP</th>
                                <th>End IP</th>
                                <th>Net Mask</th>
                                <th>Getway</th>
                                <th>DNS</th>
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
@include('Backend.Modal.Customer.Pool.ip_pool_modal')
@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
    handleSubmit('#poolForm','#addModal');
    var table=$("#datatable1").DataTable({
    "processing":true,
    "responsive": true,
    "serverSide":true,
    beforeSend: function () {},
    complete: function(){},
    ajax: "{{ route('admin.customer.ip_pool.get_all_data') }}",
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
            "data":"router.name",
          },
          {
            "data":"name"
          },
          {
            "data":"start_ip"
          },
          {
            "data":"end_ip"
          },
          {
            "data":"netmask"
          },
          {
            "data":"gateway"
          },
          {
            "data":"dns"
          },

          {
            data:null,
            render: function (data, type, row) {

            //   var viewUrl = "{{ route('admin.pop.view', ':id') }}".replace(':id', row.id);


              return `<button  class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>

              <button class="btn btn-danger btn-sm mr-3 delete-btn"  data-id="${row.id}"><i class="fa fa-trash"></i></button>



              `;
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

        // AJAX call to fetch supplier data
        $.ajax({
            url: "{{ route('admin.customer.ip_pool.edit', ':id') }}".replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#poolForm').attr('action', "{{ route('admin.customer.ip_pool.update', ':id') }}".replace(':id', id));
                    $('#ModalLabel').html('<span class="mdi mdi-account-edit mdi-18px"></span> &nbsp;Edit IP-Pool');
                    $('#poolForm select[name="router_id"]').val(response.data.router_id);
                    $('#poolForm input[name="name"]').val(response.data.name);
                    $('#poolForm input[name="start_ip"]').val(response.data.start_ip);
                    $('#poolForm input[name="end_ip"]').val(response.data.end_ip);
                    $('#poolForm input[name="netmask"]').val(response.data.netmask);
                    $('#poolForm input[name="gateway"]').val(response.data.gateway);
                    $('#poolForm input[name="dns"]').val(response.data.dns);
                    // Show the modal
                    $('#addModal').modal('show');
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
        var deleteUrl = "{{ route('admin.customer.ip_pool.delete', ':id') }}".replace(':id', id);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').find('input[name="id"]').val(id);
        $('#deleteModal').modal('show');
    });





  </script>
@endsection
