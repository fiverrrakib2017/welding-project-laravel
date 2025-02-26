
@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')

@section('content')
<div class="row">
  <div class="col-md-2 offset-md-12 mt-3 mb-2">
    <div>
      <select name="dateFilter" class="form-select" style="width: 100%;">
        <option label="Choose one"></option>
        <option value="today" selected>Today</option>
        <option value="last7days">Last 7 Days</option>
        <option value="this_month">This Month</option>
        <option value="last_month">Last Month</option>
        <option value="this_year">This Year</option>
        <option value="last_year">Last Year</option>
        <option value="last_two_years">Last 2 Years</option>
      </select>
    </div>
  </div>
</div>


  <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3 id="total_sales_amount">00</h3>

            <p>Total Sales</p>
          </div>
          <div class="icon">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3 id="total_purchase_amount">00</h3>

            <p>Total Purchase</p>
          </div>
          <div class="icon">
            <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3 id="total_customer_invoice">00</h3>

            <p>Total Customer Invoices</p>
          </div>
          <div class="icon">
            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3 id="net_profit">00</h3>

            <p>Net Profit</p>
          </div>
          <div class="icon">
            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
  </div>
  <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3 id="total_customer">00</h3>

            <p>Total Customers</p>
          </div>
          <div class="icon">
            <i class="fas fa-users fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3 id="total_supplier">00</h3>

            <p>Total Suppliers</p>
          </div>
          <div class="icon">
            <i class="fas fa-truck fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3 id="total_supplier_invoice">00</h3>

            <p>Total Suppliers Invoice</p>
          </div>
          <div class="icon">
            <i class="fas fa-boxes fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3 id="total_products">00</h3>

            <p>Total Products</p>
          </div>
          <div class="icon">
            <i class="fas fa-boxes fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3 id="total_stock">65</h3>

            <p>Total Stock</p>
          </div>
          <div class="icon">
            <i class="fas fa-box-open fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
  </div>



@endsection

@section('script')
  <script type="text/javascript">
    $("select[name='dateFilter']").select2();
    __fetch_data("today");
    $('select[name="dateFilter"]').on('change', function () {
      var data = $(this).val();
      __fetch_data(data);
    });

    function __fetch_data(date) {
      $.ajax({
        url: "{{ route('admin.dashboard_get_all_data') }}",
        type: 'POST',
        data: { date: date },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
          $('#total_sales_amount').text(response.total_sales_amount);
          $('#total_purchase_amount').text(response.total_purchase_amount);
          $('#total_customer').text(response.total_customer);
          $('#total_supplier').text(response.total_supplier);
          $('#total_products').text(response.total_products);
          $('#total_customer_invoice').text(response.total_customer_invoice);
          $('#total_supplier_invoice').text(response.total_supplier_invoice);
          $('#net_profit').text(response.net_profit);
          $('#total_customer_order').text(response.total_customer_order);
          $('#total_stock').text(response.total_quantity);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }
  </script>
@endsection
