<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        $response = Http::get("https://api.vietqr.io/v2/banks");
        if ($response->successful()) {
            $banks = $response;

            $payments = Payment::all();
            return view('admin.pages.settings.payment', compact('banks', 'payments'));
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string',
            'bank_bin' => 'required|integer',
            'bank_code' => 'required|string',
            'account_number' => 'required|digits_between:6,20',
            // 'account_name' => 'required|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);

        try {
            $validated['account_name'] = "NGUYEN HO MINH HIEN";
            if (!empty($validated['is_default'])) {
                Payment::where('is_default', true)->update(['is_default' => false]);
            }

            if (Payment::count() == 0) {
                $validated['is_default'] = true;
            }

            Payment::create($validated);

            return back()->with('success', 'Thêm tài khoản thành công');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra ' . $th->getMessage()])->withInput();
        }
    }

    public function setDefault(Payment $payment)
    {
        try {
            Payment::where('is_default', true)->update(['is_default' => false]);
            $payment->update(['is_default' => true]);

            return back()->with('success', 'Đổi tài khoản mặc định thành công');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra ' . $th->getMessage()])->withInput();
        }
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();

            if ($payment->is_default == true) {
                $recentPayment = Payment::latest()->first();

                if ($recentPayment) {
                    $recentPayment->is_default = true;
                    $recentPayment->save();
                }
            }

            return ApiHelper::success(200, null, 'Xóa tài khoản thành công');
        } catch (\Throwable $th) {
            return ApiHelper::error('Lỗi', 500, 'Có lỗi xảy ra' . $th->getMessage());
        }
    }
}
