<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('admin');
    }

    public function index()
    {
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'customer')->count();
        $totalOrders = Order::count();

        $revenue = (float) Order::where('status', '!=', 'Cancelled')
            ->get()
            ->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount);

        $recentOrders = Order::with('user')->orderByDesc('created_at')->limit(10)->get();

        return view('admin.dashboard', compact('totalProducts', 'totalUsers', 'totalOrders', 'revenue', 'recentOrders'));
    }
}
