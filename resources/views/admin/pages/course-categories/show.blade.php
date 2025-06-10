@extends('layouts.admin')

@section('admin.content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chi tiết danh mục khóa học
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Tên danh mục:</label>
                    <p>{{ $courseCategory->cc_name }}</p>
                </div>
                <div class="form-group">
                    <label>Ảnh biểu tượng (icon):</label>
                    <div class="mt-2">
                        <img src="{{ $courseCategory->icon_path }}" alt="" class="img-fluid" width="100">
                    </div>
                </div>
                <div class="form-group">
                    <label>Danh mục cha:</label>
                    <p>{{ $courseCategory->parent?->cc_name }}</p>
                </div>
                <div class="form-group">
                    <label>Trạng thái:</label>
                    <p>{{ $courseCategory->status ? 'Hiển thị' : 'Ẩn' }}</p>
                </div>
                <div class="form-group">
                    <label>Ngày tạo:</label>
                    <p>{{ $courseCategory->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
