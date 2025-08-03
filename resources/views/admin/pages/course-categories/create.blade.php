@extends('layouts.admin')

@section('admin.content')
    <div id="content" class="container-fluid">
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
                Thêm danh mục khóa học
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('ccategories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="cc_name">Tên danh mục</label>
                        <input class="form-control" type="text" name="cc_name" id="cc_name"
                            value="{{ old('cc_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Danh mục cha</label>
                        <select class="form-control" name="parent_id" id="parent_id">
                            <option value="">-- Không chọn --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->cc_id }}"
                                    {{ old('parent_id') == $category->cc_id ? 'selected' : '' }}>
                                    {{ $category->cc_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label><br>
                        <input type="checkbox" name="status" id="status" value="1"
                            {{ old('status', true) ? 'checked' : '' }}>
                        <label for="status">Hiển thị</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelector('input[name="icon_path"]').addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('icon-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
