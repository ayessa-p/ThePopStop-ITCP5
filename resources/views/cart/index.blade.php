@extends('layouts.app')

@section('title', 'Shopping Cart')

@push('styles')
<style>
    .cart-page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-bottom: .25rem;
    }
    .cart-page-subtitle {
        color: #999;
        font-size: .9rem;
        margin-bottom: 2rem;
    }
    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.75rem;
        align-items: start;
    }

    /* Items Panel */
    .cart-items-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        overflow: hidden;
    }
    .cart-items-header {
        padding: 1.25rem 1.75rem;
        border-bottom: 1.5px solid #f0ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cart-items-header h2 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin: 0;
        display: flex;
        align-items: center;
        gap: .55rem;
    }
    .cart-items-header h2 svg { color: var(--primary); }
    .cart-count-badge {
        background: var(--primary);
        color: #fff;
        font-size: .72rem;
        font-weight: 700;
        padding: .2rem .6rem;
        border-radius: 999px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid #f7f5f0;
        transition: background .15s;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background: #fdfcfa; }

    .cart-item-img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        background: var(--light-beige);
        flex-shrink: 0;
        border: 1.5px solid #f0ede6;
    }
    .cart-item-img-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        background: var(--light-beige);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ccc;
        border: 1.5px solid #f0ede6;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
    }
    .cart-item-name {
        font-size: .95rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: .2rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-item-meta {
        font-size: .8rem;
        color: #aaa;
        margin-bottom: .5rem;
    }
    .cart-item-unit-price {
        font-size: .85rem;
        font-weight: 600;
        color: #888;
    }

    .cart-item-controls {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: .6rem;
        flex-shrink: 0;
    }
    .cart-item-total {
        font-size: 1rem;
        font-weight: 800;
        color: var(--primary);
        white-space: nowrap;
    }

    /* Quantity control */
    .qty-form {
        display: flex;
        align-items: center;
        gap: .4rem;
    }
    .qty-input {
        width: 54px;
        padding: .4rem .5rem;
        border: 2px solid #e8e4dc;
        border-radius: 8px;
        font-size: .88rem;
        font-weight: 600;
        color: #333;
        text-align: center;
        outline: none;
        transition: border-color .2s;
        font-family: inherit;
    }
    .qty-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(139,0,0,.08);
    }
    .btn-qty-update {
        padding: .4rem .75rem;
        background: #f5f2eb;
        border: 2px solid #e8e4dc;
        border-radius: 8px;
        font-size: .78rem;
        font-weight: 700;
        color: #555;
        cursor: pointer;
        white-space: nowrap;
        transition: all .2s;
        font-family: inherit;
    }
    .btn-qty-update:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    .btn-remove {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .35rem .65rem;
        background: none;
        border: 1.5px solid #f0ede6;
        border-radius: 7px;
        font-size: .75rem;
        font-weight: 600;
        color: #ccc;
        cursor: pointer;
        transition: all .2s;
        font-family: inherit;
    }
    .btn-remove:hover {
        border-color: #e74c3c;
        color: #e74c3c;
        background: #fff5f5;
    }

    /* Summary Card */
    .summary-sticky { position: sticky; top: 90px; }
    .summary-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 1.75rem;
    }
    .summary-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin: 0 0 1.4rem 0;
        padding-bottom: .9rem;
        border-bottom: 1.5px solid #f0ede6;
        display: flex;
        align-items: center;
        gap: .55rem;
    }
    .summary-card-title svg { color: var(--primary); }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .88rem;
        color: #666;
        margin-bottom: .5rem;
    }
    .summary-row.total {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-top: .75rem;
        padding-top: .75rem;
        border-top: 2px solid #f0ede6;
        margin-bottom: 0;
    }
    .free-badge {
        background: #d1fae5;
        color: #065f46;
        font-size: .72rem;
        font-weight: 700;
        padding: .15rem .5rem;
        border-radius: 999px;
    }
    .btn-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        width: 100%;
        padding: .95rem 1rem;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        margin-top: 1.4rem;
        text-decoration: none;
        transition: background .2s, transform .1s;
        letter-spacing: .2px;
        font-family: inherit;
    }
    .btn-checkout:hover {
        background: var(--accent);
        transform: translateY(-1px);
        color: #fff;
    }
    .btn-checkout:active { transform: translateY(0); }

    .btn-continue-shopping {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        margin-top: .9rem;
        color: #aaa;
        text-decoration: none;
        font-size: .85rem;
        font-weight: 500;
        transition: color .2s;
    }
    .btn-continue-shopping:hover { color: var(--primary); }

    /* Empty cart */
    .cart-empty {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 4rem 2rem;
        text-align: center;
    }
    .cart-empty svg {
        color: #e0dbd0;
        margin-bottom: 1.25rem;
    }
    .cart-empty h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: .4rem;
    }
    .cart-empty p {
        color: #aaa;
        font-size: .9rem;
        margin-bottom: 1.75rem;
    }

    @media (max-width: 820px) {
        .cart-layout { grid-template-columns: 1fr; }
        .summary-sticky { position: static; }
        .cart-item { flex-wrap: wrap; gap: 1rem; }
        .cart-item-controls { flex-direction: row; align-items: center; width: 100%; justify-content: space-between; }
    }
    @media (max-width: 480px) {
        .cart-item { padding: 1rem; }
        .cart-items-header { padding: 1rem; }
    }
</style>
@endpush

@section('content')

<h1 class="cart-page-title">Shopping Cart</h1>
<p class="cart-page-subtitle">Review your items before checkout</p>

@if($cartItems->isEmpty())
    <div class="cart-empty">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <h3>Your cart is empty</h3>
        <p>Looks like you haven't added any items yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:.5rem;padding:.8rem 2rem;border-radius:10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Browse Products
        </a>
    </div>
@else
    <div class="cart-layout">

        {{-- Items Column --}}
        <div>
            <div class="cart-items-card">
                <div class="cart-items-header">
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Cart Items
                    </h2>
                    <span class="cart-count-badge">{{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }}</span>
                </div>

                @foreach($cartItems as $item)
                    <div class="cart-item">
                        {{-- Product Image --}}
                        @if($item->product->photo_url)
                            <img src="{{ $item->product->photo_url }}" alt="{{ $item->product->name }}" class="cart-item-img">
                        @else
                            <div class="cart-item-img-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Info --}}
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item->product->name }}</div>
                            <div class="cart-item-meta">{{ $item->product->series }} &mdash; {{ $item->product->brand }}</div>
                            <div class="cart-item-unit-price">&#8369;{{ number_format($item->product->price, 2) }} each</div>
                        </div>

                        {{-- Controls --}}
                        <div class="cart-item-controls">
                            <div class="cart-item-total">&#8369;{{ number_format($item->product->price * $item->quantity, 2) }}</div>

                            <form method="POST" action="{{ route('cart.update', $item) }}" class="qty-form">
                                @csrf
                                @method('PUT')
                                <input
                                    type="number"
                                    name="quantity"
                                    value="{{ $item->quantity }}"
                                    min="1"
                                    max="{{ $item->product->stock_quantity }}"
                                    class="qty-input"
                                >
                                <button type="submit" class="btn-qty-update">Update</button>
                            </form>

                            <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Summary Column --}}
        <div class="summary-sticky">
            <div class="summary-card">
                <h2 class="summary-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Order Summary
                </h2>

                <div class="summary-row">
                    <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                    <span>&#8369;{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="free-badge">Free</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>&#8369;{{ number_format($subtotal, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-checkout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Proceed to Checkout
                </a>

                <a href="{{ route('products.index') }}" class="btn-continue-shopping">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Continue Shopping
                </a>
            </div>
        </div>

    </div>
@endif

@endsection
