@extends('Backend.Layout.App')
@section('title','Student List | Admin Panel')

@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.user.create') }}" class="btn btn-success m-1">Add User</a>
        </div>
            <div class="card-body">
                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1"  class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Name </th>
                                <th class="">Username </th>
                                <th class="">Email</th>
                                <th class="">Phone</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $users = \App\Models\Admin::where('user_type', 2)->get();
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>

                                        <button type="button" data-id="{{ $user->id }}" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
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
<script>
/** Handle Delete button click**/
$('#datatable1 tbody').on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    var deleteUrl = "{{ route('admin.user.delete', ':id') }}".replace(':id', id);

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
</script>
@endsection