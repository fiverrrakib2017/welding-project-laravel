@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                  <button data-toggle="modal" data-target="#addModal" type="button" class="btn btn btn-success mb-2"><i class="mdi mdi-account-plus"></i>
                    Add New Section</button>
            </div>
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Class Name</th>
                                <th class="">Sections</th>
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

<!-- Add Section Modal -->
<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add Section
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <!----- Start Add Form ------->
            <form id="addSectionForm" action="{{ route('admin.student.section.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!----- Start Add Form input ------->
                        <div class="form-group mb-2">
                            <label for="sectionName">Class</label>
                            <select type="text" name="class_name" id="class_name" class="form-control">
                                <option value="">---Select---</option>
                                @foreach ($classes as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="sectionName">Section Name</label>
                            <input type="text" name="name" id="sectionName" placeholder="Enter Section Name" class="form-control">
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
<!-- Edit Section Modal -->
<div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Update Section
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <!----- Start Update Form ------->
            <form id="addSectionForm" action="{{ route('admin.student.section.update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!----- Start Update Form input ------->
                        <div class="form-group mb-2">
                            <label for="sectionName">Class</label>
                            <select type="text" name="class_name" id="class_name" class="form-control">
                                <option value="">---Select---</option>
                                @foreach ($classes as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="sectionName">Section Name</label>
                            <input type="text" name="id" class="d-none" required>
                            <input type="text" name="name"  placeholder="Enter Section Name" class="form-control">
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
        <form action="{{route('admin.student.section.delete')}}" method="post" enctype="multipart/form-data">
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

  <script type="text/javascript">
    $(document).ready(function(){

        var table=$("#datatable1").DataTable({
        "processing":true,
        "responsive": true,
        "serverSide":true,

        ajax: "{{ route('admin.student.class.all_data') }}",
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
            "data":"name"
            },
            {
            "data":"sections"
            },
            {
            "data":null,
            render:function(data,type,row){
                return `<button class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm mr-3 delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fa fa-trash"></i></button>`
            }
            },
        ],
        order:[
            [0, "desc"]
        ],

        });
    });





    /** Handle edit button click**/
    $('#datatable1 tbody').on('click', '.edit-btn', function () {
      var id = $(this).data('id');
      var editUrl = '{{ route("admin.student.section.edit", ":id") }}';
      var url = editUrl.replace(':id', id);
      $.ajax({
          type: 'GET',
          url: url,
          success: function (response) {
              if (response.success) {
                $('#editModal').modal('show');
                $('#editModal input[name="id"]').val(response.data.id);
                $('#editModal select[name="class_name"]').val(response.data.class_id);
                $('#editModal input[name="name"]').val(response.data.name);
                $('#editModal select[name="status"]').val(response.data.status);
              } else {
                toastr.error("Error fetching data for edit!");
              }
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
            toastr.error("Error fetching data for edit!");
          }
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
    /*Get the submit button*/
    var submitBtn =  $('#deleteModal form').find('button[type="submit"]');

    /* Save the original button text*/
    var originalBtnText = submitBtn.html();

    /*Change button text to loading state*/
    submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);

    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();
    /** Use Ajax to send the delete request **/
    $.ajax({
      type:'POST',
      'url':url,
      data: formData,

      success: function (response) {
        $('#deleteModal').modal('hide');
        if (response.success) {
          toastr.success(response.message);
          $('#datatable1').DataTable().ajax.reload( null , false);
        }
      },

      error: function (xhr, status, error) {
         /** Handle  errors **/
         toastr.error(xhr.responseText);
      },
      complete: function () {
        submitBtn.html(originalBtnText);
        }
    });
  });




  /** Store The data from the database table **/
  $('#addModal form').submit(function(e){
    e.preventDefault();
    /*Get the submit button*/
    var submitBtn =  $('#deleteModal form').find('button[type="submit"]');

    /* Save the original button text*/
    var originalBtnText = submitBtn.html();

    /*Change button text to loading state*/
    submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);
    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();
    /** Use Ajax to send the delete request **/
    $.ajax({
      type:'POST',
      'url':url,
      data: formData,
      beforeSend: function () {
        form.find(':input').prop('disabled', true);
      },
      success: function (response) {

        if (response.success) {
            $('#addModal ').modal('hide');
            $('#addModal form')[0].reset();
            toastr.success(response.message);
            $('#datatable1').DataTable().ajax.reload( null , false);
        }
      },

      error: function (xhr, status, error) {
         /** Handle  errors **/
        console.error(xhr.responseText);
      },
      complete: function () {
        submitBtn.html(originalBtnText);
          form.find(':input').prop('disabled', false);
        }
    });
  });




  /** Update The data from the database table **/
  $('#editModal form').submit(function(e){
    e.preventDefault();

    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();

    /*Get the submit button*/
    var submitBtn = form.find('button[type="submit"]');

    /*Save the original button text*/
    var originalBtnText = submitBtn.html();

    /*Change button text to loading state*/
    submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);

    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();
    /** Use Ajax to send the delete request **/
    $.ajax({
      type:'POST',
      'url':url,
      data: formData,
      beforeSend: function () {
        form.find(':input').prop('disabled', true);
      },
      success: function (response) {

        $('#editModal').modal('hide');
        $('#editModal form')[0].reset();
        if (response.success) {
            submitBtn.html(originalBtnText);
            toastr.success(response.message);
            $('#datatable1').DataTable().ajax.reload( null , false);
        }
      },

      error: function (xhr, status, error) {
        if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            $.each(errors, function(key, value) {
                toastr.error(value[0]);
            });
        } else {
            toastr.error("An error occurred. Please try again.");
        }
      },
      complete: function () {
        submitBtn.html(originalBtnText);
          form.find(':input').prop('disabled', false);
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
