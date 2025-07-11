@extends('layouts.admin')

@section('title', 'Cập nhật khóa học')

@section('admin.content')
    <div class="container-fluid py-4">

        @session('success')
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endsession

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
                        Nội dung khóa học
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
                                        <label for="slug" class="form-label fw-bold">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control"
                                            value="{{ old('slug', $course->slug) }}" disabled>
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
                                <label for="content" class="form-label fw-bold">Nội dung học</label>
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
                        <section>
                            <!-- Add Section Button -->
                            <div class="mt-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                                    <i class="bi bi-plus-lg"></i>
                                    Thêm phần học
                                </button>
                            </div>
                            <!-- Add Section Modal -->
                            <div class="modal fade" id="addSectionModal" tabindex="-1"
                                aria-labelledby="addSectionModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('sections.store') }}" method="POST" class="modal-content">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addSectionModalLabel">Thêm phần học</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="sectionName" class="form-label">Tên phần học</label>
                                                <input type="text" name="name" id="sectionName"
                                                    class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="sectionDescription" class="form-label">Mô tả</label>
                                                <textarea name="description" id="sectionDescription" class="form-control" rows="3"></textarea>
                                            </div>

                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                            <button type="button" class="btn outline-0 border-0"
                                                data-bs-dismiss="modal">Hủy</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Course Sections Accordion -->
                            <div class="accordion mt-4" id="courseAccordion">
                                @foreach ($course->sections as $section)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <!-- Accordion Toggle Button -->
                                                <button class="accordion-button collapsed flex-grow-1 text-start"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#module{{ $section->sec_id }}">
                                                    <span class="flex-grow-1 fw-bold">
                                                        {{ $section->name }} -
                                                        {{ $section->lectures ? $section->lectures->count() : 0 }}
                                                        bài giảng
                                                    </span>
                                                    <span class="text-end me-3">Thời lượng
                                                        {{ $section->duration }}</span>
                                                </button>

                                                <!-- Action Icons -->
                                                <div class="ms-2 d-flex align-items-center">
                                                    <!-- Edit icon -->
                                                    <!-- Edit icon trigger -->
                                                    <button type="button" class="btn btn-link text-dark p-0 m-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editSectionModal{{ $section->sec_id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <!-- Edit Section Modal -->
                                                    <div class="modal fade" id="editSectionModal{{ $section->sec_id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editSectionModalLabel{{ $section->sec_id }}"
                                                        aria-hidden="true">
                                                        <form action="{{ route('sections.update', $section->sec_id) }}"
                                                            method="POST" class="modal-dialog">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editSectionModalLabel{{ $section->sec_id }}">
                                                                        Chỉnh sửa phần học</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Đóng"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="sectionName{{ $section->sec_id }}"
                                                                            class="form-label">Tên phần học</label>
                                                                        <input type="text" name="name"
                                                                            id="sectionName{{ $section->sec_id }}"
                                                                            class="form-control"
                                                                            value="{{ $section->name }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="sectionDescription{{ $section->sec_id }}"
                                                                            class="form-label">Mô tả</label>
                                                                        <textarea name="description" id="sectionDescription{{ $section->sec_id }}" class="form-control" rows="3">{{ $section->description }}</textarea>
                                                                    </div>
                                                                    <input type="hidden" name="course_id"
                                                                        value="{{ $course->id }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Cập
                                                                        nhật</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <!-- Delete icon -->
                                                    <form action="{{ route('sections.destroy', $section->sec_id) }}"
                                                        method="POST" class="d-inline" name="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-link text-dark not-last:p-0 m-0">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </h2>

                                        <div id="module{{ $section->sec_id }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <ul class="list-unstyled m-0">
                                                    @foreach ($section->lectures as $lecture)
                                                        <li
                                                            class="d-flex justify-content-between py-2 border-bottom border-dark">
                                                            @if ($lecture->is_intro)
                                                                {{-- <a
                                                                    href="{{ route('user.course-video', ['course' => $course->slug, 'lecture' => $lecture->id]) }}">
                                                                    <span>{{ $lecture->title }}</span>
                                                                    <i class="bi bi-play-circle-fill ms-2"></i>
                                                                </a> --}}
                                                                <span>{{ $lecture->title }} </span>
                                                            @else
                                                                {{-- <a href="#"
                                                                    class="text-decoration-none text-secondary opacity-75 pe-none">
                                                                    <span>{{ $lecture->title }}</span>
                                                                    <i class="bi bi-lock-fill"></i>
                                                                </a> --}}
                                                                <span>{{ $lecture->title }}</span>
                                                            @endif

                                                            <div class="">
                                                                <!-- Edit lecture -->
                                                                <a href="{{ route('lectures.edit', ['lecture' => $lecture->lec_id]) }}"
                                                                    type="button" class="btn btn-link text-dark p-0 m-0">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <!-- Delete lecture -->
                                                                <form
                                                                    action="{{ route('lectures.destroy', ['lecture' => $lecture->lec_id]) }}"
                                                                    method="POST" class="d-inline" name="delete-form">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-link text-dark not-last:p-0 m-0">
                                                                        <i class="bi bi-x-lg"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                    <a href="{{ route('lectures.create', ['sec_id' => $section->sec_id]) }}"
                                                        class="btn btn-primary mt-3">
                                                        <i class="bi bi-plus-lg"></i>
                                                        Thêm bài giảng
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const deleteForms = document.querySelectorAll('form[name="delete-form"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Bạn chắc chắn muốn xóa?",
                        text: "Thao tác không thể hoàn tác!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
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
