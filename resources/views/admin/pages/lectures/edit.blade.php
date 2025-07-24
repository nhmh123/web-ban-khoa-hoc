@extends('layouts.admin')

@section('admin.content')
    <div class="container-fluid py-4">

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
                Chỉnh sửa bài giảng
            </div>

            <div class="card-body">
                <form action="{{ route('lectures.update', ['lecture' => $lecture->lec_id]) }}" method="POST">
                    @csrf
                    @METHOD('PATCH')
                    <!-- Tên bài giảng -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề bài giảng</label>
                        <input type="text" name="title" class="form-control" value="{{ $lecture->title }}" required>
                    </div>

                    <!-- Là bài giới thiệu? -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_intro" class="form-check-input" id="is_intro"
                            {{ old('is_intro') || (!empty($lecture) && $lecture->is_intro) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_intro">Là bài giảng giới thiệu</label>
                    </div>

                    <!-- Loại bài giảng -->
                    <div class="mb-3">
                        <label class="form-label">Loại bài giảng</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_video" value="video"
                                {{ old('type', $lecture->type ?? 'video') == 'video' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_video">Video</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_article" value="article"
                                {{ old('type', $lecture->type ?? '') == 'article' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_article">Bài viết</label>
                        </div>
                    </div>

                    <!-- Form Video -->
                    <div id="video_form">
                        <div class="mb-3">
                            <label for="video_url" class="form-label">URL video</label>
                            <input type="url" name="video_url" class="form-control"
                                value="{{ old('video_url') ?? ($lecture->video->video_url ?? '') }}">
                        </div>

                    </div>

                    <!-- Form Article -->
                    <div id="article_form">
                        <div class="mb-3">
                            <label for="article_content" class="form-label">Nội dung bài viết</label>
                            <textarea id="article-create" name="article_content" class="form-control" rows="4">
                                {{ old('content') ?? ($lecture->article->content ?? '') }}
                            </textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let type = $('input[type="radio"][name="type"]:checked').val();
                if (type == "video") {
                    $('#article_form').addClass('d-none');
                } else if (type == "article") {
                    $('#video_form').find('input[name="video_url"]').prop('disabled', true)
                } else {
                    return;
                }

                $('input[type="radio"][name="type"]').change(function() {
                    if ($(this).val() == "video") {
                        $('#video_form').find('input[name="video_url"]').prop('disabled', false)
                        $('#article_form').addClass('d-none')
                    } else if ($(this).val() == "article") {
                        $('#video_form').find('input[name="video_url"]').prop('disabled', true)
                        $('#article_form').removeClass('d-none');
                    }
                })
            })
        </script>
    @endpush
@endsection
