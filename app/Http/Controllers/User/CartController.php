<?php

namespace App\Http\Controllers\User;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cartItems = $user->cartItem()->with('course')->get();
        return view('user.pages.cart', compact('cartItems'));
    }
    public function addToCart(Course $course)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn cần đăng nhập để thêm khóa học vào giỏ hàng!'
                ], 401);
            }

            if ($user->cartItem()->where('course_id', $course->id)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Khóa học đã có trong giỏ hàng!'
                ], 400);
            };

            $data = $user->cartItem()->create([
                'course_id' => $course->id,
                'price' => $course->sale_price ?? $course->price,
            ]);

            return response()->json([
                'stauts' => 'success',
                'data' => $data,
                'message' => 'Course added to cart successfully',
                'course' => $course
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Lỗi xảy ra khi thêm khóa học vào giỏ hàng: ' . $th->getMessage()
            ], 500);
        }
    }

    public function removeFromCart(Course $course)
    {
        try {
            $user = auth()->user();
            $cartItem = $user->cartItem()->where('course_id', $course->id)->first();
            $cartItem->delete();
            return redirect()->back()->with('success', 'Đã xóa khóa học khỏi giỏ hàng thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()]);
        }
    }

    public function clearCart(Request $request)
    {
        try {
            $user = auth()->user();
            if ($request->has('ids')) {
                $ids = array_map('intval', $request->input('ids'));
                $user->cartItem()->whereIn('course_id', $ids)->delete();
                return redirect()->back()->with('success', 'Đã xóa các khóa học khỏi giỏ hàng thành công!');
            }

            $user->cartItem()->delete();
            return redirect()->back()->with('success', 'Đã xóa tất cả khóa học khỏi giỏ hàng thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()]);
        }
    }
}
