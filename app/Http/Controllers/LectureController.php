<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Video;
use App\Models\Course;
use App\Models\Article;
use App\Models\Lecture;
use App\Enums\LectureEnum;
use App\Helpers\ApiHelper;
use App\Models\Attachment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\VideoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Lecture\CreateLectureRequest;
use App\Http\Requests\Lecture\UpdateLectureRequest;

class LectureController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sec_id = $request->sec_id;
        return view('admin.pages.lectures.create', compact('sec_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLectureRequest $request)
    {
        try {
            $lecture = Lecture::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'is_intro' => $request->has('is_intro'),
                'type' => $request->type,
                'order' => 0,
                'sec_id' => $request->sec_id,
            ]);

            if ($request->type === LectureEnum::VIDEO->value) {
                if ($request->hasFile('course_video')) {
                    // $fileName = $request->file('course_video')->getClientOriginalName();
                    $videoUrl = $this->videoService->uploadVideoToS3Bucket($request->file('course_video'), "lectures/$lecture->lec_id/video");
                    // Storage::disk("s3")->put("course-videos/" . $fileName, file_get_contents($request->file('course_video')), "public");
                }

                Video::create([
                    'lec_id' => $lecture->lec_id,
                    'video_url' => $videoUrl ?? null,
                ]);
            } else if ($request->type === LectureEnum::ARTICLE->value) {
                Article::create([
                    'lec_id' => $lecture->lec_id,
                    'content' => $request->article_content,
                ]);
            } else {
                return back()->withErrors(['type' => 'Loại bài giảng không hợp lệ.'])->withInput();
            }

            if ($request->hasFile('attachments')) {
                $attachments = $request->file('attachments');
                // dd($attachments);
                DB::beginTransaction();
                try {
                    foreach ($attachments as $attachment) {
                        $fileName = $attachment->getClientOriginalName();
                        $path = "lectures/$lecture->lec_id/documents/";
                        Storage::disk("s3")->put($path . $fileName, file_get_contents($attachment), 'private');

                        Attachment::create([
                            'attachment_url' => $path . $fileName,
                            'lec_id' => $lecture->lec_id,
                        ]);
                    }

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollback();
                    throw new Exception($th->getMessage());
                }
            }

            $section = $lecture->section;
            $course = $section->course;
            // $section->update(['duration' => $section->duration + $request->duration]);
            // $course->update(['duration' => $course->duration + $request->duration]);
            return redirect()->route('courses.edit', $course->id)->with('success', 'Thêm bài giảng thành công');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Lecture $lecture)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($lecture->section->course_id !== $course->id) {
            abort(403, 'Bài giảng không thuộc khóa học này.');
        }

        if (!$user->canAccessLecture($lecture)) {
            abort(403, 'Bạn chưa đăng ký khóa học này.');
        }

        $url = ($lecture->type == LectureEnum::VIDEO->value) ? $this->videoService->getSignedUrl($lecture->video->video_url) : null;
        
        $attachments = $lecture->attachments ?? [];
        return view('user.pages.course-video', compact('lecture', 'course', 'url', 'attachments'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecture $lecture)
    {
        return view('admin.pages.lectures.edit', compact('lecture'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture)
    {
        try {
            $newType = $request->type;
            $newTypeArray = [];
            switch ($newType) {
                case LectureEnum::ARTICLE->value:
                    $newTypeArray = [
                        'lec_id' => $lecture->lec_id,
                        'content' => $request->article_content,
                    ];
                    break;
                case LectureEnum::VIDEO->value:
                    $newTypeArray = [
                        'lec_id' => $lecture->lec_id,
                        'video_url' => $request->video_url,
                    ];
                    break;
                default:
                    break;
            }

            $typeModelClass = '\\App\\Models\\' . ucfirst($newType);
            $typeRelation = $newType;
            $typeModel = $lecture->$typeRelation();
            if ($lecture->type != $newType) {
                $lecture->$newType()->delete();
                $typeModelClass::create($newTypeArray);
            } else {
                $typeModel->update($newTypeArray);
            }

            $updateArray = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'is_intro' => $request->has('is_intro'),
                'type' => $newType,
                'order' => 0,
            ];
            $lecture->update($updateArray);

            $section = $lecture->section;
            $course = $section->course;
            return redirect()->route('courses.edit', $course->id)->with('success', 'Cập nhật bài giảng thành công');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecture $lecture)
    {
        try {
            $section = $lecture->section;
            $course = $section->course;
            // $lectureDuration = $lecture->duration;
            $lecture->delete();

            // $section->duration -= $lectureDuration;
            // $section->save();
            return redirect()->route('courses.edit', $course->id)->with('success', 'Xóa bài giảng thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra' . $th->getMessage()])->withInput();
        }
    }

    public function updateProgress(Request $request, Lecture $lecture)
    {
        try {
            $user = Auth::user();
            $existingProgress = $user->lecture_progress->firstWhere('lec_id', $lecture->lec_id);
            $progress = $existingProgress ? $existingProgress->pivot->progress : 0;

            if ($request->input('progress') > $progress) {
                $progress = $request->input('progress');
            }
            // $progress = $request->input('progress');

            $user->lecture_progress()->syncWithoutDetaching([$lecture->lec_id => ['progress' => $progress]]);

            return ApiHelper::success(200, null, 'Đã cập nhật tiến độ xem');
        } catch (\Throwable $th) {
            return ApiHelper::error('Lỗi hệ thống', 422, $th->getMessage());
        }
    }
}
