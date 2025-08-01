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

        @can('course-category.view')
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
        @endcan

        @can('course.view')
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
        @endcan

        @can('user.view')
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
        @endcan

        @can('order.view')
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
        @endcan

        @can('review.view')
            <li class="nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                <a href="{{ route('admin.reviews.index') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    Bình luận & đánh giá
                </a>
                <i class="arrow fas {{ request()->routeIs('reviews.*') ? 'fa-angle-down' : 'fa-angle-right' }} "></i>

                <ul class="sub-menu">
                    <li><a href="{{ route('admin.reviews.index') }}">Danh sách</a></li>
                </ul>
            </li>
        @endcan

        @can('page.view')
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
        @endcan

        @can('setting.view')
            <li class="nav-link {{ request()->routeIs('settings.*', 'sliders.*') ? 'active' : '' }}">
                <a href="{{ route('settings.meta.edit') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="bi bi-gear"></i>
                    </div>
                    Cấu hình hệ thống
                </a>
                <i
                    class="arrow fas {{ request()->routeIs('settings.*', 'sliders.*') ? 'fa-angle-down' : 'fa-angle-right' }}"></i>

                <ul class="sub-menu">
                    <li><a href="{{ route('settings.meta.edit') }}">Meta data</a></li>
                </ul>
                <ul class="sub-menu">
                    <li><a href="{{ route('settings.email.edit') }}">Email</a></li>
                </ul>
                <ul class="sub-menu">
                    <li><a href="{{ route('sliders.index') }}">Slider</a></li>
                </ul>
                <ul class="sub-menu">
                    <li><a href="{{ route('settings.payment.index') }}">Thanh toán</a></li>
                </ul>
                <ul class="sub-menu">
                    <li><a href="{{ route('settings.social.edit') }}">Media</a></li>
                </ul>
                <ul class="sub-menu">
                    <li><a href="{{ route('settings.contact.edit') }}">Thông tin liên hệ</a></li>
                </ul>
            </li>
        @endcan

        @can('role.view')
            <li class="nav-link {{ request()->routeIs('permissions.*', 'roles.*') ? 'active' : '' }}">
                <a href="{{ route('permissions.create') }}">
                    <div class="nav-link-icon d-inline-flex">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    Phân quyền
                </a>
                <i
                    class="arrow fas {{ request()->routeIs('permissions.*', 'roles.*') ? 'fa-angle-down' : 'fa-angle-right' }} "></i>
                <ul class="sub-menu">
                    <li><a href="{{ route('permissions.create') }}">Quyền</a></li>
                    <li><a href="{{ route('roles.create') }}">Thêm vai trò</a></li>
                    <li><a href="{{ route('roles.index') }}">Danh sách vai trò</a></li>
                </ul>
            </li>
        @endcan
    </ul>
</div>
