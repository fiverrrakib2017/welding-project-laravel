
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('admin.dashboard')}}" class="brand-link">
        <img src="{{asset('Backend/images/it-fast.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="">

      </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('Backend/images/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('admin.dashboard')}}" class="d-block">{{Auth::guard('admin')->user()->name}}</a>
        </div>
      </div> --}}


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Dashboard -->
        <li class="nav-item ">
            <a href="{{ route('admin.dashboard') }}" class="nav-link  {{ $route == 'admin.dashboard' ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item ">
            <select class="form-control">
                <option value="1">--Select--</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </li>
           <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Customer <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Customer List</p></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add Customer</p></a></li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Package </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Billing & Payments</p>
                        </a>
                    </li>
                     <!-- Payment Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Payment History</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Customer Logs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Backup & Restore</p>
                        </a>
                    </li>
                     <!-- Contact Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Contact List</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add New Contact</p></a>
                    </li>

                    <!-- Sales & Opportunities -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Sales Opportunities</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Sales Pipeline</p></a>
                    </li>

                    <!-- Leads Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Leads List</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add New Lead</p></a>
                    </li>

                    <!-- Communication & Activities -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Activities</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Emails & Campaigns</p></a>
                    </li>

                    <!-- Customer Support -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Support Tickets</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Customer Feedback</p></a>
                    </li>

                    <!-- Reporting & Analytics -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Customer Reports</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Sales Reports</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                     <i class="nav-icon fas fa-map-marker-alt"></i>
                    <p>POP Area  <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>View POP </p></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add New POP </p></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>POP Area</p></a></li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-network-wired"></i>
                    <p>OLT Management <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <!-- OLT Device Configuration -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>OLT Device List</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Configure OLT Device</p></a>
                    </li>

                    <!-- ONT (Optical Network Terminal) Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>ONT Device List</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Assign ONT to Customer</p></a>
                    </li>

                    <!-- GPON Port Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>GPON Port Configuration</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Monitor GPON Ports</p></a>
                    </li>

                    <!-- Network Monitoring -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Network Status</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Network Traffic Monitoring</p></a>
                    </li>

                    <!-- Diagnostics and Logs -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>System Diagnostics</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>View System Logs</p></a>
                    </li>

                    <!-- Alarm Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Alarm Configuration</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>View Alarms</p></a>
                    </li>

                    <!-- OLT Reports -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>OLT Performance Reports</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Customer Service Reports</p></a>
                    </li>

                    <!-- OLT Settings -->
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>OLT Configuration Settings</p></a>
                    </li>
                </ul>
            </li>


          <li class="nav-item">
            <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'admin.tickets') ? 'active' : '' }}">
                <i class='nav-icon fas fa-ticket-alt'></i>
              <p>&nbsp; Tickets <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview"  style="{{ Str::startsWith($currentRoute, 'admin.tickets') ? 'display: block;' : 'display: none;' }}">

              <li class="nav-item">
                 <a href="{{ route('admin.tickets.index') }}" class="nav-link {{($route=='admin.tickets.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Ticket List</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.tickets.complain_type.index') }}" class="nav-link  {{($route=='admin.tickets.complain_type.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Complain Type</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.tickets.assign.index') }}" class="nav-link  {{($route=='admin.tickets.assign.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Ticket Assign</p></a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-envelope"></i>
                <p>SMS Management <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Send SMS</p></a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>SMS Logs</p></a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>SMS Configuration</p></a></li>
            </ul>
        </li>

        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>HR Management <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <!-- Employee Management -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Employee List</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add New Employee</p></a>
                </li>

                <!-- Payroll Management -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Payroll</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Bonus & Deductions</p></a>
                </li>

                <!-- Attendance Management -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Attendance Report</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Leave Requests</p></a>
                </li>

                <!-- Department & Designation -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Departments</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Designations</p></a>
                </li>

                <!-- Holiday & Leave Management -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Holiday Calendar</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Leave Management</p></a>
                </li>
            </ul>
        </li>

          <!-----------------Accounts--------------------->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calculator"></i>
                <p>Accounts Management <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <!-- Account List -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Account List</p></a>
                </li>

                <!-- Accounting Reports -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Journals</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Ledgers</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Trial Balance</p></a>
                </li>

                <!-- Financial Statements -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Income Statement</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Balance Sheet</p></a>
                </li>

                <!-- Account Transactions -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Account Transactions</p></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Deposit History</p></a>
                </li>

                <!-- Account Balances -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Account Balances</p></a>
                </li>
                <!-- Cash Flow Statement -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Cash Flow Statement</p></a>
                </li>

                <!-- Bank Reconciliation Statement: -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Bank Reconciliation:</p></a>
                </li>

                <!-- Account Settings -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Account Settings</p></a>
                </li>
            </ul>
        </li>
        <!-----------------Task Management--------------------->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>Task Management <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Tasks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Create Task</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Task Types</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Task Report</p>
                    </a>
                </li>
            </ul>
        </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
