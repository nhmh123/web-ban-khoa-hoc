<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
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
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ])->validate();

        try {
            $section = new Section();
            $section->name = $validated['name'];
            $section->slug = Str::slug($validated['name']);
            $section->description = $validated['description'] ?? '';
            $section->course_id = $request->input('course_id');
            $section->save();

            return redirect()->back()->with('success', 'Thêm phần học thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'error' => 'Có lỗi xảy ra ' . $th->getMessage()
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ])->validate();

        try {
            $section->name = $validated['name'];
            $section->slug = Str::slug($validated['name']);
            $section->description = $validated['description'] ?? '';
            $section->save();

            return redirect()->back()->with('success', 'Cập nhật phần học thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'error' => 'Có lỗi xảy ra ' . $th->getMessage()
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        try {
            $section->delete();
            return redirect()->back()->with('success', 'Xóa phần học thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'error' => 'Có lỗi xảy ra ' . $th->getMessage()
            ])->withInput();
        }
    }
}
