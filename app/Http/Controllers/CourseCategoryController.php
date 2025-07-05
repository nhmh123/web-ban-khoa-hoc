<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\CourseCategory\CreateCCategoryRequest;
use App\Http\Requests\Admin\CourseCategory\UpdateCCategoryRequest;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CourseCategory::orderByDesc('created_at')->get();
        return view('admin.pages.course-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CourseCategory::all();

        return view('admin.pages.course-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $data['cc_slug'] = Str::slug($data['cc_name']);
            if ($request->hasFile('icon_path')) {
                $file = $request->file('icon_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads' . D . 'category-icons'), $filename);
                $data['icon_path'] = 'uploads/category-icons/' . $filename;
            }
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['user_id'] = auth()->id();
            $category = CourseCategory::create($data);
            return redirect()->route('ccategories.index')->with('success', 'Thêm danh mục thành công!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseCategory $courseCategory)
    {
        return view('admin.pages.course-categories.show', compact('courseCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseCategory $ccategory)
    {
        $categories = CourseCategory::where('cc_id', '!=', $ccategory->cc_id)->get();
        return view('admin.pages.course-categories.edit', compact('ccategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCCategoryRequest $request, CourseCategory $ccategory)
    {
        try {
            $data = $request->validated();
            $data['cc_slug'] = Str::slug($data['cc_name']);
            // Handle icon upload if exists
            $data['status'] = $request->has('status');
            $ccategory->update($data);
            return redirect()->route('ccategories.index')->with('success', 'Cập nhật danh mục thành công!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCategory $ccategory)
    {
        try {
            $hasEnrolledCourse = $ccategory->courses()->whereHas('enrollments')->exists();
            $hasEnrolledCourseInChildren = $ccategory->children()->whereHas('courses.enrollments')->exists();

            if ($hasEnrolledCourse || $hasEnrolledCourseInChildren) {
                $ccategory->status = 0;
                $ccategory->save();
                return redirect()->route('ccategories.index')->with('success', 'Danh mục có khóa học đã có học viên, đã chuyển trạng thái sang ẩn!');
            }

            $ccategory->delete();
            return redirect()->route('ccategories.index')->with('success', 'Xóa danh mục thành công!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()]);
        }
    }
}
