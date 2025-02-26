{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Billing Invoice</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .invoice-container {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .invoice-header img {
            max-width: 120px;
        }
        .invoice-header h2 {
            font-size: 28px;
            font-weight: bold;
            margin-top: 10px;
        }
        .invoice-details th,
        .invoice-table th {
            background: #f1f1f1;
            text-align: left;
        }
        .invoice-details td,
        .invoice-table td {
            vertical-align: middle;
        }
        .btn-print,
        .btn-download {
            margin-top: 20px;
        }
        .invoice-footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="invoice-container">
            <!-- Invoice Header -->
            <div class="invoice-header text-center mb-4">
                <img src="http://103.146.16.154/assets/images/it-fast.png" alt="Logo">
                <h2>Billing Invoice</h2>
            </div>
            <!-- Invoice Details -->
            <table class="table table-bordered invoice-details">
                <tr>
                    <th>Bill No:</th>
                    <td>{{$data->id}}</td>
                    <th>Date:</th>
                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Student ID:</th>
                    <td>{{$data->student->id}}</td>
                    <th>Student Name:</th>
                    <td>{{$data->student->name}}</td>
                </tr>
                <tr>
                    <th>Phone Number:</th>
                    <td>{{$data->student->phone}}</td>
                    <th>Address:</th>
                    <td>{{$data->student->current_address}}</td>
                </tr>
            </table>
            <!-- Invoice Table -->
            <table class="table table-striped table-bordered invoice-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Item Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->items as $item)
                    <tr>
                        <td>{{ $item->fees_type->type_name }}</td>
                        <td>{{ $item->month }}</td>
                        <td>{{ floatval($item->amount) }} ৳</td>
                        <td>{{ floatval($item->amount * count(explode(',',$item->month ))) }} ৳</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Invoice Summary -->
            <table class="table table-bordered invoice-summary">
                <tr>
                    <th class="text-right">Total Amount:</th>
                    <td class="text-right">{{ number_format(floatval($data->total_amount), 0, '.', '') }} ৳</td>
                </tr>
                <tr>
                    <th class="text-right">Paid Amount:</th>
                    <td class="text-right">{{ number_format(floatval($data->paid_amount), 0, '.', '') }} ৳</td>
                </tr>
                <tr>
                    <th class="text-right">Due Amount:</th>
                    <td class="text-right">{{ number_format(floatval($data->due_amount), 0, '.', '') }} ৳</td>
                </tr>
            </table>
            <!-- Invoice Footer -->
            <div class="invoice-footer">
                <p>Prepared By: Rakib Mahmud</p>
                <button onclick="window.print()" class="btn btn-primary btn-print"><i class="fas fa-print"></i> Print</button>
                <button class="btn btn-success btn-download"><i class="fas fa-download"></i> Download</button>
            </div>
        </div>
    </div>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
 --}}


 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Fee Collection Invoice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        .invoice-container {
            width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px 40px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100px;
        }
        .header h1 {
            font-size: 24px;
            margin: 10px 0;
            color: #007bff;
        }
        .header p {
            font-size: 14px;
            color: #555;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .invoice-details div {
            font-size: 14px;
            color: #555;
        }
        .invoice-details strong {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background: #007bff;
            color: #fff;
            font-weight: bold;
        }
        .summary {
            text-align: right;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .summary p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
        .footer p {
            margin: 0;
            font-size: 12px;
            color: #555;
        }
        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            text-align: center;
            width: 30%;
        }
        .signature div p {
            margin-top: 40px;
            border-top: 1px solid #333;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="invoice-container" id="invoice">
        <!-- Header Section -->
        <div class="header">
            <img src="http://103.146.16.154/assets/images/it-fast.png" alt="School Logo">
            <h1>Future ICT School</h1>
            <p>123, School Road, Dhaka, Bangladesh<br>Phone: +880123456789 | Email: info@abchighschool.com</p>
        </div>
        <!-- Invoice Details -->
        <div class="invoice-details">
            <div>
                <p><strong>Invoice No:</strong> {{$data->id}}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</p>
            </div>
            <div>
                <p><strong>Student ID:</strong> {{$data->student->id}}</p>
                <p><strong>Student Name:</strong> {{$data->student->name}}</p>
                <p><strong>Phone:</strong> {{$data->student->phone}}</p>
                <p><strong>Address:</strong> {{$data->student->current_address}}</p>
            </div>
        </div>
        <!-- Fee Table -->
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Item Name</th>
                    <th>Month</th>
                    <th>Amount (৳)</th>
                    <th>Total Amount (৳)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->fees_type->type_name }}</td>
                    <td>{{ $item->month }}</td>
                    <td>{{ floatval($item->amount) }}</td>
                    <td>{{ floatval($item->amount * count(explode(',',$item->month ))) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Summary -->
        <div class="summary">
            <p style="color: green"><strong>Total Amount:</strong> {{ number_format(floatval($data->total_amount), 0, '.', '') }} ৳</p>
            <p><strong>Paid Amount:</strong> {{ number_format(floatval($data->paid_amount), 0, '.', '') }} ৳</p>
            <p style="color: red"><strong>Due Amount:</strong> {{ number_format(floatval($data->due_amount), 0, '.', '') }} ৳</p>
        </div>
        <!-- Signature Section -->
        <div class="signature">
            <div>
                <p>Prepared By</p>
            </div>
            <div>
                <p>Authorized Signature</p>
            </div>
        </div>
        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your payment! Please keep this invoice for your records.</p>
        </div>
    </div>
    <script>
        window.addEventListener("load", window.print());

    </script>
</body>
</html>

