@extends('layouts.admin')
@section('admin.content')
    <div class="container-fluid p-5">
        <h3>Tạo Trang Tĩnh Mới</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
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
                            {{ old('type', $page->type ?? '') === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea name="content" id="page-create" class="form-control" style="min-height: 200px;"
                    placeholder="Nhập nội dung trang" required>{{ old('content') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Tạo mới</button>
            <a href="{{ route('pages.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
