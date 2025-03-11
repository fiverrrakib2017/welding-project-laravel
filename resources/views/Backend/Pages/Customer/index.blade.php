@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
                <button data-toggle="modal" data-target="#addCustomerModal" type="button" class=" btn btn-success mb-2"><i class="mdi mdi-account-plus"></i>
                    Add New Customer</button>

                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1"  class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="custom-control-input" id="selectAllCheckbox" name="selectAll">
                                </th>

                                <th>ID</th>
                                <th>Name</th>
                                <th>Package</th>
                                <th>Amount</th>
                                <th>Create Date</th>
                                <th>Expired Date</th>
                                <th>User Name</th>
                                <th>Mobile no.</th>
                                <th>POP/Branch</th>
                                <th>Area/Location</th>
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
@include('Backend.Modal.Customer.customer_modal')
@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
    /*Add Modal Submit*/
    handleSubmit('#addCustomerForm','#addCustomerModal');
    /*update Modal Submit*/
    handleSubmit('#editCustomerForm','#editCustomerModal');
    var table=$("#datatable1").DataTable({
    "processing":true,
    "responsive": true,
    "serverSide":true,
    beforeSend: function () {},
    complete: function(){},
    ajax: "{{ route('admin.customer.get_all_data') }}",
    language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
    },
    "columns":[
        {
        "data": null,
        "render": function(data, type, row, meta) {
            return '<div class="custom-control custom-checkbox">' +
                '<input type="checkbox" class="custom-control-input" id="checkbox_' + meta.row + '" name="checkbox_' + meta.row + '">' +
                '<label class="custom-control-label" for="checkbox_' + meta.row + '"></label>' +
                '</div>';
            }
        },
        {
        "data":"id"
        },
        {
        "data": "fullname",
        "render": function(data, type, row) {
            var viewUrl = '{{ route("admin.customer.view", ":id") }}'.replace(':id', row.id);
            /*Set the icon based on the status*/
            var icon = '';
            var color = '';

            if (row.status === 'online') {
                icon = '<i class="fas fa-unlock" style="font-size: 15px; color: green; margin-right: 8px;"></i>';
            } else if (row.status === 'offline') {
                icon = '<i class="fas fa-lock" style="font-size: 15px; color: red; margin-right: 8px;"></i>';
            } else {
                icon = '<i class="fa fa-question-circle" style="font-size: 18px; color: gray; margin-right: 8px;"></i>';
            }

            return '<a href="' + viewUrl + '" style="display: flex; align-items: center; text-decoration: none; color: #333;">' +
                icon +
                '<span style="font-size: 16px; font-weight: bold;">' + row.fullname + '</span>' +
                '</a>';
        }
    },



          {
            "data":"package.name"
          },
          {
            "data":"amount"
          },
          {
            "data": "created_at",
            "render": function(data, type, row) {
                var date = new Date(data);
                var options = { year: 'numeric', month: 'short', day: '2-digit' };
                return date.toLocaleDateString('en-GB', options);
            }
        },

        {
            "data": "expire_date",
            "render": function(data, type, row) {
                var expireDate = new Date(data);
                var todayDate = new Date();
                todayDate.setHours(0, 0, 0, 0);

                if ( todayDate > expireDate ) {
                    return '<span class="badge bg-danger">Expire</span>';
                } else {
                    return data;
                }
            }
        },


          {
            "data":"username"
          },
          {
            "data":"phone"
          },
          {
            "data":"pop.name"
          },
          {
            "data":"area.name"
          },

          {
            data:null,
            render: function (data, type, row) {
            var viewUrl = '{{ route("admin.customer.view", ":id") }}'.replace(':id', row.id);

            return `
                <button class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}">
                    <i class="fa fa-edit"></i>
                </button>

                <button class="btn btn-danger btn-sm mr-3 delete-btn" data-id="${row.id}">
                    <i class="fa fa-trash"></i>
                </button>

                <a href="${viewUrl}" class="btn-sm btn btn-success mr-3">
                    <i class="fa fa-eye"></i>
                </a>
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
        $.ajax({
            url: "{{ route('admin.customer.edit', ':id') }}".replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editCustomerForm').attr('action', "{{ route('admin.customer.update', ':id') }}".replace(':id', id));
                    $('#editCustomerModal input[name="fullname"]').val(response.data.fullname);
                    $('#editCustomerModal input[name="username"]').val(response.data.username);
                    $('#editCustomerModal input[name="password"]').val(response.data.password);
                    $('#editCustomerModal input[name="phone"]').val(response.data.phone);
                    $('#editCustomerModal input[name="nid"]').val(response.data.nid);
                    $('#editCustomerModal input[name="con_charge"]').val(response.data.con_charge);
                    $('#editCustomerModal input[name="amount"]').val(response.data.amount);
                    $('#editCustomerModal input[name="address"]').val(response.data.address);
                    $('#editCustomerModal input[name="remarks"]').val(response.data.remarks);

                    $('#editCustomerModal select[name="pop_id"]').val(response.data.pop_id).select2();
                    $('#editCustomerModal select[name="router_id"]').val(response.data.router_id).select2();
                    $('#editCustomerModal select[name="area_id"]').val(response.data.area_id).select2();
                    $('#editCustomerModal select[name="package_id"]').val(response.data.package_id).select2();
                    $('#editCustomerModal select[name="liabilities"]').val(response.data.liabilities).select2();
                    $('#editCustomerModal select[name="status"]').val(response.data.status).trigger('change');



                    // Show the modal
                    $('#editCustomerModal').modal('show');
                } else {
                    toastr.error('Failed to fetch data.');
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
        var deleteUrl = "{{ route('admin.customer.delete', ':id') }}".replace(':id', id);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').find('input[name="id"]').val(id);
        $('#deleteModal').modal('show');
    });





  </script>
@endsection
