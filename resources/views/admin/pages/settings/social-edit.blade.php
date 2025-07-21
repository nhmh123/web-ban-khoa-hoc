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
                <h5>Cấu hình Mạng xã hội</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('settings.social.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="facebook" class="form-label fw-bold d-flex align-items-center gap-2">
                            <img src="{{ asset('images/icons/facebook.svg') }}" alt="Facebook" width="20"
                                height="20">
                            Facebook
                        </label>
                        <input type="url" class="form-control" name="facebook" id="facebook"
                            value="{{ $settings['social.facebook'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="x" class="form-label fw-bold d-flex align-items-center gap-2">
                            <img src="{{ asset('images/icons/x.svg') }}" alt="X" width="20" height="20">
                            X (Twitter)
                        </label>
                        <input type="url" class="form-control" name="x" id="x"
                            value="{{ $settings['social.x'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="linkedin" class="form-label fw-bold d-flex align-items-center gap-2">
                            <img src="{{ asset('images/icons/linkedin.svg') }}" alt="LinkedIn" width="20"
                                height="20">
                            LinkedIn
                        </label>
                        <input type="url" class="form-control" name="linkedin" id="linkedin"
                            value="{{ $settings['social.linkedin'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="instagram" class="form-label fw-bold d-flex align-items-center gap-2">
                            <img src="{{ asset('images/icons/instagram.svg') }}" alt="Instagram" width="20"
                                height="20">
                            Instagram
                        </label>
                        <input type="url" class="form-control" name="instagram" id="instagram"
                            value="{{ $settings['social.instargram'] ?? '' }}">
                    </div>


                    <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
                </form>
            </div>
        </div>
    </div>
@endsection
