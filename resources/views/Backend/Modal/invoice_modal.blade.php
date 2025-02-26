 <!-- Add Inovice Modal-->
 <div class="modal fade bs-example-modal-lg" id="invoiceModal" tabindex="-1" role="dialog"
 aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog " role="document">
    <div class="modal-content col-md-12">
       <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><span
             class="mdi mdi-account-check mdi-18px"></span> &nbsp;Invoice Summery</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
       </div>
       <div class="modal-body">
          <form id="paymentForm">

             <div class="form-group mb-2">
                <label>Total Amount </label>
                <input readonly class="form-control table_total_amount" name="table_total_amount" type="text" @if(isset($invoice_data->sub_total)) value="{{$invoice_data->sub_total}}" @else value="0" @endif >
             </div>
             <div class="form-group mb-2">
                <label>Paid Amount </label>
                <input  type="text" class="form-control table_paid_amount" name="table_paid_amount" @if(isset($invoice_data->paid_amount)) value="{{intval($invoice_data->paid_amount)}}" @else value="0" @endif>
             </div>
             <div class="form-group mb-2">
                <label> Discount Amount </label>
                <input  type="text" class="form-control table_discount_amount" name="table_discount_amount" @if(isset($invoice_data->discount)) value="{{intval($invoice_data->discount)}}" @else value="0" @endif>
             </div>
             <div class="form-group mb-2">
                <label> Due Amount </label>
                <input type="text" readonly class="form-control table_due_amount" name="table_due_amount" @if(isset($invoice_data->due_amount)) value="{{intval($invoice_data->due_amount)}}" @else value="0" @endif>
             </div>
             <div class="form-group mb-2">
                <label>Type</label>
                <select type="text" class="form-control table_status" style="width: 100%;" name="table_status">
                    <option value="">---Select---</option>
                        <option value="0" {{ isset($invoice_data->status) && $invoice_data->status == 0 ? 'selected' : '' }}>Draft</option>
                        <option value="1" {{ isset($invoice_data->status) && $invoice_data->status == 1 ? 'selected' : '' }}>Completed</option>
                        <option value="2" {{ isset($invoice_data->status) && $invoice_data->status == 2 ? 'selected' : '' }}>Print Invoice</option>
              </select>
             </div>
             <div class="modal-footer ">
                <button data-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                <button type="button" id="save_invoice_btn" class="btn btn-success">
                    @if(isset($invoice_data->id))
                        Update
                    @else
                        Save
                    @endif
                    Invoice
                </button>
             </div>
          </form>
       </div>
    </div>
 </div>
</div>
