<div class="modal fade " id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Create Product
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.product.store') }}" method="POST"  id="productForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Product Name</label>
                            <input name="name" placeholder="Enter Product Name" class="form-control" type="text" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="unit_id">Units</label>
                            <select id="unit_id" name="unit_id"  class="form-select" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $units = \App\Models\Unit::all();
                                @endphp
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6 mb-2">
                            <label for="brand_id">Brand</label>
                            <select id="brand_id" name="brand_id" class="form-select" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $brands = \App\Models\Product_Brand::latest()->get();
                                @endphp
                                @if($brands->isNotEmpty())
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                @else
                                    <option value="">No brands available</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" style="width: 100%;" class="form-select" required>
                                <option value="">---Select---</option>
                                @php
                                    $categories = \App\Models\Product_Category::latest()->get();
                                @endphp
                                @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                @else
                                    <option value="">No categories available</option>
                                @endif
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="purchase_ac">Purchase A/C</label>
                            <select id="purchase_ac" name="purchase_ac" style="width: 100%;" class="form-select" required>
                                <option value="">---Select---</option>
                                @php
                                    $purchaseAccounts = \App\Models\Ledger::where('master_ledger_id', 2)->get();
                                @endphp
                                @foreach($purchaseAccounts as $account)
                                    <optgroup label="{{ $account->ledger_name }}">
                                        @php
                                            $subLedgers = \App\Models\Sub_ledger::where('ledger_id', $account->id)->get();
                                        @endphp
                                        @foreach($subLedgers as $subLedger)
                                            <option value="{{ $subLedger->id }}">{{ $subLedger->sub_ledger_name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="sales_ac">Sales A/C</label>
                            <select id="sales_ac" name="sales_ac" class="form-select" style="width: 100%;" width="100%" required>
                                <option value="">---Select---</option>
                                @php
                                    $salesAccounts = \App\Models\Ledger::where('master_ledger_id', 1)->get();
                                @endphp
                                @foreach($salesAccounts as $account)
                                    <optgroup label="{{ $account->ledger_name }}">
                                        @php
                                            $subLedgers = \App\Models\Sub_ledger::where('ledger_id', $account->id)->get();
                                        @endphp
                                        @foreach($subLedgers as $subLedger)
                                            <option value="{{ $subLedger->id }}">{{ $subLedger->sub_ledger_name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="">Purchase Price</label>
                            <input type="text" name="purchase_price" class="form-control" placeholder="Enter Your Purchase Price" required />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Sale's Price</label>
                            <input type="text" name="sales_price" class="form-control" placeholder="Enter Your Sale's Price" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="store">Store</label>
                            <select  name="store_id" class="form-select" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $stores = \App\Models\Store::all();
                                @endphp
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Remarks</label>
                            <input type="text" class="form-control"   name="note" placeholder="Enter Your Note" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Quantity</label>
                            <input type="number" class="form-control"   name="qty" placeholder="Enter Quantity" value="0"/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
