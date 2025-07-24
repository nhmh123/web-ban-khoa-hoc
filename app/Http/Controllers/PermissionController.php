<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        // dd($permissions);
        return view('admin.pages.permissions.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ], [
            'slug.required' => 'Slug không được bỏ trống'
        ]);

        try {
            Permission::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description')
            ]);

            return back()->with('success', 'Thêm quyền thành công');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra ' . $th->getMessage()])->withInput();
        }
        // dd($request);
    }

    public function edit(Permission $permission)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.pages.permissions.edit', compact('permissions', 'permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        // dd($request->all(), $permission->toArray());
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ], [
            'slug.required' => 'Slug không được bỏ trống'
        ]);

        try {
            $permission->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description')
            ]);

            return redirect()->back()->with('success', 'Cập nhật quyền thành công');
        } catch (\Throwable $th) {
            return back()->route('permissions.edit', $permission->id)->withErrors(['error' => 'Có lỗi xảy ra ' . $th->getMessage()])->withInput();
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            return redirect()->route('permissions.create')->with('success', 'Xóa quyền thành công');
        } catch (\Throwable $th) {
            return redirect()->route('permissions.create')->withErrors(['error' => 'Có lỗi xảy ra ' . $th->getMessage()])->withInput();
        }
    }
}
