@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <button data-toggle="modal" data-target="#addModal" type="button" class="btn btn-success mb-2">
                        <i class="mdi mdi-account-plus"></i> Add New Speech
                    </button>



                    <div class="table-responsive" id="tableStyle">
                        <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Images</th>
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
    @include('Backend.Modal.Settings.Website.Speech.speech_modal')
    @include('Backend.Modal.delete_modal')

@endsection

@section('script')
    <script src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/custom_select.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //custom_select2('#ticketModal');
            handleSubmit('#speechForm', '#addModal');

            var table = $("#datatable1").DataTable({
                "processing": true,
                "responsive": true,
                "serverSide": true,
                beforeSend: function() {},
                complete: function() {},
                ajax: "{{ route('admin.settings.website.speech.get_all_data') }}",
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                "columns": [
                    {
                        "data": "title"
                    },
                    {
                        "data": "description",
                        render: function(data, type, row) {
                            return data.substr(0, 50) + '...';
                        }
                    },
                    {
                        "data": "image",
                        render: function(data, type, row) {
                            return `<img class="img-fluid" src="{{ asset('Backend/uploads/photos') }}/${data}" alt="banner" style="max-width: 400px; max-height: 90px;">`;
                        }
                    },

                    {
                        data: null,
                        render: function(data, type, row) {
                            // <button  class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>
                            return `
                             <button  class="btn btn-primary btn-sm mr-3 edit-btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm mr-3 delete-btn"  data-id="${row.id}"><i class="fa fa-trash"></i></button>
                            `;
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
                url: "{{ route('admin.settings.website.speech.edit', ':id') }}".replace(':id', id),
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#speechForm').attr('action', "{{ route('admin.settings.website.speech.update', ':id') }}"
                            .replace(':id', id));
                        $('#speechModalLabel').html(
                            '<span class="mdi mdi-account-edit mdi-18px"></span> &nbsp;Update Speech');
                        $('#speechForm input[name="title"]').val(response.data.title);
                        $('#speechForm textarea[name="description"]').val(response.data.description);
                        $('#preview').attr('src', "{{ asset('Backend/uploads/photos') }}/" + response.data.image)
                            .show();

                        // Show the modal
                        $('#addModal').modal('show');
                    } else {
                        toastr.error('Failed to fetch data.');
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });

        /** Handle Delete button click**/
        $('#datatable1 tbody').on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            var deleteUrl = "{{ route('admin.settings.website.speech.delete', ':id') }}".replace(':id', id);

            $('#deleteForm').attr('action', deleteUrl);
            $('#deleteModal').find('input[name="id"]').val(id);
            $('#deleteModal').modal('show');
        });
    </script>
@endsection
