<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
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
        $cartCourseIds = $user->cartItem()->pluck('course_id')->toArray();
        return view('user.pages.wishlist', compact('user', 'wishlistCourses', 'cartCourseIds'));
    }

    public function addToWishlist(Course $course, Request $request)
    {
        if (!Auth::check()) {
            return ApiHelper::error('Chưa đăng nhập!', 401, 'Bạn cần đăng nhập để thêm khóa học vào danh sách yêu thích!');
        }
        $user = auth()->user();
        if (!$user->wishlist()->where('course_id', $course->id)->exists()) {
            $user->wishlist()->attach($course->id);

            if ($request->ajax()) {
                return ApiHelper::success(200, null, 'Thêm khóa học vào danh sách yêu thích thành công!');
            }

            return redirect()->back()->with('success', 'Thêm khóa học vào danh sách yêu thích thành công!');
        }
    }

    public function removeFromWishlist(Course $course, Request $request)
    {
        $user = auth()->user();
        if ($user->wishlist->contains($course->id)) {
            try {
                $user->wishlist()->detach($course->id);

                if ($request->ajax()) {
                    return ApiHelper::success(200, null, 'Xóa khóa học khỏi danh sách yêu thích thành công!');
                }
            } catch (\Throwable $th) {
                return ApiHelper::error('Lỗi!', 500, $th->getMessage());
            }
        } else {
            return ApiHelper::error('Lỗi!', 422, 'Khóa học không có trong danh sách yêu thích!');
        }
    }
}
