@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary shadow-sm rounded-3">
            <div class="card-header">
                <h3 class="card-title">Accounts Transaction</h3>
            </div>
            <div class="card-body">
                <form id="transaction_form" action="{{ route('admin.transaction.store') }}" method="post">
                    @csrf
                    <!-- First Row -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="refer_no" class="form-label">Refer Number</label>
                                <input type="text" name="refer_no" class="form-control" placeholder="Enter Refer No.">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" placeholder="Enter Description" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date" class="form-label">Create Date</label>
                                <input type="date" name="create_date" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <!-- Second Row -->
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sub_ledger_id" class="form-label">Sub Ledger</label>
                                <div class="input-group">
                                    <select name="sub_ledger_id" id="sub_ledger_id" class="form-control select2" required>
                                        <option value="">--- Select ---</option>
                                        @foreach ($ledger as $item)
                                            <optgroup label="{{ $item->ledger_name }}">
                                                @php
                                                    $sub_ledger = \App\Models\Sub_ledger::where('ledger_id', $item->id)->get();
                                                @endphp
                                                @foreach ($sub_ledger as $sub_ledger_item)
                                                    <option value="{{ $sub_ledger_item->id }}">{{ $sub_ledger_item->sub_ledger_name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="qty" class="form-label">Quantity</label>
                                <input type="number" name="qty" class="form-control" placeholder="Enter Quantity" value="1" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" class="form-control" placeholder="Enter Amount" value="0" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total" class="form-label">Total</label>
                                <input type="number" readonly name="total" class="form-control bg-light" value="0" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="note" class="form-label">Note</label>
                                <input type="text" name="note" class="form-control" placeholder="Enter Note">
                            </div>
                        </div>

                    </div>
                    <!-- Submit Button -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Add Transaction
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm rounded-3 border-0">

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="transaction_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Sub Ledger</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody id="transaction_table_data"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right;">
                                    <button type="submit" name="finished_button" class="btn btn-success">Finished</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Add Section Modal -->
<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Add New Sub Ledger
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <!----- Start Add Form ------->
            <form id="addForm" action="{{ route('admin.sub_ledger.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!----- Start Add Form input ------->
                        <div class="form-group mb-2">
                            <label for="sectionName">Ledger:</label>
                            <select type="text" name="ledger_id" id="modal_ledger_id" class="form-control" style="width: 100%;"  required>
                            <option value="">---Select---</option>
                                @foreach ($ledger as $item)
                                    <option value="{{$item->id}}">{{ $item->ledger_name }}</option>
                                @endforeach

                          </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="sectionName">Sub Ledger Name:</label>
                            <input type="text" name="sub_ledger_name" class="form-control" placeholder="Enter Sub Ledger Name" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="status">Status</label>
                            <select name="status" id="" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success tx-size-xs">Save changes</button>
                    <button type="button" class="btn btn-danger tx-size-xs" data-dismiss="modal">Close</button>
                </div>
            </form>
            <!----- End Add Form ------->
        </div>
    </div>
</div>
@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function() {

        $("select[name='transaction_type']").select2();
        $("select[id='ledger_id']").select2();
        $("select[id='sub_ledger_id']").select2();


        $("select[name='transaction_type']").on('change', function() {
            var master_ledger_id = $(this).val();
            if(master_ledger_id){
                    $.ajax({
                    url: "{{ route('admin.ledger.get_ledger', ':id') }}".replace(':id', master_ledger_id),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success==true) {
                            $("select[name='ledger_id']").empty();
                            $("select[name='ledger_id']").append('<option value="">---Select---</option>');
                            $.each(response.data, function(key, item) {
                                $("select[name='ledger_id']").append('<option value="' + item.id + '">' + item.ledger_name + '</option>');
                            });
                        }


                    }
                });
            }
        });
        $("select[name='ledger_id']").on('change', function() {
            var ledger_id = $(this).val();
            if(ledger_id){
                    $.ajax({
                    url: "{{ route('admin.sub_ledger.get_sub_ledger', ':id') }}".replace(':id', ledger_id),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success==true) {
                            $("select[name='sub_ledger_id']").empty();
                            $("select[name='sub_ledger_id']").append('<option value="">---Select---</option>');
                            $.each(response.data, function(key, item) {
                                $("select[name='sub_ledger_id']").append('<option value="' + item.id + '">' + item.sub_ledger_name + '</option>');
                            });
                        }


                    }
                });
            }
        });

        function calculateTotal() {
            /*Get quantity amount*/
            var qty = parseFloat($("input[name='qty']").val()) || 0;
            var amount = parseFloat($("input[name='amount']").val()) || 0;
            var total = qty * amount; /*Calculate total*/
            $("input[name='total']").val(Math.round(total));
        }
        $("input[name='qty'], input[name='amount']").on('input', function() {
            calculateTotal();
        });
    });

    $('#addForm').submit(function(e) {
        e.preventDefault();

        /*Get the submit button*/
        var submitBtn = $(this).find('button[type="submit"]');

        var originalBtnText = submitBtn.html();

        submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);
        submitBtn.prop('disabled', true);

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();

        /*Use Ajax to send the request*/
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#addModal').modal('hide');
                    toastr.success(response.message);
                    form[0].reset();
                }else if(response.success==false){
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                /*Handle errors*/
                console.error(xhr.responseText);
                toastr.error('An error occurred while processing the request.');
            },
            complete: function() {
                /** Reset button text and enable the button */
                submitBtn.html(originalBtnText);
                submitBtn.prop('disabled', false);
            }
        });
    });
    /*Show Account Transaction*/
    show_transaction();
    function show_transaction() {
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.transaction.show') }}",
            cache: true,
            success: function(response) {
            var _number = 1;
            var html = '';

            /*Check if the response data is an array*/
            if (Array.isArray(response.data) && response.data.length > 0) {
                response.data.forEach(function(transaction) {
                    html += '<tr>';
                    html += '<td>' + (_number++) + '</td>';
                    html += '<td>' +
                            (transaction.sub_ledger ? transaction.sub_ledger.sub_ledger_name : '') +
                            '<br><i>' + (transaction.note ? transaction.note : '') + '</i></td>';
                    html += '<td>' + transaction.qty + '</td>';
                    html += '<td>' + transaction.value + '</td>';
                    html += '<td>' + transaction.total + '</td>';
                    html += '</tr>';
                });
            } else {
                html += '<tr>';
                html += '<td colspan="5" style="text-align: center;">No Data Available</td>';
                html += '</tr>';
            }

            $("#transaction_table_data").html(html);
        }

        });
    }
    $(document).on('click','button[name="finished_button"]',function(e){
        e.preventDefault();
        var submitBtn =  $('#transaction_table').find('button[name="finished_button"]');
        submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);
        submitBtn.prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: "{{ route('admin.transaction.finished') }}",
            cache: true,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                if (response.success==true) {
                    toastr.success(response.message);
                    show_transaction();
                }else if(response.success==false){
                    toastr.error(response.message);
                }else{
                    toastr.error('Server Problem');
                }
            },
            complete:function(){
                submitBtn.html('Finished');
                submitBtn.prop('disabled', false);
            }

        });
    });

    /*Transaction Form Submit*/
    $("#transaction_form").submit(function(e){
        e.preventDefault();
        /*Get the submit button*/
        var submitBtn =  $('form').find('button[type="submit"]');

        /* Save the original button text*/
        var originalBtnText = submitBtn.html();

        /*Change button text to loading state*/
        submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);
        submitBtn.prop('disabled', true);
        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();
        $.ajax({
        type:'POST',
        'url':url,
        data: formData,
            success: function (response) {
                if (response.success) {
                    $(form)[0].reset();
                    toastr.success(response.message);
                    show_transaction();
                }
            },

            error: function (xhr, status, error) {
                /** Handle  errors **/
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                for (var key in errors) {
                    errorMessage += errors[key] + '<br>';
                }
                // Display error message to the user
                toastr.error(errorMessage);
                }
            },
            complete: function () {
                submitBtn.html(originalBtnText);
                submitBtn.prop('disabled', false);
            }
        });
    });
    //handle_submit_form('#transaction_form')
  </script>

@endsection
