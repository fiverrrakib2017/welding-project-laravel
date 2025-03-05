<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog " role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="ModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New IP Pool</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                           </div>
						   <div class="modal-body">
							  <form action="{{ route('admin.customer.ip_pool.store') }}" id="poolForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <divl class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>Mikrotik Router</label>
                                            <select type="text" class="form-control" name="router_id" required>
                                                <option value="">---Select---</option>
                                                @php
                                                    $routers=App\Models\Router::latest()->get();
                                                @endphp
                                                @foreach ($routers as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Pool Name</label>
                                            <input name="name" placeholder="Enter Pool Name" class="form-control" type="text" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Start IP</label>
                                            <input name="start_ip" placeholder="Enter Start IP" class="form-control" type="text" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>DNS</label>
                                            <input name="dns" placeholder="8.8.8.8" class="form-control" type="text" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label>End IP</label>
                                            <input name="end_ip" placeholder="192.168 1.1 24" class="form-control" type="text" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Net Mask</label>
                                            <input name="netmask" placeholder="255.255. 255.0" class="form-control" type="text" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>Getway</label>
                                            <input name="gateway" placeholder="192.168.1.1" class="form-control" type="text" >
                                        </div>

                                    </div>
                                </divl>



									<div class="modal-footer ">
										<button data-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
										<button type="submit" class="btn btn-success">Save Changes</button>
									</div>
								</form>
							</div>
                        </div>
                     </div>
                  </div>
