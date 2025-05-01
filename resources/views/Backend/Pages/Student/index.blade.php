@extends('Backend.Layout.App')
@section('title','Student List | Admin Panel')

@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
        <div class="card-header">
          <a href="{{ route('admin.student.create') }}" class="btn btn-success "><i class="mdi mdi-account-plus"></i>
          Add New Student</a>

          </div>
            <div class="card-body">
                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1"  class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Student Name </th>
                                <th class="">NID Or Passport </th>
                                <th class="">Mobile Number</th>
                                <th class="">Father's Name</th>
                                <th class="">Present Address</th>
                                <th class="">Permanent Address</th>
                                <th class="">Course</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($students) > 0)
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->nid_or_passport }}</td>
                                        <td>{{ $student->mobile_number }}</td>
                                        <td>{{ $student->father_name }}</td>
                                        <td>{{ $student->present_address }}</td>
                                        <td>{{ $student->permanent_address }}</td>
                                        <td>
                                        @foreach (explode(',', $student->course) as $course)
                                            {{ $course }},
                                        @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.student.edit', $student->id) }}" class="btn btn-success btn-sm mr-3 edit-btn"><i class="fa fa-edit"></i></a>
                                            <button type="button" data-id="{{ $student->id }}" class="btn btn-danger btn-sm mr-3 delete-btn"><i class="fas fa-trash"></i></button>
                                            @if($student->is_completed == 1)
                                            <a href="{{ route('admin.student.certificate', $student->id) }}"  class="btn btn-primary btn-sm mr-3 certificate-btn">Certificate</a>
                                            @else
                                                <button class=" btn btn-info btn-sm mr-3 course_completed_btn" data-id="{{ $student->id }}"> <i class="fas fa-check-circle"></i> </button>
                                            @endif
                                            <a href="{{ route('admin.student.view', $student->id) }}" class="btn btn-success text-white btn-sm mr-3 " data-id="{{ $student->id }}"> <i class="fas fa-eye"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No Data Found</td>
                                </tr>

                            @endif
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

<script type="text/javascript">
  $(document).ready(function(){
    $('#datatable1').DataTable();
  });


  /** Handle Delete button click**/
  $('#datatable1 tbody').on('click', '.delete-btn', function() {
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

        /** Handle Completed button click**/
        $(document).on("click", ".course_completed_btn", function() {
            let id = $(this).data("id");
            let btn = $(this);
            let originalHtml = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...').prop("disabled", true);
            $.ajax({
                url: "{{ route('admin.student.change_status', '') }}/" + id,
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
