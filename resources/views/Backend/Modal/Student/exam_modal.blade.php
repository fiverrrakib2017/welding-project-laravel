<div class="modal fade bs-example-modal-lg" id="examModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog " role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="examModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;Create Examination</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                           </div>
						   <div class="modal-body">
							  <form action="{{ route('admin.student.exam.store') }}" id="examForm" method="POST" enctype="multipart/form-data">
                                @csrf
									<div class="form-group mb-2">
										<label>Examination Name</label>
										<input name="name" placeholder="Enter Examination Name" class="form-control" type="text" required>
									</div>
									<div class="form-group mb-2">
										<label>Exam Year</label>
										<select  name="year"  class="form-select" style="width: 100%;" required>
                                            @php
                                                for ($year = (int)date('Y'); $year >= 1900; $year--) {
                                                    echo "<option value='$year'>$year</option>";
                                                }
                                            @endphp
                                        </select>
									</div>
                                    <div class="form-group mb-2">
                                        <label for="">Start Date</label>
                                        <input class="form-control" type="date" name="start_date" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="">End Date</label>
                                        <input class="form-control" type="date" name="end_date" required>
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
