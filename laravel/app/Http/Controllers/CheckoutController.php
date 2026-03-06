<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $discounts = Discount::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            })
            ->get();

        $user = auth()->user();
        $cartCount = $user->cartItems()->sum('quantity');

        return view('checkout.index', compact('cartItems', 'subtotal', 'discounts', 'user', 'cartCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string|max:50',
            'discount_code' => 'nullable|string|max:50',
        ]);

        $cartItems = auth()->user()->cartItems()->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $discountAmount = 0;

        if (! empty($validated['discount_code'])) {
            $discount = Discount::where('code', strtoupper($validated['discount_code']))
                ->where('is_active', true)
                ->first();
            if ($discount && $discount->isValid() && $subtotal >= $discount->min_purchase) {
                $discountAmount = $discount->calculateDiscount($subtotal);
            }
        }

        DB::beginTransaction();
        try {
            foreach ($cartItems as $item) {
                if ($item->product->stock_quantity < $item->quantity) {
                    throw new \Exception('Insufficient stock for ' . $item->product->name);
                }
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'discount_amount' => $discountAmount,
                'status' => 'Pending',
                'shipping_address' => $validated['shipping_address'],
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);
                $item->product->decrement('stock_quantity', $item->quantity);
                $item->product->updateStatus();
            }

            auth()->user()->cartItems()->delete();
            DB::commit();

            try {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(
                    new \App\Mail\OrderReceiptMail($order->fresh(['orderItems.product', 'user']))
                );
            } catch (\Throwable $e) {
                report($e);
            }

            return redirect()->route('orders.receipt', $order)->with('success', 'Order placed successfully! Order #' . $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
