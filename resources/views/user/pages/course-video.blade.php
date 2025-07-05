@extends('layouts.user')
@section('user.content')
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
                <a class="navbar-brand fw-bold" href="{{ route('user.home') }}">
                    <i class="bi bi-play-circle"></i> CourseWeb
                </a>

                <div class="ms-auto">
                    <a href="{{ route('user.courses.show', ['course' => $course->slug]) }}" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Thoát
                    </a>
                </div>
            </nav>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
            @endif

            <!-- Main Content - Video Player & Lesson Details -->
            <main class="col-lg-8 col-md-8 px-4">
                <div class="mt-3">
                    @if ($lecture->type === App\Enums\LectureEnum::VIDEO->value)
                        <!-- Video Player -->
                        <div class="ratio ratio-16x9">
                            <video id="course-video" class="video-js vjs-big-play-centered" controls preload="auto">
                                <source src="{{ $lecture->video->video_url }}" type="video/mp4">
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a
                                    web browser that <a href="https://videojs.com/html5-video-support/"
                                        target="_blank">supports
                                        HTML5 video</a>
                                </p>
                            </video>
                        </div>

                        <script>
                            console.log("OK")
                            document.addEventListener('DOMContentLoaded', function() {
                                var player = videojs('course-video', {
                                    fluid: true,
                                    controls: true,
                                    playbackRates: [0.5, 1, 1.5, 2],
                                    controlBar: {
                                        children: [
                                            'playToggle',
                                            'volumePanel',
                                            'currentTimeDisplay',
                                            'timeDivider',
                                            'durationDisplay',
                                            'progressControl',
                                            'playbackRateMenuButton',
                                            'fullscreenToggle'
                                        ]
                                    }
                                });
                            });
                        </script>
                    @elseif ($lecture->type === App\Enums\LectureEnum::ARTICLE->value)
                        <!-- Article Content -->
                        {{-- <div class="border p-3 rounded" style="max-height: 400px; overflow-y: auto;">
                            {!! $lecture->article->content !!}
                        </div> --}}

                        <textarea name="lecture-article" class="article-content" cols="30" rows="10">
                            {{ $lecture->article->content ?? '' }}
                        </textarea>
                    @else
                        <!-- Placeholder for non-video lectures -->
                        <div class="alert alert-info" role="alert">
                            This lecture does not contain a video. Please check the resources or notes provided.
                        </div>
                    @endif

                    <!-- Lesson Title -->
                    <h3 class="mt-4 fw-bold">{{ $lecture->title }}</h3>

                    <nav class="nav nav-tabs">
                        <a href="#course-overview" class="nav-item nav-link" data-bs-toggle="tab">Tổng quan</a>
                        <a href="#course-attachments" class="nav-item nav-link" data-bs-toggle="tab">Tài liệu</a>
                        <a href="#user-course-notes" class="nav-item nav-link" data-bs-toggle="tab">Ghi chú</a>
                        <a href="#course-faq" class="nav-item nav-link" data-bs-toggle="tab">Hỏi đáp</a>
                        <a href="#course-ratings" class="nav-item nav-link" data-bs-toggle="tab">Đánh giá</a>
                    </nav>

                    <div class="tab-content">
                        <div class="tab-pane show fade"></div>
                        <div class="tab-pane show fade" id="course-attachments">
                            <ul class="list-group mb-3">
                                <li class="list-group-item">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                    <a href="#">Lecture Notes - Introduction.pdf</a>
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-file-earmark-word"></i>
                                    <a href="#">Course Outline.docx</a>
                                </li>
                            </ul>

                        </div>
                        <div class="tab-pane show fade" id="user-course-notes">
                            <!-- Select Note Scope -->
                            <div class="d-flex flex-row mt-3">
                                <div class="me-3">
                                    <label for="note-scope" class="form-label fw-bold">Loại ghi chú</label>
                                    <select id="note-scope" class="form-select">
                                        <option value="lecture">Bài giảng hiện tại</option>
                                        <option value="course">Toàn bộ khóa học</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="note-scope" class="form-label fw-bold">Thứ tự</label>
                                    <select id="note-scope" class="form-select">
                                        <option value="lecture">Mới nhất trước</option>
                                        <option value="course">Cũ nhất trước</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <!-- Note Taking Section -->
                            <label for="note-content" class="form-label fw-bold">Tạo ghi chú</label>
                            <form id="note-form" method="POST">
                                @csrf
                                <input type="hidden" name="lecture" value="{{ $lecture->lec_id }}">
                                <textarea id="note-content" class="form-control" name="content" rows="10" style="min-height: 200px;"
                                    placeholder="Write your notes here..."></textarea>

                                <button id="save-note" class="btn btn-primary mt-2" type="submit">
                                    <i class="bi bi-floppy"></i> Lưu
                                </button>
                            </form>

                            <!-- Hiển thị lỗi -->
                            <div id="note-error" class="mt-2 text-danger fw-bold"></div>

                            <!-- Hiển thị thành công -->
                            <div id="note-success" class="mt-2 text-success fw-bold"></div>


                            <hr>

                            <!-- Ghi chú đã tạo -->
                            <h5 class="mt-4 mb-3 fw-bold">Ghi chú của bạn</h5>
                            <div id="note-list" class="mt-3">
                                <!-- Ghi chú sẽ được chèn vào đây bằng JavaScript -->
                            </div>
                            {{-- @foreach ($notes as $note)
                                <div class="border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>{{ $note->lecture->title ?? 'Toàn khóa học' }}</strong>
                                        <span class="text-muted small">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                                    </div>

                                    <textarea class="form-control mb-2" rows="4" readonly>{{ $note->content }}</textarea>

                                    <div class="d-flex gap-2">
                                        <!-- Nút sửa -->
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editNoteModal" data-id="{{ $note->id }}"
                                            data-content="{{ $note->content }}">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </button>

                                        <!-- Nút xóa -->
                                        <form action="{{ route('user.notes.destroy', $note->id) }}" method="POST"
                                            onsubmit="return confirm('Xóa ghi chú này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach --}}

                        </div>
                        <div class="tab-pane show fade"></div>
                        <div class="tab-pane show fade"></div>
                    </div>

                    <!-- Next/Previous Buttons -->
                    <div class="d-flex justify-content-between my-4">
                        <a href="" class="btn border-dark">&larr; Bài trước</a>
                        <a href="" class="btn border-dark">Bài kế tiếp &rarr;</a>
                    </div>
                </div>
            </main>

            <!-- Right Sidebar - Course Lessons -->
            <nav class="col-lg-4 col-md-4 d-none d-md-block bg-light sidebar p-3">
                <h4 class="mb-3">Nội dung khóa học</h4>

                <!-- Accordion for Course Content -->
                <div class="accordion" id="courseAccordion">
                    @foreach ($course->sections as $section)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    class="accordion-button fw-bold {{ $section->lectures->contains($lecture) ? '' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#section{{ $section->sec_id }}"
                                    aria-expanded="{{ $section->lectures->contains($lecture) ? 'true' : 'false' }}"
                                    aria-controls="section{{ $section->sec_id }}">
                                    {{ $section->name }}
                                </button>
                            </h2>
                            <div id="section{{ $section->sec_id }}"
                                class="accordion-collapse collapse 
                                {{ $section->lectures->contains($lecture) ? 'show' : '' }}"
                                data-bs-parent="#courseAccordion">
                                <div class="accordion-body">
                                    <ul class="list-group">
                                        @foreach ($section->lectures as $lec)
                                            <li class="list-group-item">
                                                <a href="{{ route('user.course-video.show', ['course' => $course->slug, 'lecture' => $lec]) }}"
                                                    class="{{ $lec->lec_id == $lecture->lec_id ? 'text-primary' : 'text-dark text-opacity-75' }}">
                                                    {{ $lec->title }}
                                                    @if ($lec->lec_id == $lecture->lec_id)
                                                        <i class="bi bi-play-circle-fill"></i>
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </nav>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#note-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const url = '{{ route('notes.store') }}';
                const data = form.serialize();

                // Reset thông báo
                $('#note-error').html('');
                $('#note-success').html('');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#note-success').text('Ghi chú đã được lưu thành công.');
                        $('#note-content').val('');
                        // fetchLectureNotes({{ $lecture->lec_id }});
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                $('#note-error').append(errors[field][0] + '<br>');
                            }
                        } else {
                            $('#note-error').text('Đã có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    }
                });
            });

            // fetchLectureNotes({{ $lecture->lec_id }});

            function fetchLectureNotes(lectureId) {
                $.ajax({
                    url: `/lecture/${lectureId}/notes`,
                    method: 'GET',
                    success: function(response) {
                        console.log(response.notes); // hoặc hiển thị ra DOM
                        displayNotes(response.notes);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr, status, error);
                        alert('Không thể tải ghi chú.');
                    }
                });
            }

            function displayNotes(notes) {
                let html = '';
                notes.forEach(note => {
                    html += `
            <div class="mb-3">
                <strong class="mb-2">${note.lecture.title} - ${formatDate(note.created_at)}</strong>
                ${note.content}
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editNoteModal" data-id="${note.id}"
                        data-content="${note.content}">
                        <i class="bi bi-pencil"></i> Sửa
                    </button>
                    <form action="" method="POST" onsubmit="return confirm('Xóa ghi chú này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        `;
                });

                $('#note-list').html(html);

                // ✅ Re-initialize TinyMCE on newly inserted elements
                tinymce.init({
                    selector: 'textarea.article-content',
                    plugins: 'code table lists',
                    toolbar: false,
                    menubar: false,
                    statusbar: false,
                    readonly: 1,
                    content_css: false,
                    branding: false
                });
            }

            function formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN');
            }
        </script>
    @endpush

@endsection
