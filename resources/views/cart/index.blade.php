@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<h1 style="color: var(--dark-brown);">Shopping Cart</h1>

@if($cartItems->isEmpty())
    <p>Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a>.</p>
@else
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div>
            @foreach($cartItems as $item)
                <div style="display: flex; gap: 1rem; padding: 1rem; border: 1px solid #eee; margin-bottom: 1rem; border-radius: 8px;">
                    <div style="width: 100px; height: 100px;">
                        <img src="{{ $item->product->photo_url }}" alt="{{ $item->product->name }}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div style="flex: 1;">
                        <strong>{{ $item->product->name }}</strong>
                        <p>₱{{ number_format($item->product->price, 2) }} each × {{ $item->quantity }} = ₱{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('cart.update', $item) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" style="width: 60px; padding: 0.25rem;">
                            <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                        </form>
                        <form method="POST" action="{{ route('cart.destroy', $item) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 8px; height: fit-content;">
            <h3>Subtotal: ₱{{ number_format($subtotal, 2) }}</h3>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width: 100%;">Proceed to Checkout</a>
        </div>
    </div>
@endif
@endsection
