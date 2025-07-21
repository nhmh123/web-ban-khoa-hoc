@extends('layouts.user')
@section('user.content')
    <div class="container my-5">
        <div class="row">
            <!-- Sidebar Filter -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h4 class="mb-3 fw-bold">Bộ lọc</h4>

                    <form method="GET" action="">
                        <!-- Sort Order -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sắp xếp:</label>
                            <select class="form-select" name="sortBy">
                                <option value="new">Mới nhất</option>
                                <option value="latest" {{ request('sortBy') == 'latest' ? 'selected' : '' }}>Cũ nhất
                                </option>
                                <option value="price_low" {{ request('sortBy') == 'price_low' ? 'selected' : '' }}>Giá thấp
                                    đến cao</option>
                                <option value="price_high" {{ request('sortBy') == 'price_high' ? 'selected' : '' }}>Giá
                                    cao đến thấp</option>
                            </select>
                        </div>

                        <!-- Rating Filter -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Đánh giá:</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" value="4.5" id="rating4_5"
                                    {{ request('rating') == 4.5 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating4_5">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    (Từ 4.5 trở lên)
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" value="4.0" id="rating4_0"
                                    {{ request('rating') == 4.0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating4_0">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                    (Từ 4.0 trở lên)
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" value="3.5" id="rating3_5"
                                    {{ request('rating') == 3.5 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating3_5">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <i class="bi bi-star"></i>
                                    (Từ 3.5 trở lên)
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" value="3.0" id="rating3_0"
                                    {{ request('rating') == 3.0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating3_0">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                    <i class="bi bi-star"></i>
                                    (Từ 3.0 trở lên)
                                </label>
                            </div>
                        </div>

                        <!-- Duration Filter -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Thời lượng:</label>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="duration-0-1" name="duration[]"
                                    value="0-1" {{ in_array('0-1', (array) request('duration')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="duration-0-1">0 - 1 giờ</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="duration-1-3" name="duration[]"
                                    value="1-3" {{ in_array('1-3', (array) request('duration')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="duration-1-3">1 - 3 giờ</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="duration-3-6" name="duration[]"
                                    value="3-6" {{ in_array('3-6', (array) request('duration')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="duration-3-6">3 - 6 giờ</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="duration-6-17" name="duration[]"
                                    value="6-17" {{ in_array('6-17', (array) request('duration')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="duration-6-17">6 - 17 giờ</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="duration-17-999" name="duration[]"
                                    value="17-999" {{ in_array('17-999', (array) request('duration')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="duration-17-999">Trên 17 giờ</label>
                            </div>
                        </div>

                        <!-- Apply Button -->
                        <button type="submit" class="btn btn-primary w-100">Áp dụng</button>
                    </form>
                </div>
            </div>

            <!-- Course List -->
            <div class="col-md-9">
                <h2 class="mb-4">{{ $category->cc_name }}</h2>
                @if (!$courses->isEmpty())
                    <div class="row g-4 px-2 mt-3">
                        @foreach ($courses as $course)
                            <div class="card border-0 p-0 my-2">
                                <div class="row g-0">
                                    <!-- Course Thumbnail (Left) -->
                                    <div class="col-md-4">
                                        <img src="{{ $course->thumbnail }}" class="rounded-start" alt="Course Image"
                                            style="width: 100%; height: 175px; object-fit: cover;">
                                    </div>

                                    <!-- Course Info (Right) -->
                                    <div class="col-md-8">
                                        <div class="card-body py-0 my-0 d-flex flex-column h-100">
                                            <a href="{{ route('user.courses.show',$course->slug) }}"
                                                class="card-title fs-5 fw-bold">{{ $course->name }}</a>
                                            <p class="card-text small mb-1">
                                                {{ Str::limit($course->sort_description, 100) }}
                                            </p>
                                            <p class="mb-1 small"><strong>Đánh giá:</strong> ⭐⭐⭐⭐⭐
                                                ({{ $course->rating ?? '4.8' }})
                                            </p>

                                            <p>Lần cuối cập nhật: <strong>{{ $course->updated_at }}</strong></p>
                                            {{-- <p class="fw-bold">{{ $course->duration }}</p> --}}

                                            <div class="mt-auto d-flex justify-content-end">
                                                <p class="mb-1 small fs-5 fw-bold">
                                                    {{ number_format($course->original_price) }}đ</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                        @endforeach

                        <!-- Pagination -->
                        <nav aria-label="...">
                            {{ $courses->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                @else
                    <p>{{ $message ?? 'Không có khóa học phù hợp.' }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
