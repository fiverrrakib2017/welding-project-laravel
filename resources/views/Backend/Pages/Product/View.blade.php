@extends('Backend.Layout.App')
@section('title', 'Product Profile | Admin Panel')
@section('style')
    <style>
        #product_info>li {
            border-bottom: 1px dashed;
        }

        .section-header {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img class="img-fluid"
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSkdGbj-QrUuNqhXP7DtY3-t8yD6H1Tk4uFg&s">
                </div>
                <div class="card mt-3">
                    <div class="card-title text-center mt-1">
                        <h5>About This Product</h5>
                    </div>
                    <div class="card-body">
                        <p>this is the nast timethis is the nast timethis is the nast timethis is the nast
                            timethis is the nast timethis is the nast timethis is the nast time</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Product Name:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->name ?? '' }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Category</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->category->category_name ?? '' }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Brand</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->brand->brand_name ?? '' }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Purchase Account No:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                @php
                                   $sub_ledger= App\Models\Sub_ledger::find($data->purchase_ac);
                                   echo  $sub_ledger->sub_ledger_name ?? '';
                                @endphp
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Sales Account:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                @php
                                $sub_ledger= App\Models\Sub_ledger::find($data->sales_ac);
                                echo $sub_ledger->sub_ledger_name ?? '';
                             @endphp
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Purchase Price:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->purchase_price ?? 00 }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Sale's Price:</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->sale_price ?? 00 }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Store</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->store->name ?? '' }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" href="#purchase_history"
                                                role="tab">
                                                <span class="d-none d-md-block">Purchase History</span><span
                                                    class="d-block d-md-none">Purchase History</span>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" href="#sales_history"
                                                role="tab">
                                                <span class="d-none d-md-block">Sales History
                                                </span><span class="d-block d-md-none">Sales History</span>
                                            </button>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane p-3 tab-pane p-3 active" id="purchase_history" role="tabpanel">
                                            <div class="table table-responsive">
                                                <table id="purchase_history_table"
                                                    class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Invoice id</th>
                                                            <th>Supplier Name</th>
                                                            <th>Quantity</th>
                                                            <th>Invoice Date</th>
                                                            <th>Create Date</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($purchase_invoice_history))
                                                        @foreach ($purchase_invoice_history as $item)
                                                            <tr>
                                                                <td>{{ $item->invoice_id ?? '' }}</td>
                                                                <td>{{ $item->invoice->supplier->fullname ?? '' }}</td>
                                                                <td>{{ $item->qty ?? '' }}</td>
                                                                <td>{{ $item->invoice->invoice_date ?? '' }}</td>
                                                                <td>{{ $item->created_at ?? '' }}</td>
                                                                <td>
                                                                    <a href="{{ route('admin.supplier.invoice.view_invoice', $item->invoice_id) }}"
                                                                        class="btn btn-primary btn-sm mr-3"><i
                                                                            class="fa fa-eye"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-3" id="sales_history" role="tabpanel">
                                            <div class="table table-responsive">
                                                <table id="sales_history_table"
                                                class="table table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Invoice id</th>
                                                            <th>Customer Name</th>
                                                            <th>Quantity</th>
                                                            <th>Invoice Date</th>
                                                            <th>Create Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($sales_invoice_history))
                                                            @foreach ($sales_invoice_history as $item)
                                                                <tr>
                                                                    <td>{{ $item->invoice_id ?? '' }}</td>
                                                                    <td>{{ $item->invoice->customer->fullname ?? '' }}</td>
                                                                    <td>{{ $item->qty ?? '' }}</td>
                                                                    <td>{{ $item->invoice->invoice_date ?? '' }}</td>
                                                                    <td>{{ $item->created_at ?? '' }}</td>
                                                                    <td>
                                                                        <a href="{{ route('admin.customer.invoice.view_invoice', $item->invoice_id) }}"
                                                                            class="btn btn-primary btn-sm mr-3"><i
                                                                                class="fa fa-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
@endsection
@section('script')

<script type="text/javascript">

    $(document).ready(function(){
        $("#purchase_history_table").DataTable();
        $("#sales_history_table").DataTable();
    })

</script>

@endsection
