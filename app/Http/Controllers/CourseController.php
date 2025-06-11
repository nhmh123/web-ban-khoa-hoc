<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\DifficultyLevel;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $languages = Language::all();
        $levels = DifficultyLevel::all();
        $categories = CourseCategory::all();
        $sections = $course->sections()->orderBy('created_at','asc')->get();
        return view('admin.pages.courses.edit', compact('course', 'languages', 'levels', 'categories','sections'));
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
            if($hasEnrolled) {
                return back()->withErrors(['error' => 'Không thể xóa khóa học vì có người đã đăng ký.']);
            }
            $course->delete();
            return redirect()->route('courses.index')->with('success', 'Xóa khóa học thành công!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error'=> 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }
}
