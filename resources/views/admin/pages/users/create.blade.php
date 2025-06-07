@extends('layouts.admin')
@section('admin.content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-header font-weight-bold">
                Thêm người dùng
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">Nhập lại mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="email">
                    </div>

                    <div class="form-group">
                        <label>Ảnh đại diện</label>
                        <input type="file" name="avatar" class="form-control">
                        <div class="mt-2">
                            <img src="" alt="" class="img-fluid" width="100" id="avatar-preview">
                        </div>

                        {{-- <div class="form-group">
                        <label for="">Nhóm quyền</label>
                        <select class="form-control" id="">
                            <option>Chọn quyền</option>
                            <option>Danh mục 1</option>
                            <option>Danh mục 2</option>
                            <option>Danh mục 3</option>
                            <option>Danh mục 4</option>
                        </select>
                    </div> --}}

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelector('input[name="avatar"]').addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('avatar-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
