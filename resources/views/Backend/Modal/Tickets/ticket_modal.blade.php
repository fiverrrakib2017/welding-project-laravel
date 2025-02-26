<div class="modal fade bs-example-modal-lg" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Create Ticket
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.tickets.store') }}" method="POST"  id="ticketForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Student Name</label>
                            <select name="student_id" class="form-select" type="text" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $students = \App\Models\Student::latest()->get();
                                @endphp
                                @if($students->isNotEmpty())
                                    @foreach($students as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">No student available</option>
                                @endif
                            </select>

                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Ticket For</label>
                            <select name="ticket_for" class="form-select" type="text" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                <option value="1">Default </option>
                            </select>

                        </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6 mb-2">
                            <label>Ticket Assign</label>
                            <select name="ticket_assign_id" class="form-select" type="text" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $tickets_assign = \App\Models\Ticket_assign::latest()->get();
                                @endphp
                                @if($tickets_assign->isNotEmpty())
                                    @foreach($tickets_assign as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">Not Data available</option>
                                @endif
                            </select>

                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Complain Type</label>
                            <select name="ticket_complain_id" class="form-select" type="text" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $tickets_complain = \App\Models\Ticket_complain_type::latest()->get();
                                @endphp
                                @if($tickets_complain->isNotEmpty())
                                    @foreach($tickets_complain as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">Not Data available</option>
                                @endif
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Priority</label>
                            <select name="priority_id" class="form-select" type="text" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                <option value="1">Low</option>
                                <option value="2">Normal</option>
                                <option value="3">Standard</option>
                                <option value="4">Medium</option>
                                <option value="5">High</option>
                                <option value="6">Very High</option>
                            </select>

                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Subject</label>
                            <input name="subject" class="form-control" type="text" placeholder="Enter Subject" required/>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Description</label>
                            <textarea name="description" class="form-control" type="text" placeholder="Enter Description" required></textarea>

                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Ticket Status</label>
                            <select name="status_id" class="form-select" type="text" style="width: 100%;" required>
                                <option value="0">Active</option>
                                <option value="1">Completed</option>
                            </select>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Percentage</label>
                            <select name="percentage" class="form-select" type="text" style="width: 100%;" required>
                                <option value="0%">0%</option>
                                <option value="15%">15%</option>
                                <option value="25%">25%</option>
                                <option value="35%">35%</option>
                                <option value="45%">45%</option>
                                <option value="55%">55%</option>
                                <option value="65%">65%</option>
                                <option value="75%">75%</option>
                                <option value="85%">85%</option>
                                <option value="95%">95%</option>
                                <option value="100%">100%</option>
                            </select>

                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Note</label>
                            <input name="note" class="form-control" type="text" placeholder="Enter Note"/>

                        </div>
                        <div class="col-md-6 mb-2">

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
