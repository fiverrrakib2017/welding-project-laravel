@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<!-- vendor css -->
<link href="{{asset('Backend/lib/highlightjs/styles/github.css')}}" rel="stylesheet">

<link href="{{asset('Backend/lib/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('Backend/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet">

<!-- Bracket CSS -->
<link rel="stylesheet" href="{{asset('Backend/css/bracket.css')}}">
@endsection


@section('content')
<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{route('admin.dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{route('admin.supplier.index')}}">Supplier</a>
        <span class="breadcrumb-item active">Create Return</span>
    </nav>
</div><!-- br-pageheader -->
<div class="br-section-wrapper" style="padding: 0px !important;">
  <div class="table-wrapper">
    <div class="card mt-3">
      <div class="card-header bg-primary text-white">
       <h6>Create Purchase Return</h6>
      </div>
      <div class="card-body">
        <form id="returnForm" action="{{route('admin.supplier.return.invoice.store')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Note:</label>
                        <textarea type="text" name="return_note" placeholder="Enter Your Note" class="form-control" style="height: 43px;"></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Supplier:</label>
                        <select type="text" name="supplier_id" class="form-control" style="width: 100%;">
                        <option value="">Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->fullname }}</option>
                        @endforeach
                            
                        </select>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Invoice Id:</label>
                    
                        <select type="text" name="invoice_id" class="form-control" style="width: 100%;">
                        <option value="">Select Invoice</option>
                        @foreach ($invoices as $item)
                            <option value="{{ $item->id }}">{{ $item->supplier->fullname . ' - ' . $item->id }}</option>
                        @endforeach
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Product /Barcode:</label>
                    
                        <select type="text" name="product_id" class="form-control" style="width: 100%;">
                        <option value="">Select Supplier</option>
                        @foreach ($products as $item)
                            <option value="{{ $item->id }}">{{ $item->title . ' - ' . $item->barcode }}</option>
                        @endforeach
                            
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <table id="datatable1" class="table display responsive nowrap">
                        <thead>
                            <tr>
                                <th class="">Product Name</th>
                                <th class="">Quantity</th>
                                <th class="">Price</th>
                                <th class="">Total</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                            <tbody id="tableRow"></tbody>
                            <tfoot class="">
                                <tr>
                                    <th class="text-center" colspan="2"></th>
                                    <th class="text-left" colspan="3">
                                    Total Amount <input readonly class="form-control total_amount" name="total_amount" type="text">
                                    </th>
                                </tr>
                            </tfoot>
                            
                    </table>
                    <div class="form-group text-center">
                            <button type="submit"  class="btn btn-success"><i class="fe fe-dollar"></i> Create Now</button>
                            </div>
                </div>
            </div>
        </form>
      </div>
    </div>

  </div><!-- table-wrapper -->
</div><!-- br-section-wrapper -->

@endsection


@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $("select[name=invoice_id]").select2({
            placeholder: "Select Invoice",
        });
        $("select[name=supplier_id]").select2({
            placeholder: "Select Supplier",
        });
        $("select[name=product_id]").select2({
            placeholder: "Select  Product  Or Barcode",
        });
        $(document).on('change',"select[name=product_id]",function(){
         var product_id = $(this).val();
         __get_product(product_id);
        });
        /*Show Product item */
        __get_product=(product_id)=>{
            $.ajax({
                url: "{{ route('admin.products.get_product', ':id') }}".replace(':id', product_id),
                method: "GET",
                success: function(response) {
                $.each(response, function(index, product) {
                var product_exists=false;
                /*Check if the product already exists in the table*/
                $("#tableRow tr").each(function(){
                    var existing_product_id=$(this).find('input[name="product_id[]"]').val();
                    if (existing_product_id==product_id) {
                        product_exists=true;
                        return false;
                    }
                });
                if (product_exists) {
                    toastr.error("Product already added. Please increase the quantity.");
                    return false;
                }
                /* Create table row with product details*/
                var row = '<tr>' +
                        '<td><input type="hidden" name="product_id[]" value="'+product.id+'">'+__get_short_string(product.title,50)+'</td>'+

                        '<td><input type="number" min="1" name="qty[]"  value="1" class="form-control qty" max="'+product.qty+'"></td>' +

                        '<td><input readonly type="number"  name=price[] class="form-control " value="' + product.price + '"></td>' +

                        '<td><input readonly type="number" id="total_price"  name=total_price[] class="form-control" value="' + product.price+ '"></td>' +

                        '<td><a type="button" id="itemRow"><i class="text-danger icon ion-close" ></i></a></td>' +
                        '</tr>';

                    /* Append row to the table body*/
                    $('#tableRow').append(row);
                    calculateTotalPrice();
                });
                }
            });
        }
        /*Get product from invoice*/
        $(document).on('change',"select[name=invoice_id]",function(){
            var invoice_id = $(this).val();
            if(invoice_id) {
                $.ajax({
                    url: "{{ route('admin.supplier.return.invoice.get_product', ':id') }}".replace(':id', invoice_id),
                    method: "GET",
                    success: function(response) {
                        $("select[name=product_id]").empty();
                        $("select[name=product_id]").append('<option value="">Select Product</option>');
                        $.each(response, function(index, product){
                            $("select[name=product_id]").append('<option value="'+ product.id +'">'+ product.title + ' - ' + product.barcode +'</option>');
                        });
                    }
                });
            } else {
                $("select[name=product_id]").empty();
                $("select[name=product_id]").append('<option value="">Select Product</option>');
            }
        });
        $(document).on('click', '#itemRow', function() {
            $(this).closest('tr').remove();
            calculateTotalPrice();
        });
        $(document).on('change','input[name="qty[]"]',function(){
            var result=$(this).val();
            var price=$(this).closest('tr').find('input[name="price[]"]').val();
            var total_price=result*price;
            $(this).closest('tr').find('input[name="total_price[]"]').val(total_price);
            calculateTotalPrice();
        });
        $("form").submit(function(e){
            e.preventDefault();

            var form = $(this);
            form.find('button[type="submit"]').prop('disabled',true).html(`<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>`);
            var url = form.attr('action');
            var formData = form.serialize();
                /** Use Ajax to send the  request **/
                $.ajax({
                type:'POST',
                'url':url,
                data: formData,
                success: function (response) {
                    if (response.success==true) {
                        toastr.success(response.message);
                        setTimeout(() => {
                        location.reload();
                        }, 500);
                    }
                },

                error: function (xhr, status, error) {
                    /** Handle  errors **/
                    if (xhr.status === 400) {
                        toastr.error(xhr.responseJSON.message);
                        return false;
                    }
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        Object.values(errors).forEach(function(errorMessage) {
                        toastr.error(errorMessage);
                        });
                    } else {
                        console.error(xhr.responseText);
                        toastr.error('Server Issu Problem Please try again later.');
                    }
                },complete: function() {
                    form.find('button[type="submit"]').prop('disabled',false).html('Create Now');
                }
            });
        });
        function calculateTotalPrice(){
            var total_price=0;
            $("input[name='total_price[]']").each(function(){
                total_price+=parseFloat($(this).val());
            });
            $(".total_amount").val(total_price);
        }

        function __get_short_string(str,num){
         if(str.length <=num){
            return str;
         }
         return str.slice(0,num)+'...';
        }
    });
</script>


@endsection