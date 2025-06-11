@extends('layouts.admin')

@section('title', 'Cập nhật khóa học')

@section('admin.content')
    <div class="container-fluid py-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật khóa học
            </div>

            {{-- Nav Tabs --}}
            <nav class="p-4">
                <div class="nav nav-tabs" id="courseTab" role="tablist">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
                        role="tab" aria-controls="info" aria-selected="true">
                        Thông tin khóa học
                    </button>
                    <button class="nav-link" id="sections-tab" data-bs-toggle="tab" data-bs-target="#sections"
                        type="button" role="tab" aria-controls="sections" aria-selected="false">
                        Danh sách Section
                    </button>
                </div>
            </nav>
            <div class="tab-content px-4" id="courseTabContent">
                {{-- Tab 1: Course Information --}}
                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab"
                    tabindex="0">
                    <div class="card-body">
                        <form action="{{ route('courses.update', $course->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Tên khóa học</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name', $course->name) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label fw-bold">Ảnh đại diện</label>
                                        <input type="file" class="form-control" name="thumbnail" id="thumbnail">
                                        <div class="mt-2">
                                            <img src="{{ $course->thumbnail ? asset($course->thumbnail) : '' }}"
                                                alt="" class="img-fluid" width="300" id="thumbnail-preview">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="original_price" class="form-label fw-bold">Giá gốc</label>
                                        <div class="d-flex">
                                            <input type="number" step="0.01" name="original_price" id="original_price"
                                                class="form-control"
                                                value="{{ old('original_price', $course->original_price) }}">
                                            <span>VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="short_description" class="form-label fw-bold">Mô tả ngắn</label>
                                        <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ old('short_description', $course->short_description) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="enroll_requirements" class="form-label fw-bold">Yêu cầu ghi danh</label>
                                        <textarea name="enroll_requirements" id="enroll_requirements" class="form-control" rows="3">{{ old('enroll_requirements', $course->enroll_requirements) }}</textarea>
                                    </div>
                                </div>
                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="audience" class="form-label fw-bold">Đối tượng</label>
                                        <textarea name="audience" id="audience" class="form-control" rows="3">{{ old('audience', $course->audience) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label fw-bold">Trạng thái</label>
                                        <select name="status" id="status" class="form-control">
                                            @php
                                                use App\Enums\CourseEnum;
                                            @endphp
                                            @foreach (CourseEnum::cases() as $enum)
                                                @if ($enum !== CourseEnum::ARCHIVED)
                                                    <option value="{{ $enum->value }}"
                                                        {{ old('status', $course->status) === $enum->value ? 'selected' : '' }}>
                                                        @switch($enum)
                                                            @case(CourseEnum::DRAFT)
                                                                Nháp
                                                            @break

                                                            @case(CourseEnum::PUBLISHED)
                                                                Công khai
                                                            @break
                                                        @endswitch
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cat_id" class="form-label fw-bold">Danh mục</label>
                                        <select name="cat_id" id="cat_id" class="form-control">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->cc_id }}"
                                                    {{ old('cat_id', $course->cat_id) == $category->cc_id ? 'selected' : '' }}>
                                                    {{ $category->cc_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-inline-flex mb-3">
                                        <label for="language" class="form-label fw-bold">Ngôn ngữ</label>
                                        <select name="language_id" id="language" class="form-control">
                                            @foreach ($languages as $lang)
                                                <option value="{{ $lang->lang_id }}"
                                                    {{ old('language', $course->language_id) == $lang->lang_id ? 'selected' : '' }}>
                                                    {{ $lang->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="level_id" class="form-label fw-bold">Trình độ</label>
                                        <select name="level_id" id="level_id" class="form-control">
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->level_id }}"
                                                    {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                                                    {{ $level->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Full Width -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Mô tả chi tiết</label>
                                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $course->description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label fw-bold">Nội dung khóa học</label>
                                <textarea name="content" id="content" class="form-control" rows="4">{{ old('content', $course->content) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
                {{-- Tab 2: Course Sections --}}
                <div class="tab-pane fade" id="sections" role="tabpanel" aria-labelledby="sections-tab"
                    tabindex="0">
                    <div class="card-body">

                        <!-- Course Curriculum -->
                        <section class="mt-4">
                            <h2 class="fs-4">Course Curriculum</h2>
                            <div class="accordion" id="courseAccordion">
                                {{-- @foreach ($course->sections as $section)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#module{{ $section->id }}">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.querySelector('input[name="thumbnail"]').addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('thumbnail-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
