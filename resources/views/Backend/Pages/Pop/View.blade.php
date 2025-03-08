@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection
@section('content')
<div class="row mb-3">
     <!-- Buttons -->
   <div class="col-md-12 d-flex flex-wrap gap-2">
       <button class="btn btn-success m-1"><i class="fas fa-user-plus"></i> Add Customer</button>

       <button class="btn btn-secondary m-1" data-toggle="modal" data-target="#addBranchPackageModal">
            <i class="fas fa-box"></i> Add Package
        </button>

       <button class="btn btn-dark m-1"  data-toggle="modal" data-target="#PopRechargeModal" ><i class="fas fa-hand-holding-usd"></i> Pop Recharge & Received</button>
       <button class="btn btn-primary m-1 edit-pop" data-id="{{ $pop->id }}"><i class="fas fa-edit"></i> Edit POP/Branch</button>

       <button class="btn btn-danger m-1 " data-id="{{ $pop->id }}"><i class="fas fa-solid fa-user-lock"></i> Disable POP/Branch</button>

       <button class="btn btn-success m-1 " data-id="{{ $pop->id }}"><i class="fas fa-solid fa-user-lock"></i> Enable POP/Branch</button>

         <button id="resetOrderBtn" class="btn btn-warning m-1"><i class="fas fa-undo"></i> Reset Card</button>
   </div>
</div>


<div class="row" id="dashboardCards">
    @php
    $dashboardCards = [
        ['id' => 1,'title' => 'Online', 'value' => 0, 'bg' => 'success', 'icon' => 'fas fa-solid fa-user-check'],
        ['id' => 2,'title' => 'Offline', 'value' => 0, 'bg' => 'info', 'icon' => 'fas fa-solid fa-user-times'],
        ['id' => 3,'title' => 'Active Customers', 'value' => 0, 'bg' => 'primary', 'icon' => 'fas fa-solid fa-users'],
        ['id' => 4,'title' => 'Expired', 'value' => 0, 'bg' => 'danger', 'icon' => 'fas fa-solid fa-user-clock'],
        ['id' => 5,'title' => 'Disabled', 'value' => 0, 'bg' => 'warning', 'icon' => 'fas fa-solid fa-user-lock'],
        ['id' => 6,'title' => 'Current Balance', 'value' => 0, 'bg' => 'success', 'icon' => 'fas fa-solid fa-dollar-sign'],
        ['id' => 7,'title' => 'Total Paid', 'value' => 0, 'bg' => 'success', 'icon' => 'fas fa-solid fa-hand-holding-dollar'],
        ['id' => 8,'title' => 'Total Due', 'value' => '$0', 'bg' => 'danger', 'icon' => 'fas fa-solid fa-dollar-sign'],
        ['id' => 9,'title' => 'Due Paid', 'value' => 0, 'bg' => 'success', 'icon' => 'fas fa-hand-holding-usd'],
        ['id' => 10,'title' => 'Area', 'value' => 0, 'bg' => 'success', 'icon' => 'fas fa-solid fa-map-marker-alt'],
        ['id' => 11,'title' => 'Total Tickets', 'value' => 0, 'bg' => 'success', 'icon' => 'fas fa-solid fa-ticket-alt'],
        ['id' => 12,'title' => 'Resolved Tickets', 'value' => 0, 'bg' => 'success', 'icon' => 'fas fa-solid fa-check-circle'],
        ['id' => 13,'title' => 'Pending Tickets', 'value' => 0, 'bg' => 'danger', 'icon' => 'fas fa-solid fa-exclamation-triangle'],
    ];
 @endphp

 @foreach($dashboardCards as $card)
    <div class="col-lg-3 col-6 card-item wow animate__animated animate__fadeInUp" data-id="{{ $card['id'] }}" data-wow-delay="0.{{ $card['id'] }}s">
        <div class="small-box bg-{{ $card['bg'] }}">
            <div class="inner">
                <h3>{{ $card['value'] }}</h3>
                <p>{{ $card['title'] }}</p>
            </div>
            <div class="icon">
                <i class="{{ $card['icon'] }} fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
 @endforeach

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Users ( 3369 )</a></li>
              <li class="nav-item"><a class="nav-link" href="#invoice" data-toggle="tab">Tickets</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Recharge History</a></li>
              <li class="nav-item"><a class="nav-link" href="#documents" data-toggle="tab">Package</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Transaction Statment</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- Activity -->
              <div class="active tab-pane" id="activity">
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
              <!-- Invoice -->
              <div class="tab-pane" id="invoice">
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
                <!-- Timeline -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <div class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <div class="time-label">
                    <span class="bg-danger">
                      10 Feb. 2014
                    </span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-envelope bg-primary"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a href="#" class="btn btn-primary btn-sm">Read more</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-user bg-info"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                      <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-comments bg-warning"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <div class="time-label">
                    <span class="bg-success">
                      3 Jan. 2014
                    </span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <div>
                    <i class="far fa-clock bg-gray"></i>
                  </div>
                </div>
              </div>
              <!-- Documents -->
              <div class="tab-pane" id="documents">
                  <div class="row">
                      @if(!empty($student_docs))
                          @foreach ($student_docs as $item)
                          <!-- File 1 -->
                          <div class="col-sm-3">
                              <div class="position-relative file-container">
                                  <img src="https://winaero.com/blog/wp-content/uploads/2018/12/file-explorer-folder-libraries-icon-18298.png" alt="{{ $item->file_name }}" class="img-fluid">

                                  <a href="{{ asset('/uploads/documents/' . $item->docs_name) }}" download class="download-btn btn btn-primary">
                                      <i class="fas fa-download"></i> Download
                                  </a>
                              </div>
                          </div>
                          @endforeach
                      @else
                          <h4 class="text-center text-danger">Documents Not Found</h4>
                      @endif
                  </div>
              </div>
              <!--Settings -->
              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName2" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
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
            <div class="card-header bg-info text-white">Recent Transactions</div>
            <div class="card-body">
                <table  id="recent_transaction" class="table table-striped">
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
                <table id="recent_tickets" class="table table-striped">
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
@include('Backend.Modal.Pop.pop_modal')
@include('Backend.Modal.Customer.Package.branch_package_modal')
@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
    handleSubmit('#popForm','#addModal');
        $("#recent_transaction").DataTable();
        $("#recent_tickets").DataTable();
    });

    /** Handle Edit button click **/
    $(document).on('click', '.edit-pop', function () {
        var id = $(this).data('id');

        // AJAX call to fetch supplier data
        $.ajax({
            url: "{{ route('admin.pop.edit', ':id') }}".replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#popForm').attr('action', "{{ route('admin.pop.update', ':id') }}".replace(':id', id));
                    $('#ModalLabel').html('<span class="mdi mdi-account-edit mdi-18px"></span> &nbsp;Edit POP/Branch');
                    $('#popForm input[name="name"]').val(response.data.name);
                    $('#popForm input[name="username"]').val(response.data.username);
                    $('#popForm input[name="password"]').val(response.data.password);
                    $('#popForm input[name="phone"]').val(response.data.phone);
                    $('#popForm input[name="email"]').val(response.data.email);
                    $('#popForm input[name="address"]').val(response.data.address);
                    $('#popForm select[name="status"]').val(response.data.status);

                    // Show the modal
                    $('#addModal').modal('show');
                } else {
                    toastr.error('Failed to fetch Supplier data.');
                }
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    /** Handle Delete button click**/
    $('#datatable1 tbody').on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        var deleteUrl = "{{ route('admin.pop.delete', ':id') }}".replace(':id', id);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').find('input[name="id"]').val(id);
        $('#deleteModal').modal('show');
    });

/************************** Card Move Another Place*****************************************/
function saveOrder() {
            let order = [];
            $(".card-item").each(function() {
                order.push($(this).data("id"));
            });
            localStorage.setItem("dashboardOrder", JSON.stringify(order));
        }

        function loadOrder() {
            let savedOrder = localStorage.getItem("dashboardOrder");
            if (savedOrder) {
                let order = JSON.parse(savedOrder);
                let container = $("#dashboardCards");
                let elements = {};

                $(".card-item").each(function() {
                    let id = $(this).data("id");
                    elements[id] = $(this);
                });

                container.empty();

                order.forEach(id => {
                    if (elements[id]) {
                        container.append(elements[id]);
                        delete elements[id];
                    }
                });
                Object.values(elements).forEach(el => container.append(el));
            }
        }


        $("#dashboardCards").sortable({
            update: function(event, ui) {
                saveOrder();
            }
        });

        loadOrder();

         function resetOrder() {
            localStorage.removeItem("dashboardOrder");
            location.reload();
        }
        $("#resetOrderBtn").click(function(){
            resetOrder();
        });
    /************************** Card Move Another Place*****************************************/
    /************************** Yearly Revenue Chart*****************************************/
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
    /************************** Yearly Revenue Chart*****************************************/
    /************************** Customer  Chart*****************************************/
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
    /************************** Customer  Chart*****************************************/
  </script>
@endsection
