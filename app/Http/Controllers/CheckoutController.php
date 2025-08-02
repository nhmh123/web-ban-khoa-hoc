<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Course;
use App\Enums\OrderEnum;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
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
        return redirect()->back()->with('success', 'Thanh toán thành công.');
    }

    //MOMO payment
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momoPayment(Request $request)
    {
        $user = Auth::user();
        $checkoutCourses = json_decode($request->input('checkout_course'));
        $order = $this->orderService->createOrderFormList($user, $checkoutCourses);
        // $user->cartItem()->whereIn('course_id', $checkoutCourses)->delete();
        // $user->enrolledCourses()->syncWithoutDetaching($checkoutCourses);

        if ((int) $request->input('total_amount') === 0) {
            $user->enrolledCourses()->syncWithoutDetaching($checkoutCourses);
            $user->cartItem()->whereIn('course_id', $checkoutCourses)->delete();

            // Có thể cập nhật trạng thái đơn nếu cần
            Transaction::create([
                'user_id' => $user->id,
                'order_id' => $order->order_id,
                'transaction_id' => $transactionData['transId'] ?? '',
                'amount' => $transactionData['amount'] ?? 0,
                'method' => 'momo',
                'status' => 'success',
                'message' => $transactionData['message'] ?? null,
            ]);

            $order->status = OrderEnum::COMPLETED->value;
            $order->save();

            return redirect()->back()->with('success', 'Đăng ký khóa học thành công!');
        }

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán qua MoMo";
        $amount = (int) $request->input('total_amount');
        $orderId = time() . "";
        $redirectUrl = route('user.checkout.momo.return');
        $ipnUrl = route('user.checkout.momo.return');
        $extraData = base64_encode(json_encode([
            'user' => Auth::user(),
            'checkoutCourses' => $checkoutCourses,
            'orderId' => $order->order_id ?? null
        ]));


        $requestId = time() . "";
        $requestType = "payWithATM";

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        return redirect()->to($jsonResult['payUrl']);
    }
    public function momoReturn(Request $request)
    {
        $transactionData = $request->all();

        $extraData = json_decode(base64_decode($transactionData['extraData']), true);
        $userData = $extraData['user'] ?? null;
        $checkoutCourses = $extraData['checkoutCourses'] ?? [];
        $customOrderId = $extraData['orderId'] ?? null;

        $order = Order::where('order_id', $customOrderId)->first();
        $user = User::find($userData['id']);

        if (!$order || !$user) {
            return abort(404, 'Order or User not found.');
        }

        Transaction::create([
            'user_id' => $user->id,
            'order_id' => $order->order_id,
            'transaction_id' => $transactionData['transId'],
            'amount' => $transactionData['amount'],
            'method' => 'momo',
            'status' => $transactionData['resultCode'] == 0 ? 'success' : 'failed',
            'message' => $transactionData['message'] ?? null,
        ]);

        if ($transactionData['resultCode'] == 0) {
            $order->status = OrderEnum::COMPLETED->value;
            $order->save();

            $user->cartItem()->whereIn('course_id', $checkoutCourses)->delete();
            $user->enrolledCourses()->syncWithoutDetaching($checkoutCourses);

            return redirect()
                ->route('user.cart')
                ->with('success', 'Giao dịch thành công.');
        } else {
            $order->status = OrderEnum::CANCELLED->value;
            $order->save();

            return redirect()
                ->route('user.cart')
                ->with('error', $transactionData['message'] ?? 'Giao dịch thất bại. Vui lòng thử lại.');
        }
    }
}
