<div class="modal fade bs-example-modal-lg" id="brandModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog " role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="brandModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;Create Brand</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                           </div>
						   <div class="modal-body">
							  <form action="{{ route('admin.brand.store') }}" id="brandForm" method="POST" enctype="multipart/form-data">
                                @csrf
									<div class="form-group mb-2">
										<label>Brand Name</label>
										<input name="name" placeholder="Enter Brand Name" class="form-control" type="text" required>
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
