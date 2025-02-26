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
    .month_name {
        height: auto;
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
         <form id="form-data" action="{{route('admin.student.bill_collection.store')}}" method="post">@csrf
            <div class="row">
                <div class="col-md-3 col-sm-12 mb-3">
                    <label for="" class="form-label">Class Name</label>
                    <select type="text" name="class_id" class="form-control" style="width:100%">
                        <option value="">---Select---</option>
                        @php
                           use App\Models\Student_class;
                           $classes=Student_class::all();
                        @endphp
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
               <div class="col-md-3 col-sm-12 mb-3">
                  <label class="form-label">Student Name</label>
                  <select name="student_id" class="form-select" style="width:100%">
                     <option>---Select---</option>
                  </select>
               </div>

                <div class="col-md-3 col-sm-12 mb-3">
                  <label for="date" class="form-label">Previous Due</label>
                  <input readonly type="text" name="previous_due_amount" class="form-control" value="00"/>
                </div>
                <div class="col-md-3 col-sm-12 mb-3">
                  <label for="date" class="form-label">Collection Date:</label>
                  <input readonly type="date" class="form-control" name="bill_date" value="@php
                      echo date('Y-m-d');
                  @endphp"/>
                </div>
            </div>
            <div class="row">
               <div class="col-md-3 col-sm-12 mb-3">
                  <label for="" class="form-label">Billing Item Name</label>
                  <select type="text" id="billing_item" class="form-control" style="width:100%">
                        <option>---Select---</option>
                  </select>
               </div>
               <div class="col-md-4 col-sm-12 mb-3">
                  <label for="" class="form-label">Month Name</label>
                  <select type="text" id="month_name" class="form-control month_name" style="width:100%" multiple>
                        <option>---Select---</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                  </select>
               </div>



               <div class="col-md-3 col-sm-12 mb-3">
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
                            <th>Month</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableRow" class="text-center"></tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="2">Total Amount</th>
                            <th colspan="2">
                                <input type="number" readonly  class="form-control total_amount text-right" name="total_amount" value="00">
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right" colspan="2">Paid Amount</th>
                            <th colspan="2">
                                <input type="number" class="form-control paid_amount text-right" name="paid_amount" placeholder="Enter paid amount">
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right" colspan="2">Due Amount</th>
                            <th colspan="2">
                                <input type="number" readonly class="form-control due_amount text-right" name="due_amount" placeholder="Due amount will be calculated">
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
<script  src="{{ asset('Backend/assets/js/custom_function.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){

    $("select[name='student_id']").select2();
    $("select[name='class_id']").select2();
    $(".month_name").select2();
    $("#billing_item").select2();

    $(document).on('change', 'select[name="class_id"]', function () {
        var class_id = $(this).val();
        if (class_id !== '---Select---' && class_id !== "") {
            var url="{{ route('admin.student.student_filter') }}";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
           $.ajax({
               url: url,
               type: 'POST',
               data: {  _token: csrfToken,  class_id: class_id  },

               success: function (response) {
                $.each(response.data, function (index, item) {
                    $('select[name="student_id"]').append('<option value="' + item.id + '">' + item.name + '</option>');
                });
               },
               error: function (xhr, status, error) {
                   console.error('Error:', error);
               }
           });
        } else {
            $('#student_id').html('<option>---Select---</option>');
        }
    });
     $(document).on('change', 'select[name="student_id"]', function () {
        var studentId = $(this).val();
        if (studentId !== '---Select---' && studentId !== "") {
            var url="{{ route('admin.student.get_student', ':id') }}";
            url = url.replace(':id', studentId);
           $.ajax({
               url: url,
               type: 'GET',
               data: { student_id: studentId  },
               success: function (response) {
                    getFeesType(response.current_class.id);
                    get_due_amount(studentId);
               },
               error: function (xhr, status, error) {
                   console.error('Error:', error);
               }
           });
        } else {
            $('#billing_item').html('<option>---Select---</option>');
        }
    });
    function getFeesType(classId) {

        var editUrl = '{{ route("admin.student.fees_type.get_fees_for_class", ":id") }}';
        var url = editUrl.replace(':id', classId);
        $.ajax({
            url: url,
            type: 'GET',
            data: { class_id: classId },
            success: function (response) {
                $('#billing_item').html('<option>---Select---</option>');
                $.each(response.data, function (index, item) {
                    $('#billing_item').append('<option value="' + item.id + '">' + item.type_name + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
    function get_due_amount(student_id){
        var editUrl = '{{ route("admin.student.get_student_due_amount", ":id") }}';
        var url = editUrl.replace(':id', student_id);
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                $("input[name='previous_due_amount']").val(response.data);
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
        var month = $('#month_name').val();
        var amount = $('#amount').val();
        /* Validation*/
        if (billingItemId === '---Select---' || billingItemId === "" || amount === "") {
            toastr.error("Please select a billing item and enter a valid amount.");
            return;
        }

        /*Month Display*/
        var month_display=month.join(', ');

        /*calculation total price*/
        if(month.length > 0){
            var total_price = amount * month.length;
        }else{
            var total_price= amount * 1;
        }
        /*Create New Row*/
        var newRow = `<tr>
                        <td>
                            <input type="hidden" name="billing_item_id[]" value="${billingItemId}">
                            ${billingItemName}
                        </td>
                       <td>
                            <input type="hidden" name="month_name[]" value="${month}">
                            ${month_display}
                        </td>
                        <td>
                            <input type="hidden" name="amount[]" value="${amount}">${amount}
                        </td>
                        <td>
                            <input type="hidden" name="total_price[]" value="${total_price}">${total_price}
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
        $('input[name="total_price[]"]').each(function() {
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
