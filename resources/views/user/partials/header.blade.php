<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="">
            <i class="bi bi-play-circle me-1"></i>CourseWeb</a>
        <form action="" class="d-none d-md-flex ms-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="tìm kiếm khóa học">
                <button class="btn btn-primary">
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="courseDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                        <!-- IT Category -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">IT</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#web-development">Phát triển web</a></li>
                                <li><a class="dropdown-item" href="#cybersecurity">Bảo mật</a></li>
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
                            <a class="dropdown-item dropdown-toggle" href="#">Ngôn ngữ</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#english">English</a></li>
                                <li><a class="dropdown-item" href="#japanese">Japanese</a></li>
                                <li><a class="dropdown-item" href="#chinese">Chinese</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#wishlist">
                        <i class="bi bi-heart"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="#cart">
                        <i class="bi bi-cart3"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="#notifications">
                        <i class="bi bi-bell"></i>
                    </a></li>
                <!-- Login Button (Trigger Modal) -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Đăng nhập
                </button>
            </ul>
        </div>

        <!-- Offcanvas Toggle Button (Only visible in mobile view) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Offcanvas Sidebar (Mobile Menu) -->
        <div class="offcanvas offcanvas-end d-md-none" tabindex="-1" id="offcanvasNavbar">
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
                <button type="button" class="btn btn-primary w-100 mt-3" data-bs-toggle="modal"
                    data-bs-target="#loginModal">
                    Đăng nhập
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Marquee Section for Sales Strategy -->
<div class="marquee-container bg-warning text-dark pt-2">
    <marquee behavior="scroll" direction="left" scrollamount="5">
        🎉 Ưu đãi có thời hạn: Giảm giá 50% cho tất cả các khóa học! Đăng ký ngay! 🎉
        🚀 Khóa học AI mới ra mắt! Tham gia ngay để trở thành chuyên gia! 🚀
        📚 Tặng Ebook miễn phí cho mỗi lượt đăng ký! Đừng bỏ lỡ! 📚
    </marquee>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Login Form -->
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password"
                            placeholder="Enter your password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="position-relative my-4">
                    <hr>
                    <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white">OR</span>
                </div>

                <!-- Social Login -->
                <div class="d-flex gap-2">
                    <button class="btn btn-danger flex-fill">
                        <i class="bi bi-google"></i> Login with Google
                    </button>
                    <button class="btn btn-primary flex-fill">
                        <i class="bi bi-facebook"></i> Login with Facebook
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
