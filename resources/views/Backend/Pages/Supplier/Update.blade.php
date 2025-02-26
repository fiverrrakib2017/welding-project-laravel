@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')

    <style>
       #preview {

        margin-top: 10px;
        max-width: 200px;
        max-height: 200px;
    }

    .loading-spinner {
        border:4px solid #f1f1f1;
        border-left-color: #000000;;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        }

        @keyframes spin {
        to {
            transform: rotate(360deg);
        }
        }

    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h4>Update Supplier</h4>
            </div>
            <form action="{{route('admin.supplier.update',$data->id)}}" method="post" id="addForm" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
               
                    <!-- Customer Personal Information -->
                    <div class="section">
                        <h6 style="color:#777878">Customer Personal Information</h6>
                        <hr style="border-top: 1px dashed #d3c6c6;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname">Full Name</label>
                                <input type="text" class="form-control" name="fullname" placeholder="Enter full name" value="{{$data->fullname}}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email_address">Email Address</label>
                                <input type="email" class="form-control" name="email_address" placeholder="Enter email address" value="{{$data->email_address}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="profile_image">Profile Image</label>
                                <input type="file" class="form-control" name="profile_image" id="profile_image" accept="image/*">

                               
                                @if (!empty($data->profile_image))
                                <img id="preview" class="img-fluid" src="{{ asset('Backend/uploads/photos/' . $data->profile_image) }}" alt="Image Preview" style="display: ; max-width: 100px; max-height: 100px;" />
                                @else 
                                <img src="{{ asset('Backend/images/default.jpg') }}" height="90px" width="150px" alt="">
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number" value="{{$data->phone_number ?? ''}}">
                            </div>
                        </div>
                    </div>
                    <hr style="border-top: 1px dashed #d3c6c6;">

                    <!-- Emergency Contact Information -->
                    <div class="section">
                        <h6 style="color:#777878">Emergency Contact Information</h6>
                        <hr style="border-top: 1px dashed #d3c6c6;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="e_contract">Emergency Contact</label>
                                <input type="number" class="form-control" name="e_contract" placeholder="Enter emergency contact" value="{{ $data->emergency_contract }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="city" placeholder="Enter city" value="{{$data->city}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state">State</label>
                                <input type="text" class="form-control" name="state" placeholder="Enter state"  value="{{$data->state}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Enter address" value="{{$data->address}}">
                            </div>
                        </div>
                    </div>
                    <hr style="border-top: 1px dashed #d3c6c6;">

                    <!-- Additional Information -->
                    <div class="section">
                        <h6 style="color:#777878">Additional Information</h6>
                        <hr style="border-top: 1px dashed #d3c6c6;">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth" value="{{$data->dob}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gender">Gender</label>
                                <select type="text"  class="form-control" name="gender">
                                    <option value="1" {{ $data->gender == 1 ? 'selected' : '' }}>Male</option>
                                    <option value="0" {{ $data->gender == 0 ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="marital_status">Marital Status</label>
                                <select type="text"  class="form-control" name="marital_status">
                                    <option value="1" {{ $data->marital_status == 1 ? 'selected' : '' }}>Single</option>
                                    <option value="2" {{ $data->marital_status == 2 ? 'selected' : '' }}>Married</option>
                                    <option value="3" {{ $data->marital_status == 3 ? 'selected' : '' }}>Devorce</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr style="border-top: 1px dashed #d3c6c6;">

                    <!-- Verification Information -->
                    <div class="section">
                        <h6 style="color:#777878">Verification Information</h6>
                        <hr style="border-top: 1px dashed #d3c6c6;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="verification_status">Verification Status</label>
                                <select type="text"  class="form-control" name="verification_status">
                                    <option value="1" {{ $data->verification_status == 1 ? 'selected' : '' }}>Completed</option>
                                    <option value="2" {{ $data->verification_status == 2 ? 'selected' : '' }}>Panding</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="verification_info">Verification Info</label>
                                <textarea class="form-control" name="verification_info" placeholder="Enter verification info">{{ $data->verification_info}}</textarea>
                            </div>
                        </div>
                    </div>
                    <hr style="border-top: 1px dashed #d3c6c6;">

                    <!-- Banking Information -->
                    <div class="section">
                        <h6 style="color:#777878">Banking Information</h6>
                        <hr style="border-top: 1px dashed #d3c6c6;">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="opening_balance">Opening Balance</label>
                                <input type="number" class="form-control" name="opening_balance" placeholder="Enter amount" value="{{$data->opening_balance}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name" placeholder="Enter bank name" value="{{$data->bank_name}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bank_account_name">Bank Account Name</label>
                                <input type="text" class="form-control" name="bank_account_name" placeholder="Enter bank account name" value="{{$data->bank_acc_name}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="bank_acc_no">Bank Account Number</label>
                                <input type="number" class="form-control" name="bank_acc_no" placeholder="Enter bank account number" value="{{$data->bank_acc_no}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bank_routing_no">Bank Routing Number</label>
                                <input type="number" class="form-control" name="bank_routing_no" placeholder="Enter bank routing number" value="{{$data->bank_routing_no}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bank_payment_status">Bank Payment Status</label>
                                <select type="text"  class="form-control" name="bank_payment_status">
                                  <option value="1"{{ $data->bank_payment_status == 1 ? 'selected' : '' }}>Completed</option>
                                  <option value="2" {{ $data->bank_payment_status == 2 ? 'selected' : '' }}>Panding</option>
                              </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-success">Update Now</button>

              <button onclick="history.back();" type="button" class="btn btn-danger">Back</button> 
            </div>
          </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function(){
        $("select[name='gender']").select2();
        $("select[name='marital_status']").select2();
        $("select[name='verification_status']").select2();
        $("select[name='bank_payment_status']").select2();

        $('#profile_image').change(function() {
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
            var formData = new FormData(this);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while adding the customer.');
                },
                complete: function() {
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                }
            });
        });

    });
</script>
@endsection
