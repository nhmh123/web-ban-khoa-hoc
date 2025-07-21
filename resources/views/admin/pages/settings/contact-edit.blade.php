@extends('layouts.admin')

@section('admin.content')
    <div class="container-fluid mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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
        <div class="card">
            <div class="card-header">
                <h5>Cấu hình Thông tin Liên hệ</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('settings.contact.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="contact_email" class="form-label fw-bold">Email liên hệ</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email"
                            value="{{ $settings['contact.email'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="contact_phone" class="form-label fw-bold">Hotline</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                            value="{{ $settings['contact.phone'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="contact_address" class="form-label fw-bold">Địa chỉ</label>
                        <textarea class="form-control" id="contact_address" name="contact_address" rows="3">{{ $settings['contact.address'] ?? '' }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
                </form>
            </div>
        </div>
    </div>
@endsection
