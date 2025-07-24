<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Course;
use App\Enums\OrderEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DasboardController extends Controller
{
    public function index(Request $request)
    {
        // $totalRevenue = Order::where('status', OrderEnum::COMPLETED->value)->sum('total_amount');
        $totalRevenue = Order::sum('total_amount');

        if ($request->query()) {
            // dd($request->query());

            switch ($request->query('time_type')) {
                case 'month':
                    $month = $request->query('month');
                    $carbonDate = Carbon::createFromFormat('Y-m', $month);
                    $year = $carbonDate->year;
                    $month = $carbonDate->month;
                    // dd($year,$month);
                    $totalRevenue = Order::whereRaw('MONTH(created_at) = ?', [$month])
                        ->whereRaw('YEAR(created_at) = ?', [$year])
                        ->sum('total_amount');
                    break;
                case 'quarter':
                    $quarter = $request->query('quarter');
                    $quarterYear = $request->query('quarter_year');
                    $totalRevenue = Order::whereRaw('QUARTER(created_at) = ?', [$quarter])
                        ->whereRaw('YEAR(created_at) = ?', [$quarterYear])
                        ->sum('total_amount');
                    // dd($totalRevenue);
                    break;
                case 'year':
                    $year = $request->query('year');
                    $totalRevenue = Order::whereRaw('YEAR(created_at) = ?', [$year])->sum('total_amount');
                    break;
                default:
                    break;
            }
        }

        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalCanceledOrders = Order::where('status', OrderEnum::CANCELLED)->count();

        // $revenueByMonth = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
        //     ->whereYear('created_at', 2023)
        //     ->groupByRaw('MONTH(created_at)')
        //     ->orderBy('month')
        //     ->pluck('total', 'month') // [1 => 100000, 2 => 200000, ...]
        //     ->toArray();

        // $revenueByQuarter = Order::selectRaw('QUARTER(created_at) as quarter, SUM(total_amount) as total')
        //     ->whereYear('created_at', 2024) // You can use any year based on user selection
        //     ->groupByRaw('QUARTER(created_at)')
        //     ->orderBy('quarter')
        //     ->pluck('total', 'quarter')
        //     ->toArray();

        return view('admin.pages.dashboard', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'totalRevenue' => $totalRevenue,
            'totalCanceledOrders' => $totalCanceledOrders,
            // 'revenueByMonth' => $revenueByMonth,
            // 'revenueByQuarter' => $revenueByQuarter,
        ]);
    }
}
