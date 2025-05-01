<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('Backend/images/it-fast.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3"
            style="">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ $route == 'admin.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Student List -->
                <li class="nav-item">
                    <a href="{{ route('admin.student.index') }}"
                        class="nav-link {{ $route == 'admin.student.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Student List</p>
                    </a>
                </li>

                <!-- Student Create -->
                <li class="nav-item">
                    <a href="{{ route('admin.student.create') }}"
                        class="nav-link {{ $route == 'admin.student.create' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>Student Create</p>
                    </a>
                </li>

                <!-- Student Course -->
                <li class="nav-item">
                    <a href="{{ route('admin.student.course.list') }}"
                        class="nav-link {{ $route == 'admin.student.course.list' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Student Course</p>
                    </a>
                </li>

                <!-- Student Logs -->
                <li class="nav-item">
                    <a href="{{ route('admin.student.log.index') }}"
                        class="nav-link {{ $route == 'admin.student.log.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Student Logs</p>
                    </a>
                </li>

                <!-- Recycle Bin -->
                <li class="nav-item">
                    <a href="{{ route('admin.student.recycle.index') }}"
                        class="nav-link {{ $route == 'admin.student.recycle.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-trash"></i>
                        <p>Recycle Bin</p>
                    </a>
                </li>

                <!-- User Management -->
                <li class="nav-item">
                    <a href="{{ route('admin.user.management.index') }}"
                        class="nav-link {{ $route == 'admin.user.management.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>User Management</p>
                    </a>
                </li>
                <!-- Signature -->
                <li class="nav-item">
                    <a href="{{ route('admin.signature.index') }}"
                        class="nav-link {{ $route == 'admin.signature.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-pen-nib"></i>
                        <p>Signature Management</p>
                    </a>
                </li>


            </ul>
        </nav>
    </div>
</aside>
