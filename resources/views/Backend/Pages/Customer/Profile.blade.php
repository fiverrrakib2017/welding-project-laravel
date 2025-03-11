@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>

</style>
@endsection

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
              <!-- Buttons -->
    <div class="col-md-12 d-flex flex-wrap gap-2">
        <button class="btn btn-primary m-1"><i class="fas fa-user-clock"></i> New Request</button>
        <button class="btn btn-secondary m-1"><i class="fas fa-user-plus"></i> Add Customer</button>
        <button class="btn btn-success m-1"><i class="fas fa-bolt"></i> Recharge Now</button>
        <button class="btn btn-danger m-1"><i class="fas fa-ticket-alt"></i> Add Ticket</button>
        <button class="btn btn-warning m-1"><i class="fas fa-envelope"></i> SMS Notification</button>
        <button class="btn btn-info m-1"><i class="fas fa-chart-line"></i> Reports</button>
        <button class="btn btn-dark m-1"><i class="fas fa-user-shield"></i> Admin Panel</button>
         <button class="btn btn-secondary m-1"><i class="fas fa-cogs"></i> Settings</button>
        <button class="btn btn-primary m-1"><i class="fas fa-user-cog"></i> User Management</button>
          <button id="resetOrderBtn" class="btn btn-danger m-1"><i class="fas fa-undo"></i> Reset Card</button>
    </div>
        </div>
      <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img src="{{ asset($data->photo ?? 'uploads/photos/avatar.png') }}"
                             alt="Profile Picture"
                             class="profile-user-img img-fluid img-circle border border-primary">
                    </div>

                    <h3 class="profile-username text-center mt-2">{{ $data->fullname ?? 'N/A' }}</h3>
                    <p class="text-muted text-center">
                        <i class="fas fa-user-tag"></i> User ID: {{ $data->id ?? 'N/A' }}
                    </p>

                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('admin.customer.edit', $data->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>

                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item">
                            <i class="fas fa-phone-alt text-primary"></i> <strong>Phone:</strong>
                            <span class="float-right">{{ $data->phone ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map-marker-alt text-success"></i> <strong>Address:</strong>
                            <span class="float-right">{{ $data->address ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-building text-warning"></i> <strong>POP Branch:</strong>
                            <span class="float-right">{{ $data->pop->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map text-info"></i> <strong>Area:</strong>
                            <span class="float-right">{{ $data->area->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-network-wired text-secondary"></i> <strong>Package:</strong>
                            <span class="float-right">{{ $data->package->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-dollar-sign text-danger"></i> <strong>Monthly Charge:</strong>
                            <span class="float-right">{{ number_format($data->amount, 2) }} ৳</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-hand-holding-usd text-success"></i> <strong>Connection Charge:</strong>
                            <span class="float-right">{{ number_format($data->con_charge, 2) }} ৳</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-exclamation-circle text-danger"></i> <strong>Status:</strong>
                            <span class="float-right badge badge-{{ $data->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($data->status ?? 'N/A') }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



        <div class="col-md-8">
            <div class="row">

            </div>


            <div class="row">
                @php
                    $dashboardCards = [
                        ['id' => 1, 'title' => 'Recharged', 'value' => 0, 'bg' => 'success', 'icon' => 'fa-arrow-up'],
                        ['id' => 2, 'title' => 'Total Paid', 'value' => 0, 'bg' => 'info', 'icon' => 'fa-credit-card'],
                        ['id' => 3, 'title' => 'Total Due', 'value' => '0', 'bg' => 'danger', 'icon' => 'fa-hand-holding-usd'],
                        ['id' => 4, 'title' => 'Due Paid', 'value' => 0, 'bg' => 'warning', 'icon' => 'fa-check-circle'],
                    ];
                @endphp
                @foreach($dashboardCards as $card)
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="small-box bg-{{ $card['bg'] }} shadow-lg rounded">
                            <div class="inner">
                                <h3>{{ $card['value'] }}</h3>
                                <p>{{ $card['title'] }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas {{ $card['icon'] }} fa-2x"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#tickets" data-toggle="tab">Tickets</a></li>
                <li class="nav-item"><a class="nav-link" href="#recharge" data-toggle="tab">Recharge</a></li>

              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <!-- Tickets -->
                <div class="active tab-pane" id="tickets">
                    <div class="table-responsive">
                        @include('Backend.Component.Tickets.Tickets')
                    </div>
                </div>
                <!-- Invoice -->
                <div class="tab-pane" id="recharge">
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
                            <tbody id=""> </tbody>
                        </table>
                    </div>
                </div>
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>

      </div>
    </div>
  </section>




<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <form action="{{route('admin.customer.delete')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fas fa-trash"></i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <input type="hidden" name="id" value="">
                <a class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="mdi mdi-close"></i></a>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#transaction_datatable").DataTable();
        $("#activities_datatable").DataTable();
        $("#invoice_datatable").DataTable();


        /** Handle Delete button click**/
        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            $('#deleteModal').modal('show');
            console.log("Delete ID: " + id);
            var value_input = $("input[name*='id']").val(id);
        });


        /** Handle form submission for delete **/
        $('#deleteModal form').submit(function(e){
            e.preventDefault();
            /*Get the submit button*/
            var submitBtn =  $('#deleteModal form').find('button[type="submit"]');

            /* Save the original button text*/
            var originalBtnText = submitBtn.html();

            /*Change button text to loading state*/
            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();
            /** Use Ajax to send the delete request **/
            $.ajax({
            type:'POST',
            'url':url,
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    toastr.success(response.message);
                    window.location.href = "{{ route('admin.customer.index') }}";
                }
            },

            error: function (xhr, status, error) {
                /** Handle  errors **/
                toastr.error(xhr.responseText);
            },
            complete: function () {
                submitBtn.html(originalBtnText);
                }
            });
        });

    });


</script>

@endsection
