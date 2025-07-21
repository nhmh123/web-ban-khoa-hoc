@extends('layouts.user')

@section('user.content')
    <div class="container my-5">
        <h3 class="text-start mb-4">Khóa học của tôi</h3>

        {{-- Bộ lọc --}}
        <form method="GET" action="{{ route('user.my-courses') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="input-group">
                    {{-- <input type="hidden" name="q" value={{ request('q') }}> --}}
                    <input type="text" class="form-control" placeholder="tìm kiếm khóa học" name="my_course_q"
                        value={{ request('my_course_q') }}>
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">-- Tất cả danh mục --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->cc_id }}" {{ request('category') == $cat->cc_id ? 'selected' : '' }}>
                            {{ $cat->cc_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="{{ route('user.my-courses') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                @if ($courses->isEmpty())
                    <p class="text-muted">Không có khóa học phù hợp.</p>
                @else
                    <div class="row mt-3">
                        @foreach ($courses as $course)
                            <div class="col-md-3 mb-4">
                                <div class="card border-0 shadow-sm mb-4 h-100 d-flex flex-column">
                                    <img src="{{ $course->thumbnail }}" class="card-img-top"
                                        style="height: 150px; object-fit: cover;" alt="Course Image">
                                    <div class="card-body d-flex flex-column">
                                        @php
                                            $firstLecture = $course->sections->first()?->lectures->first();
                                        @endphp

                                        @if ($firstLecture)
                                            <a href="{{ route('user.course-video.show', ['course' => $course->slug, 'lecture' => $firstLecture]) }}"
                                                class="card-title fs-6 fw-bold">
                                                {{ $course->name }}
                                            </a>
                                        @else
                                            <span class="card-title fs-6 fw-bold text-muted">
                                                {{ $course->name }}
                                            </span>
                                        @endif

                                        {{-- <p class="mb-1 small">{{ $course->user->name }}</p> --}}

                                        {{-- <div class="mt-auto">
                                            <div class="progress" style="height: 12px">
                                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <i>50%</i>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <nav aria-label="...">
                        {{ $courses->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
