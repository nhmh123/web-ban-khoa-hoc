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
                        <span> • {{ $course->enrollments()->count() }} Học viên</span>
                    </div>
                    <p class="mt-3">Giảng viên: <strong>{{ $course->user->name }}</strong></p>
                </div>
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
                                                    @if ($lecture->is_intro || (Auth::check() && Auth::user()->enrolledCourses->contains($course->id)))
                                                        @if ($lecture->type === 'video')
                                                            <a href="{{ $lecture->video->video_url }}" data-fancybox
                                                                data-width="640" data-height="360">
                                                                {{ $lecture->title }}
                                                                <i class="bi bi-play-circle"></i>
                                                            </a>
                                                        @else
                                                            <a href="#" data-fancybox data-src="#dialog-content">
                                                                {{ $lecture->title }}
                                                                <i class="bi bi-file-earmark-text"></i>
                                                            </a>

                                                            <div id="dialog-content" style="display:none;max-width:500px;">
                                                                <h2>{{ $lecture->title }}</h2>
                                                                <p>{{ $lecture->article->content }}</p>
                                                            </div>
                                                        @endif
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
                {{-- <section class="mt-4">
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
                </section> --}}

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
                        <h3 class="card-title fw-bold">{{ $course->original_price_formatted }}đ</h3>
                        </h3>

                        @if (Auth::check() && Auth::user()->enrolledCourses->contains($course->id))
                            @php
                                $firstLecture = $course->sections->first()?->lectures->first();
                            @endphp

                            @if ($firstLecture)
                                <a href="{{ route('user.course-video.show', ['course' => $course->slug, 'lecture' => $firstLecture]) }}"
                                    class="btn btn-primary w-100 mb-2">
                                    Truy cập khóa học
                                </a>
                            @else
                                <button class="btn btn-secondary w-100 mb-2" disabled>
                                    Khóa học chưa có bài giảng
                                </button>
                            @endif
                        @else
                            <form action="{{ route('user.course.enroll', $course->id) }}" method="POST"
                                name="enroll-course">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 mb-2">Mua ngay</button>
                            </form>
                            <div class="d-flex justify-content-between gap-2">
                                <div id="cart-action-wrapper" class="d-flex justify-content-between gap-2">
                                    @if ($alreadyInCart)
                                        <a href="{{ route('user.cart') }}" class="btn btn-success w-100">
                                            <i class="bi bi-cart-check-fill me-1"></i> Đi tới giỏ hàng
                                        </a>
                                    @else
                                        <form action="{{ route('user.cart.add', $course->id) }}" method="POST"
                                            name="add-to-cart">
                                            @csrf
                                            <button type="submit" class="flex-fill btn btn-outline-primary w-100">
                                                <span>Thêm vào giỏ hàng</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                @if ($alreadyInWishlist)
                                    <form action="{{ route('user.wishlist.remove', $course->id) }}" method="POST"
                                        name="remove-from-wishlist">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex-fill btn btn-danger w-100">
                                            <i class="bi bi-heartbreak"></i>
                                            <span>Xóa khỏi yêu thích</span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('user.wishlist.add', $course->id) }}" method="POST"
                                        name="add-to-wishlist">
                                        @csrf
                                        <button type="submit" class="flex-fill btn btn-danger w-100">
                                            <i class="bi bi-heart"></i>
                                            <span>Thêm vào yêu thích</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
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
    @push('scripts')
        <script>
            Fancybox.bind("[data-fancybox]", {
                // Your custom options
            });
        </script>
        <script>
            $(document).ready(function() {
                let addToWishlist = $('form[name="add-to-wishlist"]');
                let removeFromWishlist = $('form[name="remove-from-wishlist"]');
                let addToCart = $('form[name="add-to-cart"]');
                let cartElement = $('#user-cart-total');

                console.log({{ $alreadyInCart }});

                addToWishlist.on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let url = form.attr('action');

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: form.serialize(),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            console.log('Success:', response);
                            alert(response.message ||
                                'Khóa học đã được thêm vào danh sách yêu thích.');
                            location.reload();
                            // form.hide();
                            // removeFromWishlist.show();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error, status, xhr);
                            if (xhr.status === 401) {
                                alert('Bạn cần đăng nhập để thực hiện hành động này.');
                                return;
                            }
                            alert(error.JSON.message ||
                                'Đã xảy ra lỗi khi thêm khóa học vào danh sách yêu thích.');
                        }
                    });
                });

                removeFromWishlist.on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let url = form.attr('action');

                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: form.serialize(),
                        success: function(response) {
                            console.log('Success:', response);
                            alert(response.message ||
                                'Khóa học đã được xóa khỏi danh sách yêu thích.');
                            location.reload();
                            // form.hide();
                            // addToWishlist.show();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error, status, xhr);
                            alert('Đã xảy ra lỗi khi xóa khóa học khỏi danh sách yêu thích.');
                        }
                    })
                });

                addToCart.on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let url = form.attr('action');

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: form.serialize(),
                        success: function(response) {
                            if (response.status === 'success') {
                                displaySuccessToast(response.message);
                                $('#cart-action-wrapper').html(`
                                    <a href="{{ route('user.cart') }}" class="btn btn-success w-100">
                                        <i class="bi bi-cart-check-fill me-1"></i> Đi tới giỏ hàng
                                    </a>
                                `);
                                updateCartTotal(
                                    '{{ route('user.cart.get-total') }}');
                            } else {
                                alert(response.message || 'Đã xảy ra lỗi!');
                            }
                        },
                        error: function(xhr, status, error) {
                            let res = xhr.responseJSON;
                            let title = 'Lỗi';
                            let detail = 'Đã xảy ra lỗi khi thêm khóa học vào giỏ hàng.';
                            let redirect = "";

                            if (res) {
                                if (res.detail) {
                                    detail = res.detail;
                                } else if (res.title) {
                                    title = res.title;
                                }
                            } else if (xhr.status === 401) {
                                title = 'Chưa đăng nhập';
                                detail = 'Bạn cần đăng nhập để thực hiện thao tác này.';
                                redirect = '<a href="{{ route('login') }}">Đăng nhập</a>';
                            } else if (xhr.status === 400) {
                                detail = 'Yêu cầu không hợp lệ.';
                            }

                            displayErrorAlert(title, detail, redirect);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
