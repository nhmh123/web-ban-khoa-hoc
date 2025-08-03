@extends('layouts.admin')

@section('admin.content')
    <div class="container-fluid py-4 position-relative">

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

                    <!-- Form Video -->
                    <div id="video_form">
                        <small class="text-muted">
                            Cho phép: .mp4, .mov, .avi,.wmv, .mkv, .flv
                        </small>
                        <br>
                        <small class="text-muted">
                            Dung lượng tối đa: 500MB
                        </small>
                        <div class="mb-3">
                            <label for="course-video" class="form-label fw-bold">Video bài giảng </label>
                            <label class="delete-preview-button btn btn-danger  mb-2 ">Xóa video</label>

                            <input type="file" name="course_video" id="course-video" class="form-control">
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-animate bg-primary" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            </div>
                        </div>
                        <div class="ratio ratio-16x9" id="video-preview-wrapper" style="display: none;">
                            <video id="video-preview" controls></video>
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
        <!-- Overlay loading chỉ trong container -->
        <div id="form-overlay"
            style="
    display: none;
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(255, 255, 255, 0.7);
    z-index: 999;
    justify-content: center;
    align-items: center;
">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $(function() {
                    $('input[type="radio"][name="type"]:checked').trigger('change');
                });

                let type = $('input[type="radio"][name="type"]:checked').val();
                if (type == "video") {
                    $('#article_form').find('textarea').prop('disabled', true)
                } else if (type == "article") {
                    $('#video_form').find('input[name="video_url"]').prop('disabled', true)
                } else {
                    return;
                }

                $('input[type="radio"][name="type"]').change(function() {
                    if ($(this).val() === "video") {
                        $('#video_form').show().find('input, video').prop('disabled', false);
                        $('#article_form').hide().find('textarea').prop('disabled', true);
                    } else {
                        $('#video_form').hide().find('input, video').prop('disabled', true);
                        $('#article_form').show().find('textarea').prop('disabled', false);
                    }
                });
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

                // ----------Preview video------------
                const videoInput = $('input[type="file"][name="course_video"]');
                const videoPreview = $('#video-preview');
                const deletePreviewButton = $('.delete-preview-button');
                videoInput.on('change', function(e) {
                    const file = e.target.files[0];

                    if (file) {
                        if (file.size > 500 * 1024 * 1024) {
                            alert("File quá lớn. Vui lòng chọn file dưới 500MB.");
                            videoInput.val() = "";
                        }

                        const videoUrl = URL.createObjectURL(file);
                        console.log(videoUrl);

                        videoPreview.attr('src', videoUrl);
                        videoPreview.closest('.ratio').show();

                        const previousUrl = videoPreview.data('previousUrl');
                        if (previousUrl) {
                            URL.revokeObjectURL(previousUrl);
                        }

                        videoPreview.data('previousUrl', videoUrl);
                    }
                })
                deletePreviewButton.on('click', function() {
                    videoPreview.attr('src', '');
                    videoPreview.closest('.ratio').hide();
                })

                $('#create-course-form').on('submit', function() {
                    $('#form-overlay').fadeIn();
                    $('#form-overlay').css('display', 'flex');
                    // $('#create-course-form').find('input, textarea, button, select').prop('disabled', true);
                });

                // console.log(videoInput, videoPreview)
            })
        </script>
    @endpush
@endsection
