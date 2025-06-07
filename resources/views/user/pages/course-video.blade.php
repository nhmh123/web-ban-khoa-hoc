@extends('layouts.user')
@section('user.content')
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
                <a class="navbar-brand fw-bold" href="{{ route('user.home') }}">
                    <i class="bi bi-play-circle"></i> CourseWeb
                </a>

                <div class="ms-auto">
                    <a href="{{ route('user.course-detail', ['course' => $course->slug]) }}" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Exit Course
                    </a>
                </div>
            </nav>

            <!-- Main Content - Video Player & Lesson Details -->
            <main class="col-lg-8 col-md-8 px-4">
                <div class="mt-3">
                    <!-- Video Player -->
                    <div class="ratio ratio-16x9">
                        <video id="course-video" class="video-js vjs-big-play-centered" controls preload="auto">
                            <source src="{{ asset('storage/lectures/' . $course->id . '/' . $lecture->video_url) }}"
                                type="video/mp4">
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a
                                web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports
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

                    {{-- <script>
                        function autoGenerateNote() {
                            const courseId = document.querySelector('[data-course-id]').dataset.courseId;
                            const videoFile = document.querySelector('[data-video-file]').dataset.videoFile;
                            const noteTextarea = document.querySelector('#note-content');
                            const generateBtn = document.querySelector('#auto-generate-btn');

                            generateBtn.disabled = true;
                            generateBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Converting video...';

                            fetch('/test-convert', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        course_id: courseId,
                                        video_file: videoFile
                                    })
                                })
                                .then(response => response.json())
                                .then(async data => {
                                    if (!data.success) throw new Error(data.message);

                                    let fullTranscript = '';
                                    const chunks = data.chunks;


                                    for (let i = 0; i < chunks.length; i++) {
                                        generateBtn.innerHTML = `<i class="bi bi-arrow-clockwise"></i> Transcribing part ${i + 1}/${chunks.length}...`;

                                        const chunkPath = chunks[i].path.replace(/\\/g, '/'); 
                                        const relativePath = chunkPath.split('app/public/')[1]; 

                                        const response = await fetch('/transcribe-file', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                path: relativePath,
                                                course_id: courseId,
                                                chunk_index: i,
                                                total_chunks: chunks.length
                                            })
                                        });

                                        const chunkData = await response.json();
                                        if (!chunkData.success) throw new Error(chunkData.message);

                                        fullTranscript += chunkData.transcript + ' ';
                                        console.log(chunkData.transcript,chunkData.confidence);
                                        noteTextarea.value = fullTranscript.trim();
                                    }

                                    generateBtn.innerHTML = '<i class="bi bi-check-circle"></i> Generated!';
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    generateBtn.innerHTML = '<i class="bi bi-x-circle"></i> Failed - Try Again';
                                    alert('Failed to generate transcript: ' + error.message);
                                })
                                .finally(() => {
                                    setTimeout(() => {
                                        generateBtn.disabled = false;
                                        generateBtn.innerHTML = '<i class="bi bi-magic"></i> Auto Generate Note';
                                    }, 3000);
                                });
                        }
                    </script> --}}

                    <script>
                        function autoGenerateNote() {
                            const courseId = document.querySelector('[data-course-id]').dataset.courseId;
                            const videoFile = document.querySelector('[data-video-file]').dataset.videoFile;
                            const noteTextarea = document.querySelector('#note-content');
                            const generateBtn = document.querySelector('#auto-generate-btn');

                            generateBtn.disabled = true;
                            generateBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Converting video...';

                            fetch('/change-video-format', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        course_id: courseId,
                                        video_file: videoFile
                                    })
                                })
                                .then(response => response.json())
                                .then(async data => {
                                    if (!data.success) throw new Error(data.message);

                                    const audioPath = data.audio_path;

                                    let fullTranscript = '';
                                    generateBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Transcribing...';

                                    // const response = await fetch('/send-audio-file', {  // POST to transcription service
                                    //     method: 'POST',
                                    //     headers: {
                                    //         'Content-Type': 'application/json',
                                    //         'Accept': 'application/json'
                                    //     },
                                    //     body: JSON.stringify({
                                    //         path: audioPath,
                                    //         course_id: courseId
                                    //     })
                                    // });

                                    // const transcriptData = await response.json();
                                    // if (!transcriptData.success) throw new Error(transcriptData.message);

                                    // fullTranscript += transcriptData.transcript + ' ';
                                    // console.log(transcriptData.transcript, transcriptData.confidence);

                                    // noteTextarea.value = fullTranscript.trim();

                                    // generateBtn.innerHTML = '<i class="bi bi-check-circle"></i> Generated!';

                                    const response = await fetch('/send-audio-file', { // POST to transcription service
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            path: audioPath,
                                            course_id: courseId
                                        })
                                    });

                                    const transcriptData = await response.json();
                                    if (!transcriptData.success) throw new Error(transcriptData.message);

                                    console.log(transcriptData);    
                                    fullTranscript += transcriptData.transcript + ' ';
                                    console.log(transcriptData.transcript, transcriptData.confidence);

                                    noteTextarea.value = fullTranscript.trim();

                                    generateBtn.innerHTML = '<i class="bi bi-check-circle"></i> Generated!';
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    generateBtn.innerHTML = '<i class="bi bi-x-circle"></i> Failed - Try Again';
                                    alert('Failed to generate transcript: ' + error.message);
                                })
                                .finally(() => {
                                    setTimeout(() => {
                                        generateBtn.disabled = false;
                                        generateBtn.innerHTML = '<i class="bi bi-magic"></i> Auto Generate Note';
                                    }, 3000);
                                });
                        }
                    </script>


                    <!-- Lesson Title -->
                    <h3 class="mt-4 fw-bold">{{ $lecture->title }}</h3>

                    <!-- Lesson Description -->
                    {{-- <p>
                        In this lesson, you will learn the fundamentals of PHP programming, including syntax, variables, and
                        functions.
                    </p> --}}

                    <div class="accordion my-4" id="arrcodingAccordion">
                        <!-- Arrcoding Header -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingArrcoding">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#arrcodingCollapse" aria-expanded="false"
                                    aria-controls="arrcodingCollapse">
                                    <i class="bi bi-journal-text"></i>
                                    <span class="ms-1">Course Resources</span>
                                </button>
                            </h2>
                            <!-- Arrcoding Content -->
                            <div id="arrcodingCollapse" class="accordion-collapse collapse"
                                aria-labelledby="headingArrcoding" data-bs-parent="#arrcodingAccordion">
                                <div class="accordion-body">
                                    <!-- Attachments & Documents -->
                                    <h6>Attachments & Documents</h6>
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

                                    <!-- Note Taking Section -->
                                    <h6>Notes</h6>
                                    <textarea id="note-content" class="form-control" rows="10" style="min-height: 300px;"
                                        placeholder="Write your notes here..."></textarea>
                                    <button id="auto-generate-btn" onclick="autoGenerateNote()" class="btn btn-dark mt-2"
                                        data-course-id="{{ $course->id }}" data-video-file="{{ $lecture->video_url }}">
                                        <i class="bi bi-magic"></i> Auto Generate Note
                                    </button>
                                    <button id="saveNote" class="btn btn-primary mt-2">
                                        <i class="bi bi-floppy"></i> Save Note
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next/Previous Buttons -->
                    <div class="d-flex justify-content-between my-4">
                        <button class="btn border-dark">&larr; Previous Lesson</button>
                        <button class="btn border-dark">Next Lesson &rarr;</button>
                    </div>
                </div>
            </main>

            <!-- Right Sidebar - Course Lessons -->
            <nav class="col-lg-4 col-md-4 d-none d-md-block bg-light sidebar p-3">
                <h4 class="mb-3">Course Content</h4>

                <!-- Accordion for Course Content -->
                <div class="accordion" id="courseAccordion">
                    @foreach ($course->sections as $section)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    class="accordion-button fw-bold {{ $section->lectures->contains($lecture) ? '' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#section{{ $section->id }}"
                                    aria-expanded="{{ $section->lectures->contains($lecture) ? 'true' : 'false' }}"
                                    aria-controls="section{{ $section->id }}">
                                    {{ $section->title }}
                                </button>
                            </h2>
                            <div id="section{{ $section->id }}"
                                class="accordion-collapse collapse 
                                {{ $section->lectures->contains($lecture) ? 'show' : '' }}"
                                data-bs-parent="#courseAccordion">
                                <div class="accordion-body">
                                    <ul class="list-group">
                                        @foreach ($section->lectures as $lec)
                                            <li class="list-group-item">
                                                <a href="{{ route('user.course-video', ['course' => $course->slug, 'lecture' => $lec->id]) }}"
                                                    class="{{ $lec->id == $lecture->id ? 'text-primary' : 'text-dark text-opacity-75' }}">
                                                    {{ $lec->title }}
                                                    @if ($lec->id == $lecture->id)
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
@endsection
