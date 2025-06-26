<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlist()
    {
        $user = auth()->user();
        $wishlistCourses = $user->wishlist()->paginate(10);
        return view('user.pages.wishlist', compact('user', 'wishlistCourses'));
    }

    public function addToWishlist(Course $course)
    {
        if(!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để thêm khóa học vào danh sách yêu thích!'
            ],401);
        }
        $user = auth()->user();
        if (!$user->wishlist()->where('course_id', $course->id)->exists()) {
            $user->wishlist()->attach($course->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm khóa học vào danh sách yêu thích thành công!'
            ]);

            // return redirect()->back()->with('success', 'Thêm khóa học vào danh sách yêu thích thành công!');
        }
    }

    public function removeFromWishlist(Course $course)
    {
        $user = auth()->user();
        if ($user->wishlist->contains($course->id)) {
            $user->wishlist()->detach($course->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa khóa học khỏi danh sách yêu thích thành công!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Khóa học không có trong danh sách yêu thích!'
            ]);
        }
    }
}
