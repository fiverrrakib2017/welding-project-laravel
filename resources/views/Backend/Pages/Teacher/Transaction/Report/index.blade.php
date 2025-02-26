@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card border-0 shadow-lg rounded">
            <div class="card-header bg-primary ">
                <h5 class="text-center text-white mb-0">Teacher Transaction Report</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form action="{{ route('admin.teacher.transaction.report_generate') }}" method="POST" id="" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from_date">From Date</label>
                                        <input type="date" name="from_date" id="from_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="to_date">To Date</label>
                                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    <i class="fas fa-times-circle"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                @if(isset($transactions) && $transactions->count() > 0)
                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="bg-info  text-white">
                            <tr>
                                <th>Teacher Name</th>
                                <th>Type</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($transactions as $teacher => $teacher_transactions)
                        <tr>
                            <td>{{ $teacher }}</td>
                            <td>
                                @php $teacherTotal = 0; @endphp
                                @foreach($teacher_transactions as $transaction)
                                    @php
                                        $type = '';
                                        if($transaction->type == 1) $type = 'Advance';
                                        elseif($transaction->type == 2) $type = 'Loan';
                                        elseif($transaction->type == 3) $type = 'Salary';
                                        $teacherTotal += $transaction->amount;
                                    @endphp
                                    <div class="d-flex justify-content-between">
                                        <span>{{ $type }}</span>
                                        <span style="text-align: right;">{{ $transaction->amount }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td style="text-align: right;">{{ $teacherTotal }}</td>
                        </tr>
                        @php $grandTotal += $teacherTotal; @endphp
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
                <h5 class="text-center text-danger">No Transactions Found For The Selected Date Range</h5>
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

        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden"></span>');
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
                    <title>Teacher Transaction Report</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { padding: 10px; border: 1px solid #ddd; }
                        th { background: #f8f9fa; text-align: left; }
                    </style>
                </head>
                <body>
                    <h3 class="text-center">Teacher Transaction Report</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">` + content + `</table>
                    </div>
                </body>
            </html>
        `);

        printWindow.document.close();

        printWindow.onload = function () {
            printWindow.print();
            printWindow.close();
        };
    }
</script>


@endsection
