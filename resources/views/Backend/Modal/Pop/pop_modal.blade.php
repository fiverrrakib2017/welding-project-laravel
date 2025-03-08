<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><span class="mdi mdi-account-check mdi-18px"></span> &nbsp;New
                    POP/Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.pop.store') }}" id="popForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Fullname</label>
                        <input name="name" placeholder="Enter Fullname" class="form-control" type="text" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Username</label>
                        <input name="username" placeholder="Enter Username" class="form-control" type="text"
                            required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Password</label>
                        <input name="password" placeholder="Enter Password" class="form-control" type="password"
                            required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Phone Number</label>
                        <input class="form-control" type="text" name="phone" id="phone_number"
                            placeholder="Type Phone Number" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Email</label>
                        <input class="form-control" type="email" name="email" id="email"
                            placeholder="Type Your Email" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Address</label>
                        <input class="form-control" type="text" name="address" id="address"
                            placeholder="Type Your Address" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Status</label>
                        <select type="text" class="form-select" name="status" style="width: 100%;">
                            <option value="">---Select---</option>
                            <option value="1">Active</option>
                            <option value="0">Expire</option>
                        </select>
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


<div class="modal fade bs-example-modal-lg" id="PopRechargeModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><span class="mdi mdi mdi-battery-charging-90 mdi-18px"></span> &nbsp;
                    POP/Branch Recharge</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.pop.store') }}" id="popForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Amount</label>
                        <input name="amount" placeholder="Enter Amount" class="form-control" type="number"
                            required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Action</label>
                        <select name="action"  class="form-control" type="text"
                            required>
                            <option value="">---Select---</option>
                            <option value="Recharge">Recharge</option>
                            <option value="Paid">Due Paid</option>
                            <option value="Return">Return</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="">Transaction Type</label>
                        <select type="text" class="form-select" name="status" style="width: 100%;" required>
                            <option value="">---Select---</option>
                            <option value="1">Cash</option>
                            <option value="0">Credit</option>
                            <option value="2">Bkash</option>
                            <option value="3">Nagad</option>
                            <option value="4">Bank</option>
                        </select>
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
