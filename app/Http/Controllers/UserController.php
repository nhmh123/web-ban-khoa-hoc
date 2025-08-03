<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $defaultAvatar = "avatars/avatar-default-icon.png";
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
        $avatar = $this->defaultAvatar;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $avatar,
            'password' => bcrypt($request->password),
        ]);

        if ($request->has('avatar')) {
            $fileName = $request->file('avatar')->getClientOriginalName();
            $path = $request->file('avatar')->storeAs('avatars', $user->id . "-" . $fileName, 'public');
            $user->avatar = $path;
            $user->save();
        }

        $user->roles()->sync($request->input('role', []));
        $user->save();

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
                if (($user->avatar && $user->thubmnail !== $this->defaultAvatar) && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $fileName = $request->file('avatar')->getClientOriginalName();
                $path = $request->file('avatar')->storeAs('avatars', $user->id . "-" . $fileName, 'public');
                $user->avatar = $path;
                $user->save();
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
