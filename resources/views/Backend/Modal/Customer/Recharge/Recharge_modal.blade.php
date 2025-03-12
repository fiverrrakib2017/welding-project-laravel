<div class="modal fade bs-example-modal-lg" id="CustomerRechargeModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><span class="mdi mdi mdi-battery-charging-90 mdi-18px"></span> &nbsp;
                    Customer Recharge</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.customer.recharge.store') }}" id="customerRechargeForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @php
                    $months = [
                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                    ];

                    /*Current Month*/
                    $currentMonth = date('n');
                @endphp

                <div class="form-group mb-2">
                    <label>Recharge Month</label>
                    <select name="recharge_month[]" class="form-control" multiple required>
                        <option value="{{ $months[$currentMonth] }}" selected>{{ $months[$currentMonth] }}</option>
                        @foreach($months as $num => $name)
                            @if($num != $currentMonth)
                                <option value="{{ $name }}">{{ $name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <small class="text-success">Hold Ctrl (Windows) or Command (Mac) to select multiple months.</small>
                </div>



                    <div class="d-none">
                        <input name="pop_id"  class="form-control" type="text" value="{{ $data->pop_id }}">
                        <input name="area_id"  class="form-control" type="text" value="{{ $data->area_id }}">
                        <input name="customer_id"  class="form-control" type="text" value="{{ $data->id }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Package</label>
                        <input readonly class="form-control" type="text" value="{{ $data->package->name ?? 'N/A' }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Amount</label>
                        <input readonly name="amount" placeholder="Enter Amount" class="form-control" type="number" value="{{ $data->amount ?? '0' }}"
                            required>
                    </div>

                    <div class="form-group mb-2">
                        <label>Payable Amount</label>
                        <input name="payable_amount" placeholder="Enter Amount" class="form-control" type="number" value="{{ $data->amount ?? '0' }}"
                            required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="">Transaction Type</label>
                        <select type="text" class="form-select" name="transaction_type" style="width: 100%;" required>
                            <option value="">---Select---</option>
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                            <option value="bkash">Bkash</option>
                            <option value="nagad">Nagad</option>
                            <option value="due_paid">Due Paid</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Remarks</label>
                        <input name="note" placeholder="Enter Remarks" class="form-control" type="text"
                            >
                    </div>
                    <div class="modal-footer ">
                        <button data-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {

        /*****Customer Recharge ****/
        handleSubmit('#customerRechargeForm', '#CustomerRechargeModal');

       $(document).on('change',"select[name='recharge_month[]']",function(){
            let result=$(this).val();

            let per_month_amont = parseFloat($("input[name='amount']").val()) || 0;

            let payableAmount = result.length * per_month_amont;
            payableAmount =  Math.round(payableAmount);
            $("input[name='payable_amount']").val(payableAmount);
       });
    });
</script>
