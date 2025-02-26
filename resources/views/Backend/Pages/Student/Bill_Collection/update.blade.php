@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<style>
    /* Custom styling for professional look */
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table thead th {
        background-color: #17a2b8;
        color: white;
    }

    .table tfoot th {
        background-color: #f8f9fa;
    }

    /* .form-control {
        border: none;
        border-bottom: 2px solid #17a2b8;
        box-shadow: none;
    } */

    /* .form-control:focus {
        border-bottom: 2px solid #117a8b;
        box-shadow: none;
    } */
    
    /* .table tfoot .form-control[readonly] {
        background-color: transparent;
    } */

    .table tfoot th {
        font-weight: normal;
    }
</style>

@endsection
@section('content')
<div class="container">
   <div class="card shadow-sm">
      <div class="card-header ">
         <h4>Student Bill Collection</h4>
      </div>
      <div class="card-body">
         <form id="form-data" action="{{route('admin.student.bill_collection.update', $data->id)}}" method="post">@csrf
            <div class="row">
               <div class="col-md-4 col-sm-12 mb-3">
                  <label class="form-label">Student Name</label>
                  <select name="student_id" class="form-select" style="width:100%">
                     <option>---Select---</option>
                     @foreach ($student as $item)
                        <option value="{{$item->id}}" @if($item->id == $data->student_id) selected @endif>{{$item->name}}</option>
                    @endforeach
                  </select>
               </div>

                <div class="col-md-4 col-sm-12 mb-3">
                  <label for="" class="form-label">Class Name</label>
                  <select type="text" name="class_id" class="form-control" style="width:100%">
                        <option>---Select---</option>
                  </select>
                </div>

                <div class="col-md-4 col-sm-12 mb-3">
                  <label for="date" class="form-label">Previous Due</label>
                  <input type="text" class="form-control" value="00"/>
                </div>

               <div class="col-md-4 col-sm-12 mb-3">
                  <label for="" class="form-label">Billing Item Name</label>
                  <select type="text" id="billing_item" class="form-control" style="width:100%">
                        <option>---Select---</option>
                  </select>
               </div>

               

               <div class="col-md-4 col-sm-12 mb-3">
                  <label for="" class="form-label">Amount</label>
                  <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter Amount"/>
               </div>

               <div class="col-md-2 col-sm-12 d-flex align-items-end mb-3">
                  <button type="button" id="submitBtn" class="btn btn-primary w-100">Add Now</button>
               </div> 
            </div>

            <div class="table-responsive">
                <table class="table table-bordered  table-sm">
                    <thead class="text-center">
                        <tr>
                            <th>Billing Item Name</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableRow" class="text-center">
                        @foreach ($data->items as $item)
                        <tr>
                            <td>
                                <input type="hidden" name="billing_item_id[]" value="{{$item->fees_type->id}}">
                                {{ $item->fees_type->type_name }}
                            </td>
                            <td>
                                <input type="hidden" name="amount[]" value="{{$item->amount}}">{{floatVal($item->amount)}}
                            </td>
                            <td>
                                <input type="hidden" name="total_price[]" value="{{$item->amount}}">{{floatVal($item->amount)}}
                            </td>
                            <td>
                                <button type="button" class="btn-sm btn-danger removeRow"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                            <th class="text-right" colspan="2">Total Amount</th>
                            <th colspan="2">
                                <input type="text" readonly  class="form-control total_amount text-right" name="total_amount" value="{{floatVal($data->total_amount)}}">
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right" colspan="2">Paid Amount</th>
                            <th colspan="2">
                                <input type="text" class="form-control paid_amount text-right" name="paid_amount" placeholder="Enter paid amount" value="{{floatVal($data->paid_amount)}}">
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right" colspan="2">Due Amount</th>
                            <th colspan="2">
                                <input type="text" readonly class="form-control due_amount text-right" name="due_amount" placeholder="Due amount will be calculated"  value="{{floatVal($data->due_amount)}}">
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-end">
               <button type="button" onclick="history.back();" class="btn btn-danger ">Back</button>
               <button type="submit" class="btn btn-success "><i class="fas fa-dollar-sign"></i> Create Now</button>
            </div>
         </form>
      </div>
   </div>
</div>

@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var studentId = '{{ $data->student_id }}';
    $("select[name='student_id']").select2();
    $("select[name='class_id']").select2();
    $("#billing_item").select2();

     $(document).on('change', 'select[name="student_id"]', function () {
        var studentId = $(this).val();
        get_billing_item(studentId)
        
    });
    get_billing_item(studentId)
    function get_billing_item(studentId){
        if (studentId !== '---Select---' && studentId !== "") {
            var url="{{ route('admin.student.get_student', ':id') }}";
            url = url.replace(':id', studentId);
           $.ajax({
               url: url,
               type: 'GET',
               data: { student_id: studentId  },
               success: function (response) {
                    console.log(response.current_class.id);
                    $("select[name='class_id']").html(`<option value="${response.current_class.id}">${response.current_class.name}</option>`);
                    getFeesType(response.current_class.id);
               },
               error: function (xhr, status, error) {
                   console.error('Error:', error);
               }
           });
        } else {
            $('#billing_item').html('<option>---Select---</option>');
        }
    }
    function getFeesType(classId) {
      
        var editUrl = '{{ route("admin.student.fees_type.get_fees_for_class", ":id") }}';
        var url = editUrl.replace(':id', classId);
        $.ajax({
            url: url, 
            type: 'GET',
            data: { class_id: classId },
            success: function (response) {
                $('#billing_item').html('<option>---Select---</option>');
                console.log(response.data);
                $.each(response.data, function (index, item) {
                    $('#billing_item').append('<option value="' + item.id + '">' + item.type_name + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
    $("#billing_item").on('change',function(){
        var billing_item_id = $(this).val();
        var editUrl = '{{ route("admin.student.fees_type.get_fees_type", ":id") }}';
        var url=editUrl.replace(':id', billing_item_id);
        $.ajax({
            url:url, 
            type: 'GET',
            data: { id: billing_item_id},
            success: function (response) {
                $('#amount').val(response.data.amount);
                
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
   /*When Add Now Button is Click*/
     $('#submitBtn').on('click', function() {
        /*Collect form input value*/
        var billingItemName = $('#billing_item option:selected').text();
        var billingItemId = $('#billing_item').val();
        var amount = $('#amount').val();

        /* Validation*/
        if (billingItemId === '---Select---' || billingItemId === "" || amount === "") {
            toastr.error("Please select a billing item and enter a valid amount.");
            return;
        }

        /*Create New Row*/ 
        var newRow = `<tr>
                        <td>
                            <input type="hidden" name="billing_item_id[]" value="${billingItemId}">
                            ${billingItemName}
                        </td>
                        <td>
                            <input type="hidden" name="amount[]" value="${amount}">${amount}
                        </td>
                        <td>
                            <input type="hidden" name="total_price[]" value="${amount}">${amount}
                        </td>
                        <td>
                            <button type="button" class="btn-sm btn-danger removeRow"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;

       
        $('#tableRow').append(newRow);
        updateTotalAmount();
        $('#amount').val('');
        $('#billing_item').val('---Select---');
    });

    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
        updateTotalAmount();
    });

    
    function updateTotalAmount() {
        var totalAmount = 0;
        $('input[name="amount[]"]').each(function() {
            totalAmount += parseFloat($(this).val()) || 0;
        });
        $('input[name="total_amount"]').val(totalAmount);

        var paidAmount = parseFloat($('input[name="paid_amount"]').val()) || 0;
        var dueAmount = totalAmount - paidAmount;
        $('input[name="due_amount"]').val(dueAmount);
    }

    $('input[name="paid_amount"]').on('input', function() {
        updateTotalAmount();
    });
    /* Handle form submit */
    $("#form-data").submit(function(e){
        e.preventDefault();
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        submitBtn.prop('disabled', true);

        var formData = new FormData(this);
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.student.bill_collection.index') }}";
                    }, 500);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) { 
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            toastr.error(message); 
                        });
                    });
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            },
            complete: function() {
                submitBtn.html(originalBtnText);
                submitBtn.prop('disabled', false);
            }
        });
    });

   
});

  </script>
  

@endsection
