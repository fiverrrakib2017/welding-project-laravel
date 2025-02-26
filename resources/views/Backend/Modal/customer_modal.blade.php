<div class="modal fade bs-example-modal-lg" id="CustomerModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog " role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="customerModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Customer</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                           </div>
						   <div class="modal-body">
							  <form action="{{ route('admin.customer.store') }}" id="CustomerForm" method="POST" enctype="multipart/form-data">
                                @csrf
									<div class="form-group mb-2">
										<label>Fullname</label>
										<input name="fullname" placeholder="Enter Fullname" class="form-control" type="text" required>
									</div>
									<div class="form-group mb-2">
										<label>Company</label>
										<input name="company" placeholder="Enter Company" class="form-control" type="text"  >
									</div>
                                    <div class="form-group mb-2">
                                        <label for="">Phone Number</label>
                                        <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Type Phone Number" required/>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="">Email</label>
                                        <input class="form-control" type="email" name="email" id="email" placeholder="Type Your Email" />
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="">Address</label>
                                        <input class="form-control" type="text" name="address" id="address" placeholder="Type Your Address" required/>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="">Status</label>
                                        <select class="form-control" type="text" style="width: 100%; " name="status">
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
