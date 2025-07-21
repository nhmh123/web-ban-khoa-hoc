@extends('layouts.admin')

@section('admin.content')
    <div class="container mt-4">
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thêm Slider mới</h5>
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary btn-sm">Quay lại</a>
            </div>
            <div class="card-body">
                <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Thứ tự hiển thị</label>
                        <input type="number" name="order" class="form-control" min="0"
                            value="{{ old('order', 0) }}">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Lưu Slider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
