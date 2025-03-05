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
                    Add New Router</button>

                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-striped table-bordered    " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nas Details</th>
                                <th>Online User</th>
                                <th>Location</th>
                                <th>IP</th>
                                <th>Secret</th>
                                <th>Api User</th>
                                <th>Description</th>
                                <th>Server</th>
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
<!-- Add Modal -->
<!-- Add Router Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addRouterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRouterModalLabel">Add New Router</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <form action="{{ route('admin.router.store') }}" method="POST" id="routerForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name">Router Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Router Name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ip_address">IP Address</label>
                                <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="Enter IP Address" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="port">API Port</label>
                                <input type="text" class="form-control" id="port" name="port" value="8728" placeholder="Enter Port" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="api_version">API Version</label>
                                <input type="text" class="form-control" id="api_version" name="api_version" placeholder="e.g., 6.48" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="location">Location (POP/Branch)</label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location">
                            </div>
                            <div class="form-group mb-3">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Any additional remarks"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Router</button>
                </div>
            </form>
        </div>
    </div>
</div>


@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
    handleSubmit('#routerForm','#addModal');
    var table=$("#datatable1").DataTable({
    "processing":true,
    "responsive": true,
    "serverSide":true,
    beforeSend: function () {},
    complete: function(){},
    ajax: "{{ route('admin.pop.get_all_data') }}",
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
            "data":"name",
          },
          {
            "data":"username"
          },
          {
            "data":"phone"
          },
          {
            "data":"status",
            render: function (data, type, row) {
              if (row.status == 1) {
                return '<span class="badge badge-success">Active</span>';
              } else {
                return '<span class="badge badge-danger">Expired</span>';
              }
            }
          },

          {
            data:null,
            render: function (data, type, row) {

              var viewUrl = "{{ route('admin.pop.view', ':id') }}".replace(':id', row.id);


              return `<button  class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>

              <button class="btn btn-danger btn-sm mr-3 delete-btn"  data-id="${row.id}"><i class="fa fa-trash"></i></button>

              <a href="${viewUrl}" class="btn btn-success btn-sm mr-3 "><i class="fa fa-eye"></i></a>


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
            url: "{{ route('admin.pop.edit', ':id') }}".replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#popForm').attr('action', "{{ route('admin.pop.update', ':id') }}".replace(':id', id));
                    $('#ModalLabel').html('<span class="mdi mdi-account-edit mdi-18px"></span> &nbsp;Edit POP/Branch');
                    $('#popForm input[name="name"]').val(response.data.name);
                    $('#popForm input[name="username"]').val(response.data.username);
                    $('#popForm input[name="password"]').val(response.data.password);
                    $('#popForm input[name="phone"]').val(response.data.phone);
                    $('#popForm input[name="email"]').val(response.data.email);
                    $('#popForm input[name="address"]').val(response.data.address);
                    $('#popForm select[name="status"]').val(response.data.status);

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
        var deleteUrl = "{{ route('admin.pop.delete', ':id') }}".replace(':id', id);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').find('input[name="id"]').val(id);
        $('#deleteModal').modal('show');
    });





  </script>
@endsection
