@extends('layouts.user')
@section('user.content')
    <!-- Hero Section -->
    <header class="bg-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                {{-- <div class="col-lg-8">
                    <h1 class="fw-bold">{{ $course->title }}</h1>
                    <p class="lead">{{ $course->short_description }}</p>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge text-white">{{ $course->rating }} ⭐ (1,250 Reviews)</span>
                        <span> • 10,000+ Students</span>
                    </div>
                    <p class="mt-3">Instructor: <strong>{{ $course->user->name }}</strong></p>
                </div> --}}
                {{-- <div class="col-lg-4 text-lg-end">
                    <button class="btn btn-primary btn-lg">Buy Now - $99.99</button>
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
                    <h2 class="fs-4">What You Will Learn</h2>
                    {{-- <p>{{ $course->content }}</p> --}}
                </section>

                <!-- Course Curriculum -->
                <section class="mt-4">
                    <h2 class="fs-4">Course Curriculum</h2>
                    <div class="accordion" id="courseAccordion">
                        {{-- @foreach ($course->sections as $section)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#module{{ $section->id }}">
                                        {{ $section->title }}
                                    </button>
                                </h2>
                                <div id="module{{ $section->id }}" class="accordion-collapse collapse"
                                    data-bs-parent="#courseAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled m-0">
                                            @foreach ($section->lectures as $lecture)
                                                <li class="d-block py-2">
                                                    @if ($lecture->is_intro)
                                                        <a
                                                            href="{{ route('user.course-video', ['course' => $course->slug, 'lecture' => $lecture->id]) }}">
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
                        @endforeach --}}
                    </div>
                </section>

                <!-- Instructor Section -->
                <section class="mt-4">
                    <h2 class="fs-4">Instructor</h2>
                    <div class="d-flex align-items-center">
                        <img src="https://www.shutterstock.com/shutterstock/photos/1765602338/display_1500/stock-photo-portrait-of-indian-male-teacher-standing-against-blackboard-teaching-mathematics-in-classroom-1765602338.jpg"
                            class="rounded-circle me-3" alt="Instructor" width="100" height="100">
                        <div>
                            <h5>
                                {{-- <a href="#">{{ $course->user->name }}</a> --}}
                            </h5>
                            <p>Senior Laravel Developer with 10+ years of experience.</p>
                        </div>
                    </div>
                </section>

                <!-- Reviews -->
                <section class="mt-4">
                    <h2 class="fs-4">Student Reviews</h2>
                    <div class="border p-3 rounded mb-3">
                        <h5>Jane Smith</h5>
                        <p>⭐ ⭐ ⭐ ⭐ ⭐</p>
                        <p>"This course is amazing! The instructor explains everything clearly."</p>
                    </div>
                    <div class="border p-3 rounded mb-3">
                        <h5>Michael Brown</h5>
                        <p>⭐ ⭐ ⭐ ⭐ ⭐</p>
                        <p>"Highly recommended for anyone wanting to master Laravel!"</p>
                    </div>
                </section>
            </div>

            <!-- Right Column: Sidebar -->
            {{-- <div class="col-lg-4 order-1 order-md-2 mb-3 mb-md-0">
                <div class="card">
                    <img src="{{ $course->thumbnail }}" class="card-img-top" alt="Course Thumbnail"
                        style="max-height: 250px">
                    <div class="card-body">
                        @if ($course->sale_price)
                            <div class="d-flex">
                                <h3 class="card-title text-decoration-line-through me-3">${{ $course->original_price }}
                                </h3>
                                </p>
                                <h3 class="card-title fw-bold">${{ $course->sale_price }}</h3>
                            </div>
                        @else
                            <h3 class="card-title">${{ $course->original_price }}</h3>
                        @endif
                        <h3 class="card-title">${{ $course->original_price }}</h3>
                        <p class="text-muted">Limited-time offer</p>

                        <a href=""
                            class="btn btn-success w-100 mb-2">Enroll now</a>
                        <div class="d-flex gap-2">
                            <button class="flex-fill btn btn-outline-primary w-100">
                                <i class="bi bi-cart-plus"></i>
                                <span>Add to cart</span>
                            </button>
                            <button class="flex-fill btn btn-outline-secondary w-100">
                                <i class="bi bi-heart"></i>
                                <span>Add to Wishlist</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Course Details</h3>
                        <ul class="list-unstyled">
                            <li><strong>Duration:</strong> {{ $course->duration }} hours</li>
                            <li><strong>Level:</strong> {{ $course->difficulty_level }}</li>
                            <li><strong>Language:</strong> English</li>
                            <li><strong>Certificate:</strong> Yes</li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Who can choose this course?</h3>
                        <ul class="list-unstyled">
                            <p>{{ $course->audience }}</p>
                        </ul>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Requirements</h3>
                        <ul class="list-unstyled">
                            <p>{{ $course->requirements }}</p>
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
