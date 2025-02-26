@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')

@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
        <div class="card-header">
          <a href="{{route('admin.student.bill_collection.create')}}" class="btn btn-success ">  <i class="	fas fa-donate" aria-hidden="true"></i>
           Bill Collection</a>
          </div>
            <div class="card-body">
                <div class="table table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Student Name </th>
                                <th class="">Class </th>
                                <th class="">Section </th>
                                <th class="">Total Amount </th>
                                <th class="">Paid Amount</th>
                                <th class="">Due Amount</th>
                                <th class="">Status</th>
                                <th class="">Note</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <form action="{{route('admin.student.bill_collection.delete')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fas fa-trash"></i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <input type="hidden" name="id" value="">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
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
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var classes = @json($class);
    var class_filter = '<label style="margin-left: 10px;">';
    class_filter += '<select id="search_class_id" class="form-control">';
    class_filter += '<option value="">--Select Class--</option>';
    classes.forEach(function(item) {
        class_filter += '<option value="' + item.id + '">' + item.name + '</option>';
    });
    class_filter += '</select></label>';
    setTimeout(() => {
        $('.dataTables_length').append(class_filter);
    }, 100);
    var table = $("#datatable1").DataTable({
      "processing":true,
      "responsive": true,
      "serverSide":true,
      ajax: {
        url: "{{ route('admin.student.bill_collection.all_data') }}",
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
        {
          "data": "student.name",
          render: function(data, type, row){
              return '<a href="{{ route('admin.student.view', '') }}/' + row.student.id + '">' + data + '</a>';
          }
        },
        {"data":"student.current_class.name"},
        {"data":"student.section.name"},
        {"data":"total_amount"},
        {"data":"paid_amount"},
        {"data":"due_amount"},
        {
          "data":"due_amount",
          render:function(data,type,row){
            if(data > 0){
              return '<span class="badge bg-danger">Due</span>';
            }else{
              return '<span class="badge bg-success">Paid</span>';
            }
          }
        },
        {"data":"note"},
        {
          "data":null,
          render:function(data,type,row){
            var editUrl="{{ route('admin.student.bill_collection.edit', ':id') }}";
            var url=editUrl.replace(':id',row.id);

            var viewUrl="{{ route('admin.student.bill_collection.invoice_show', ':id') }}";
            var viewurl=viewUrl.replace(':id',row.id);
              return `
              <a href="${viewurl}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
              <a href="${url}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
              <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fa fa-trash"></i></button>
            `;
          }
        },
      ],
      order:[ [0, "desc"] ],
    });

    /* Search filter reload*/
    $(document).on('change', '#search_class_id', function() {
      table.ajax.reload(null, false);
    })

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
