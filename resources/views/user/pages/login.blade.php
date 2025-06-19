@extends('layouts.user')
@section('user.content')
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-4">Đăng nhập</h4>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="Nhập địa chỉ email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu"
                        required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </div>
            </form>

            <div class="text-center my-3 text-muted small">
                — Hoặc —
            </div>

            <div class="d-grid gap-2">
                <a href="#" class="btn btn-danger">
                    <i class="bi bi-google"></i> Đăng nhập bằng Google
                </a>
                <a href="{{ route('user.register') }}" class="btn btn-outline-secondary">
                    Đăng ký tài khoản mới
                </a>
            </div>
        </div>
    </div>
@endsection
