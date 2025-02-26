function load_product_price($url, $price_type){
    $.ajax({
        url: $url,
        // url: "{{ route('admin.product.edit', ':id') }}".replace(':id', $product_id),
        method: 'GET',
        success: function(response) {
            selectedProductId = response.data.id;
            var price = $price_type === 'sale' ? response.data.sale_price : response.data.purchase_price;
            $('#price').val(price);
            updateTotalPrice();

        },
        error: function(xhr, status, error) {
            /*handle the error response*/
            console.log(error);
        }
    });
}
