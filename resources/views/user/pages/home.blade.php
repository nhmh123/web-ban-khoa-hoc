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
        <h3 class="text-start mb-4">Khóa học phổ biến</h3>
        <div class="row">
            @foreach ($popularCourses as $course)
                <div class="col-md-3">
                    <div class="card border-0 mb-4">
                        <img src="{{ $course->thumbnail }}" class="card-img-top" alt="Course Image"
                            style="height: 150px; object-fit: fill;">
                        <div class="card-body py-3 px-0">
                            <h5 class="card-title fs-5 fw-bold">{{ $course->name }}</h5>
                            <p class="card-text small mb-1">{{ Str::limit($course->sort_description, 100) }}</p>
                            <p class="mb-1 small">{{ $course->user->name }}</p>
                            <p class="mb-1 small">⭐⭐⭐⭐⭐ (4.8)</p>
                            @if ($course->sale_price)
                                <div class="d-flex small">
                                    <p class="me-2 mb-1">
                                        <span class="text-decoration-line-through fs-5">
                                            {{ $course->original_price_formatted }}
                                        </span>
                                    </p>
                                    <p class="mb-1 fs-5 fw-bold">{{ $course->sale_price_formatted }}</p>
                                </div>
                            @else
                                <p class="mb-1 small fs-5 fw-bold">{{ $course->original_price_formatted }}</p>
                            @endif
                            <a href="{{ route('user.courses.show', ['course' => $course->slug]) }}"
                                class="btn btn-primary btn-sm mt-auto">Xem khóa học</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <div class="container my-5">
        <h3 class="text-start mb-4">Tất cả khoá học</h3>
        <div class="row">
            <!-- Course List -->
            <div class="col-md-12">
                <div class="row mt-3">
                    @foreach ($courses as $course)
                        <div class="col-md-2">
                            <div class="card border-0 mb-4">
                                <img src="{{ $course->thumbnail }}" class="card-img-top" alt="Course Image"
                                    style="height: 120px; object-fit: fill;">
                                <div class="card-body py-3 px-0">
                                    <h5 class="card-title fs-5 fw-bold">{{ $course->name }}</h5>
                                    <p class="card-text small mb-1">{{ Str::limit($course->sort_description, 100) }}</p>
                                    <p class="mb-1 small">{{ $course->user->name }}</p>
                                    <p class="mb-1 small">⭐⭐⭐⭐⭐ (4.8)</p>
                                    @if (!is_null($course->sale_price))
                                        <div class="d-flex small">
                                            <p class="me-2 mb-1">
                                                <span class="text-decoration-line-through fs-5">
                                                    {{ $course->original_price_formatted }}
                                                </span>
                                            </p>
                                            <p class="mb-1 fs-5 fw-bold">{{ $course->sale_price_formatted }}</p>
                                        </div>
                                    @else
                                        <p class="mb-1 small fs-5 fw-bold">{{ $course->original_price_formatted }}</p>
                                    @endif
                                    <a href="{{ route('user.courses.show', ['course' => $course->slug]) }}"
                                        class="btn btn-primary btn-sm mt-auto">Xem khóa học</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- <nav aria-label="...">
                    {{ $courses->links('pagination::bootstrap-5') }}
                </nav> --}}
            </div>
        </div>
    </div>
@endsection
