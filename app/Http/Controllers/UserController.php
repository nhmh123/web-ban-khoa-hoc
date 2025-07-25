<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $defaultAvatar = "https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png";
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $roles = Role::all();
        // if ($roleQuery && $roleQuery !== 'all') {
        //     $users = User::whereHas('role', function ($query) use ($roleQuery) {
        //         $query->where('name', $roleQuery);
        //     })->orderBy('created_at', 'desc')->get();
        // }
        return view('admin.pages.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.pages.users.create', compact('roles'));
    }

    public function store(CreateUserRequest $request)
    {
        // $slug = Str::slug($request->name);
        if ($request->has('avatar')) {
            echo $request->file('avatar')->getClientOriginalName();
        }
        $avatar = $this->defaultAvatar;
        $user = User::create([
            'name' => $request->name,
            // 'slug' => $slug,
            'email' => $request->email,
            'avatar' => $avatar,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Thêm người dùng thành công.');
    }
    public function edit(User $user, $isAdmin = true)
    {
        if ($isAdmin) {
            $roles = Role::all();
            return view('admin.pages.users.edit', compact('user', 'roles'));
        }

        return view('user.pages.profile', compact('user'));
    }
    public function update(UpdateUserRequest $request, User $user, $isAdmin = true)
    {
        // dd($request->all());
        try {
            if (!$isAdmin) {
                if ($user->id != Auth::id()) {
                    abort(403, 'Không có quyền thực hiện thao tác này');
                }
            }
            // throw new \Exception('System error'); // Simulating an error for testing
            $user->name = $request->name;
            if ($request->password !== null) {
                $user->password = Hash::make($request->password);
            }
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatar;
            }

            $user->roles()->sync($request->input('role', []));
            $user->save();

            if ($isAdmin) {
                return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công.');
            }

            return redirect()->back()->with('success', 'Cập nhật người dùng thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Cập nhật người dùng thất bại: ' . $th->getMessage());
        }
    }
}
