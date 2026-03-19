<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Order::with('user')->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        $statusCountsQuery = Order::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $allStatuses = ['Pending' => 0, 'Processing' => 0, 'Shipped' => 0, 'Delivered' => 0, 'Cancelled' => 0];
        $statusCounts = array_merge($allStatuses, $statusCountsQuery);

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($oldStatus !== $request->status) {
            try {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(
                    new \App\Mail\OrderStatusUpdatedMail($order->fresh(['orderItems.product', 'user']))
                );
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return back()->with('success', 'Order status updated.');
    }
}
