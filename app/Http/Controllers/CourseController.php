<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Language;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Models\DifficultyLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::orderByDesc('created_at')->get();
        return view('admin.pages.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        $levels = DifficultyLevel::all();
        $categories = CourseCategory::all();
        return view('admin.pages.courses.create', compact('languages', 'levels', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCourseRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            // Handle thumbnail upload if exists
            $data['user_id'] = Auth::id();
            $course = Course::create($data);
            return redirect()->route('courses.index')->with('success', 'Thêm khóa học thành công!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load('category', 'user', 'sections', 'sections.lectures', 'reviews');
        $alreadyInWishlist = Auth::user()?->wishlist->contains($course->id) ?? false;
        $alreadyInCart = Auth::user()?->cartItem()->where('course_id', $course->id)->exists() ?? false;
        return view('user.pages.course-detail', compact('course', 'alreadyInWishlist', 'alreadyInCart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $languages = Language::all();
        $levels = DifficultyLevel::all();
        $categories = CourseCategory::all();
        $sections = $course->sections()->orderBy('created_at', 'asc')->get();
        return view('admin.pages.courses.edit', compact('course', 'languages', 'levels', 'categories', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name']);
            // Handle thumbnail upload if exists
            $course->update($data);
            return redirect()->route('courses.index')->with('success', 'Cập nhật khóa học thành công!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $hasEnrolled = $course->enrollments()->exists();
            if ($hasEnrolled) {
                return back()->withErrors(['error' => 'Không thể xóa khóa học vì có người đã đăng ký.']);
            }
            $course->delete();
            return redirect()->route('courses.index')->with('success', 'Xóa khóa học thành công!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }

    public function enroll(Course $course)
    {
        $user = Auth::user();
        try {
            $user->enrolledCourses()->syncWithoutDetaching([$course->id]);

            if ($user->cartItem()->where('course_id', $course->id)->exists()) {
                $user->cartItem()->where('course_id', $course->id)->delete();
            }

            return redirect()->back()->with('success', 'Đăng ký khóa học thành công!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }

    public function userCourses(Request $request)
    {
        $user = Auth::user();
        // $courses = Enrollment::where('user_id', $user->id)->with('course')->paginate(3);

        $coursesQuery = $user->enrolledCourses()->with('category', 'user', 'sections', 'sections.lectures');

        if ($request->has('my_course_q')) {
            $searchKey = Str::of($request->query('my_course_q'))->trim();
            $coursesQuery->whereRaw("name LIKE N'%{$searchKey}%'");
        }

        if ($request->filled('category')) {
            $categoryId = $request->category;
            $coursesQuery->where('cat_id', $categoryId);
        }

        $courses = $coursesQuery->paginate(8);

        $categories = Enrollment::where('user_id', $user->id)->with('course.category')->get()->pluck('course.category')->unique('cc_id');
        return view('user.pages.my-courses', compact('courses', 'categories'));
    }
}
