<table id="datatable1" class="table table-bordered dt-responsive nowrap"
 style="border-collapse: collapse; border-spacing: 0; width: 100%;">
 <thead>
     <tr>
         <th>ID</th>
         <th>Recharged date</th>
         <th>Customer Username</th>
         <th>Months</th>
         <th>Type</th>
         <th>Paid until</th>
         <th>Amount</th>
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

     /* Status Filter */
     var status = `<label>
                         <span>Status:</span>
                         <select class="status_filter form-control">
                             <option value="">---Select Type---</option>
                             <option value="credit">Credit</option>
                             <option value="cash">Cash</option>
                             <option value="bkash">Bkash</option>
                             <option value="nagad">Nagad</option>
                             <option value="due_paid">Due Paid</option>
                         </select>
                     </label>`;

     /* Bill Collector */
     var bill_collect = `<label>
                             <span>Collector:</span>
                             <select class="bill_collect form-control">
                                 <option value="">---Collection---</option>
                                 <option value="45">Md. Saiful Islam</option>
                                 <option value="46">MR Rayhan Shekh</option>
                                 <option value="50">Sumon</option>
                                 <option value="52">Md Mynouddin Hossain</option>
                                 <option value="53">Mr.Jakaria</option>
                                 <option value="54">rakib mahmud</option>
                                 <option value="58">Sm Ratul Islam</option>
                                 <option value="59">Ismail</option>
                                 <option value="65">Md Masud Rabbane</option>
                                 <option value="71">Mim Akter</option>
                                 <option value="72">Hasan Mozumder</option>
                                 <option value="73">Sazzad Hossain</option>
                                 <option value="74">Johirul</option>
                                 <option value="81">Chandrika</option>
                                 <option value="82">Mr. Ibrahim</option>
                             </select>
                         </label>`;
          /* Total Amount Display */
     var total_amount = `<label style="margin-left: 10px; font-weight: bold; font-size: 16px;">
                             Total Amount: <span id="total_amount" style="color: #007bff;">0</span> ৳
                         </label>`;

     setTimeout(() => {
         let filterContainer = $('.dataTables_filter');
         let lengthContainer = $('.dataTables_length');

         lengthContainer.parent().removeClass('col-sm-12 col-md-6');
         filterContainer.parent().removeClass('col-sm-12 col-md-6');

         filterContainer.append(from_date);
         filterContainer.append(to_date);
         filterContainer.append(status);
         filterContainer.append(bill_collect);
         filterContainer.append(total_amount);

         $('.status_filter').select2({ width: '150px' });
         $('.bill_collect').select2({ width: '150px' });
     }, 1000);

     var table = $("#datatable1").DataTable({
         "processing": true,
         "responsive": true,
         "serverSide": true,
         ajax: {
             url: "{{ route('admin.customer.payment.history.get_all_data') }}",
             data: function (d) {
                 d.start = d.start || 0;
                 d.length = d.length || 10;
                 d.from_date = $('.from_date').val();
                 d.to_date = $('.to_date').val();
                 d.status_filter = $('.status_filter').val();
                 d.bill_collect = $('.bill_collect').val();
             },
             dataSrc: function (json) {
                 $('#total_amount').text(json.totalAmount);
                 return json.data;
             }
         },
         language: {
             searchPlaceholder: 'Search...',
             sSearch: '',
             lengthMenu: '_MENU_ items/page',
         },
         "columns": [
             { "data": "id" },
             {
                 "data": "created_at",
                 "render": function(data, type, row) {
                     var date = new Date(data);
                     var options = { year: 'numeric', month: 'short', day: '2-digit' };
                     return date.toLocaleDateString('en-GB', options);
                 }
             },
             {
                 "data": "customer.fullname",
                 "render": function(data, type, row) {
                     var customerId = row.customer ? row.customer.id : '0';
                     var viewUrl = "{{ route('admin.customer.view', ':id') }}".replace(':id', customerId);

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
             },
             { "data": "recharge_month" },
             {
                 "data": "transaction_type",
                 "render": function(data, type, row) {
                     if (data == 'cash') {
                         return '<span class="badge bg-success">Cash</span>';
                     } else if (data == 'credit') {
                         return '<span class="badge bg-danger">Credit</span>';
                     } else if (data == 'due_paid') {
                         return '<span class="badge bg-success">Due Paid</span>';
                     }
                 }
             },
             {
                 "data": "paid_until",
                 "render": function(data, type, row) {
                     var date = new Date(data);
                     var options = { year: 'numeric', month: 'short', day: '2-digit' };
                     return date.toLocaleDateString('en-GB', options);
                 }
             },
             { "data": "amount" }
         ],
         order: [[0, "desc"]],
     });
     /* Filter Change Event*/
     $(document).on('change','.from_date, .to_date, .status_filter, .bill_collect',function(){
         $('#datatable1').DataTable().ajax.reload();
     });
 });
 </script>
