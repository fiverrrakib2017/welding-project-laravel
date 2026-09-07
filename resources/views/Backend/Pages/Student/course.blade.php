@extends('Backend.Layout.App')
@section('title', 'Student Course List | Admin Panel')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Course List</h4>
                <!-- Add Course Button -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseModal">
                    <i class="fa fa-plus"></i> Add New Course
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="tableStyle">
                    <table id="student_datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr id="course_row_{{ $course->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info editBtn" data-id="{{ $course->id }}"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $course->id }}"><i class="fas fa-trash"></i> Delete</button>
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

<!------------Add Course Modal------------>
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCourseForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter course name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!------------- Edit Course Modal--------->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCourseForm">
                @csrf
                <input type="hidden" name="id" id="edit_course_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" name="name" id="edit_course_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        /*------------CSRF Token Setup for AJAX---------*/ 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*----------Add Course Data----------*/
        $('#addCourseForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.student.course.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success) {
                        $('#addCourseModal').modal('hide');
                        toastr.success(response.message)
                        $('#addCourseForm')[0].reset();
                        setTimeout(() => {
                            location.reload();    
                        }, 1000);
                         
                    }
                },
                error: function (xhr) {
                    toastr.error('Something went wrong! Please try again.');
                }
            });
        });

        /*------Fetch Course Data For Edit----------*/
        $(document).on('click', '.editBtn', function () {
            let id = $(this).data('id');
            let url = "{{ route('admin.student.course.edit', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    if (response.success) {
                        $('#edit_course_id').val(response.data.id);
                        $('#edit_course_name').val(response.data.name);
                        $('#editCourseModal').modal('show');
                    }
                }
            });
        });

        /*----------Update Course ------------*/
        $('#editCourseForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.student.course.update') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success) {
                        $('#editCourseModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();    
                        }, 1000);
                        
                    }
                },
                error: function (xhr) {
                    toastr.error('Update failed!');
                }
            });
        });

        /*--------Delete Course Data-----------*/
        $(document).on('click', '.deleteBtn', function () {
            let id = $(this).data('id');

            if (confirm('Are you sure you want to delete this course?')) {
                $.ajax({
                    url: "{{ route('admin.student.course.destroy') }}",
                    type: "POST",
                    data: { id: id },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message)
                            $('#course_row_' + id).remove();
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Delete failed!');
                    }
                });
            }
        });
    });
</script>
@endsection