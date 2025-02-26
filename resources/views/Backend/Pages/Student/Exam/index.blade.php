@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <button data-toggle="modal" data-target="#examModal" type="button" class="btn btn-success mb-2"><i
                            class="mdi mdi-account-plus"></i>
                        Create Examination</button>

                    <div class="table-responsive" id="tableStyle">
                        <table id="datatable1" class="table table-striped table-bordered    " cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Examination Name</th>
                                    <th>Year</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
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
    @include('Backend.Modal.Student.exam_modal')
    @include('Backend.Modal.delete_modal')


@endsection

@section('script')
    <script src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/custom_select.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            custom_select2('#examModal');
            handleSubmit('#examForm', '#examModal');
            var table = $("#datatable1").DataTable({
                "processing": true,
                "responsive": true,
                "serverSide": true,
                beforeSend: function() {},
                complete: function() {},
                ajax: "{{ route('admin.student.exam.get_all_data') }}",
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "year"
                    },
                    {
                        "data": "start_date"
                    },
                    {
                        "data": "end_date"
                    },

                    {
                        data: null,
                        render: function(data, type, row) {

                            //   var viewUrl = "{{ route('admin.customer.view', ':id') }}".replace(':id', row.id);
                            return `<button  class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>

              <button class="btn btn-danger btn-sm mr-3 delete-btn"  data-id="${row.id}"><i class="fa fa-trash"></i></button> `;
                        }

                    },
                ],
                order: [
                    [0, "desc"]
                ],

            });

        });








        /** Handle Edit button click **/
        $('#datatable1 tbody').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('admin.student.exam.edit', ':id') }}".replace(':id', id),
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#examForm').attr('action', "{{ route('admin.student.exam.update', ':id') }}"
                            .replace(':id', id));
                        $('#examModalLabel').html(
                            '<span class="mdi mdi-account-edit mdi-18px"></span> &nbsp;Edit Examination'
                            );
                        $('#examForm input[name="name"]').val(response.data.name);
                        $('#examForm select[name="year"]').val(response.data.year);
                        $('#examForm input[name="start_date"]').val(response.data.start_date);
                        $('#examForm input[name="end_date"]').val(response.data.end_date);

                        // Show the modal
                        $('#examModal').modal('show');
                    } else {
                        toastr.error('Failed to fetch customer data.');
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });

        /** Handle Delete button click**/
        $('#datatable1 tbody').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            var deleteUrl = "{{ route('admin.student.exam.delete', ':id') }}".replace(':id', id);

            $('#deleteForm').attr('action', deleteUrl);
            $('#deleteModal').find('input[name="id"]').val(id);
            $('#deleteModal').modal('show');
        });
    </script>
@endsection
