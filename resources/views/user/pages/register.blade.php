@extends('layouts.user')

@section('user.content')
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-4">Đăng ký</h4>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
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

            <form action="{{ route('user.register.submit', ['redirectRoute' => 'user.home']) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" name="name" id="name"
                        placeholder="Nhập họ tên đầy đủ" required value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="Nhập địa chỉ email" required value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu"
                        required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                        placeholder="Nhập lại mật khẩu" required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Đăng ký</button>
                </div>
            </form>

            <div class="text-center text-muted small">
                Đã có tài khoản? <a href="{{ route('user.login') }}">Đăng nhập</a>
            </div>
        </div>
    </div>
@endsection
