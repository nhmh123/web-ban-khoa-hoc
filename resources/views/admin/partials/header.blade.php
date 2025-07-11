<nav class="topnav shadow navbar-light bg-white d-flex">
    <div class="navbar-brand"><a href="{{ route('admin.dashboard') }}">COURSEWEB ADMIN</a></div>
    <div class="ms-auto">
        <div class="dropdown">
            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                {{ Auth::user()->name }}
            </button>

            <!-- Căn phải dropdown -->
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Tài khoản</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Thoát</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- end nav  -->
