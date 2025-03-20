<div class="modal fade bs-example-modal-lg" id="addSendMessageModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog " role="document">
                        <div class="modal-content col-md-12">
                           <div class="modal-header">
                              <h5 class="modal-title" id="ModalLabel"><span
                                 class="mdi mdi-account-check mdi-18px"></span> &nbsp;Send Message</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                           </div>
						   <div class="modal-body">
							  <form action="{{ route('admin.sms.send_message_store') }}" id="SendMessageForm" method="POST" enctype="multipart/form-data">
                                @csrf
									<div class="form-group mb-2">
										<label>Customer Name</label>
										<select name="customer_id" class="form-control" type="text" required>
                                            <option value="">---Select---</option>
                                            @php
                                                $customers = \App\Models\Customer::where('is_delete', '!=', '1')->latest()->get();
                                            @endphp

                                            @if ($customers->isNotEmpty())
                                                @foreach ($customers as $item)
                                                    <option value="{{ $item->id }}"> [{{ $item->id }}] - {{ $item->username }} ||
                                                        {{ $item->fullname }}, ({{ $item->phone }})</option>
                                                @endforeach
                                                @else
                                            @endif
                                        </select>
									</div>
									<div class="form-group mb-2">
										<label>Template Name</label>
										<select name="template_id" class="form-control" type="text" required style="width: 100%">
                                            <option value="">---Select---</option>
                                            @php
                                                $data = \App\Models\Message_template::latest()->get();
                                            @endphp
                                            @foreach ($data as $item)
                                                <option value="{{ $item->id }}"> {{ $item->name }}</option>
                                            @endforeach
                                        </select>
									</div>
                                    <script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("select[name='template_id']").on('change', function() {
                                                var template_id = $(this).val();
                                                if (template_id) {
                                                    $.ajax({
                                                        url: "{{ route('admin.sms.template_get', ':id') }}".replace(':id', template_id),
                                                        type: "GET",
                                                        dataType: "json",
                                                        success: function(response) {
                                                            $("textarea[name='message']").val(response.data.message);
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.log("Error:", error);
                                                        }
                                                    });
                                                } else {
                                                    $("textarea[name='message']").val('');
                                                }
                                            });
                                        });
                                    </script>

									<div class="form-group mb-2">
										<label>SMS </label>
										<textarea name="message" placeholder="Enter SMS" class="form-control" type="text" style="height: 158px;"></textarea>
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
