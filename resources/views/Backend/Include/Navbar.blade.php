<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
     

        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
                <img src="{{asset('Backend/images/avatar.png')}}" alt="User Image" class="user-img border" style="width: 40px; height: 40px; object-fit: cover; border-radius:50%; margin-right: 10px;">
                <span>
                    <b>{{ Auth::guard('admin')->user()->name }}</b>
                </span>
                <i class="fa fa-angle-down ml-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right border-0 shadow" aria-labelledby="account_settings">
                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" id="manage_account">
                    <i class="fa fa-cog mr-2 text-muted"></i> Manage Account
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('admin.logout') }}">
                    <i class="fa fa-power-off mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
  </nav>

