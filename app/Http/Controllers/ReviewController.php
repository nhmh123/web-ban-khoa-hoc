<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        try {
            $reviews = Review::with('user')->orderBy('created_at', 'desc')->get();

            if ($request->has('course_id')) {
                $courseId = (int) $request->query('course_id');
                $reviews = Review::with('user')->where('course_id', $courseId)->orderBy('updated_at', 'desc')->get();
            }

            if ($request->ajax()) {
                return ApiHelper::success(200, $reviews, 'Lấy dữ liệu review thành công');
            }

            return view('admin.pages.reviews.index', compact('reviews'));
        } catch (\Throwable $th) {
            return ApiHelper::error('Lỗi hệ thống', 500, 'Lỗi tải dữ liệu: ' . $th->getMessage());
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        try {
            $userId = Auth::id();
            $courseId = $request->input('course_id');

            $user = Auth::user();
            $course = Course::find($courseId);

            if (!$user->enrolledCourses()->where('course_id', $courseId)->exists()) {
                return ApiHelper::error('Lỗi!!', 422, 'Người dùng chưa tham gia khóa học');
            }

            $totalLectures = 0;
            $totalSection = $course->sections;
            foreach ($totalSection as $section) {
                $totalLectures += $section->lectures->count();
            };
            $courseLectures = $course->sections->flatMap(function ($section) {
                return $section->lectures->pluck('lec_id');
            });
            $completedLectures = $user->lecture_progress()->where('progress', 100)->whereIn('lectures.lec_id', $courseLectures)->get();
            $completion = $totalLectures > 0 ? round($completedLectures->count() / $totalLectures * 100) : 0;

            if ($completion < 100) {
                return ApiHelper::error('Lỗi!!', 422, 'Người dùng chưa hoàn thành khóa học');
            }

            $alreadyReview = Review::where('course_id', $courseId)->where('user_id', $userId)->exists();

            if ($alreadyReview) {
                return ApiHelper::error('Đã đánh giá!!', 422, 'Bạn đã đánh giá khóa học này');
            }

            DB::beginTransaction();
            try {
                $review = Review::create(
                    [
                        'user_id' => $userId,
                        'course_id' => $courseId,
                        'rating' => $request->input('rating'),
                        'comment' => $request->input('comment')
                    ]
                );
                $avgRating = Review::where('course_id', $courseId)->avg('rating');
                Course::where('id', $courseId)->update(['rating' => $avgRating]);
                DB::commit();
                if ($request->ajax()) {
                    return ApiHelper::success(200, $review, 'Gửi đánh giá thành công!');
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                return ApiHelper::error('Lỗi', 500, 'Lỗi khi gửi đánh giá: ' . $th->getMessage());
            }
        } catch (\Throwable $th) {
            return ApiHelper::error('Lỗi', 500, 'Lỗi khi gửi đánh giá: ' . $th->getMessage());
        }
    }
}
