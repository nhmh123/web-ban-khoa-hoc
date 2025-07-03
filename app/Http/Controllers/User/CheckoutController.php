<?php

namespace App\Http\Controllers\User;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\EmailService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    protected $orderService;
    protected $emailService;

    public function __construct(OrderService $orderService, EmailService $emailService)
    {
        $this->orderService = $orderService;
        $this->emailService = $emailService;
    }
    public function checkout(Request $request)
    {
        $courseIds = $request->input('checkout_course', []);
        $courses = Course::whereIn('id', $courseIds)->get();
        $summary = $courses->sum(function ($course) {
            return $course->original_price;
        });

        if ($courses->isEmpty()) {
            return redirect()->back()->with('error', 'Không có khóa học nào được chọn để thanh toán.');
        }

        return view('user.pages.checkout', compact('courses', 'summary'));
    }

    public function checkoutSubmit(Request $request)
    {
        $user = Auth::user();
        $checkoutCourses = json_decode($request->input('checkout_course'));
        $order = $this->orderService->createOrderFormList($user, $checkoutCourses);
        // $this->emailService->sendOrderInformation($user->email)
        $user->cartItem()->whereIn('course_id', $checkoutCourses)->delete();
        $user->enrolledCourses()->syncWithoutDetaching($checkoutCourses);
        return redirect()->back()->with('success', 'Thanh toán thành công, vui lòng kiểm tra email');
    }
}
