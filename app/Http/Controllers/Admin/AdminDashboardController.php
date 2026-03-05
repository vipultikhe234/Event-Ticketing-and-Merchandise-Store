<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;
use App\Models\Performer;
use App\Models\Event;
use App\Models\Merchandise;
use App\Models\DiscountCode;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'categories' => Category::count(),
            'performers' => Performer::count(),
            'events' => Event::count(),
            'merchandise' => Merchandise::count(),
            'discount_codes' => DiscountCode::count(),
            'orders_count' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
        ];

        $recentOrders = Order::with(['user', 'event', 'merchandise'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
