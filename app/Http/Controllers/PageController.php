<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.static-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.static-pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|max:255',
            'content' => 'required',
            'type'    => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($request->input('title'));

        Page::create([
            'title'   => $request->input('title'),
            'slug'    => $slug,
            'content' => $request->input('content'),
            'type'    => $request->input('type'),
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('pages.index')->with('success', 'Trang đã được tạo thành công.');
    }

    public function show(Page $page) {
        return view('user.pages.static-page', compact('page'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.static-pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        // dd($request->boolean('is_active'));
        $request->validate([
            'title'     => 'required|max:255',
            'content'   => 'required',
            'type'      => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($request->input('title'));
        $page->update([
            'title'     => $request->input('title'),
            'slug'      => $slug,
            'content'   => $request->input('content'),
            'type'      => $request->input('type'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('pages.index')->with('success', 'Trang đã được cập nhật.');
    }


    public function destroy(Request $request, Page $page)
    {
        $page->delete();
        if($request->ajax()) {
            return response()->json(['success' => 'Trang đã được xóa.']);
        }

         // Redirect to the index page with a success message
        return redirect()->route('pages.index')->with('success', 'Trang đã được xóa.');
    }
}
