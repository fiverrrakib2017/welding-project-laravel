@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                  <button data-toggle="modal" data-target="#addModal" type="button" class="btn btn-success mb-2"><i class="mdi mdi-account-plus"></i>
                    Add New Transaction</button>
            </div>
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Teacher Name</th>
                                <th class="">Billing Type</th>
                                <th class="">Amount</th>
                                <th class="">Transaction Date</th>
                                <th class=""></th>
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

<!-- Add  Modal -->
<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add Transaction
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!----- Start Add Form ------->
            <form id="addForm" action="{{ route('admin.teacher.transaction.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!----- Start Add Form input ------->
                        <div class="form-group mb-2">
                        <label for="sectionName">Teacher Name</label>
                            <select type="text" name="teacher_id" class="form-control" style="width: 100%;">
                                <option >---Select---</option>
                                @foreach ($teachers as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                        <label for="sectionName">Transaction Type</label>
                            <select type="text" name="type_name"  class="form-control" style="width: 100%;">
                                <option value="">---Select---</option>
                                <option value="1">Advance</option>
                                <option value="2">Loan</option>
                                <option value="3">Salary</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="sectionName">Amount</label>
                            <input type="text" name="amount"  placeholder="Enter  Amount" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="sectionName">Transaction Date</label>
                            <input type="date" name="transaction_date" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success tx-size-xs">Save changes</button>
                    <button type="button" class="btn btn-danger tx-size-xs" data-dismiss="modal">Close</button>
                </div>
            </form>
            <!----- End Add Form ------->
        </div>
    </div>
</div>
<!-- Edit  Modal -->
<div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Transaction
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!----- Start Update Form ------->
            <form id="updateForm" action="{{ route('admin.teacher.transaction.update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!----- Start Add Form input ------->
                        <div class="form-group mb-2">
                        <label for="sectionName">Teacher Name</label>
                            <input type="text" name="id" class="d-none">
                            <select type="text" name="teacher_id" class="form-control" style="width: 100%;">
                                <option>---Select Teacher---</option>
                                @foreach ($teachers as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                        <label for="sectionName">Transaction Type</label>
                            <select type="text" name="type_name"  class="form-control" style="width: 100%;">
                                <option value="">---Select---</option>
                                <option value="1">Advance</option>
                                <option value="2">Loan</option>
                                <option value="3">Salary</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="sectionName">Amount</label>
                            <input type="text" name="amount"  placeholder="Enter  Amount" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="sectionName">Transaction Date</label>
                            <input type="date" name="transaction_date" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success tx-size-xs">Save changes</button>
                    <button type="button" class="btn btn-danger tx-size-xs" data-dismiss="modal">Close</button>
                </div>
            </form>
            <!----- End Update Form ------->
        </div>
    </div>
</div>
<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <form action="{{route('admin.teacher.transaction.delete')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fas fa-trash"></i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <input type="hidden" name="id" value="">
                <a class="close" data-dismiss="modal" aria-hidden="true"><i class="mdi mdi-close"></i></a>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
    var table = $("#datatable1").DataTable({
      "processing":true,
      "responsive": true,
      "serverSide":true,
      ajax: {
            url: "{{ route('admin.teacher.transaction.all_data') }}",
            type: 'GET',
            data: function(d) {
              d.class_id = $('#search_class_id').val();
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
      "columns":[
        {"data":"id"},
        {"data": "teacher.name"},
        {"data": "type",
        "render": function(data, type, row) {
            if (data==1) {
                return '<span class="badge bg-success">Advance</span>';
            }else if(data==2){
                return '<span class="badge bg-warning">Loan</span>';
            }else if(data==3){
                return '<span class="badge bg-primary">Salary</span>';
            }
          }
        },
        {"data":"amount"},
        {"data":"transaction_date",
        "render": function(data, type, row) {
            return moment(data).format("DD-MM-YYYY");
          }

        },
        {
          "data":null,
          render:function(data,type,row){
              return `
              <button type="button" class="btn btn-primary btn-sm" name="edit_button" data-id="${row.id}"><i class="fa fa-edit"></i></button>
              <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fa fa-trash"></i></button>
            `;
          }
        },
      ],
      order:[ [0, "desc"] ],
    });

    /* Search filter reload*/
    $('#search_class_id').change(function() {
        table.ajax.reload(null, false);
    });

    /* Initialize select2 for modal dropdowns*/
    // function initializeSelect2(modalId) {
    //   $(modalId).on('show.bs.modal', function (event) {
    //     if (!$("select[name='teacher_id']").hasClass("select2-hidden-accessible")) {
    //         $("select[name='teacher_id']").select2({
    //             dropdownParent: $(modalId),
    //             placeholder: "Select Teacher"
    //         });
    //     }
    //   });
    // }

    /* Initialize select2 modals*/
    // initializeSelect2("#addModal");
    // initializeSelect2("#editModal");

    /* General form submission handler*/
    function handleFormSubmit(modalId, form) {
        $(modalId + ' form').submit(function(e){
            e.preventDefault();
            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            submitBtn.prop('disabled', true);

            var formData = new FormData(this);
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                        $(modalId).modal('hide');
                        form[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $.each(messages, function(index, message) {
                                toastr.error(message);
                            });
                        });
                    } else {
                        toastr.error('An error occurred. Please try again.');
                    }
                },
                complete: function() {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                }
            });
        });
    }

    /* Handle Add and Edit Form */
    handleFormSubmit("#addModal", $('#addModal form'));
    handleFormSubmit("#editModal", $('#editModal form'));

    /* Edit button click handler*/
    $(document).on("click", "button[name='edit_button']", function() {
        var _id = $(this).data("id");
        var editUrl = '{{ route("admin.teacher.transaction.get_transaction", ":id") }}';
        var url = editUrl.replace(':id', _id);
        $.ajax({
          url: url,
          type: "GET",
          success: function(response) {
              if (response.success) {
                $('#editModal').modal('show');
                $('#editModal input[name="id"]').val(response.data.id);
                 $('#editModal select[name="teacher_id"]').val(response.data.teacher_id);
                $('#editModal select[name="type_name"]').val(response.data.type);
                $('#editModal input[name="amount"]').val(response.data.amount);
                $('#editModal input[name="transaction_date"]').val(response.data.transaction_date);
              } else {
                  toastr.error("Error fetching data for edit: " + response.message);
              }
          },
          error: function(xhr) {
              toastr.error('Failed to fetch bill collection details.');
          }
        });
    });

    /* Handle Delete button click and form submission*/
    $('#datatable1 tbody').on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        $('#deleteModal').modal('show');
        $("input[name*='id']").val(id);
    });

    $('#deleteModal form').submit(function(e){
        e.preventDefault();
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        var form = $(this);
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                    $('#deleteModal').modal('hide');
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseText);
            },
            complete: function() {
                submitBtn.html(originalBtnText);
            }
        });
    });
});
</script>


@endsection
