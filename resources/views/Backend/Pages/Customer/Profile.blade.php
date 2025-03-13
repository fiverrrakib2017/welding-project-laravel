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
        <button class="btn btn-success m-1"  data-toggle="modal" data-target="#CustomerRechargeModal"><i class="fas fa-bolt"></i> Recharge Now</button>
        <button class="btn btn-dark m-1" data-toggle="modal" data-target="#ticketModal"><i class="fas fa-ticket-alt"></i> Add Ticket</button>
        <button class="btn btn-warning m-1"><i class="fas fa-undo-alt"></i> Ree-Connect</button>

        <!--------Customer Disable And Enable Button--------->
        @if($data->status=='disabled')
            <button type="button" class="btn btn-{{ $data && $data->status == 'disabled' ? 'danger' : 'success' }} m-1 change-status" data-id="{{ $data->id }}">
                <i class="fas fa-user-lock"></i>
                {{ $data && $data->status == 'disabled' ? 'Disable' : 'Enable' }} This User
            </button>
        @endif


        <button type="button" class="btn btn-sm btn-primary m-1 customer_edit_btn" data-id="{{ $data->id }}"><i class="fas fa-edit"></i> Edit Profile</button>
    </div>
        </div>
      <div class="row">
        <div class="col-md-4">
            <div class="card card-danger card-outline shadow-sm">
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
                    @php
                    $expireDate = $data->expire_date;
                    $today_date = date('Y-m-d');

                    $isExpired = $expireDate && (strtotime($today_date) > strtotime($expireDate));

                    $formattedDate = $expireDate ? date('d M Y', strtotime($expireDate)) : 'N/A';
                @endphp

                <p class="text-muted text-center">
                    <i class="fas fa-calendar-alt"></i>
                    <strong>Expire Date:</strong>
                    <span class="{{ $isExpired ? 'text-danger' : 'text-success' }}">
                        {{ $isExpired ? 'Expired' : $formattedDate }}
                    </span>
                </p>




                    <p class="text-muted text-center">
                        @php
                            $icon = '';
                            $statusText = $data->status ?? 'N/A';
                            $badgeColor = 'secondary';

                            switch($data->status) {
                                case 'online':
                                    $icon = 'fas fa-check-circle text-success';
                                    $badgeColor = 'success';
                                    break;
                                case 'offline':
                                    $icon = 'fas fa-times-circle text-danger';
                                    $badgeColor = 'danger';
                                    break;
                                case 'active':
                                    $icon = 'fas fa-user-circle text-primary';
                                    $badgeColor = 'primary';
                                    break;
                                case 'blocked':
                                    $icon = 'fas fa-ban text-warning';
                                    $badgeColor = 'warning';
                                    break;
                                case 'expired':
                                    $icon = 'fas fa-clock text-secondary';
                                    $badgeColor = 'secondary';
                                    break;
                                case 'disabled':
                                    $icon = 'fas fa-slash text-dark';
                                    $badgeColor = 'dark';
                                    break;
                                default:
                                    $icon = 'fas fa-question-circle text-muted';
                                    $badgeColor = 'secondary';
                                    break;
                            }
                        @endphp
                        <i class="{{ $icon }}"></i> <span class="badge badge-{{ $badgeColor }}">{{ ucfirst($statusText) }}</span>
                    </p>
                    <hr>
                    <!-- Additional Information -->
                    <div class="mt-3">
                        <div class="row text-center">
                            <div class="col-6">
                                <p><i class="fas fa-clock text-warning"></i> <strong>Up Time:</strong> <span class="text-danger">00:04:13 Hrs</span></p>
                            </div>
                            <div class="col-6">
                                <p><i class="fas fa-chart-line text-success"></i> <strong>Monthly Usage:</strong> <span class="text-primary">7.802 MB</span></p>
                            </div>
                        </div>

                        <div class="row text-center mt-2">
                            <div class="col-6">
                                <p><i class="fas fa-arrow-up text-success"></i> <strong>Upload Speed:</strong> <span class="text-primary">7.802 Mbps</span></p>
                            </div>
                            <div class="col-6">
                                <p><i class="fas fa-arrow-down text-danger"></i> <strong>Download Speed:</strong> <span>{{ $data->download_speed ?? 'N/A' }} Mbps</span></p>
                            </div>
                        </div>

                        <div class="row text-center mt-2">
                            <div class="col-6">
                                <p><i class="fas fa-plug text-info"></i> <strong>Interface:</strong> <span>{{ $data->interface ?? 'N/A' }}</span></p>
                            </div>
                            <div class="col-6">
                                <p><i class="fas fa-address-card text-warning"></i> <strong>MAC Address:</strong> <span>{{ $data->mac_address ?? 'N/A' }}</span></p>
                            </div>
                        </div>

                        <div class="row text-center mt-2">
                            <div class="col-6">
                                <p><i class="fas fa-laptop-code text-secondary"></i> <strong>Remote IP:</strong> <span>{{ $data->remote_ip ?? 'N/A' }}</span></p>
                            </div>
                            <div class="col-6">
                                <p><i class="fas fa-route text-success"></i> <strong>Router Used:</strong> <span>{{ $data->router_used ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item">
                            <i class="fas fa-user-alt text-primary"></i> <strong>Username:</strong>
                            <span class="float-right">{{ $data->username ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-phone-alt text-success"></i> <strong>Phone:</strong>
                            <span class="float-right">{{ $data->phone ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map-marker-alt text-info"></i> <strong>Address:</strong>
                            <span class="float-right">{{ $data->address ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-building text-warning"></i> <strong>POP Branch:</strong>
                            <span class="float-right">{{ $data->pop->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map text-danger"></i> <strong>Area:</strong>
                            <span class="float-right">{{ $data->area->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-network-wired text-secondary"></i> <strong>Package:</strong>
                            <span class="float-right">{{ $data->package->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-dollar-sign text-primary"></i> <strong>Monthly Charge:</strong>
                            <span class="float-right">{{ number_format($data->amount, 2) }} ৳</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-hand-holding-usd text-success"></i> <strong>Connection Charge:</strong>
                            <span class="float-right">{{ number_format($data->con_charge, 2) }} ৳</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>









        <div class="col-md-8">


            <div class="row">
                @php
                    $dashboardCards = [
                        ['id' => 1, 'title' => 'Recharged', 'value' => $total_recharged, 'bg' => 'success', 'icon' => 'fa-arrow-up'],
                        ['id' => 2, 'title' => 'Total Paid', 'value' => $totalPaid, 'bg' => 'info', 'icon' => 'fa-credit-card'],
                        ['id' => 3, 'title' => 'Total Due', 'value' => $totalDue, 'bg' => 'danger', 'icon' => 'fa-hand-holding-usd'],
                        ['id' => 4, 'title' => 'Due Paid', 'value' => $duePaid, 'bg' => 'warning', 'icon' => 'fa-check-circle'],
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
                <li class="nav-item"><a class="nav-link" href="#recharge" data-toggle="tab">Recharge History</a></li>

              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <!-- Tickets -->
                <div class="active tab-pane" id="tickets">
                    <div class="table-responsive">
                        @include('Backend.Component.Tickets.Tickets',['customer_id' => $data->id])
                    </div>
                </div>
                <!-- Invoice -->
                <div class="tab-pane" id="recharge">
                    <div class="table-responsive">
                        <table id="recharge_datatable"
                            class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Months</th>
                                    <th>Type</th>
                                    <th>Remarks</th>
                                    <th>Paid until</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_recharge_data=App\Models\Customer_recharge::where('customer_id',$data->id)->get();
                                @endphp
                                 @foreach ($total_recharge_data as $item)
                                 <tr>
                                     <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                     <td>{{ $item->recharge_month }}</td>
                                     <td>
                                        @if ($item->transaction_type == 'cash')
                                            <span class="badge bg-success">{{ ucfirst($item->transaction_type) }}</span>
                                        @elseif($item->transaction_type == 'credit')
                                        <span class="badge bg-danger">{{ ucfirst($item->transaction_type) }}</span>
                                        @elseif($item->transaction_type == 'due_paid')
                                        <span class="badge bg-success">{{ ucfirst($item->transaction_type) }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($item->transaction_type) }}</span>
                                        @endif
                                    </td>

                                     <td>{{ ucfirst($item->note) }}</td>
                                     <td>{{ ucfirst($item->paid_until) }}</td>

                                     <td>{{ number_format($item->amount, 2) }} BDT</td>
                                     <td>
                                         <button class="btn btn-danger btn-sm customer_recharge_undo_btn" data-id="{{ $item->id }}"><i class="fas fa-undo"></i></button>
                                     </td>
                                 </tr>
                                 @endforeach
                            </tbody>
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
  @include('Backend.Modal.Customer.Recharge.Recharge_modal')
  @include('Backend.Modal.Tickets.ticket_modal',['customer_id' => $data->id, 'pop_id'=>$data->pop_id,'area_id'=>$data->area_id])
  @include('Backend.Modal.Customer.customer_modal')
  @include('Backend.Modal.delete_modal')
@endsection

@section('script')
<script src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#recharge_datatable").DataTable();
        /************** Customer Enable And Disabled Start**************************/
        $(document).on("click", ".change-status", function () {
            let id = $(this).data("id");
            let btn = $(this);
            let originalHtml = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...').prop("disabled", true);
            $.ajax({
                url: "{{ route('admin.pop.change_status', '') }}/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        let newStatus = response.new_status;
                        btn.toggleClass("btn-danger btn-success");
                        btn.html(
                            `<i class="fas fa-user-lock"></i> ` +
                            (newStatus == 1 ? "Disable" : "Enable") + " POP/Branch"
                        );
                    }
                },
                error: function () {
                    toastr.error("Something went wrong!");
                },
                complete: function () {
                    btn.prop("disabled", false);
                }
            });
        });
        /************** Customer Enable And Disabled End**************************/

        /** Handle Customer Undo Recharge button click **/
        $(document).on('click', '.customer_recharge_undo_btn', function() {
            if(confirm('Are you sure you want to undo this action?')){
                var id = $(this).data('id');
                var button = $(this);
                var row = button.closest('tr');
                var originalContent = button.html();
                button.html('<i class="fas fa-spinner fa-spin"></i> Undoing...').prop('disabled', true);
                $.ajax({
                    url: "{{ route('admin.customer.recharge.undo', ':id') }}".replace(':id', id),
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            row.fadeOut(300, function() {
                                $(this).remove();
                                toastr.success('Successfully Undo!');
                            });

                        }
                    },
                    error: function() {
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            }
        });
    });


</script>

@endsection
