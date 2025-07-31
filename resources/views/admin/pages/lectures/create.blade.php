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
            <div class="card-header font-weight-bold fs-3">
                Thêm bài giảng mới
            </div>

            <div class="card-body">
                <form id="create-course-form" action="{{ route('lectures.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="sec_id" value="{{ $sec_id }}">
                    <!-- Tên bài giảng -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Tiêu đề bài giảng</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <!-- Là bài giới thiệu? -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_intro" class="form-check-input" id="is_intro">
                        <label class="form-check-label" for="is_intro" {{ old('is_intro') ? 'checked' : '' }}>Là bài giảng
                            giới thiệu?</label>
                    </div>

                    <!-- Loại bài giảng -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Loại bài giảng</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_video" value="video"
                                {{ old('type') == 'video' ? 'checked' : '' }} checked>
                            <label class="form-check-label" for="type_video">Video</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_article" value="article"
                                {{ old('type') == 'article' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_article">Bài viết</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-3">
                            <label for="course-video" class="form-label fw-bold">Video bài giảng</label>
                            <input type="file" name="course_video" id="course-video" class="form-control">
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-animate bg-primary" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
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

                    {{-- Attachment --}}
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="attachments" class="form-label fw-bold">Tài liệu bài giảng</label>
                            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu bài giảng</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let type = $('input[type="radio"][name="type"]:checked').val();
                if (type == "video") {
                    $('#article_form').find('textarea').prop('disabled', true)
                } else if (type == "article") {
                    $('#video_form').find('input[name="video_url"]').prop('disabled', true)
                } else {
                    return;
                }

                $('input[type="radio"][name="type"]').change(function() {
                    if ($(this).val() == "video") {
                        $('#video_form').find('input[name="video_url"]').prop('disabled', false)
                        $('#article_form').find('textarea').prop('disabled', true)
                    } else if ($(this).val() == "article") {
                        $('#video_form').find('input[name="video_url"]').prop('disabled', true)
                        $('#article_form').find('textarea').prop('disabled', false)
                    }
                })

                // $('#create-course-form').ajaxForm({
                //     beforeSend: function() {
                //         var percentage = '0';
                //     },
                //     uploadProgress: function(event, position, total, percentComplete) {
                //         var percentage = percentComplete;
                //         $('.progress .progress-bar').css('width', percentage + '%', function() {
                //             return $(this).attr('aria-valuenow', percentage) + '%';
                //         })
                //     },
                //     complete: function(xhr) {
                //         console.log('file uploaded');
                //     }
                // });
            })
        </script>
    @endpush
@endsection
