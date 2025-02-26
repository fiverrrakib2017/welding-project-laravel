@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')

    <style>
       #preview {

        margin-top: 10px;
        max-width: 200px;
        max-height: 200px;
    }
    .small, small {
    color: red !important;
}
    </style>
@endsection
@section('content')
<div class="row">
    <div class="card card-primary m-auto">
        <form action="{{ route('admin.teacher.store') }}" method="post" id="addForm" enctype="multipart/form-data">
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
                                            <input type="text" class="form-control" name="name" placeholder="Enter Fullname"  required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email Address</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="email" placeholder="Enter Email"  required>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Phone Number-1</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="phone"  placeholder="Enter Phone Number 1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Phone Number-2</label><small class="req"> *</small>
                                            <input type="text" class="form-control" placeholder="Enter Phone Number 2" name="phone_2" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Subject</label><small class="req"> *</small>
                                            <input type="text" class="form-control" placeholder="Enter Subject" name="subject" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Hire Date</label><small class="req"> *</small>
                                            <input type="date" class="form-control"name="hire_date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Address</label><small class="req"> *</small>
                                            <input type="text"  placeholder="Enter Address" class="form-control"name="address" required>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Photo</label><small class="req"> *</small><br />
                                            <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
                                            <img id="preview" class="img-fluid" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;" />

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Father's Name</label><small class="req"> *</small>
                                            <input type="text"  placeholder="Enter Father's Name" class="form-control" name="father_name" placeholder="Enter Father's Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Mother's Name</label><small class="req"> *</small>
                                            <input type="text"  placeholder="Enter Mother's Name" class="form-control" name="mother_name" placeholder="Enter Mother's Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Gender</label><small class="req"> *</small>
                                            <select type="text"  class="form-control" name="gender" required>
                                                <option value="">Select gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Birth Date</label><small class="req"> *</small>
                                            <input type="date" class="form-control" name="birth_date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">National ID</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="national_id" placeholder="Enter national ID" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Religion</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="religion" placeholder="Enter Religion" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Blood Group</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="blood_group" placeholder="Enter Blood Group" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Blood Group</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="blood_group" placeholder="Enter Blood Group" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Highest Education</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="highest_education" placeholder="Enter Highest Education">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2" style="text-decoration:underline dotted;">Professional Information</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Previous School</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="previous_school" placeholder="Enter Previous School" required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Designation</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="designation" placeholder="Enter Designation" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guardian_name">Salary</label>
                                            <input type="text" class="form-control" name="salary" placeholder="Enter salary" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tshadow mb25 bozero">
                                <h4 class="pagetitleh2" style="text-decoration:underline dotted;">Emergency Contact Information</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Emergency Contact Name</label><small class="req"> *</small>
                                            <input type="text" class="form-control"  name="emergency_contact_name" placeholder="Enter Emergency Contact Name" required>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Emergency Contact Phone</label><small class="req"> *</small>
                                            <input type="text" class="form-control" name="emergency_contact_phone" placeholder="Enter emergency contact phone" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guardian_name">Remarks</label>
                                            <textarea type="text" class="form-control" name="remarks"  placeholder="Enter any remarks" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                                <td>CV Or Resume</td>
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
                        <button type="submit" class="btn btn-success">Add Teacher</button>
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
         $("select[name='gender']").select2();
        // $("select[name='status']").select2();

        $('#photo').change(function() {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#addForm').submit(function(e) {
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
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        form[0].reset();
                        $('#preview').hide();
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
                        toastr.error('Error Request');
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
