<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id=""><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;New
                    Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.customer.package.store') }}" id="addForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label>IP-Pool</label>
                        <select type="text" class="form-select" name="pool_id" required>
                            <option value="">---Select---</option>
                            @php
                                $pools = App\Models\Ip_pools::latest()->get();
                            @endphp
                            @foreach ($pools as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} || {{ $item->start_ip }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Package Name</label>
                        <input name="name" placeholder="Enter Package Name" class="form-control" type="text"
                            required>
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

<div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
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
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label>IP-Pool</label>
                        <select type="text" class="form-select" name="pool_id" required>
                            <option value="">---Select---</option>
                            @php
                                $pools = App\Models\Ip_pools::latest()->get();
                            @endphp
                            @foreach ($pools as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} || {{ $item->start_ip }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Package Name</label>
                        <input name="name" placeholder="Enter Package Name" class="form-control" type="text"
                            required>
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
