<!-- Marquee Section for Sales Strategy -->
<div class="marquee-container bg-primary text-light pt-2">
    <marquee behavior="scroll" direction="left" scrollamount="5">
        🎉 Ưu đãi có thời hạn: Giảm giá <mark>50%</mark> cho tất cả các khóa học! Đăng ký ngay! 🎉
        🚀 Khóa học AI mới ra mắt! Tham gia ngay để trở thành chuyên gia! 🚀
        📚 Tặng Ebook <mark>miễn phí</mark> cho mỗi lượt đăng ký! Đừng bỏ lỡ! 📚
    </marquee>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom border-dark">
    <div class="container-fluid d-flex justify-content-between py-2">
        <a class="navbar-brand fw-bold" href="{{ route('user.home') }}">
            <i class="bi bi-play-circle me-1"></i>CourseWeb</a>

        @include('user.partials.main-menu')

        <form action="{{ route('user.search') }}" class="d-none d-md-flex ms-3">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="tìm kiếm khóa học"
                    value="{{ request('q') }}" required>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- Normal Navbar (Visible on Desktop) -->
        {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <form action="" class="d-flex d-md-none">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="tìm kiếm khóa học">
                        <button class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <li class="nav-item fw-bold mx-2 align-content-center"><a class="nav-link text-dark"
                        href="{{ route('user.wishlist') }}">
                        <i class="bi bi-heart fs-5"></i>
                    </a></li>

                <li class="nav-item fw-bold mx-2 align-content-center">
                    <a class="nav-link position-relative" href="{{ route('user.cart') }}">
                        <span id="user-cart-total"
                            class="position-absolute top-2 start-100 translate-middle badge rounded-pill bg-danger
                {{ auth()->user()?->cartItem->count() > 0 ? '' : 'd-none' }}">
                            {{ auth()->user()?->cartItem->count() }}
                        </span>
                        <i class="bi bi-cart3 fs-5 text-dark"></i>
                    </a>
                </li>


                <li class="nav-item fw-bold mx-2 align-content-center"><a class="nav-link" href="#notifications">
                        <i class="bi bi-bell text-dark fs-5"></i>
                    </a></li>

                @auth
                    <div class="dropdown justify-content-center align-item-center">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="" class="rounded-circle"
                                width="50px" height="50px">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <strong class="text-center px-2">{{ auth()->user()->name }}</strong>
                            <hr>
                            <li><a class="dropdown-item"
                                    href="{{ route('user.profile', [
                                        'user' => auth()->user()->id,
                                    ]) }}">Thông
                                    tin</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.my-courses') }}">Khóa học</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.orders.history') }}">Lịch sử mua</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.logout') }}">Đăng xuất</a></li>
                        </ul>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary align-content-center">
                        Đăng nhập
                    </a>
                @endguest

                <a href="{{ url('admin') }}" class="btn btn-outline-primary align-content-center ms-2">
                    Admin
                </a>
            </ul>
        </div>

        <!-- Offcanvas Toggle Button (Only visible in mobile view) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Offcanvas Sidebar (Mobile Menu) -->
        {{-- <div class="offcanvas offcanvas-end d-md-none" tabindex="-1" id="offcanvasNavbar">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <form action="" class="d-flex mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for course">
                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="courseDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Courses
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                            <!-- IT Category -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">IT</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#web-development">Web Development</a></li>
                                    <li><a class="dropdown-item" href="#cybersecurity">Cybersecurity</a></li>
                                    <li><a class="dropdown-item" href="#data-science">Data Science</a></li>
                                </ul>
                            </li>

                            <!-- Marketing Category -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">Marketing</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#seo">SEO</a></li>
                                    <li><a class="dropdown-item" href="#digital-marketing">Digital Marketing</a></li>
                                    <li><a class="dropdown-item" href="#branding">Branding</a></li>
                                </ul>
                            </li>

                            <!-- Language Category -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">Language</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#english">English</a></li>
                                    <li><a class="dropdown-item" href="#japanese">Japanese</a></li>
                                    <li><a class="dropdown-item" href="#chinese">Chinese</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                @if (auth()->check())
                    echo auth()->user()->name;
                @else
                    <button type="button" class="btn btn-primary w-100 mt-3" data-bs-toggle="modal"
                        data-bs-target="#loginModal">
                        Đăng nhập
                    </button>
                @endif
            </div>
        </div> --}}
    </div>
</nav>
<nav class="navbar navbar-light bg-light shadow mb-3 py-1">
    <div class="container-fluid px-3">
        <div class="w-100 overflow-auto">
            <ul class="navbar-nav flex-row flex-nowrap">
                @foreach ($rootCategories as $category)
                    <li class="nav-item me-3">
                        <a href="{{ route('user.category.show', $category->full_slug_path) }}"
                            class="nav-link text-nowrap text-dark fw-semibold">
                            {{ $category->cc_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        $(document).ready(function() {

        })
    </script>
@endpush
