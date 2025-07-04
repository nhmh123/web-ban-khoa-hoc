<div id="sidebar" class="bg-dark">
    <ul id="sidebar-menu">
        <li class="nav-link">
            <a href="{{ route('admin.dashboard') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="bi bi-speedometer"></i>
                </div>
                Dashboard
            </a>
            <i class="arrow fas fa-angle-right"></i>
        </li>
        <li class="nav-link {{ request()->routeIs('ccategories.*') ? 'active' : '' }}">
            <a href="{{ route('ccategories.index') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="bi bi-tags"></i>
                </div>
                Danh mục khóa học
            </a>
            <i class="arrow fas {{ request()->routeIs('ccategories.*') ? 'fa-angle-down' : 'fa-angle-right' }} "></i>

            <ul class="sub-menu">
                <li><a href="{{ route('ccategories.create') }}">Thêm mới</a></li>
                <li><a href="{{ route('ccategories.index') }}">Danh sách</a></li>
            </ul>
        </li>
        <li class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
            <a href="{{ route('courses.index') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="bi bi-book"></i>
                </div>
                Khóa học
            </a>
            <i class="arrow fas {{ request()->routeIs('courses.*') ? 'fa-angle-down' : 'fa-angle-right' }} "></i>

            <ul class="sub-menu">
                <li><a href="{{ route('courses.create') }}">Thêm mới</a></li>
                <li><a href="{{ route('courses.index') }}">Danh sách</a></li>
            </ul>
        </li>
        <li class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="bi bi-people"></i>
                </div>
                Users
            </a>
            <i class="arrow fas {{ request()->routeIs('users.*') ? 'fa-angle-down' : 'fa-angle-right' }} "></i>

            <ul class="sub-menu">
                <li><a href="{{ route('users.create') }}">Thêm mới</a></li>
                <li><a href="{{ route('users.index') }}">Danh sách</a></li>
            </ul>
        </li>
        <li class="nav-link">
            <a href="?view=permission">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Phân quyền
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                <li><a href="?view=permission">Quyền</a></li>
                <li><a href="?view=add-role">Thêm vai trò</a></li>
                <li><a href="?view=list-role">Danh sách vai trò</a></li>
            </ul>
        </li>
    </ul>
</div>
