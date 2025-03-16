<table id="datatable1" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Customer Username</th>
            <th>Ip Address</th>
            <th>Operation By</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<style>
    .dataTables_filter {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 600;
        color: #333;
    }

    .dataTables_filter input,
    .dataTables_filter select {
        height: 35px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 5px;
    }

    .select2-container--default .select2-selection--single {
        height: 35px !important;
        line-height: 35px !important;
        border-radius: 5px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        /* From Date */
        var from_date = `<label>
                         <span>From:</span>
                         <input class="from_date form-control" type="date" value="">
                     </label>`;

        /* To Date */
        var to_date = `<label>
                         <span>To:</span>
                         <input class="to_date form-control" type="date" value="">
                     </label>`;

        setTimeout(() => {
            let filterContainer = $('.dataTables_filter');
            let lengthContainer = $('.dataTables_length');

            lengthContainer.parent().removeClass('col-sm-12 col-md-6');
            filterContainer.parent().removeClass('col-sm-12 col-md-6');

            filterContainer.append(from_date);
            filterContainer.append(to_date);

            $('.status_filter').select2({
                width: '150px'
            });
            $('.bill_collect').select2({
                width: '150px'
            });
        }, 1000);

        var table = $("#datatable1").DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            ajax: {
                url: "{{ route('admin.customer.log.get_all_data') }}",
                data: function(d) {
                    d.start = d.start || 0;
                    d.length = d.length || 10;
                    d.from_date = $('.from_date').val();
                    d.to_date = $('.to_date').val();
                },
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
                    "data": "created_at",
                    "render": function(data, type, row) {
                        var date = new Date(data);

                        var dateOptions = {
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit'
                        };
                        var formattedDate = date.toLocaleDateString('en-GB', dateOptions);

                        var timeOptions = {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: true
                        };
                        var formattedTime = date.toLocaleTimeString('en-GB', timeOptions);

                        return formattedDate + "<br><span class='text-success'>" + formattedTime + "</span>";
                    }
                },

                {
                    "data": "customer.fullname",
                    "render": function(data, type, row) {
                        var customerId = row.customer ? row.customer.id : '0';
                        var viewUrl = "{{ route('admin.customer.view', ':id') }}".replace(':id',
                            customerId);

                        var icon = '';
                        if (row.customer && row.customer.status === 'online') {
                            icon =
                                '<i class="fas fa-unlock" style="font-size: 15px; color: green; margin-right: 8px;"></i>';
                        } else if (row.customer && row.customer.status === 'offline') {
                            icon =
                                '<i class="fas fa-lock" style="font-size: 15px; color: red; margin-right: 8px;"></i>';
                        } else {
                            icon =
                                '<i class="fa fa-question-circle" style="font-size: 18px; color: gray; margin-right: 8px;"></i>';
                        }

                        return '<a href="' + viewUrl +
                            '" style="display: flex; align-items: center; text-decoration: none; color: #333;">' +
                            icon +
                            '<span style="font-size: 16px; font-weight: bold;">' + (row
                                .customer ? row.customer.fullname : 'N/A') + '</span>' +
                            '</a>';
                    }
                },
                {
                    "data": "ip_address"
                },
                {
                    "data": "user.name"
                },
                {
                    "data": "action_type",
                    "render": function(data, type, row) {
                        if (data == 'add') {
                            return '<span class="badge bg-success">Add</span>';
                        } else if (data == 'edit') {
                            return '<span class="badge bg-danger">Edit</span>';
                        } else if (data == 'package_change') {
                            return '<span class="badge bg-success">Package Change</span>';
                        } else if (data == 'reconnect') {
                            return '<span class="badge bg-success">Reconnect</span>';
                        } else if (data == 'recharge') {
                            return '<span class="badge bg-success">Recharge</span>';
                        } else if (data == 'delete') {
                            return '<span class="badge bg-danger">Deleted</span>';
                        } else {
                            return '<span class="badge bg-danger">N/A</span>';
                        }
                    }
                },
                {
                    "data": "description",
                },

            ],
            order: [
                [0, "desc"]
            ],
        });
        /* Filter Change Event*/
        $(document).on('change', '.from_date, .to_date', function() {
            $('#datatable1').DataTable().ajax.reload();
        });
    });
</script>
