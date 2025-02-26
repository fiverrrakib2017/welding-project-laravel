@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
              <a href="{{ route('admin.teacher.create') }}" class="btn btn-success"><i class="mdi mdi-account-plus"></i>
                      Add New Teacher</a>
            </div>
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Images</th>
                                <th class="">Teacher Name </th>
                                <th class="">Subject</th>
                                <th class="">Email Address </th>
                                <th class="">Phone Number</th>
                                <th class="">Gender</th>
                                <th class="">Joining Date</th>
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
        <form action="{{route('admin.teacher.delete')}}" method="post" enctype="multipart/form-data">
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
        beforeSend: function () {
          //$('#preloader').addClass('active');
        },
        complete: function(){
          //$('.product_loading').css({"display":"none"});
        },
        ajax: "{{ route('admin.teacher.all_data') }}",
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
            "data":"photo",
            render: function(data) {
                var url;
                if (data == null || data === '') {
                    url = "{{ asset('uploads/photos') }}/avatar.png";
                } else {
                    url = "{{ asset('uploads/photos') }}/" + data;
                }
                return '<img src="' + url + '" style="width: 50px; height: 50px; border-radius: 50%;">';
            }
          },
          {
            "data":"name",
            render: function(data, type, row){
                return '<a href="{{ route('admin.teacher.view', '') }}/' + row.id + '">' + data + '</a>';
            }
          },
          {
            "data":"subject"
          },
          {
            "data":"email"
          },
          {
            "data":"phone"
          },
          {
            "data":"gender"
          },
          {
            "data":"hire_date"
          },
          {
            "data":null,
            render:function(data,type,row){
                var editUrl = "{{ route('admin.teacher.edit', ':id') }}".replace(':id', row.id);
                var viewUrl = "{{ route('admin.teacher.view', ':id') }}".replace(':id', row.id);
                return `<a href="${editUrl}" class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}"><i class="fa fa-edit"></i></a>
                <button class="btn btn-danger btn-sm mr-3 delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fa fa-trash"></i></button>

                <a href="${viewUrl}" class="btn btn-success btn-sm mr-3 edit-btn"><i class="fa fa-eye"></i></a>
              `;
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
    console.log("Delete ID: " + id);
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
    submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');

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
