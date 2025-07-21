<?php

namespace App\Http\Controllers;

use App\Enums\OrderEnum;
use App\Models\User;
use App\Models\Order;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DasboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalRevenue = Order::where('status', OrderEnum::COMPLETED->value)->sum('total_amount');
        $totalCanceledOrders = Order::where('status', OrderEnum::CANCELLED)->count();

        return view('admin.pages.dashboard', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'totalRevenue' => $totalRevenue,
            'totalCanceledOrders' => $totalCanceledOrders,
        ]);
    }
}
