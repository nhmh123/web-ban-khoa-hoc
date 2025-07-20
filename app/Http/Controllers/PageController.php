<?php

namespace App\Http\Controllers;

use App\Models\Page;
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
            'slug'    => 'required|alpha_dash|unique:pages,slug',
            'content' => 'required',
            'type'    => 'nullable|string|max:50',
        ]);


        Page::create($request->only(['title', 'slug', 'content', 'type']));

        return redirect()->route('pages.index')->with('success', 'Trang đã được tạo thành công.');
    }

    public function show(Page $page)
    {
        return view('pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'   => 'required|max:255',
            'slug'    => 'required|alpha_dash|unique:pages,slug,' . $page->id,
            'content' => 'required',
            'type'    => 'nullable|string|max:50',
        ]);

        $page->update($request->only(['title', 'slug', 'content', 'type']));

        return redirect()->route('pages.index')->with('success', 'Trang đã được cập nhật.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Trang đã được xóa.');
    }
}
