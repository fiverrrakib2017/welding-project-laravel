<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('Backend/images/it-fast.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3"
            style="">

    </a>
    <!-- Sidebar -->
    <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item ">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link  {{ $route == 'admin.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                @php
                    $active_prefix = ['admin.student.index','admin.student.create','admin.student.course.list','admin.student.log.index'];
                @endphp
                <li class="nav-item has-treeview">
                    <a href="#"
                        class="nav-link  {{ Str::startsWith($currentRoute, $active_prefix) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Student<i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview"
                        style="{{ Str::startsWith($currentRoute, $active_prefix) ? 'display: block;' : 'display: none;' }}">

                        <!-- Payment Management -->
                        <li class="nav-item">
                            <a href="{{ route('admin.student.index') }}"
                                class="nav-link {{ $route == 'admin.student.index' ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Student List</p>
                            </a>
                        </li>
                        <!-- Student Create-->
                        <li class="nav-item">
                            <a href="{{ route('admin.student.create') }}"
                                class="nav-link {{ $route == 'admin.student.create' ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p> Student Create</p>
                            </a>
                        </li>
                        <!-- Student Course-->
                        <li class="nav-item">
                            <a href="{{ route('admin.student.course.list') }}"
                                class="nav-link {{ $route == 'admin.student.course.list' ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p> Student Course</p>
                            </a>
                        </li>
                           <!-- Student Logs-->
                        <li class="nav-item">
                            <a href="{{ route('admin.student.log.index') }}"
                                class="nav-link {{ $route == 'admin.student.log.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Student Logs</p>
                            </a>
                        </li>
                           <!-- Student Logs-->
                        <li class="nav-item">
                            <a href="{{ route('admin.student.recycle.index') }}"
                                class="nav-link {{ $route == 'admin.student.recycle.index' ? 'active' : '' }}">
                                <i class="fas fa-trash-alt nav-icon"></i>
                                <p>Recycle Bin</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <!-----------------User Management--------------------->
                @php
                    $active_prefix = [];
                @endphp
                <li class="nav-item has-treeview">
                    <a href="#"
                        class="nav-link {{ Str::startsWith($currentRoute, $active_prefix) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>User Management <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview"
                        style="{{ Str::startsWith($currentRoute, $active_prefix) ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Settings</p>
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
