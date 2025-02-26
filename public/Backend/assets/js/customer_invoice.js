$(document).ready(function() {
    $("#customer_name").select2();
    $(document).on('change','#product_name',function(){
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

                   '<td><input type="number" min="1" name="qty[]"  value="1" class="form-control qty"></td>' +

                   '<td><input readonly type="number"  name=price[] class="form-control " value="' + product.s_price + '"></td>' +

                   '<td><input readonly type="number" id="total_price"  name=total_price[] class="form-control" value="' + product.s_price+ '"></td>' +

                   '<td><a class="btn-sm  btn-danger" type="button" id="itemRow"><i class="mdi mdi-close" ></i></a></td>' +
                   '</tr>';

             // Append row to the table body
             $('#tableRow').append(row);
             calculateTotalPrice();
          });
          }
       });
    }


    $(document).on('change', '[name="qty[]"]', function() {
       var quantity = $(this).val();
       var price = $(this).closest('tr').find('[name="price[]"]').val();
       var total_price = Number(quantity * price);
       $(this).closest('tr').find('[name="total_price[]"]').val(total_price);
       calculateTotalPrice();
    });



    $(document).on('click', '#itemRow', function() {
       $(this).closest('tr').remove();
       $(".paid_amount").val('');
       $(".due_amount").val('');
       calculateTotalPrice();
    });



    function calculateTotalPrice() {
       var totalPrice = 0;
       $('[name="total_price[]"]').each(function() {
          totalPrice += parseFloat($(this).val() || 0);
       });
       $('.total_amount').val(totalPrice);
    }

    $(document).on('keyup','.paid_amount',function(){
       var paid_amount=$(this).val();
       var total_amount=$('.total_amount').val();
       var totalDue=Number(total_amount-paid_amount);
       /*check don't give much more money*/
       if (Number(paid_amount) > Number(total_amount)) {
          $(this).val(total_amount);
          total_due=0;
          $('.due_amount').val(total_due);
          return false;
       }
       $(".due_amount").val(totalDue);

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
             if(response.success==false){
                toastr.success(response.message);
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
                return false;
             }
              else {
                console.error(xhr.responseText);
                toastr.error('Server Problem');
             }
          },complete: function() {
             form.find('button[type="submit"]').prop('disabled',false).html('Create Now');
          }
       });
    });

    $(document).on('keyup', '[name="product_name_search"]', function() {
       var search = $(this).val();
       if (search.trim() === '') {
          fetchAllProducts();
       } else {
          searchProducts(search);
       }
    });
    function fetchAllProducts(){
       $.ajax({
          url: "{{ route('admin.customer.invoice.search_product_data') }}",
          method: 'POST',
          headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
          data: { search: '' },
          success: function(response) {
             if (response.success) {
                displayProducts(response.data);
             }
          },
          error: function(xhr, status, error) {
             console.error(xhr.responseText);
          }
       });
    }
    function searchProducts(search) {
       $.ajax({
          url: "{{ route('admin.customer.invoice.search_product_data') }}",
          method: 'POST',
          headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
          data: { search: search },
          success: function(response) {
             if (response.success) {
                displayProducts(response.data);
             }
          },
          error: function(xhr, status, error) {
             console.error(xhr.responseText);
          }
       });
    }
    function displayProducts(products) {
       var products_container = $('#search-results');
       products_container.empty();
       $.each(products, function(index, product) {
          var imageUrl = product.product_image.length > 0 ? product.product_image[0].image : '';
          var newImageUrl = imageUrl !== '' ? "{{ asset('uploads/product/') }}/" + imageUrl : '';
          products_container.append(
                `<div class="col-sm-6 py-1">
                   <div class="product-list-box card p-2">
                      <a href="javascript:void(0);" onclick="__get_product(${product.id})">
                            <img src="${newImageUrl}" class="img-fluid" alt="work-thumbnail" style="height: 150px; width: 150px;">
                      </a>
                      <div class="detail">
                            <h6 class="font-size-10 mt-2"><a href="#" onclick="__get_product(${product.id})" class="text-dark">${__get_short_string (product.title,40)}</a></h6>
                            <span>Price: ${ product.s_price}</span><br>
                            <span>Stock: ${product.qty}</span>
                      </div>
                   </div>
                </div>`
          );
       });
    }
    function __get_short_string(str,num){
       if(str.length <=num){
          return str;
       }
       return str.slice(0,num)+'...';
    }
  });
