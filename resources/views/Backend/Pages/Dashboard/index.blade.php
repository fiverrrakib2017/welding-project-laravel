
@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')

@section('content')
<div class="row mb-3">
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
    </div>
</div>



  <div class="row" id="dashboardCards">
     @php
        $dashboardCards = [
            ['title' => 'Online', 'value' => 0, 'bg' => 'success', 'icon' => 'fa-user-check'],
            ['title' => 'Offline', 'value' => 0, 'bg' => 'info', 'icon' => 'fa-user-times'],
            ['title' => 'Active Customers', 'value' => 0, 'bg' => 'primary', 'icon' => 'fa-users'],
            ['title' => 'Expired', 'value' => 0, 'bg' => 'danger', 'icon' => 'fa-user-clock'],
            ['title' => 'Disabled', 'value' => 0, 'bg' => 'warning', 'icon' => 'fa-user-lock'],
            ['title' => 'Requests', 'value' => 0, 'bg' => 'dark', 'icon' => 'fa-user-edit'],
            ['title' => 'Total Revenue', 'value' => '$0', 'bg' => 'success', 'icon' => 'fa-dollar-sign'],
            ['title' => 'Pending Payments', 'value' => '$0', 'bg' => 'danger', 'icon' => 'fa-exclamation-circle'],
            ['title' => 'Total Bandwidth Used', 'value' => '0GB', 'bg' => 'info', 'icon' => 'fa-network-wired'],
            ['title' => 'Active Connections', 'value' => 0, 'bg' => 'primary', 'icon' => 'fa-plug'],
            ['title' => 'New Connection Requests', 'value' => 0, 'bg' => 'warning', 'icon' => 'fa-user-plus'],
            ['title' => 'Due Amounts', 'value' => '$0', 'bg' => 'danger', 'icon' => 'fa-hand-holding-usd'],
            ['title' => 'Resolved Tickets', 'value' => 0, 'bg' => 'success', 'icon' => 'fa-check-circle'],
            ['title' => 'New Registrations', 'value' => 0, 'bg' => 'primary', 'icon' => 'fa-user-plus'],
             ['title' => 'Complaints', 'value' => 0, 'bg' => 'danger', 'icon' => 'fa-exclamation-triangle'],
            ['title' => 'Support Requests', 'value' => 0, 'bg' => 'info', 'icon' => 'fa-headset']

        ];
    @endphp

     @foreach($dashboardCards as $card)
    <div class="col-lg-3 col-6 card-item" >
        <div class="small-box bg-{{ $card['bg'] }}">
            <div class="inner">
                <h3>{{ $card['value'] }}</h3>
                <p>{{ $card['title'] }}</p>
            </div>
            <div class="icon">
                <i class="fas {{ $card['icon'] }} fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>


  <div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">Recent Transactions</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>$50</td>
                            <td><span class="badge bg-success">Paid</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-white">Recent Tickets</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Issue</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Jane Smith</td>
                            <td>No Internet</td>
                            <td><span class="badge bg-danger">Open</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">Yearly Revenue Chart</div>
            <div class="card-body">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
             <div class="card-header bg-primary text-white">Active vs Inactive Customers</div>
              <div class="card-body">
                <canvas id="customerChart"></canvas>
              </div>
        </div>
    </div>
</div>


<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">Bandwidth Usage Chart</div>
            <div class="card-body">
                <canvas id="bandwidthChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">Payment Status Chart</div>
            <div class="card-body">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(document).ready(function(){
        console.log("Dashboard Loaded Successfully");
    });
    
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','July','Augest','September','Octobar','November','December'],
            datasets: [{
                label: 'Revenue',
                data: [1200, 1900, 3000, 5000, 2000, 3000,1200, 1900, 3000, 5000, 2000, 3000],
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: {
            responsive: true
        }
    });


    var ctx2 = document.getElementById('customerChart').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [80, 20],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: { responsive: true }
    });

    var ctx3 = document.getElementById('bandwidthChart').getContext('2d');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Bandwidth Usage (GB)',
                data: [100, 150, 200, 250, 300, 350],
                backgroundColor: 'rgba(255, 159, 64, 0.6)'
            }]
        },
        options: { responsive: true }
    });

    var ctx4 = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Pending', 'Overdue'],
            datasets: [{
                data: [70, 20, 10],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: { responsive: true }
    });


     // function saveOrder() {
     //        let order = [];
     //        $(".card-item").each(function() {
     //            order.push($(this).data("id"));
     //        });
     //        localStorage.setItem("dashboardOrder", JSON.stringify(order));
     //    }

     //    function loadOrder() {
     //        let savedOrder = localStorage.getItem("dashboardOrder");
     //        if (savedOrder) {
     //            let order = JSON.parse(savedOrder);
     //            let container = $("#dashboardCards");
     //            let elements = {};

     //            $(".card-item").each(function() {
     //                let id = $(this).data("id");
     //                elements[id] = $(this);
     //            });
                
     //            container.empty();
     //            order.forEach(id => {
     //                if (elements[id]) {
     //                    container.append(elements[id]);
     //                }
     //            });
     //        }
     //    }

     //    $("#dashboardCards").sortable({
     //        update: function(event, ui) {
     //            saveOrder();
     //        }
     //    });

     //    loadOrder();
</script>
@endsection
