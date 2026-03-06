<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $cartCount = auth()->user()->cartItems()->sum('quantity');

        return view('cart.index', compact('cartItems', 'subtotal', 'cartCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if ($product->stock_quantity < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock.');
        }

        $cart = auth()->user()->cartItems()->firstOrCreate(
            ['product_id' => $product->id],
            ['quantity' => 0]
        );
        $cart->quantity += $validated['quantity'];
        $cart->save();

        return back()->with('success', 'Item added to cart.');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validated['quantity'] === 0) {
            $cart->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
        }

        if ($cart->product->stock_quantity < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock.');
        }

        $cart->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
