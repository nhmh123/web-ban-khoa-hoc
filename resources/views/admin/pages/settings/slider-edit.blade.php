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
                <h5 class="mb-0">Chỉnh sửa Slider</h5>
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary btn-sm">Quay lại</a>
            </div>
            <div class="card-body">
                <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if ($slider->image)
                            <div class="mt-2">
                                <img src="{{ asset($slider->image) }}" alt="Slider Image" style="max-width: 200px;">
                            </div>
                        @endif
                        <small class="text-muted">Để trống nếu không muốn thay đổi ảnh.</small>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Thứ tự hiển thị</label>
                        <input type="number" name="order" class="form-control" min="0" max=99
                            value="{{ old('order', $slider->order) }}">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Cập nhật Slider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
