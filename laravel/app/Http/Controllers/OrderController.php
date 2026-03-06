<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index()
    {
        $orders = auth()->user()->orders()->with('orderItems.product')->orderByDesc('created_at')->paginate(10);
        $cartCount = auth()->user()->cartItems()->sum('quantity');

        return view('orders.index', compact('orders', 'cartCount'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load(['orderItems.product']);
        $cartCount = auth()->user()->cartItems()->sum('quantity');

        return view('orders.show', compact('order', 'cartCount'));
    }

    public function receipt(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load(['orderItems.product', 'user']);
        $cartCount = auth()->user()->cartItems()->sum('quantity');

        return view('orders.receipt', compact('order', 'cartCount'));
    }
}
