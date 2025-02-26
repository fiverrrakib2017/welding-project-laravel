@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<style>
.small, small {
    color: red !important;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="card card-primary m-auto">
        <form action="{{ route('admin.student.update', $student->id) }}" method="post" id="addStudentForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="update_id" value=""/>
            <div class="card-body" >
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2" style="text-decoration:underline dotted;">Personal Information </h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Full Name</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Fullname" value="{{ $student->name ??'' }}" required>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="birth_date">Birth Date</label><small class="req"> *</small>
                                            <input type="date" class="form-control" name="birth_date" value="{{ $student->birth_date ??'' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Gender</label><small class="req"> *</small>
                                            <select class="form-control " name="gender" required>
                                                <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ $student->gender == 'Other' ? 'selected' : '' }}>Other</option>

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Photo</label><br />
                                            <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
                                            <img id="preview" class="img-fluid" src="{{ asset('uploads/photos/' . $student->photo) }}" alt="Image Preview" style="display: ; max-width: 100px; max-height: 100px;" />

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Blood Group</label>
                                            <input type="text" class="form-control" name="blood_group" placeholder="Enter blood group" value="{{ $student->blood_group ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Health Conditions</label>
                                            <input type="text" class="form-control" name="health_conditions" placeholder="Enter health conditions" value="{{ $student->health_conditions ?? '' }}">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Emergency Contact Name</label>
                                            <input type="text" class="form-control" name="emergency_contact_name" placeholder="Enter emergency contact name" value="{{ $student->emergency_contact_name ?? '' }}"required>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="emergency_contact_phone">Emergency Contact Phone</label>
                                            <input type="tel" class="form-control" name="emergency_contact_phone" placeholder="Enter emergency contact phone" value="{{ $student->emergency_contact_phone ?? '' }}" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Religion</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="religion" placeholder="Enter religion" value="{{ $student->religion ?? '' }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nationality</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="nationality" placeholder="Enter nationality" value="{{ $student->nationality ?? '' }}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2" style="text-decoration:underline dotted;">Guardian Information</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Father's Name</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="father_name" placeholder="Enter father's name" value="{{ $student->father_name ?? '' }}" required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Mother's Name</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="mother_name" placeholder="Enter mother's name" value="{{ $student->mother_name ?? '' }}"  required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guardian_name">Guardian's Name (if different)</label>
                                            <input type="text" class="form-control" name="guardian_name" placeholder="Enter guardian's name"  value="{{ $student->guardian_name ?? '' }}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2" style="text-decoration:underline dotted;">Contact Information</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Current Address</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="current_address" placeholder="Current Address"  value="{{ $student->current_address ?? '' }}"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Permanent Address</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="permanent_address" placeholder="Permanent Address"  value="{{ $student->permanent_address ?? '' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Phone Number-1</label>
                                            <input type="tel" class="form-control" name="phone" placeholder="Enter phone number" value="{{ $student->phone ?? '' }}" required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="phone">Phone Number-2</label>
                                            <input type="tel" class="form-control" name="phone_2" placeholder="Enter phone number"  value="{{ $student->phone_2 ?? '' }}"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2" style="text-decoration:underline dotted;">Education Information</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Current Class</label><small class="req"> *</small>
                                            <select type="text" class="form-control" name="current_class"  style="width: 100%;" required>
                                                <option value="">---Select---</option>
                                                @foreach($data as $item)
                                                    <option value="{{ $item->id }}" {{ $student->current_class == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Section Name</label><small class="req"> *</small>
                                            <select type="text" class="form-control" name="section_id"  style="width: 100%;" required>
                                                <option value="">---Select---</option>

                                                @foreach($section as $item)
                                                <option value="{{ $item->id }}" {{ $student->section_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>

                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Previous School</label>
                                            <input type="text" class="form-control" name="previous_school" placeholder="Enter previous school"  value="{{ $student->previous_school }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="academic_results">Academic Results</label>
                                            <input type="text" class="form-control" name="academic_results" placeholder="Enter academic results"  value="{{ $student->academic_results }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="remarks">Class Roll No.</label>
                                        <input class="form-control" name="roll_no" rows="1" placeholder="Enter Roll No" value="{{ $student->roll_no ?? '' }}">

                                    </div>
                                    <div class="col-md-6">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="form-control" name="remarks" rows="1" placeholder="Enter any remarks">{{ $student->remarks ?? '' }}</textarea>

                                    </div>
                                </div>
                            </div><br>
                            <div id="upload_documents_hide_show">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tshadow bozero">
                                            <h4 class="pagetitleh2" style="text-decoration:underline dotted;">Upload Documents</h4>
                                            <div class="row around10">
                                                <div class="col-md-6">
                                                    <table class="table">
                                                        <tbody><tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>Title</th>
                                                                <th>Documents</th>
                                                            </tr>
                                                            <tr>
                                                                <td>1.</td>
                                                                <td>Birth Certificate</td>
                                                                <td>
                                                                    <input class="form-control" type="file" name="documents[]" id="doc1" style="padding-top:3px;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3.</td>
                                                                <td>Registration Paper</td>
                                                                <td>
                                                                    <input class="form-control" type="file" name="documents[]" style="padding-top:3px;">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-6">
                                                    <table class="table">
                                                        <tbody><tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>Title</th>
                                                                <th>Documents</th>
                                                            </tr>
                                                            <tr>
                                                                <td>2.</td>
                                                                <td>T. Certificate</td>
                                                                <td>
                                                                    <input class="filestyle form-control" type="file" name="documents[]" id="doc2" style="padding-top:3px;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>4.</td>
                                                                <td>Others Documents</td>
                                                                <td>
                                                                    <input class="filestyle form-control" type="file" name="documents[]" id="doc2" style="padding-top:3px;">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="history.back();" class="btn btn-danger">Back</button>
                        <button type="submit" class="btn btn-success">Student Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function(){
         $("select[name='current_class']").select2();
         $("select[name='section_id']").select2();

        $("input[name='current_address']").on('keyup',function(){
            var current_address = $(this).val();
            $("input[name='permanent_address']").val(current_address);
        });
        $(document).on('change','select[name="current_class"]',function(){
            var sections = @json($section);
            var selectedClassId = $(this).val();
            var filteredSections = sections.filter(function(section) {
                /*Filter sections by class_id*/
                return section.class_id == selectedClassId;
            });

            /* Update Section dropdown*/
            var sectionOptions = '<option value="">--Select Section--</option>';
            filteredSections.forEach(function(section) {
                sectionOptions += '<option value="' + section.id + '">' + section.name + '</option>';
            });

            $('select[name="section_id"]').html(sectionOptions);
            $('select[name="section_id"]').select2();
        });

        $('#photo').change(function() {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#addStudentForm').submit(function(e) {
            e.preventDefault();

            /* Get the submit button */
            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();

            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
            submitBtn.prop('disabled', true);

            var form = $(this);
            var url = form.attr('action');
            /*Change to FormData to handle file uploads*/
            var formData = new FormData(this);

            /* Use Ajax to send the request */
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    /* Disable the Form input */
                    form.find(':input').prop('disabled', true);
                    submitBtn.prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        // form[0].reset();
                        // $('#preview').hide();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr, status, error) {
                    /* Handle errors */
                    console.error(xhr.responseText);
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        for (var error in errors) {
                            toastr.error(errors[error][0]);
                        }
                    } else {
                        toastr.error('An error occurred while processing the request.');
                    }
                },
                complete: function() {
                    /* Reset button text and enable the button */
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                }
            });
        });


    });
  </script>


@endsection
