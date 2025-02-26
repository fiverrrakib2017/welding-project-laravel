@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                  <a href="{{route('admin.supplier.invoice.create_invoice')}}" class="btn-sm btn btn-success mb-2"><i class="mdi mdi-account-plus"></i>
                    Add New Invoice</a>
            </div>
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                            <th class="">Invoice No.</th>
                            <th class="">Supplier Name</th>
                            <th class="">Phone Number</th>
                            <th class="">Total Amount</th>
                            <th class="">Paid Amount</th>
                            <th class="">Due Amount</th>
                            <th class="">Status</th>
                            <th class="">Create Date</th>
                            <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="payModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add Payment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!----- Start Add Form ------->
            <form  action="{{ route('admin.supplier.invoice.pay_due_amount') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!----- Start Add Form input ------->
                    <input type="number" name="id" class="d-none" required>
                    <div class="row">
                        <div class="form-group mb-2">
                            <label for="sectionName">Amount:</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter Your Amount" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success tx-size-xs">Save changes</button>
                    <button type="button" class="btn btn-danger tx-size-xs" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
            <!----- End Add Form ------->
        </div>
    </div>
</div>
<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <form action="{{route('admin.supplier.invoice.delete_invoice')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fas fa-trash"></i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <input type="hidden" name="id" value="">
                <a class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="mdi mdi-close"></i></a>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function(){

      var table=$("#datatable1").DataTable({
         "processing":true,
        "responsive": true,
        "serverSide":true,
        beforeSend: function () {
        },
        ajax: "{{ route('admin.supplier.invoice.show_invoice_data') }}",
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
            "data":"supplier.fullname",
            render:function(data,type,row){
                var link ="{{ route('admin.supplier.view', ':id') }}".replace(':id', row.supplier.id);
                return '<a href="'+link+'">'+row.supplier.fullname+'</a>';
            }
          },
          {
            "data":"supplier.phone_number"
          },
          {
            "data":"sub_total"
          },
          {
            "data":"paid_amount"
          },
          {
            "data":"due_amount"
          },
          {
            "data":null,
            render:function(data,type,row){
              if (row.due_amount==0) {
                return '<span class="badge bg-success">Paid</span>';
              }else{
                 return '<span class="badge bg-danger">Not Paid</span>';
              }
            }
          },
          {
            "data":"created_at",
            render: function (data, type, row) {
                var formattedDate = moment(row.created_at).format('DD MMM YYYY');
                return formattedDate;
            }
          },
          {
            "data":null,
            render:function(data,type,row){
                var editUrl = "{{ route('admin.supplier.invoice.edit_invoice', ':id') }}";
                var viewUrl = "{{ route('admin.supplier.invoice.view_invoice', ':id') }}";
                editUrl = editUrl.replace(':id', row.id);
                viewUrl = viewUrl.replace(':id', row.id);

                if (row.due_amount==0) {
                  return `
                  <a href="${viewUrl}" class="btn btn-success btn-sm mr-3" ><i class="fa fa-eye"></i></a>

                  <a href="${editUrl}" class="btn btn-primary btn-sm mr-3 "><i class="fa fa-edit"></i></a>

                  <button class="btn btn-danger btn-sm mr-3 delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fa fa-trash"></i></button>
                  `;
                }else{
                  return `
                  <button class="btn btn-primary btn-sm mr-3 pay-button"  data-id="${row.id}">Pay Now</button>

                  <a href="${viewUrl}" class="btn btn-success btn-sm mr-3" ><i class="fa fa-eye"></i></a>

                  <a href="${editUrl}" class="btn btn-primary btn-sm mr-3 "><i class="fa fa-edit"></i></a>

                  <button class="btn btn-danger btn-sm mr-3 delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fa fa-trash"></i></button>
                  `;
                }
            }
          },
        ],
        order:[
          [0, "desc"]
        ],

      });
    });

  /** Handle Delete button click**/
  $('#datatable1 tbody').on('click', '.delete-btn', function () {
    var id = $(this).data('id');
    $('#deleteModal').modal('show');
    var value_input = $("input[name*='id']").val(id);
  });

  /** Handle form submission for delete **/
  $('#deleteModal form').submit(function(e){
    e.preventDefault();

    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();
    /** Use Ajax to send the delete request **/
    $.ajax({
      type:'POST',
      'url':url,
      data: formData,
      success: function (response) {
        if (response.original.success==true) {
          $('#deleteModal').modal('hide');
          toastr.success(response.original.message);
          $('#datatable1').DataTable().ajax.reload( null , false);
        } else {
           /** Handle  errors **/
          toastr.error("Error!!!");
        }
      },

      error: function (xhr, status, error) {
         /** Handle  errors **/
        console.error(xhr.responseText);
      }
    });
  });
  /** Handle Pay button click**/
  $('#datatable1 tbody').on('click', '.pay-button', function () {
    var id = $(this).data('id');
    $('#payModal').modal('show');
    var value_input = $("input[name*='id']").val(id);
  });
  /** Handle form submission for Pay **/
  $('#payModal form').submit(function(e){
    e.preventDefault();

    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();
    /** Use Ajax to send the delete request **/
    $.ajax({
      type:'POST',
      'url':url,
      data: formData,
      success: function (response) {
        if (response.success==true) {
          $('#payModal').modal('hide');
          toastr.success(response.message);
          $('#datatable1').DataTable().ajax.reload( null , false);
        }
      },

      error: function(xhr, status, error) {
        /** Handle errors **/
        var err = eval("(" + xhr.responseText + ")");
        toastr.error(err.message);
      }

    });
  });
  </script>


  @if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
    @elseif(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
    @endif

@endsection
