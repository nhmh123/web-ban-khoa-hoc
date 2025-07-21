@extends('layouts.user')
@section('user.content')
    @session('error')
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endsession

    <!-- Hero Section -->
    {{-- <header class="bg-primary text-white text-center py-5">
        <h1>Học mọi thứ; mọi nơi, mọi lúc</h1>
        <p>Truy cập các khóa học và bắt đầu hành trình ngay bây giờ</p>
        <a href="#courses" class="btn btn-light">Xem khóa học</a>
    </header> --}}

    @include('user.partials.slider')

    <div class="container border rounded-3 bg-primary p-3 mt-5 text-white fw-bold">
        Học mọi thứ, mọi nơi, mọi lúc. Truy cập các khóa học và bắt đầu hành trình ngay bây giờ!
    </div>

    <div class="container my-5">
        <h4 class="text-start fw-bold mb-4">Tất cả khoá học</h4>
        <div data-aos="fade-up">
            <div class="row">
                <!-- Course List -->
                <div class="col-md-12">
                    <div class="row mt-3">
                        @foreach ($courses as $course)
                            <div class="col-md-3 d-flex">
                                <div class="card border-0 mb-4 h-100 d-flex flex-column">
                                    <img src="{{ $course->thumbnail }}" class="card-img-top" alt="Course Image"
                                        style="height: 150px; object-fit: fill;">
                                    <div class="card-body py-3 px-0 d-flex flex-column">
                                        <a href="{{ route('user.courses.show', ['course' => $course->slug]) }}"
                                            class="card-title fs-5 fw-bold">{{ $course->name }}</a>
                                        <p class="card-text small mb-1">{{ Str::limit($course->sort_description, 100) }}</p>
                                        <p class="mb-1 small">{{ $course->user->name }}</p>
                                        <p class="mb-1 small">⭐⭐⭐⭐⭐ ({{ $course->rating }})</p>

                                        <div class="mt-auto">
                                            <p class="mb-1 small fs-5 fw-bold text-end">
                                                {{ $course->original_price_formatted }}đ</p>
                                        </div>
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
    </div>
@endsection
