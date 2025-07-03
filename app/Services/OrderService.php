<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Course;
use App\Enums\OrderEnum;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function generateOrderCode()
    {
        return 'ORD-' . now()->format('YmDHis') . '-' . Str::upper(Str::random(5));
    }

    public function createOrderFormList(User $user, array $courseIds)
    {
        $courses = Course::whereIn('id', $courseIds)->get();
        $totalPrice = $courses->sum('original_price');

        DB::beginTransaction();

        $order = Order::create([
            'order_id' => $this->generateOrderCode(),
            'user_id' => $user->id,
            'status' => OrderEnum::PENDING->value,
            'total_price' => $totalPrice,
            'total_amount' => $totalPrice,
            'sub_total' => count($courseIds),
        ]);
        try {
            foreach ($courses as $course) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'course_id' => $course->id,
                    'course_title' => $course->name,
                    'item_price' => $course->original_price,
                    'price_amount' => $course->original_price
                ]);
            }
            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
