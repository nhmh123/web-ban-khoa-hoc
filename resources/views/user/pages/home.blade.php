@extends('layouts.user')
@section('user.content')
    @session('error')
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endsession
    <!-- Hero Section -->
    <header class="bg-primary text-white text-center py-5">
        <h1>Học mọi thứ; mọi nơi, mọi lúc</h1>
        <p>Truy cập các khóa học và bắt đầu hành trình ngay bây giờ</p>
        <a href="#courses" class="btn btn-light">Xem khóa học</a>
    </header>

    <!-- Courses Section -->
    <section id="courses" class="container my-5">
        <h2 class="text-start mb-4">Khóa học phổ biến</h2>
        <div class="row">
            {{-- @foreach ($popularCourses as $course)
                <div class="col-md-3">
                    <div class="card border-0 mb-4">
                        <img src="{{ $course->thumbnail }}" class="card-img-top" alt="Course Image" 
                            style="height: 140px; object-fit: cover;">
                        <div class="card-body py-3 px-0">
                            <h5 class="card-title fs-6 fw-bold">{{ $course->title }}</h5>
                            <p class="card-text small mb-1">{{ Str::limit($course->sort_description, 100) }}</p>
                            <p class="mb-1 small"><strong>Instructor:</strong> {{ $course->user->name }}</p>
                            <p class="mb-1 small"><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (4.8)</p>
                            @if ($course->sale_price)
                                <div class="d-flex small">
                                    <p class="me-2 mb-1"><strong>Price:</strong>
                                        <span class="text-decoration-line-through">
                                            ${{ $course->original_price }}
                                        </span>
                                    </p>
                                    <p class="mb-1">${{ $course->sale_price }}</p>
                                </div>
                            @else
                                <p class="mb-1 small"><strong>Price:</strong> ${{ $course->original_price }}</p>
                            @endif
                            <a href="{{ route('user.course-detail', ['course' => $course->slug]) }}"
                                class="btn btn-primary btn-sm mt-auto">View Course</a>
                        </div>
                    </div>
                </div>
            @endforeach --}}
        </div>
    </section>
    <div class="container my-5">
        <div class="row">
            <!-- Bộ lọc bên trái -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h4 class="mb-3">Bộ lọc</h4>

                    <form method="GET" action="">
                        <!-- Sắp xếp -->
                        <div class="mb-3">
                            <label class="form-label">Sắp xếp theo:</label>
                            <select class="form-select" name="sort">
                                <option value="popular">Phổ biến nhất</option>
                                <option value="latest">Mới nhất</option>
                                <option value="price_low">Giá: Thấp đến Cao</option>
                                <option value="price_high">Giá: Cao đến Thấp</option>
                            </select>
                        </div>

                        <!-- Lọc theo trình độ -->
                        <div class="mb-3">
                            <label class="form-label">Trình độ:</label>
                            <select class="form-select" name="level">
                                <option value="all">Tất cả trình độ</option>
                                <option value="beginner">Người mới bắt đầu</option>
                                <option value="intermediate">Trung cấp</option>
                                <option value="advanced">Nâng cao</option>
                            </select>
                        </div>

                        <!-- Khoảng giá -->
                        <div class="mb-3">
                            <label class="form-label">Khoảng giá:</label>
                            <input type="range" class="form-range" min="0" max="500" name="price"
                                id="priceRange">
                            <p class="text-muted">Tối đa $<span id="priceValue">250</span></p>
                        </div>

                        <!-- Lọc theo ngôn ngữ -->
                        <div class="mb-3">
                            <label class="form-label">Ngôn ngữ:</label>
                            <select class="form-select" name="language">
                                <option value="all">Tất cả ngôn ngữ</option>
                                <option value="english">Tiếng Anh</option>
                                <option value="spanish">Tiếng Tây Ban Nha</option>
                                <option value="french">Tiếng Pháp</option>
                                <option value="japanese">Tiếng Nhật</option>
                            </select>
                        </div>

                        <!-- Nút áp dụng -->
                        <button type="submit" class="btn btn-primary w-100">Áp dụng bộ lọc</button>
                    </form>
                </div>
            </div>


            <!-- Course List -->
            <div class="col-md-9">
                <h2 class="mb-4">Toàn bộ khóa học</h2>
                <div class="row g-4 px-4 mt-3">
                    {{-- @foreach ($courses as $course)
                        <div class="card border-0 p-0 my-2">
                            <div class="row g-0">
                                <!-- Course Thumbnail (Left) -->
                                <div class="col-md-4">
                                    <img src="{{ $course->thumbnail }}" class="rounded-start" alt="Course Image"
                                        style="width: 100%; height: 175px; object-fit: cover;">
                                </div>

                                <!-- Course Info (Right) -->
                                <div class="col-md-8">
                                    <div class="card-body py-0">
                                        <h5 class="card-title fs-6 fw-bold">{{ $course->title }}</h5>
                                        <p class="card-text small mb-1">{{ Str::limit($course->short_description, 100) }}</p>
                                        <p class="mb-1 small"><strong>Instructor:</strong> {{ $course->user->name }}</p>
                                        <p class="mb-1 small"><strong>Rating:</strong> ⭐⭐⭐⭐⭐ ({{ $course->rating }})</p>
                                        @if ($course->sale_price)
                                            <div class="d-flex small">
                                                <p class="me-2 mb-1"><strong>Price:</strong>
                                                    <span class="text-decoration-line-through">
                                                        ${{ $course->original_price }}
                                                    </span>
                                                </p>
                                                <p class="mb-1">${{ $course->sale_price }}</p>
                                            </div>
                                        @else
                                            <p class="mb-1 small"><strong>Price:</strong> ${{ $course->original_price }}</p>
                                        @endif
                                        <a href="{{ route('user.course-detail', ['course' => $course->slug]) }}"
                                            class="btn btn-primary btn-sm">View Course</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                    @endforeach --}}
                </div>
                <nav aria-label="...">
                    {{-- {{ $courses->links('pagination::bootstrap-5') }} --}}
                </nav>
            </div>
        </div>
    </div>
@endsection
