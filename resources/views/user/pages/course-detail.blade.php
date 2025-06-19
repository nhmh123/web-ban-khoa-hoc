@extends('layouts.user')
@section('user.content')
    <!-- Hero Section -->
    <header class="bg-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold">{{ $course->name }}</h1>
                    <p class="lead">{{ $course->short_description }}</p>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge text-white">{{ $course->rating }} ⭐ (1,250 Lượt đánh giá)</span>
                        <span> • 10,000+ Học viên</span>
                    </div>
                    <p class="mt-3">Giảng viên: <strong>{{ $course->user->name }}</strong></p>
                </div>
                {{-- <div class="col-lg-4 text-lg-end">
                    <button class="btn btn-primary btn-lg">Mua ngay - {{ $course->original_price }}</button>
                </div> --}}
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- Left Column: Course Details -->
            <div class="col-lg-8 order-2 order-md-1">
                <!-- Course Overview -->
                <section>
                    <h2 class="fs-5 fw-bold">Bạn sẽ được học những gì?</h2>
                    <p>{{ $course->content }}</p>
                </section>

                <!-- Course Curriculum -->
                <section class="mt-4">
                    <h2 class="fs-5 fw-bold">Nội dung khóa học</h2>
                    <div class="accordion" id="courseAccordion">
                        @foreach ($course->sections as $section)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#module{{ $section->sec_id }}">
                                        {{ $section->name }}
                                    </button>
                                </h2>
                                <div id="module{{ $section->sec_id }}" class="accordion-collapse collapse"
                                    data-bs-parent="#courseAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled m-0">
                                            @foreach ($section->lectures as $lecture)
                                                <li class="d-block py-2">
                                                    @if ($lecture->is_intro)
                                                        <a href="">
                                                            <span>{{ $lecture->title }}</span>
                                                            <i class="bi bi-play-circle-fill ms-2"></i>
                                                        </a>
                                                    @else
                                                        <a href="#"
                                                            class="text-decoration-none text-secondary opacity-75 pe-none">
                                                            <span>{{ $lecture->title }}</span>
                                                            <i class="bi bi-lock-fill"></i>
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Instructor Section -->
                <section class="mt-4">
                    <h2 class="fs-5 fw-bold">Người hướng dẫn</h2>
                    <div class="d-flex align-items-center">
                        <img src="{{ $course->user->avatar }}" class="rounded-circle me-3" alt="Instructor" width="70"
                            height="70">
                        <div>
                            <h6>
                                <a href="#">{{ $course->user->name }}</a>
                            </h6>
                            <p>Senior Laravel Developer with 10+ years of experience.</p>
                        </div>
                    </div>
                </section>

                <!-- Reviews -->
                <section class="mt-4">
                    <h2 class="fs-5 fw-bold">Đánh giá của học viên</h2>
                    <div class="border p-3 rounded mb-3">
                        <h6 class="fw-bold">Jane Smith</h6>
                        <p>⭐ ⭐ ⭐ ⭐ ⭐</p>
                        <p>"This course is amazing! The instructor explains everything clearly."</p>
                    </div>
                    <div class="border p-3 rounded mb-3">
                        <h6 class="fw-bold">Michael Brown</h6>
                        <p>⭐ ⭐ ⭐ ⭐ ⭐</p>
                        <p>"Highly recommended for anyone wanting to master Laravel!"</p>
                    </div>
                </section>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="col-lg-4 order-1 order-md-2 mb-3 mb-md-0">
                <div class="card">
                    <img src="{{ $course->thumbnail }}" class="card-img-top" alt="Course Thumbnail"
                        style="max-height: 250px">
                    <div class="card-body">
                        @if ($course->sale_price)
                            <div class="d-flex">
                                <h3 class="card-title text-decoration-line-through me-3">{{ $course->original_price }}
                                </h3>
                                </p>
                                <h3 class="card-title fw-bold">{{ $course->sale_price }}</h3>
                            </div>
                        @else
                            <h3 class="card-title">{{ $course->original_price }}</h3>
                        @endif
                        <h3 class="card-title">{{ $course->original_price }}</h3>
                        <p class="text-muted">Limited-time offer</p>

                        <a href="" class="btn btn-success w-100 mb-2">Đăng ký ngay</a>
                        <div class="d-flex gap-2">
                            <button class="flex-fill btn btn-outline-primary w-100">
                                <i class="bi bi-cart-plus"></i>
                                <span>Thêm vào giỏ hàng</span>
                            </button>
                            <button class="flex-fill btn btn-outline-secondary w-100">
                                <i class="bi bi-heart"></i>
                                <span>Yêu thích</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title fs-5 fw-bold">Chi tiết khóa học</h3>
                        <ul class="list-unstyled">
                            <li><strong>Thời lượng:</strong> {{ $course->duration }}</li>
                            <li><strong>Cấp độ:</strong> {{ $course->level->name }}</li>
                            <li><strong>Ngôn ngữ:</strong> English</li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title fs-5 fw-bold">Ai có thể học khóa học này?</h3>
                        <ul class="list-unstyled">
                            <p>{{ $course->audience }}</p>
                        </ul>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title fs-5 fw-bold">Kiến thức yêu cầu</h3>
                        <ul class="list-unstyled">
                            <p>{{ $course->enroll_requirements }}</p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
