<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.pages.roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.pages.roles.create', compact('permissions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'permission_id' => 'nullable|array',
        ]);

        try {
            $role = Role::create([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);

            $role->permissions()->attach($request->input('permission_id'));

            return redirect()->route('roles.index')->with('success', 'Thêm vai trò thành công');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra ' . $th->getMessage()])->withInput();
        }
    }
    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.pages.roles.edit', compact('role', 'permissions'));
    }
    public function update(Request $request, Role $role)
    {
        // dd($request->input('permission_id'));
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->role_id .
                ',role_id',
            'description' => 'nullable',
            'permission_id' => 'nullable|array',
            'permission_id.*' => 'exists:permissions,id',
        ]);

        try {
            $role->update([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);

            $role->permissions()->sync($request->input('permission_id', []));

            return redirect()->route('roles.index')->with('success', 'Cập nhật vai trò thành công');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra ' . $th->getMessage()])->withInput();
        }
    }

    public function destroy(Request $request)
    {
        try {
            $roleId = Role::findOrFail($request->input('role_id'));

            $roleId->delete();

            if ($request->ajax()) {
                return ApiHelper::success(200, null, 'Xóa vai trò thành công');
            }
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return ApiHelper::error('Lỗi hệ thống', 500, $th->getMessage());
            }
        }
    }
}
