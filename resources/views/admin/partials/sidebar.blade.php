<div id="sidebar" class="bg-dark">
    <ul id="sidebar-menu">
        <li class="nav-link">
            <a href="{{ route('admin.dashboard') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="bi bi-speedometer"></i>
                </div>
                Dashboard
            </a>
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
                Người dùng
            </a>
            <i class="arrow fas {{ request()->routeIs('users.*') ? 'fa-angle-down' : 'fa-angle-right' }} "></i>

            <ul class="sub-menu">
                <li><a href="{{ route('users.create') }}">Thêm mới</a></li>
                <li><a href="{{ route('users.index') }}">Danh sách</a></li>
            </ul>
        </li>
        <li class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <a href="{{ route('orders.index') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="bi bi-upc-scan"></i>
                </div>
                Đơn hàng
            </a>
            <i class="arrow fas {{ request()->routeIs('orders.*') ? 'fa-angle-down' : 'fa-angle-right' }} "></i>

            <ul class="sub-menu">
                <li><a href="{{ route('orders.index') }}">Danh sách</a></li>
            </ul>
        </li>
        <li class="nav-link">
            <a href="">
                <div class="nav-link-icon d-inline-flex">
                    <i class="bi bi-chat-dots"></i>
                </div>
                Bình luận & đánh giá
            </a>
            <i class="arrow fas {{ request()->routeIs('orders.*') ? 'fa-angle-down' : 'fa-angle-right' }} "></i>

            <ul class="sub-menu">
                <li><a href="">Danh sách</a></li>
            </ul>
        </li>

        <li class="nav-link {{ request()->routeIs(patterns: 'pages.*') ? 'active' : '' }}">
            <a href="{{ route('pages.index') }}">
                <div class="nav-link-icon d-inline-flex align-item-center">
                    <i class="bi bi-diagram-3"></i>
                    Trang tĩnh
                </div>
            </a>
            <i class="arrow fas {{ request()->routeIs('pages.*') ? 'fa-angle-down' : 'fa-angle-right' }}"></i>

            <ul class="sub-menu">
                <li><a href="{{ route('pages.create') }}">Thêm mới</a></li>
                <li><a href="{{ route('pages.index') }}">Danh sách</a></li>
            </ul>
        </li>
        <li class="nav-link {{ request()->routeIs(patterns: 'settings.*') ? 'active' : '' }}">
            <a href="{{ route('settings.meta.edit') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="bi bi-gear"></i>
                </div>
                Cấu hình hệ thống
            </a>
            <i class="arrow fas {{ request()->routeIs('settings.*') ? 'fa-angle-down' : 'fa-angle-right' }}"></i>

            <ul class="sub-menu">
                <li><a href="{{ route('settings.meta.edit') }}">Meta data</a></li>
            </ul>
            <ul class="sub-menu">
                <li><a href="{{ route('settings.email.edit') }}">Email</a></li>
            </ul>
            <ul class="sub-menu">
                <li><a href="">Slider</a></li>
            </ul>
            <ul class="sub-menu">
                <li><a href="">Thanh toán</a></li>
            </ul>
            <ul class="sub-menu">
                <li><a href="{{route('settings.social.edit')}}">Media</a></li>
            </ul>
            <ul class="sub-menu">
                <li><a href="{{route('settings.contact.edit')}}">Thông tin liên hệ</a></li>
            </ul>
        </li>
    </ul>
</div>
