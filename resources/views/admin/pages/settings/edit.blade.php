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
                <h5>Cấu hình Meta (SEO)</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="site_name" class="form-label fw-bold">Tên Website</label>
                        <input type="text" class="form-control" id="site_name" name="site_name"
                            value="{{ $settings['meta.site_name'] ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label fw-bold">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                            value="{{ $settings['meta.title'] ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ $settings['meta.description'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="favicon" class="form-label fw-bold">Favicon (PNG, ICO, SVG)</label>
                        <input class="form-control" type="file" id="favicon" name="favicon">
                        @if (!empty($settings['favicon']))
                            <div class="mt-2">
                                <img src="{{ $settings['favicon'] }}" alt="favicon" style="height: 32px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
                </form>

            </div>
        </div>
    </div>
@endsection
