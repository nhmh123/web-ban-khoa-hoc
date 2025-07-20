<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItem()->with('course')->get();
        if (!$cartItems) {
            return view('user.pages.cart', ['cartItems' => []])->with('message', 'Giỏ hàng của bạn hiện đang trống.');
        }

        if ($request->ajax()) {
            return response()->json([
                'data' => $cartItems
            ]);
        }

        return view('user.pages.cart', compact('cartItems'));
    }
    public function getCartTotal()
    {
        $user = Auth::user();
        $cartTotal = $user ? $user->cartItem()->count() : 0;

        return response()->json(['cartTotal' => $cartTotal]);
    }
    public function addToCart(Course $course)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiHelper::error(
                    title: 'Chưa xác thực',
                    status: 401,
                    detail: 'Bạn cần đăng nhập để thêm khóa học vào giỏ hàng.',
                    code: 'ERR_UNAUTHENTICATED'
                );
            }

            if ($user->cartItem()->where('course_id', $course->id)->exists()) {
                return ApiHelper::error(
                    title: 'Khóa học đã có trong giỏ hàng',
                    status: 400,
                    detail: 'Khách hàng đã cố thêm một khóa học đã tồn tại.',
                    code: 'ERR_COURSE_ALREADY_IN_CART'
                );
            }

            $data = $user->cartItem()->create([
                'course_id' => $course->id,
                'price'     => $course->original_price,
            ]);

            return response()->json([
                'status'  => 'success',
                'data'    => $data,
                'message' => 'Đã thêm khóa học vào giỏ hàng thành công.',
                'course'  => $course
            ]);
        } catch (\Throwable $th) {
            return ApiHelper::error(
                title: 'Lỗi máy chủ',
                status: 500,
                detail: 'Lỗi xảy ra khi thêm khóa học vào giỏ: ' . $th->getMessage(),
                code: 'ERR_INTERNAL_SERVER'
            );
        }
    }
    public function removeFromCart(Course $course)
    {
        try {
            $user = Auth::user();
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
            $user = Auth::user();
            // if ($request->has('ids')) {
            //     $ids = array_map('intval', $request->input('ids'));
            //     $user->cartItem()->whereIn('course_id', $ids)->delete();
            //     return redirect()->back()->with('success', 'Đã xóa các khóa học khỏi giỏ hàng thành công!');
            // }

            $user->cartItem()->delete();

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đã xóa tất cả khóa học khỏi giỏ hàng.',
                ]);
            }
            return redirect()->back()->with('success', 'Đã xóa tất cả khóa học khỏi giỏ hàng thành công!');
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                ApiHelper::error(
                    title: 'Lỗi hệ thống',
                    status: 500,
                    detail: $th->getMessage(),
                    code: 'server_error'
                );
            }
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $th->getMessage()]);
        }
    }
}
