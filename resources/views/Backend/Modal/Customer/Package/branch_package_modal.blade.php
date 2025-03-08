<div class="modal fade bs-example-modal-lg" id="addBranchPackageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id=""><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Create
                    Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.pop.brnach.package.store') }}" id="BranchPackageForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Package</label>
                        <select type="text" class="form-select" name="package_id" required>
                            <option value="">---Select---</option>
                            @php
                                $package = App\Models\Package::latest()->get();
                            @endphp
                            @foreach ($package as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-none">
                        <label>POP ID</label>
                        <input name="pop_id" class="form-control" type="text" value="{{ $pop->id ?? ''}}"
                            required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Purchase Price</label>
                        <input name="purchase_price" placeholder="Enter Your Amount" class="form-control" type="text" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Sale's Price</label>
                        <input name="sales_price" placeholder="Enter Your Amount" class="form-control" type="text"required>
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



<!----------------- Update Modal ------------------------>

<div class="modal fade bs-example-modal-lg" id="editBranchPackageModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Edit
                    Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBranchPackageForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Package</label>
                        <select type="text" class="form-select" name="package_id" required>
                            <option value="">---Select---</option>
                            @php
                                $package = App\Models\Package::latest()->get();
                            @endphp
                            @foreach ($package as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-none">
                        <label>POP ID</label>
                        <input name="pop_id" class="form-control" type="text" value="{{ $pop->id ?? ''}}"
                            required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Purchase Price</label>
                        <input name="purchase_price" placeholder="Enter Your Amount" class="form-control" type="text" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Sale's Price</label>
                        <input name="sales_price" placeholder="Enter Your Amount" class="form-control" type="text"required>
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
