@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card border-0 shadow-lg rounded">
                <div class="card-header bg-gradient-success text-white text-center">
                    <h5 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Account Transaction Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.accounts.transaction.report_generate') }}" method="POST" class="needs-validation">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="from_date" class="form-label fw-bold text-muted">📅 From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control " required>
                            </div>
                            <div class="col-md-3">
                                <label for="to_date" class="form-label fw-bold text-muted">📅 To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control " value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="master_ledger_id" class="form-label fw-bold text-muted">📂 Master Ledger</label>
                                <select name="master_ledger_id" id="master_ledger_id" class="form-control " required>
                                    <option value="">--- Select Ledger ---</option>
                                    @foreach ($master_ledger as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 ">
                                <button type="submit" class="btn btn-success "><i class="fas fa-check-circle"></i> Submit</button>
                                <button type="reset" class="btn btn-outline-danger"><i class="fas fa-redo"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card mt-4">
                <div class="card-body">
                    @if (isset($transactions) && $transactions->count() > 0)
                        <div class="table-responsive" id="tableStyle">
                            <table id="datatable1" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Ledger</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $grandTotal = 0;
                                        $i = 1;
                                    @endphp
                                    @foreach ($transactions as $ledger_name => $ledger_transactions)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <b>{{ $ledger_name }}</b>

                                                @php $ledgerTotal = 0; @endphp
                                                @foreach ($ledger_transactions as $transaction)
                                                    @php
                                                        $ledgerTotal += $transaction->total;
                                                    @endphp
                                                    @if ($same_date_flag == 1)
                                                        <div class="d-flex justify-content-between">
                                                            <span>{{ $transaction->sub_ledger->sub_ledger_name ?? '' }}<br>{{ $transaction->note ?? '' }}</span>
                                                            <span
                                                                style="text-align: right;">{{ $transaction->total }}</span>
                                                        </div>
                                                    @else
                                                        <div class="d-flex justify-content-between">
                                                            <span>{{ $transaction->sub_ledger->sub_ledger_name ?? '' }}</span>
                                                            <span
                                                                style="text-align: right;">{{ $transaction->total }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td style="text-align: right;">{{ $ledgerTotal }}</td>
                                        </tr>
                                        @php $grandTotal += $ledgerTotal; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="text-align: right;">Total</th>
                                        <th style="text-align: right;">{{ $grandTotal }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Print Button -->
                        <div class="d-flex justify-content-center mt-4">
                            <button onclick="printReport()" class="btn btn-primary">Print Report</button>
                        </div>
                    @else
                        <h5 class="text-center text-danger">No Transactions Found </h5>
                    @endif

                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script type="text/javascript">
        $("#reportForm").submit(function(e) {
            e.preventDefault();

            /* Get the submit button */
            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();

            submitBtn.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden"></span>'
                );
            submitBtn.prop('disabled', true);

            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    // if (response.success) {
                    //     toastr.success(response.message);
                    //     form[0].reset();
                    // }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        /* Validation error*/
                        var errors = xhr.responseJSON.errors;

                        /* Loop through the errors and show them using toastr*/
                        $.each(errors, function(field, messages) {
                            $.each(messages, function(index, message) {
                                /* Display each error message*/
                                toastr.error(message);
                            });
                        });
                    } else {
                        /*General error message*/
                        toastr.error('An error occurred. Please try again.');
                    }
                },
                complete: function() {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                }
            });
        });



        function printReport() {
            var printWindow = window.open('', '_blank');
            var content = document.getElementById('tableStyle').innerHTML;

            printWindow.document.write(`
            <html>
                <head>
                    <title>Accounts Transaction Report</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { padding: 10px; border: 1px solid #ddd; }
                        th { background: #f8f9fa; text-align: left; }
                    </style>
                </head>
                <body>
                    <h3 class="text-center">Accounts Transaction Report</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">` + content + `</table>
                    </div>
                </body>
            </html>
        `);

            printWindow.document.close();

            printWindow.onload = function() {
                printWindow.print();
                printWindow.close();
            };
        }
    </script>


@endsection
