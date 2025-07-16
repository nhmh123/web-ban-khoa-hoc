<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        return view('admin.pages.orders.index',compact('orders'));
    }
    public function show(Order $order){
        $orderItems = $order->items;
        return view('admin.pages.orders.detail',compact('order','orderItems'));
    }
    public function history()
    {
        $user = Auth::user();
        $userOrders = Order::where('user_id', $user->id)->get();
        return view('user.pages.checkout-history', compact('userOrders'));
    }
    public function detail(Order $order)
    {
        $orderItems = $order->items;
        return view('user.pages.checkout-detail', compact('order', 'orderItems'));
    }
}
