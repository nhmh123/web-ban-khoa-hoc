<div id="sidebar" class="bg-white">
    <ul id="sidebar-menu">
        <li class="nav-link">
            <a href="?view=dashboard">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Dashboard
            </a>
            <i class="arrow fas fa-angle-right"></i>
        </li>
        <li class="nav-link">
            <a href="?view=list-post">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Trang
            </a>
            <i class="arrow fas fa-angle-right"></i>

            <ul class="sub-menu">
                <li><a href="?view=add-post">Thêm mới</a></li>
                <li><a href="?view=list-post">Danh sách</a></li>
            </ul>
        </li>
        <li class="nav-link">
            <a href="?view=list-post">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Bài viết
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                <li><a href="?view=add-post">Thêm mới</a></li>
                <li><a href="?view=list-post">Danh sách</a></li>
                <li><a href="?view=cat">Danh mục</a></li>
            </ul>
        </li>
        <li class="nav-link">
            <a href="?view=list-product">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Sản phẩm
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                <li><a href="?view=add-product">Thêm mới</a></li>
                <li><a href="?view=list-product">Danh sách</a></li>
                <li><a href="?view=cat-product">Danh mục</a></li>
            </ul>
        </li>
        <li class="nav-link">
            <a href="?view=list-order">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Bán hàng
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                <li><a href="?view=list-order">Đơn hàng</a></li>
            </ul>
        </li>
        <li class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
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
            <i class="arrow fas fa-angle-down"></i>
            <ul class="sub-menu">
                <li><a href="?view=permission">Quyền</a></li>
                <li><a href="?view=add-role">Thêm vai trò</a></li>
                <li><a href="?view=list-role">Danh sách vai trò</a></li>
            </ul>
        </li>
    </ul>
</div>
