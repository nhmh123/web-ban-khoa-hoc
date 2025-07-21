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
                <h5>Cấu hình Email</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('settings.email.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="MAIL_HOST" class="form-label fw-bold">Mail Host</label>
                        <input type="text" class="form-control" id="MAIL_HOST" name="MAIL_HOST"
                            value="{{ setting('mail.host') ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="MAIL_PORT" class="form-label fw-bold">Mail Port</label>
                        <input type="text" class="form-control" id="MAIL_PORT" name="MAIL_PORT"
                            value="{{ setting('mail.port') ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="MAIL_USERNAME" class="form-label fw-bold">Mail Username</label>
                        <input type="text" class="form-control" id="MAIL_USERNAME" name="MAIL_USERNAME"
                            value="{{ setting('mail.username') ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="MAIL_PASSWORD" class="form-label fw-bold">Mail Password</label>
                        <input type="text" class="form-control" id="MAIL_PASSWORD" name="MAIL_PASSWORD"
                            value="{{ setting('mail.password') ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="MAIL_FROM_ADDRESS" class="form-label fw-bold">Mail From Address</label>
                        <input type="email" class="form-control" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS"
                            value="{{ setting('mail.from_address') ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="MAIL_FROM_NAME" class="form-label fw-bold">Mail From Name</label>
                        <input type="text" class="form-control" id="MAIL_FROM_NAME" name="MAIL_FROM_NAME"
                            value="{{ setting('mail.from_name') ?? '' }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
                </form>
            </div>
        </div>
    </div>
@endsection
