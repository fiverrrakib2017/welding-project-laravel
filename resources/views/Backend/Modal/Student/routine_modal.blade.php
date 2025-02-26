<div class="modal fade bs-example-modal-lg" id="routineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="routineModalLabel">
                    <span class="mdi mdi-account-check mdi-18px"></span> &nbsp;Create Examination Routine
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.student.exam.routine.store') }}" method="POST"  id="routineForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Examination Name</label>
                            <select name="exam_id" class="form-select" type="text" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $exams = \App\Models\Student_exam::latest()->get();
                                @endphp
                                @if($exams->isNotEmpty())
                                    @foreach($exams as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Class Name</label>
                            <select name="class_id" class="form-select" type="text" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $classes = \App\Models\Student_class::latest()->get();
                                @endphp
                                @if($classes->isNotEmpty())
                                    @foreach($classes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6 mb-2">
                            <label>Subject Name</label>
                            <select name="subject_id" class="form-select" type="text" style="width: 100%;" required>
                                <option value="">---Select---</option>
                                @php
                                    $subjects = \App\Models\Student_subject::latest()->get();
                                @endphp
                                @if($subjects->isNotEmpty())
                                    @foreach($subjects as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Exam Date</label>
                            <input  type="date" name="exam_date" class="form-control"  required />
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Start Time</label>
                            <input type="time"  name="start_time" class="form-control" required />

                        </div>
                        <div class="col-md-6 mb-2">
                            <label>End Time</label>
                            <input type="time" name="end_time" class="form-control"  required />

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Room Number</label>
                            <input type="number" name="room_number" class="form-control" type="text" placeholder="Enter Room Number" required />

                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Invigilator Name</label>
                            <input name="invigilator_name" class="form-control" type="text" placeholder="Enter Invigilator Name" required />

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
