@extends('layouts.admin')
@section('admin.content')
    <div class="container-fluid p-5">
        <h3>Chỉnh sửa Trang Tĩnh</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pages.update',$page) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $page->title) }}" required>
            </div>

            @php
                use App\Enums\StaticPageTypeEnum;
            @endphp

            <div class="mb-3">
                <label for="type" class="form-label">Loại trang (tùy chọn)</label>
                <select name="type" id="type" class="form-select">
                    <option value="">-- Chọn loại trang --</option>
                    @foreach (StaticPageTypeEnum::cases() as $type)
                        <option value="{{ $type->value }}"
                            {{ old('type', $page->type) === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea name="content" id="page-create" class="form-control" style="min-height: 200px;"
                    placeholder="Nhập nội dung trang">{{ old('content', $page->content) }}</textarea>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                    {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Hiển thị công khai</label>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('pages.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    @vite(['resources/js/app.js'])
@endsection
