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
                    Add New POP/Area</button>

                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-striped table-bordered    " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>POP/Branch Name</th>
                                <th>Area Name</th>
                                <th>Billing Cycle</th>
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
@include('Backend.Modal.Pop.Area.pop_area_modal')
@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
    handleSubmit('#popForm','#addModal');
    var table=$("#datatable1").DataTable({
    "processing":true,
    "responsive": true,
    "serverSide":true,
    beforeSend: function () {},
    complete: function(){},
    ajax: "{{ route('admin.pop.area.get_all_data') }}",
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
            "data":"pop.name",
          },
          {
            "data":"name",
          },
          {
            "data":"billing_cycle"
          },

          {
            data:null,
            render: function (data, type, row) {

              var viewUrl = "{{ route('admin.pop.area.view', ':id') }}".replace(':id', row.id);


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
            url: "{{ route('admin.pop.area.edit', ':id') }}".replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#popForm').attr('action', "{{ route('admin.pop.area.update', ':id') }}".replace(':id', id));
                    $('#ModalLabel').html('<span class="mdi mdi-account-edit mdi-18px"></span> &nbsp;Edit POP/Area');
                    $('#popForm select[name="pop_id"]').val(response.data.pop_id).trigger('change');
                    $('#popForm input[name="name"]').val(response.data.name);
                    $('#popForm select[name="billing_cycle"]').val(response.data.billing_cycle).trigger('change');

                    // Show the modal
                    $('#addModal').modal('show');
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
        var deleteUrl = "{{ route('admin.pop.area.delete', ':id') }}".replace(':id', id);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').find('input[name="id"]').val(id);
        $('#deleteModal').modal('show');
    });





  </script>
@endsection
