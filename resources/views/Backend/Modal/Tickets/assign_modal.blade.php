<div class="modal fade bs-example-modal-lg" id="assignModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog " role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="assignModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;New Assign To </h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                           </div>
						   <div class="modal-body">
							  <form action="{{ route('admin.tickets.assign.store') }}" id="assignForm" method="POST" enctype="multipart/form-data">
                                @csrf
									<div class="form-group mb-2">
										<label>Assign To</label>
										<input name="name" placeholder="Enter Assign Name" class="form-control" type="text" required>
									</div>
                           <div class="form-group mb-2">
                              <label>POP Branch</label>
                              <select name="pop_id" id="pop_id" class="form-control" required>
                                  <option value="">Select POP Branch</option>
                                  @php
                                      $branch_user_id = Auth::guard('admin')->user()->pop_id ?? null;
                                      if(empty($pop_id)){
                                          $pop_id = $branch_user_id;
                                      }
                                      if ($branch_user_id != null) {
                                          $pops = App\Models\Pop_branch::where('id', $branch_user_id)->get();
                                      } else {
                                          $pops = App\Models\Pop_branch::latest()->get();
                                      }
                                  @endphp
                                  @foreach ($pops as $item)
                                      <option value="{{ $item->id }}"  @if($item->id == $pop_id) selected @endif>{{ $item->name }}</option>
                                  @endforeach
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
