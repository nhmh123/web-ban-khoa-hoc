@extends('layouts.user')
@section('user.content')
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
                <a class="navbar-brand fw-bold" href="{{ route('user.home') }}">
                    <i class="bi bi-play-circle"></i> CourseWeb
                </a>

                <div class="mx-auto text-center text-white d-none d-lg-block">
                    <div class="small">
                        <span class="fs-5">Đã học: {{ $totalCompleted }}/{{ $totalLectures }} bài</span> ·
                        <span class="fs-5">Hoàn thành: {{ $completion }}%</span>
                    </div>
                    <div class="progress" style="height: 10px; width: 300px; margin: 0 auto;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $completion }}%;"
                            aria-valuenow="{{ $completion }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

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
                            <video id="course-video" class="video-js  vjs-tech vjs-big-play-centered" controls
                                preload="auto" controlsList="nodownload" oncontextmenu="return false;">
                                <source src="{{ $url }}" type="video/mp4">
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a
                                    web browser that <a href="https://videojs.com/html5-video-support/"
                                        target="_blank">supports
                                        HTML5 video</a>
                                </p>
                            </video>
                        </div>

                        <script>
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
                        <div class="border p-3 rounded" style="max-height: 400px; overflow-y: auto;">
                            {!! $lecture->article->content !!}
                        </div>
                    @else
                        <!-- Placeholder for non-video lectures -->
                        <div class="alert alert-info" role="alert">
                            This lecture does not contain a video. Please check the resources or notes provided.
                        </div>
                    @endif

                    <h3 class="mt-4 fw-bold">{{ $lecture->title }}</h3>

                    <nav class="nav nav-tabs">
                        <a href="#course-attachments" class="nav-item nav-link" data-bs-toggle="tab">Tài liệu</a>
                        <a href="#user-course-notes" class="nav-item nav-link" data-bs-toggle="tab">Ghi chú</a>
                        <a href="#course-ratings" class="nav-item nav-link" data-bs-toggle="tab">Đánh giá</a>
                    </nav>

                    <div class="tab-content">
                        <div class="tab-pane show fade" id="course-attachments">
                            @if (!$attachments->isEmpty())
                                <ul class="list-group mb-3">
                                    @foreach ($attachments as $attachment)
                                        <li class="list-group-item">
                                            <a
                                                href="{{ route('attachments.download', $attachment) }}">{{ $attachment->attachment_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="tab-pane show fade" id="user-course-notes">
                            <div class="note-errors alert alert-danger d-none">
                                <ul></ul>
                            </div>

                            <label for="note-content" class="form-label fw-bold mt-2">Tạo ghi chú</label>
                            <form id="note-form" method="POST">
                                @csrf
                                <input type="hidden" name="lecture" value="{{ $lecture->lec_id }}">
                                <textarea class="form-control" name="content" rows="5" style="min-height: 100px;"
                                    placeholder="Write your notes here..."></textarea>

                                <button id="save-note" class="btn btn-primary mt-2" type="submit">
                                    <i class="bi bi-floppy"></i> Lưu
                                </button>
                            </form>
                            <hr>

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

                            <!-- Ghi chú đã tạo -->
                            <h5 class="mt-4 mb-3 fw-bold">Ghi chú của bạn</h5>
                            <div id="note-list" class="mt-3">

                            </div>
                        </div>
                        <div class="tab-pane show fade" id="course-ratings">
                            <div class="position-relative">
                                <div id="review-overlay"
                                    class="overlay d-flex justify-content-center align-items-center text-white bg-dark bg-opacity-75"
                                    style="position: absolute; inset: 0; border-radius: .375rem; z-index: 2; {{ $completion >= 100 ? 'display: none;' : '' }}">
                                    <span class="fw-bold">Bạn cần hoàn thành 100% tiến độ để đánh giá</span>
                                </div>

                                <form id="review-form" method="POST" action="{{ route('reviews.store') }}"
                                    class="border p-4 rounded shadow-sm bg-white" style="position: relative; z-index: 1;">
                                    @csrf
                                    <div class="mb-3 d-flex align-item-center">
                                        <label class="form-label align-content-center m-0 fw-bold">Đánh giá của
                                            bạn:</label>
                                        <select class="star-rating" name="rating" required
                                            {{ $completion < 100 ? 'disabled' : '' }}>
                                            <option value="5"></option>
                                            <option value="4"></option>
                                            <option value="3"></option>
                                            <option value="2"></option>
                                            <option value="1"></option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="comment" class="form-label fw-bold">Nhận xét của bạn:</label>
                                        <textarea name="comment" class="form-control" rows="3" placeholder="Hãy chia sẻ cảm nhận..." required
                                            {{ $completion < 100 ? 'disabled' : '' }}></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100"
                                        {{ $completion < 100 ? 'disabled' : '' }}>Gửi đánh giá</button>
                                </form>
                            </div>


                            <section name="course-reviews" class="mt-4">

                            </section>
                        </div>

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
                                    <div class="d-block w-100">
                                        {{ $section->name }}
                                    </div>
                                    <div class="d-block w-50 text-nowrap text-muted fw-normal text-end pe-1">
                                        {{ $section->duration }}</div>
                                </button>
                            </h2>
                            <div id="section{{ $section->sec_id }}"
                                class="accordion-collapse collapse 
                                {{ $section->lectures->contains($lecture) ? 'show' : '' }}"
                                data-bs-parent="#courseAccordion">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($section->lectures as $lec)
                                            @php
                                                $userProgress = $lec
                                                    ->user_progress()
                                                    ->where('user_id', Auth::id())
                                                    ->first();
                                                $isCurrent = $lec->lec_id == $lecture->lec_id;
                                            @endphp
                                            <li class="list-group-item px-2 py-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center gap-2">
                                                        @php
                                                            $icons = [
                                                                App\Enums\LectureEnum::VIDEO->value => $isCurrent
                                                                    ? 'bi bi-play-circle-fill text-primary fs-5'
                                                                    : 'bi bi-play-circle text-muted fs-5',
                                                                App\Enums\LectureEnum::ARTICLE->value =>
                                                                    'bi bi-file-earmark-text fs-5 text-secondary',
                                                            ];

                                                            $iconClass =
                                                                $icons[$lec->type] ??
                                                                'bi bi-question-circle text-muted fs-5';
                                                        @endphp
                                                        {{-- Play icon --}}
                                                        <i class="{{ $iconClass }}"></i>

                                                        {{-- Lecture title --}}
                                                        <a href="{{ route('user.course-video.show', ['course' => $course->slug, 'lecture' => $lec]) }}"
                                                            class="fw-medium {{ $isCurrent ? 'text-primary' : 'text-dark text-opacity-75' }}">
                                                            {{ $lec->title }}
                                                        </a>
                                                    </div>

                                                    <div class="text-end d-flex flex-column align-items-end">
                                                        {{-- Duration --}}
                                                        @if ($lecture->duration_raw > 0)
                                                            <div class="fw-bold">
                                                                {{ $lec->duration }}
                                                            </div>
                                                        @endif

                                                        {{-- Progress --}}
                                                        {{-- @if ($lec->type === App\Enums\LectureEnum::VIDEO->value) --}}
                                                        <small class="text-success fw-semibold">
                                                            {{ $userProgress ? number_format($userProgress->pivot->progress) : 0 }}%
                                                        </small>
                                                        {{-- @endif --}}
                                                    </div>
                                                </div>
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
            $(document).ready(function() {
                var stars = new StarRating('.star-rating', {
                    classNames: {
                        active: 'gl-active',
                        base: 'gl-star-rating',
                        selected: 'gl-selected',
                    },
                    clearable: true, // Cho phép bỏ chọn nếu click lại
                    maxStars: 5,
                    prebuilt: false,
                    stars: null,
                    tooltip: false,
                });

                fetchUserNote();
                fetchCourseReview();

                let noteForm = $('#note-form');
                noteForm.on('submit', function(e) {
                    e.preventDefault();

                    let createNoteUrl = "{{ route('notes.store') }}";
                    let csrf = $('meta[name="csrf-token"]').attr('content');
                    let lecId = noteForm.find('input[name="lecture"]').val();
                    let content = noteForm.find('textarea[name="content"]').val();

                    $.ajax({
                        type: "POST",
                        url: createNoteUrl,
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        data: {
                            lecture: lecId,
                            content: content
                        },
                        success: function(response) {
                            noteForm.find('textarea[name="content"]').val('');
                            fetchUserNote();
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            error = xhr.responseJSON.errors;
                            let errorList = $('.note-errors ul');
                            errorList.empty();
                            errorList.removeClass('d-none');
                            $.each(error, function(key, value) {
                                errorList.append('<li>' + value + '</li>');
                            });
                            console.error("Error saving note:", xhr);
                        }
                    });
                });

                //update note
                $('#note-list').on('click', '.edit-note-button', function() {
                    let noteId = $(this).data('note-edit');
                    console.log("Click edit", noteId);

                    let noteCard = $(this).closest('.card');
                    let noteContent = noteCard.find('textarea[name="note-edit"]');
                    noteCard.find('.edit-note-button').addClass('d-none');
                    noteContent.prop('readonly', false);
                    let editConfirmButtons = noteCard.find('.edit-confirm-button');
                    editConfirmButtons.removeClass('d-none');

                    editConfirmButtons.find('.cancel-edit').on('click', function() {
                        noteContent.prop('readonly', true);
                        noteCard.find('.edit-note-button').removeClass('d-none');
                        editConfirmButtons.addClass('d-none');
                    })

                    editConfirmButtons.find('.save-edit').on('click', function() {
                        let csrf = $('meta[name="csrf-token"]').attr('content');
                        let content = noteContent.val();

                        $.ajax({
                            type: "PUT",
                            url: `/notes/${noteId}`,
                            headers: {
                                'X-CSRF-TOKEN': csrf
                            },
                            data: {
                                content: content,
                            },
                            success: function(response) {
                                console.log(response);
                                fetchUserNote();
                                noteContent.prop('readonly', true);
                                noteCard.find('.edit-note-button').removeClass('d-none');
                                editConfirmButtons.addClass('d-none');
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr);
                            }
                        });
                    })
                });

                //delete note
                $('#note-list').on('click', '.delete-note-button', function() {
                    let csrf = $('meta[name="csrf-token"]').attr('content');
                    let lecId = "{{ $lecture->lec_id }}";
                    let noteId = $(this).data('note-delete');
                    console.log("Click delete", noteId);

                    $.ajax({
                        type: "DELETE",
                        url: `/notes/${noteId}`,
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        data: {
                            lec_id: lecId
                        },
                        success: function(response) {
                            console.log(response);
                            fetchUserNote();
                        },
                        error: function(xhr, status, error) {
                            console.error("Error deleting note:", xhr);
                        }
                    });
                });

                //store review
                let reviewForm = $('#review-form');
                reviewForm.on('submit', function(e) {
                    e.preventDefault();
                    let storeReviewUrl = "{{ route('reviews.store') }}";
                    let csrf = $('meta[name="csrf-token"]').attr('content');
                    let courseId = {{ $course->id }};
                    let rating = reviewForm.find('select[name="rating"]').val();
                    let comment = reviewForm.find('textarea[name="comment"]').val();

                    console.log(storeReviewUrl, courseId, rating, comment);

                    $.ajax({
                        type: "POST",
                        url: storeReviewUrl,
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        data: {
                            course_id: courseId,
                            rating: rating,
                            comment: comment
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Thành công!',
                                'Đánh giá của bạn đã được gửi.',
                                'success'
                            ).then(() => {
                                reviewForm[0].reset();
                                fetchCourseReview();
                            });
                        },
                        error: function(xhr) {
                            displayErrorAlert(xhr.responseJSON.title, xhr.responseJSON.detail);
                            reviewForm[0].reset();
                            console.error(xhr.responseText);
                        }
                    });
                })

                function fetchUserNote() {
                    let fetchUrl = "{{ route('notes.index', ['lecture' => $lecture->lec_id]) }}";
                    let csrf = $('meta[name="csrf-token"]').attr('content');
                    let lecId = "{{ $lecture->lec_id }}";

                    $.ajax({
                        type: "GET",
                        url: fetchUrl,
                        data: {
                            lec_id: lecId
                        },
                        success: function(response) {
                            // console.log(response);
                            renderNotes(response.data);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching notes:", xhr);
                        }
                    });
                }

                function renderNotes(notes) {
                    let noteList = $('#note-list');
                    let noteHtml = " ";

                    if (notes && notes.length > 0) {
                        notes.forEach(note => {
                            noteHtml += `
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between">
                                    <strong class="fs-5">${note.lecture.title}</strong>
                                    <div class="action-button">
                                        <button class="edit-note-button btn border-none outline-none" data-note-edit="${note.id}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="delete-note-button btn border-none outline-none" data-note-delete="${note.id}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <textarea name="note-edit" class="form-control" rows="4" readonly>
                                        ${note.content}
                                    </textarea>
                                </div>
                                <div class="card-footer d-flex jutify-content-between">
                                    <span class="text-muted small flex-fill">Cập nhật lần cuối: <strong
                                            class="note-updated-at">${formatDate(note.updated_at)}
                                            </strong></span>

                                    <div class="edit-confirm-button d-none">
                                        <button class="save-edit btn btn-primary" type="submit">
                                            <i class="bi bi-floppy"></i> Lưu
                                        </button>
                                        <button class="cancel-edit btn btn-danger" type="submit">
                                            <i class="bi bi-x-square"></i> Hủy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `
                        });
                    };

                    noteList.html(noteHtml);
                }

                function fetchCourseReview() {
                    let fetchUrl = "{{ route('reviews.index', ['course_id' => $course->id]) }}";
                    $.ajax({
                        type: "GET",
                        url: fetchUrl,
                        success: function(response) {
                            console.log(response);
                            renderReviews(response.data);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                }

                function renderReviews(reviews) {
                    const reviewSection = $('section[name="course-reviews"]');
                    let html = `<h2 class="fs-5 fw-bold">Đánh giá của học viên</h2>`;

                    if (reviews && reviews.length > 0) {
                        reviews.forEach(review => {
                            html += `
                                <div class="border p-3 rounded mb-3">
                                    <h6 class="fw-bold">${review.user.name}</h6>
                                    <p>${'⭐ '.repeat(parseInt(review.rating))}</p>
                                    <p>${review.comment || ''}</p>
                                    <p class="text-muted small">Đánh giá vào: <strong>${formatDate(review.updated_at)}</strong></p>
                                </div>
                            `;
                        });
                    } else {
                        html += `<p class="text-muted">Chưa có đánh giá nào cho khoá học này.</p>`;
                    }

                    reviewSection.html(html);
                }

                function formatDate(dateStr) {
                    const date = new Date(dateStr);
                    return date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN');
                }


                const videoElement = $('#course-video');
                const isArticle = {{ $lecture->type === \App\Enums\LectureEnum::ARTICLE->value ? 'true' : 'false' }};

                if (isArticle) {
                    updateUserLectureProgress(100);
                }

                console.log("is article: " + isArticle);
                videoElement.on('loadedmetadata', function() {
                    const duration = this.duration;
                    // const completion = 0;
                    // const progress = Number(($('#course-video').get(0)
                    //         .currentTime * 100) /
                    //     duration).toFixed(2)

                    // videoElement.on('timeupdate', function() {
                    //     console.log("Current time: " + this.currentTime);
                    //     console.log("current progress: " + Number((this.currentTime * 100) / duration)
                    //         .toFixed(2) + "%")
                    // })

                    videoElement.on('ended', function() {
                        const video = $('#course-video').get(0);
                        const current = video.currentTime;
                        const progress = Number((current * 100) / duration).toFixed(2);
                        updateUserLectureProgress(progress);
                    })

                    $(window).on('beforeunload', function() {
                        const video = $('#course-video').get(0);
                        const current = $('#course-video').get(0).currentTime;
                        const progress = Number((current * 100) / duration).toFixed(2);

                        updateUserLectureProgress(progress);
                    });
                });

                function updateUserLectureProgress(progress) {
                    let csrf = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('lectures.progress', $lecture) }}",
                        headers: {
                            // 'X-CSRF-TOKEN': csrf
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "progress": progress,
                            "lec_id": {{ $lecture->lec_id }}
                        },
                        success: function(response) {
                            console.log(response)
                        },
                        error: function(xrh) {
                            console.log(xhr);
                        }
                    });
                }
            })
        </script>
    @endpush
@endsection
