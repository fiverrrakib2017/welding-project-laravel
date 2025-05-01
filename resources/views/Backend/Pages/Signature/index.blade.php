@extends('Backend.Layout.App')
@section('title', 'Student Course List | Admin Panel')

@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">
                   <button data-toggle="modal" data-target="#uploadModal" type="button" class=" btn btn-success mb-2">Add New Signature</button>

                    </div>
                <div class="card-body">


                    <div class="table-responsive" id="tableStyle">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Signature Image</th>
                                <th>Upload By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td> <img src="{{ asset('Backend/uploads/photos/' . $item->name) }}" class="card-img-top" alt="Singature Image" height="100" width="100"></td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        <button type="button" data-id="{{ $item->id }}" class="btn btn-danger btn-sm mr-3 delete-btn"><i class="fas fa-trash"></i></button>
                                        <button class=" btn btn-info btn-sm mr-3 active_btn" data-id="{{ $item->id }}"> <i class="fas fa-check-circle"></i> </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload New Signature</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.signature.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Select Signature</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <form method="post" enctype="multipart/form-data" id="deleteForm">
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
    $('#datatable').DataTable();
  });
  /** Handle Delete button click**/
  /** Handle Delete button click**/
  $('#datatable tbody').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            var deleteUrl = "{{ route('admin.student.delete', ':id') }}".replace(':id', id);

            $('#deleteForm').attr('action', deleteUrl);
            $('#deleteModal').find('input[name="id"]').val(id);
            $('#deleteModal').modal('show');
        });

        /** Handle form submission for delete **/
        $('#deleteModal form').submit(function(e) {
            e.preventDefault();
            /*Get the submit button*/
            var submitBtn = $('#deleteModal form').find('button[type="submit"]');

            /* Save the original button text*/
            var originalBtnText = submitBtn.html();

            /*Change button text to loading state*/
            submitBtn.html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`
            );

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();
            /** Use Ajax to send the delete request **/
            $.ajax({
                type: 'POST',
                'url': url,
                data: formData,
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                },

                error: function(xhr, status, error) {
                    /** Handle  errors **/
                    toastr.error(xhr.responseText);
                },
                complete: function() {
                    submitBtn.html(originalBtnText);
                }
            });
        });

        /** Handle Change button click**/
        $(document).on("click", ".active_btn", function() {
            let id = $(this).data("id");
            let btn = $(this);
            let originalHtml = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...').prop("disabled", true);
            $.ajax({
                url: "{{ route('admin.signature.change_status', '') }}/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        btn.html(originalHtml).prop("disabled", false);
                        toastr.success(response.message);
                     setTimeout(() => {
                        location.reload();
                     }, 1000);
                    } else if (response.success == false) {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error("Something went wrong!");
                },
                complete: function() {
                    btn.prop("disabled", false);
                }
            });
        });
  </script>
@endsection
