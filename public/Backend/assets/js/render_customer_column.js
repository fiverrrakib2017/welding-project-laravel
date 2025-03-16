// var customerViewRoute = "{{ route('admin.customer.view', ':id') }}";

function render_customer_column(data, type, row, ) {
    var customerId = row.customer ? row.customer.id : '0';
    //var baseUrl = window.location.origin;
    var viewUrl = baseUrl + "/admin/customer/view/" + customerId;

    var icon = '';
    if (row.customer && row.customer.status === 'online') {
        icon = '<i class="fas fa-unlock" style="font-size: 15px; color: green; margin-right: 8px;"></i>';
    } else if (row.customer && row.customer.status === 'offline') {
        icon = '<i class="fas fa-lock" style="font-size: 15px; color: red; margin-right: 8px;"></i>';
    } else {
        icon = '<i class="fa fa-question-circle" style="font-size: 18px; color: gray; margin-right: 8px;"></i>';
    }

    return '<a href="' + viewUrl +
        '" style="display: flex; align-items: center; text-decoration: none; color: #333;">' +
        icon +
        '<span style="font-size: 16px; font-weight: bold;">' + (row.customer ? row.customer.fullname : 'N/A') + '</span>' +
        '</a>';
}
