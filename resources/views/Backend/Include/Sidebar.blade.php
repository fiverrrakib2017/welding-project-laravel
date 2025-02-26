
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
            <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'admin.student') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p> Students <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview"  style="{{ Str::startsWith($currentRoute, 'admin.student') ? 'display: block;' : 'display: none;' }}">
              <li class="nav-item">
                <a href="{{ route('admin.student.index') }}" class="nav-link  {{ $route == 'admin.student.index' ||$route == 'admin.student.create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student</p>
                </a>
              </li>

              <li class="nav-item">
                 <a href="{{ route('admin.student.class.index') }}" class="nav-link {{ $route == 'admin.student.class.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Class</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.subject.index') }}" class="nav-link {{ $route == 'admin.student.subject.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Subject</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.class.routine.index') }}" class="nav-link {{ $route == 'admin.student.class.routine.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Class Routine</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.section.index') }}" class="nav-link {{($route=='admin.student.section.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Section</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.exam.index') }}" class="nav-link {{($route=='admin.student.exam.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Examination</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.exam.routine.index') }}" class="nav-link {{($route=='admin.student.exam.routine.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Exam Routine</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.exam.result.create') }}" class="nav-link  {{($route=='admin.student.exam.result.create') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Create Exam Result</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.exam.result.report') }}" class="nav-link {{($route=='admin.student.exam.result.report') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Exam Result Report</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.shift.index') }}" class="nav-link {{($route=='admin.student.shift.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Shift</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.leave.index') }}" class="nav-link {{($route=='admin.student.leave.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Leave</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.attendence.index') }}" class="nav-link  {{($route=='admin.student.attendence.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Attendance</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.attendence.log') }}" class="nav-link {{($route=='admin.student.attendence.log') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Attendance Report</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.fees_type.index') }}" class="nav-link  {{($route=='admin.student.fees_type.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Fees Type</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.student.bill_collection.index') }}" class="nav-link  {{($route=='admin.student.bill_collection.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Bill Collection</p></a>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link {{ Str::startsWith($currentRoute, 'admin.teacher') ? 'active' : '' }}">
                <i class='nav-icon fas fa-chalkboard-teacher'></i>
              <p>&nbsp; Teachers <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview"  style="{{ Str::startsWith($currentRoute, 'admin.teacher') ? 'display: block;' : 'display: none;' }}">

              <li class="nav-item">
                 <a href="{{ route('admin.teacher.index') }}" class="nav-link {{($route=='admin.teacher.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Teacher</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.teacher.transaction.index') }}" class="nav-link {{($route=='admin.teacher.transaction.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Transaction</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.teacher.transaction.report') }}" class="nav-link  {{($route=='admin.teacher.transaction.report') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Report</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.teacher.leave.index') }}" class="nav-link {{($route=='admin.teacher.leave.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Leave</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.teacher.attendence.index') }}" class="nav-link {{($route=='admin.teacher.attendence.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Attendance</p></a>
              </li>

              <li class="nav-item">
                 <a href="{{ route('admin.teacher.attendence.log') }}" class="nav-link {{($route=='admin.teacher.attendence.log') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Attendance Report</p></a>
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

          @php
              $active_prefix=['admin.customer','admin.supplier','admin.product','admin.brand','admin.category','admin.unit','admin.store'];
          @endphp
          <li class="nav-item">
            <a href="#" class="nav-link {{ Str::startsWith($currentRoute, $active_prefix) ? 'active' : '' }}">
                <i class="nav-icon fas fa-warehouse"></i>
              <p>&nbsp; Inventory <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview" style="{{ Str::startsWith($currentRoute, $active_prefix) ? 'display: block;' : 'display: none;' }}">

              <li class="nav-item">
                 <a href="{{ route('admin.customer.invoice.create_invoice') }}" class="nav-link  {{($route=='admin.customer.invoice.create_invoice') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Sale</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.customer.invoice.show_invoice') }}" class="nav-link {{($route=='admin.customer.invoice.show_invoice') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Sale Invoice</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.supplier.invoice.create_invoice') }}" class="nav-link {{($route=='admin.supplier.invoice.create_invoice') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Purchase</p></a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.supplier.invoice.show_invoice') }}" class="nav-link {{($route=='admin.supplier.invoice.show_invoice') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Purchase Invoice</p></a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.brand.index') }}" class="nav-link {{($route=='admin.brand.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Brand</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.category.index') }}" class="nav-link {{($route=='admin.category.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Category</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.unit.index') }}" class="nav-link {{($route=='admin.unit.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Units</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.store.index') }}" class="nav-link {{($route=='admin.store.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Store</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.product.index') }}" class="nav-link  {{($route=='admin.product.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Products</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.supplier.index') }}" class="nav-link {{($route=='admin.supplier.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Supplier</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.customer.index') }}" class="nav-link {{($route=='admin.customer.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Customer</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.customer.tickets.index') }}" class="nav-link {{($route=='admin.customer.tickets.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Customer Ticket</p></a>
              </li>
            </ul>
          </li>

          @php
              $active_prefix=['admin.master_ledger','admin.ledger','admin.sub_ledger','admin.transaction'];
          @endphp

          <li class="nav-item">
            <a href="#" class="nav-link  {{ Str::startsWith($currentRoute, $active_prefix) ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>&nbsp; Accounts <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview"  style="{{ Str::startsWith($currentRoute, $active_prefix) ? 'display: block;' : 'display: none;' }}">

              <li class="nav-item">
                 <a href="{{ route('admin.master_ledger.index') }}" class="nav-link {{($route=='admin.master_ledger.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Master Ledger</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.ledger.index') }}" class="nav-link  {{($route=='admin.ledger.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Ledger</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.sub_ledger.index') }}" class="nav-link {{($route=='admin.sub_ledger.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Sub Ledger</p></a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.transaction.index') }}" class="nav-link  {{($route=='admin.transaction.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Transaction</p></a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.transaction.report.index') }}" class="nav-link  {{($route=='admin.transaction.report.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Report</p></a>
              </li>

            </ul>
          </li>

          <!-----------------Website Settings--------------------->
            @php
                $active_prefix=['admin.settings.website.banner','admin.settings.website.slider','admin.settings.website.speech','admin.settings.website.gallery'];
            @endphp
          <li class="nav-item">
            <a href="#" class="nav-link  {{ Str::startsWith($currentRoute, $active_prefix) ? 'active' : '' }}">
                <i class="fa fa-cog mr-2 "></i>
              <p>&nbsp; Website Settings <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview"  style="{{ Str::startsWith($currentRoute, $active_prefix) ? 'display: block;' : 'display: none;' }}">

              <li class="nav-item">
                 <a href="{{ route('admin.settings.website.banner.index') }}" class="nav-link {{($route=='admin.settings.website.banner.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Banner</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.settings.website.slider.index') }}" class="nav-link {{($route=='admin.settings.website.slider.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Slider</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.settings.website.speech.index') }}" class="nav-link {{($route=='admin.settings.website.speech.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Speech</p></a>
              </li>
              <li class="nav-item">
                 <a href="{{ route('admin.settings.website.gallery.index') }}" class="nav-link {{($route=='admin.settings.website.gallery.index') ?  'active':''}}"><i class="far fa-circle nav-icon"></i><p>Gallery</p></a>
              </li>

            </ul>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
