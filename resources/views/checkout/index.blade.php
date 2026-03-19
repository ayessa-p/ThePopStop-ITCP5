@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<h1 style="color: var(--dark-brown);">Checkout</h1>
<form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    <div style="margin-bottom: 1rem;">
        <label for="shipping_address">Shipping Address *</label>
        <textarea name="shipping_address" id="shipping_address" rows="3" required style="width: 100%; padding: 0.5rem;">{{ $user->address }}</textarea>
        @error('shipping_address')<span style="color:red;">{{ $message }}</span>@enderror
    </div>
    <div style="margin-bottom: 1rem;">
        <label for="payment_method">Payment Method *</label>
        <select name="payment_method" id="payment_method" required style="padding: 0.5rem;">
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="GCash">GCash</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select>
    </div>
    <div style="margin-bottom: 1rem;">
        <label for="discount_code">Discount Code</label>
        <input type="text" name="discount_code" id="discount_code" value="{{ old('discount_code') }}" placeholder="Enter code" style="padding: 0.5rem;">
    </div>
    <div style="margin: 2rem 0;">
        <h3>Order Summary</h3>
        @foreach($cartItems as $item)
            <p>{{ $item->product->name }} x {{ $item->quantity }} = P{{ number_format($item->product->price * $item->quantity, 2) }}</p>
        @endforeach
        <p><strong>Subtotal: P{{ number_format($subtotal, 2) }}</strong></p>
    </div>
    <button type="submit" class="btn btn-primary">Place Order</button>
    <a href="{{ route('cart.index') }}" class="btn btn-secondary">Back to Cart</a>
</form>
@endsection
