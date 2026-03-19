@extends('layouts.app')
@section('title', 'Checkout')

@push('styles')
<style>
    .checkout-page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-bottom: .25rem;
    }
    .checkout-page-subtitle {
        color: #999;
        font-size: .9rem;
        margin-bottom: 2rem;
    }
    .checkout-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 1.75rem;
        align-items: start;
    }
    .co-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 1.75rem;
        margin-bottom: 1.25rem;
    }
    .co-card:last-child { margin-bottom: 0; }
    .co-card-title {
        display: flex;
        align-items: center;
        gap: .6rem;
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin: 0 0 1.4rem 0;
        padding-bottom: .9rem;
        border-bottom: 1.5px solid #f0ede6;
    }
    .co-card-title svg {
        color: var(--primary);
        flex-shrink: 0;
    }
    .co-label {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: .4rem;
    }
    .co-field {
        margin-bottom: 1.25rem;
    }
    .co-field:last-child { margin-bottom: 0; }
    .co-input,
    .co-textarea,
    .co-select {
        width: 100%;
        padding: .75rem 1rem;
        border: 2px solid #e8e4dc;
        border-radius: 10px;
        font-size: .93rem;
        color: #333;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        font-family: inherit;
    }
    .co-input:focus,
    .co-textarea:focus,
    .co-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(139,0,0,.09);
    }
    .co-textarea {
        resize: vertical;
        min-height: 90px;
        line-height: 1.55;
    }
    .co-select {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238B0000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .85rem center;
        background-size: 1.1rem;
        padding-right: 2.5rem;
        cursor: pointer;
    }
    .co-error {
        color: #c0392b;
        font-size: .8rem;
        margin-top: .3rem;
    }

    /* Payment option cards */
    .payment-options {
        display: flex;
        flex-direction: column;
        gap: .6rem;
    }
    .payment-option {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: .85rem 1rem;
        border: 2px solid #e8e4dc;
        border-radius: 10px;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        position: relative;
    }
    .payment-option:has(input:checked) {
        border-color: var(--primary);
        background: rgba(139,0,0,.03);
    }
    .payment-option input[type="radio"] {
        accent-color: var(--primary);
        width: 17px;
        height: 17px;
        cursor: pointer;
        flex-shrink: 0;
    }
    .payment-option-label {
        font-size: .92rem;
        font-weight: 600;
        color: #333;
        cursor: pointer;
        flex: 1;
    }
    .payment-option-icon {
        color: #aaa;
    }
    .payment-option:has(input:checked) .payment-option-label {
        color: var(--primary);
    }
    .payment-option:has(input:checked) .payment-option-icon {
        color: var(--primary);
    }

    /* Discount row */
    .discount-row {
        display: flex;
        gap: .5rem;
    }
    .discount-row .co-input {
        flex: 1;
    }
    .btn-apply-code {
        padding: .75rem 1.15rem;
        background: #f5f2eb;
        border: 2px solid #e8e4dc;
        border-radius: 10px;
        font-weight: 700;
        font-size: .85rem;
        color: var(--primary);
        cursor: pointer;
        white-space: nowrap;
        transition: all .2s;
        font-family: inherit;
    }
    .btn-apply-code:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    /* Order Summary (right column) */
    .summary-sticky {
        position: sticky;
        top: 90px;
    }
    .order-items-list { margin-bottom: .5rem; }
    .order-item-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: .75rem;
        padding: .7rem 0;
        border-bottom: 1px solid #f0ede6;
    }
    .order-item-row:last-child { border-bottom: none; }
    .oi-name {
        font-size: .88rem;
        color: #444;
        line-height: 1.35;
        flex: 1;
    }
    .oi-qty {
        display: inline-block;
        margin-top: .2rem;
        font-size: .77rem;
        color: #999;
        font-weight: 600;
    }
    .oi-price {
        font-size: .9rem;
        font-weight: 700;
        color: var(--dark-brown);
        white-space: nowrap;
    }

    .summary-divider {
        border: none;
        border-top: 1.5px solid #f0ede6;
        margin: 1rem 0;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .88rem;
        color: #666;
        margin-bottom: .45rem;
    }
    .total-row.grand {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-top: .5rem;
        padding-top: .6rem;
        border-top: 2px solid #e8e4dc;
        margin-bottom: 0;
    }
    .total-row .free-badge {
        background: #d1fae5;
        color: #065f46;
        font-size: .72rem;
        font-weight: 700;
        padding: .15rem .5rem;
        border-radius: 999px;
    }

    .btn-place-order {
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
        transition: background .2s, transform .1s;
        letter-spacing: .2px;
        font-family: inherit;
    }
    .btn-place-order:hover {
        background: var(--accent);
        transform: translateY(-1px);
    }
    .btn-place-order:active { transform: translateY(0); }

    .back-to-cart-link {
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
    .back-to-cart-link:hover { color: var(--primary); }

    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        font-size: .75rem;
        color: #bbb;
        margin-top: 1rem;
    }

    @media (max-width: 820px) {
        .checkout-layout { grid-template-columns: 1fr; }
        .summary-sticky { position: static; }
    }
</style>
@endpush

@section('content')

<h1 class="checkout-page-title">Checkout</h1>
<p class="checkout-page-subtitle">Complete your order below</p>

<form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    <div class="checkout-layout">

        {{-- ===== LEFT COLUMN ===== --}}
        <div>

            {{-- Shipping Address --}}
            <div class="co-card">
                <h2 class="co-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Shipping Address
                </h2>
                <div class="co-field">
                    <label class="co-label" for="shipping_address">Delivery Address <span style="color:var(--primary);">*</span></label>
                    <textarea
                        name="shipping_address"
                        id="shipping_address"
                        class="co-textarea"
                        rows="3"
                        required
                        placeholder="Enter your full delivery address..."
                    >{{ old('shipping_address', $user->address) }}</textarea>
                    @error('shipping_address')
                        <div class="co-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="co-card">
                <h2 class="co-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    Payment Method
                </h2>
                <div class="payment-options">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="Cash on Delivery" checked>
                        <span class="payment-option-label">Cash on Delivery</span>
                        <span class="payment-option-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="GCash">
                        <span class="payment-option-label">GCash</span>
                        <span class="payment-option-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="Bank Transfer">
                        <span class="payment-option-label">Bank Transfer</span>
                        <span class="payment-option-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Discount Code --}}
            <div class="co-card">
                <h2 class="co-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Promo Code
                </h2>
                <div class="co-field">
                    <label class="co-label" for="discount_code">Have a discount code?</label>
                    <div class="discount-row">
                        <input
                            type="text"
                            name="discount_code"
                            id="discount_code"
                            class="co-input"
                            value="{{ old('discount_code') }}"
                            placeholder="Enter code here"
                        >
                        <button type="button" class="btn-apply-code">Apply</button>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== RIGHT COLUMN: ORDER SUMMARY ===== --}}
        <div class="summary-sticky">
            <div class="co-card">
                <h2 class="co-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Order Summary
                    <span style="margin-left:auto;font-size:.78rem;font-weight:600;color:#bbb;">{{ $cartItems->count() }} item(s)</span>
                </h2>

                <div class="order-items-list">
                    @foreach($cartItems as $item)
                        <div class="order-item-row">
                            <div class="oi-name">
                                {{ $item->product->name }}
                                <span class="oi-qty">x{{ $item->quantity }}</span>
                            </div>
                            <div class="oi-price">&#8369;{{ number_format($item->product->price * $item->quantity, 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <hr class="summary-divider">

                <div class="total-row">
                    <span>Subtotal</span>
                    <span>&#8369;{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Shipping</span>
                    <span class="free-badge">Free</span>
                </div>
                <div class="total-row grand">
                    <span>Total</span>
                    <span>&#8369;{{ number_format($subtotal, 2) }}</span>
                </div>

                <button type="submit" class="btn-place-order">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Place Order
                </button>

                <a href="{{ route('cart.index') }}" class="back-to-cart-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Cart
                </a>

                <div class="secure-note">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Secure &amp; encrypted checkout
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
