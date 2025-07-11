@extends('layouts.admin')

@section('title', 'Thêm khóa học')

@section('admin.content')
    <div class="container-fluid p-5">
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
                Thêm Khóa Học
            </div>
            <div class="card-body">
                <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Tên khóa học</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="thumbnail" class="form-label fw-bold">Ảnh đại diện</label>
                                <input type="file" class="form-control" name="thumbnail" id="thumbnail">
                                <div class="mt-2">
                                    <img src="" alt="" class="img-fluid" width="100"
                                        id="thumbnail-preview">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="original_price" class="form-label fw-bold">Giá gốc</label>
                                <div class="d-flex">
                                    <input type="number" step="0.01" name="original_price" id="original_price"
                                        class="form-control" value="{{ old('original_price') }}">
                                    <span>VNĐ</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="short_description" class="form-label fw-bold">Mô tả ngắn</label>
                                <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ old('short_description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="enroll_requirements" class="form-label fw-bold">Yêu cầu ghi danh</label>
                                <textarea name="enroll_requirements" id="enroll_requirements" class="form-control" rows="3">{{ old('enroll_requirements') }}</textarea>
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="audience" class="form-label fw-bold">Đối tượng</label>
                                <textarea name="audience" id="audience" class="form-control" rows="3">{{ old('audience') }}</textarea>
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
                                                {{ old('status') === $enum->value ? 'selected' : '' }}>
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
                                <label for="category-select" class="form-label fw-bold">Danh mục</label>
                                <select name="cat_id" id="category-select" class="form-control">
                                    <option value="" selected>--Chọn danh mục--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->cc_id }}"
                                            {{ old('cat_id') == $category->cc_id ? 'selected' : '' }}>
                                            {{ $category->cc_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-inline-flex mb-3">
                                <label for="language-select" class="form-label fw-bold">Ngôn ngữ</label>
                                <select name="language_id" id="language-select" class="form-control">
                                    <option value="" selected>--Chọn ngôn ngữ--</option>
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang->lang_id }}"
                                            {{ old('language_id') == $lang->lang_id ? 'selected' : '' }}>
                                            {{ $lang->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="level-select" class="form-label fw-bold">Trình độ</label>
                                <select name="level_id" id="level-select" class="form-control">
                                    <option value="" selected>--Chọn trình độ--</option>
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
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Nội dung khóa học</label>
                        <textarea name="content" id="content" class="form-control" rows="4">{{ old('content') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm khóa học</button>
                </form>
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
