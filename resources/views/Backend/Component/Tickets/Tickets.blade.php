

<table id="datatable1" class="table table-bordered dt-responsive nowrap"
style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Status</th>
            <th>Created</th>
            <th>Priority</th>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>POP/Branch</th>
            <th>Area Name</th>
            <th>Issues</th>
            <th>Assigned To</th>
            <th>Ticket For</th>
            <th>Acctual Work</th>
            <th>Percentage</th>
            <th>Note</th>
            <th></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>

<script>

    $(document).ready(function() {
        var customer_id = @json($customer_id ?? '');
        var pop_id = @json($pop_id ?? '');
        var area_id = @json($area_id ?? '');

        var table = $("#datatable1").DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            beforeSend: function() {},
            complete: function() {},
           "ajax": {
                url: "{{ route('admin.tickets.get_all_data') }}",
                type: "GET",
                data: function(d) {
                    d.customer_id = customer_id;
                    d.pop_id = pop_id;
                    d.area_id = area_id;
                }
            },
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "status",
                    render: function(data, type, row) {
                        if (row.status == 0) {
                            return '<span class="badge bg-danger">Active</span>';
                        } else if (row.status == 2) {
                            return '<span class="badge bg-warning">Pending</span>';
                        } else if (row.status == 1) {
                            return '<span class="badge bg-success">Completed</span>';
                        }
                    }
                },
                {
                    "data": "created_at",
                    render: function(data, type, row) {
                        return moment(row.created_at).format('D MMMM YYYY');
                    }
                },
                {
                    "data": "priority_id",
                    render: function(data, type, row) {
                        let priorityLabel = '';
                        switch (row.priority_id) {
                            case 1:
                                priorityLabel = 'Low';
                                break;
                            case 2:
                                priorityLabel = 'Normal';
                                break;
                            case 3:
                                priorityLabel = 'Standard';
                                break;
                            case 4:
                                priorityLabel = 'Medium';
                                break;
                            case 5:
                                priorityLabel = 'High';
                                break;
                            case 6:
                                priorityLabel = 'Very High';
                                break;
                            default:
                                priorityLabel = 'Unknown';
                                break;
                        }
                        return priorityLabel;
                    }

                },
                {
                    "data": "customer.fullname"
                },
                {
                    "data": "customer.phone"
                },
                {
                    "data": "pop.name"
                },
                {
                    "data": "area.name"
                },
                {
                    "data": "complain_type.name"
                },
                {
                    "data": "assign.name"
                },
                {
                    "data": "ticket_for",
                    render: function(data, type, row) {
                        if (row.ticket_for == 1) {
                            return `Default`;
                        }
                    }
                },
                {
                    "data": null,
                    render: function(data, type, row) {
                        if (row.updated_at == row.created_at) {
                            return 'N/A';
                        }
                        if (row.updated_at && row.created_at) {
                            let start = moment(row.created_at);
                            let end = moment(row.updated_at);

                            return end.from(start);
                        } else {
                            return 'N/A';
                        }
                    }
                },
                {
                    "data": "percentage"
                },
                {
                    "data": "note"
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        if(data.status == 1){
                            return `
                            <button class="btn btn-primary btn-sm mr-3 tickets_edit_btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm mr-3 tickets_delete_btn"  data-id="${row.id}"><i class="fa fa-trash"></i></button>
                            `;
                        }else{
                            return `
                            <button  class="btn btn-primary btn-sm mr-3 tickets_edit_btn" data-id="${row.id}"><i class="fa fa-edit"></i></button>

                            <button class="btn btn-danger btn-sm mr-3 tickets_delete_btn"  data-id="${row.id}"><i class="fa fa-trash"></i></button>

                            <button class=" btn btn-info btn-sm mr-3 tickets_completed_btn" data-id="${row.id}"> <i class="fas fa-check-circle"></i> </button>

                            `;
                        }

                    }

                },
            ],
            order: [
                [0, "desc"]
            ],

        });



    });
</script>
