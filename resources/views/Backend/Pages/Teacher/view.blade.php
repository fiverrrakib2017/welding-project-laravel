@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
    <style>
        #student_info  > li {
            border-bottom: 1px dashed;
        }
        .section-header {
        background-color: #007bff; /* Blue background color */
        color: white; /* Text color */
        padding: 5px 10px; /* Padding around text */
        margin-bottom: 5px; /* Bottom margin */
        border-radius: 5px; /* Rounded corners */
    }
    .profile-card {
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .profile-card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .profile-card .card-body {
            padding: 20px;
        }
        .profile-card h5 {
            margin: 0;
        }
        .profile-card .text-secondary {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="row">
        <div class="">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="d-flex py-2" style="float:right;">
                        <abbr title="Complain">
                            <button type="button" data-bs-target="#ComplainModalCenter" data-bs-toggle="modal"
                                class="btn-sm btn btn-warning">
                                <i class="mdi mdi-alert-outline"></i>
                            </button>
                        </abbr>
                        &nbsp;
                        <abbr title="Payment received">
                            <button type="button" data-bs-target="#paymentModal" data-bs-toggle="modal"
                                class="btn-sm btn btn-info">
                                <i class="mdi mdi mdi-cash-multiple"></i>
                            </button>
                        </abbr>
                        &nbsp;
                        <abbr title="Disable">
                            <button type="button" class="btn-sm btn btn-danger">
                                <i class="mdi mdi mdi-wifi-off "></i>
                            </button>
                        </abbr>
                        &nbsp;
                        <abbr title="Reconnect">
                            <button type="button" class="btn-sm btn btn-success">
                                <i class="mdi mdi-sync"></i>
                            </button>
                        </abbr>
                        &nbsp;
                        <abbr title="Edit Customer">
                            <a href="{{ route('admin.teacher.edit', $teacher->id) }}">
                                <button type="button" class="btn-sm btn btn-info">
                                    <i class="mdi mdi-account-edit"></i>
                                </button>
                            </a>
                        </abbr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                    <div class="card profile-card">
                        <div class="card-header p-0">
                            @if($teacher->photo && file_exists(public_path('Backend/uploads/photos/' . $teacher->photo)))
                                <img src="{{ asset('Backend/uploads/photos/'.$teacher->photo) }}" alt='Profile Picture' class="img-fluid" />
                            @else
                                <img src="{{ asset('Backend/images/default.jpg') }}" alt='Default Profile Picture' class="img-fluid" />
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h5>{{$teacher->name}}</h5>
                            <p class="text-secondary mb-1">ID: {{ $teacher->id }}</p>
                            <p class="text-secondary">{{ $teacher->phone }}</p>
                        </div>
                    </div>

                    </div>
                    <div class="col-md-8">
                        <div class="container">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#basic_information"
                                                    role="tab">
                                                    <span class="d-none d-md-block">Basic Information
                                                    </span><span class="d-block d-md-none"><i
                                                            class="mdi mdi-home-variant h5"></i></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " data-bs-toggle="tab" href="#activities"
                                                    role="tab">
                                                    <span class="d-none d-md-block">Activities
                                                    </span><span class="d-block d-md-none"><i
                                                            class="mdi mdi-home-variant h5"></i></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " data-bs-toggle="tab" href="#transaction"
                                                    role="tab">
                                                    <span class="d-none d-md-block">Transaction
                                                    </span><span class="d-block d-md-none"><i
                                                            class="mdi mdi-home-variant h5"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="basic_information" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body" style="padding: 0 !important;">
                                                    <ul class="list-group" id="student_info">

                                                    <li class="section-header">
                                        <strong>Personal Information</strong>
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Name:</strong> {{ $teacher->name }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Email:</strong> {{ $teacher->email }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Phone:</strong> {{ $teacher->phone }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Subject:</strong> {{ $teacher->subject }}
                                    </li>
                                    <li class="section-header">
                                        <strong>Personal Details</strong>
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Hire Date:</strong> {{ $teacher->hire_date }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Address:</strong> {{ $teacher->address }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Gender:</strong> {{ $teacher->gender }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Birth Date:</strong> {{ $teacher->birth_date }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>National ID:</strong> {{ $teacher->national_id }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Religion:</strong> {{ $teacher->religion }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Blood Group:</strong> {{ $teacher->blood_group ?: 'N/A' }}
                                    </li>
                                    <li class="section-header">
                                        <strong>Professional Details</strong>
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Highest Education:</strong> {{ $teacher->highest_education }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Previous School:</strong> {{ $teacher->previous_school ?: 'N/A' }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Designation:</strong> {{ $teacher->designation }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Salary:</strong> {{ $teacher->salary }}
                                    </li>
                                    <li class="section-header">
                                        <strong>Emergency Contact Information</strong>
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Emergency Contact Name:</strong> {{ $teacher->emergency_contact_name }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Emergency Contact Phone:</strong> {{ $teacher->emergency_contact_phone }}
                                    </li>
                                    <li class="section-header">
                                        <strong>Additional Information</strong>
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Remarks:</strong> {{ $teacher->remarks ?: 'N/A' }}
                                    </li>
                                    <li class="list-group-item list-group-item-action list-group-item-primary">
                                        <strong>Status:</strong> {{ $teacher->status == 1 ? 'Active' : 'Inactive' }}
                                    </li>
</ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="transaction" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                <table id="transaction_datatable"
                                                                    class="table table-bordered dt-responsive nowrap"
                                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Amount</th>
                                                                            <th>Date</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!--  -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane " id="invoice" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                <table id="invoice_datatable"
                                                                    class="table table-bordered dt-responsive nowrap"
                                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Invoice id</th>
                                                                            <th>Sub Total</th>
                                                                            <th>Discount</th>
                                                                            <th>Grand Total</th>
                                                                            <th>Create Date</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="ticket-list">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="tab-pane " id="activities" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                <table id="activities_datatable"
                                                                    class="table table-bordered dt-responsive nowrap"
                                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Id</th>
                                                                            <th>Date</th>
                                                                            <th>In Time</th>
                                                                            <th>Out Time</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $("#transaction_datatable").DataTable();
        $("#activities_datatable").DataTable();
    });
</script>
    
@endsection
