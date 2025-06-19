@extends('layouts.user')

@section('user.content')
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header text-center fw-bold">
                Cập nhật hồ sơ cá nhân
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.profile.update', ['user' => $user]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Để trống nếu không thay đổi">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                        <input type="file" name="avatar" id="avatar" class="form-control">
                        @if (auth()->user()->avatar)
                            <div class="mt-2">
                                <img id="avatar-preview" src="{{ auth()->user()->avatar }}" class="img-thumbnail"
                                    width="100">
                            </div>
                        @endif
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#avatar').on('change', function() {
                    const file = this.files[0];
                    console.log(file)
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#avatar-preview').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
    @endpush
@endsection
