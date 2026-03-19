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

    /* ── Discount browser ───────────────────────────────────────────────── */
    .disc-browse-toggle {
        display: flex;
        align-items: center;
        gap: .55rem;
        width: 100%;
        padding: .65rem 1rem;
        background: #faf8f4;
        border: 1.5px dashed #e0dbd2;
        border-radius: 10px;
        color: #999;
        font-size: .83rem;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        font-family: inherit;
        text-align: left;
        margin-top: .85rem;
    }
    .disc-browse-toggle:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(139,0,0,.02);
    }
    .disc-toggle-arrow {
        margin-left: auto;
        transition: transform .28s ease;
        flex-shrink: 0;
        color: #bbb;
    }
    .disc-browse-toggle:hover .disc-toggle-arrow { color: var(--primary); }

    .disc-panel {
        max-height: 0;
        overflow: hidden;
        transition: max-height .35s ease, opacity .28s ease;
        opacity: 0;
    }
    .disc-panel-open {
        max-height: 700px;
        opacity: 1;
        overflow-y: auto;
    }
    .disc-panel-inner {
        padding-top: .85rem;
        display: flex;
        flex-direction: column;
        gap: .6rem;
    }

    /* Individual discount card */
    .disc-item {
        border: 1.5px solid #e8e4dc;
        border-radius: 10px;
        padding: .9rem 1rem;
        transition: border-color .2s, background .15s, box-shadow .2s;
        background: #fff;
    }
    .disc-item:hover { box-shadow: 0 2px 10px rgba(0,0,0,.06); }
    .disc-item.disc-ineligible { background: #fdfcfa; opacity: .8; }
    .disc-item.disc-applied {
        border-color: var(--primary);
        background: rgba(139,0,0,.03);
    }

    .disc-item-head {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin-bottom: .4rem;
        flex-wrap: wrap;
    }
    .disc-code {
        font-size: .8rem;
        font-weight: 800;
        letter-spacing: .8px;
        background: var(--primary);
        color: #fff;
        padding: .22rem .7rem;
        border-radius: 5px;
        font-family: 'Courier New', monospace;
    }
    .disc-applied .disc-code { background: #065f46; }

    .disc-value-badge {
        font-size: .78rem;
        font-weight: 700;
        padding: .2rem .65rem;
        border-radius: 999px;
        white-space: nowrap;
    }
    .disc-value-percentage { background: #eff6ff; color: #1d4ed8; }
    .disc-value-fixed      { background: #f0fdf4; color: #15803d; }

    .disc-desc {
        font-size: .83rem;
        color: #555;
        margin-bottom: .35rem;
        line-height: 1.45;
    }
    .disc-meta {
        font-size: .75rem;
        color: #bbb;
        margin-bottom: .65rem;
        display: flex;
        flex-wrap: wrap;
        gap: .25rem;
        align-items: center;
    }
    .disc-meta-dot { margin: 0 .1rem; }

    .disc-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .5rem;
    }
    .disc-status {
        display: flex;
        align-items: center;
        gap: .3rem;
        font-size: .76rem;
        font-weight: 700;
    }
    .disc-status-ok   { color: #065f46; }
    .disc-status-warn { color: #b45309; }
    .disc-status-applied { color: var(--primary); }

    .btn-use-code {
        font-size: .78rem;
        font-weight: 700;
        padding: .35rem .9rem;
        border-radius: 7px;
        background: var(--primary);
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background .15s;
        font-family: inherit;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .btn-use-code:hover   { background: var(--accent); }
    .disc-applied .btn-use-code { background: #065f46; }
    .disc-ineligible .btn-use-code {
        background: #e8e4dc;
        color: #aaa;
        cursor: default;
    }

    /* Code feedback strip */
    .code-feedback {
        font-size: .8rem;
        font-weight: 600;
        padding: .5rem .85rem;
        border-radius: 8px;
        margin-top: .5rem;
        display: flex;
        align-items: flex-start;
        gap: .45rem;
        line-height: 1.45;
    }
    .code-feedback svg { flex-shrink: 0; margin-top: 1px; }
    .code-feedback-success { background: #f0fdf4; color: #065f46; border: 1px solid #bbf7d0; }
    .code-feedback-error   { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .code-feedback-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }

    .remove-code-link {
        font-size: .75rem;
        color: #bbb;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        margin-top: .4rem;
        font-family: inherit;
        text-decoration: underline;
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        transition: color .2s;
    }
    .remove-code-link:hover { color: #c0392b; }

    /* Discount row in summary */
    .discount-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .83rem;
        color: #065f46;
        font-weight: 600;
        margin-bottom: .45rem;
        padding: .3rem .5rem;
        background: #f0fdf4;
        border-radius: 6px;
    }
    .discount-summary-row .disc-remove-btn {
        background: none;
        border: none;
        color: #aaa;
        cursor: pointer;
        font-size: .75rem;
        padding: 0;
        margin-left: .5rem;
        transition: color .2s;
        font-family: inherit;
    }
    .discount-summary-row .disc-remove-btn:hover { color: #c0392b; }

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
                    @if($discounts->count() > 0)
                        <span style="margin-left:auto;font-size:.72rem;font-weight:600;color:#bbb;">
                            {{ $discounts->count() }} code{{ $discounts->count() !== 1 ? 's' : '' }} available
                        </span>
                    @endif
                </h2>

                {{-- Manual code entry --}}
                <div class="co-field">
                    <label class="co-label" for="discount_code">Have a promo code?</label>
                    <div class="discount-row">
                        <input
                            type="text"
                            name="discount_code"
                            id="discount_code"
                            class="co-input"
                            value="{{ old('discount_code') }}"
                            placeholder="Enter code here"
                            autocomplete="off"
                            oninput="this.value = this.value.toUpperCase()"
                        >
                        <button type="button" class="btn-apply-code" onclick="applyDiscountCode()">Apply</button>
                    </div>
                    {{-- Feedback message --}}
                    <div id="code-feedback" class="code-feedback" style="display:none;"></div>
                    {{-- Remove applied code --}}
                    <button type="button" id="remove-code-btn" class="remove-code-link" style="display:none;" onclick="removeDiscountCode()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Remove applied code
                    </button>
                </div>

                @if($discounts->count() > 0)
                    {{-- Browse available codes toggle --}}
                    <button type="button" id="disc-toggle-btn" class="disc-browse-toggle" onclick="toggleDiscPanel()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        <span class="disc-toggle-text">Browse {{ $discounts->count() }} Available Code{{ $discounts->count() !== 1 ? 's' : '' }}</span>
                        <svg class="disc-toggle-arrow" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Discount list panel --}}
                    <div id="disc-panel" class="disc-panel">
                        <div class="disc-panel-inner">
                            @foreach($discounts as $discount)
                                @php
                                    $isEligible  = $subtotal >= $discount->min_purchase;
                                    $isPercent   = strtolower($discount->discount_type) === 'percentage';
                                    $valueBadge  = $isPercent
                                        ? $discount->discount_value . '% off'
                                        : '₱' . number_format($discount->discount_value, 0) . ' off';
                                    $badgeClass  = $isPercent ? 'disc-value-percentage' : 'disc-value-fixed';
                                    $savingsAmt  = $isPercent
                                        ? $subtotal * ($discount->discount_value / 100)
                                        : min($discount->discount_value, $subtotal);
                                @endphp
                                <div class="disc-item {{ $isEligible ? 'disc-eligible' : 'disc-ineligible' }}"
                                     id="disc-item-{{ $discount->code }}"
                                     data-code="{{ $discount->code }}">

                                    <div class="disc-item-head">
                                        <span class="disc-code">{{ $discount->code }}</span>
                                        <span class="disc-value-badge {{ $badgeClass }}">{{ $valueBadge }}</span>
                                        @if($isEligible)
                                            <span style="font-size:.72rem;font-weight:700;color:#065f46;margin-left:auto;">
                                                Save &#8369;{{ number_format($savingsAmt, 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($discount->description)
                                        <div class="disc-desc">{{ $discount->description }}</div>
                                    @endif

                                    <div class="disc-meta">
                                        @if($discount->min_purchase > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Min. &#8369;{{ number_format($discount->min_purchase, 0) }} purchase
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            No minimum purchase
                                        @endif
                                        <span class="disc-meta-dot">&bull;</span>
                                        @if($discount->end_date)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Expires {{ $discount->end_date->format('M d, Y') }}
                                        @else
                                            No expiry
                                        @endif
                                    </div>

                                    <div class="disc-footer">
                                        @if($isEligible)
                                            <span class="disc-status disc-status-ok">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Eligible for your order
                                            </span>
                                            <button type="button" class="btn-use-code"
                                                    onclick="useDiscountCode('{{ $discount->code }}')">
                                                Use Code
                                            </button>
                                        @else
                                            @php $needed = $discount->min_purchase - $subtotal; @endphp
                                            <span class="disc-status disc-status-warn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                Add &#8369;{{ number_format($needed, 2) }} more to unlock
                                            </span>
                                            <button type="button" class="btn-use-code disc-ineligible" disabled title="Add more items to unlock this code">
                                                Locked
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
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
                {{-- Dynamic discount row (hidden until a code is applied) --}}
                <div id="discount-summary-row" class="discount-summary-row" style="display:none;">
                    <span id="discount-summary-label" style="display:flex;align-items:center;gap:.35rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Discount
                    </span>
                    <span style="display:flex;align-items:center;gap:.4rem;">
                        <span id="discount-summary-amount" style="font-weight:700;">-&#8369;0.00</span>
                        <button type="button" class="disc-remove-btn" onclick="removeDiscountCode()" title="Remove discount">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </span>
                </div>
                <div class="total-row">
                    <span>Shipping</span>
                    <span class="free-badge">Free</span>
                </div>
                <div class="total-row grand">
                    <span>Total</span>
                    <span id="order-total-display">&#8369;{{ number_format($subtotal, 2) }}</span>
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

@push('scripts')
<script>
    const CO_SUBTOTAL  = {{ $subtotal }};
    const CO_DISCOUNTS = {!! json_encode($discounts->map(function($d) {
        return [
            'code'         => $d->code,
            'description'  => $d->description,
            'type'         => $d->discount_type,
            'value'        => (float) $d->discount_value,
            'min_purchase' => (float) $d->min_purchase,
            'end_date'     => $d->end_date ? $d->end_date->format('M d, Y') : null,
        ];
    })) !!};

    let currentAppliedCode = null;
    let panelOpen = false;

    // ── Toggle available codes panel ──────────────────────────────────────
    function toggleDiscPanel() {
        panelOpen = !panelOpen;
        const panel    = document.getElementById('disc-panel');
        const arrow    = document.querySelector('.disc-toggle-arrow');
        const textEl   = document.querySelector('.disc-toggle-text');
        const count    = CO_DISCOUNTS.length;

        if (panelOpen) {
            panel.classList.add('disc-panel-open');
            arrow.style.transform = 'rotate(180deg)';
            textEl.textContent    = 'Hide Available Codes';
        } else {
            panel.classList.remove('disc-panel-open');
            arrow.style.transform = '';
            textEl.textContent    = `Browse ${count} Available Code${count !== 1 ? 's' : ''}`;
        }
    }

    // ── Click "Use Code" on a discount card ───────────────────────────────
    function useDiscountCode(code) {
        document.getElementById('discount_code').value = code;
        applyDiscountCode();
        // Collapse the panel after selecting
        if (panelOpen) toggleDiscPanel();
    }

    // ── Apply button / manual code entry ─────────────────────────────────
    function applyDiscountCode() {
        const input    = document.getElementById('discount_code');
        const code     = input.value.trim().toUpperCase();

        if (!code) {
            showFeedback('Please enter a promo code.', 'warning',
                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>');
            return;
        }

        const discount = CO_DISCOUNTS.find(d => d.code.toUpperCase() === code);

        if (!discount) {
            showFeedback('This code is invalid or has expired.', 'error',
                '<path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>');
            clearSummaryDiscount();
            return;
        }

        if (CO_SUBTOTAL < discount.min_purchase) {
            const needed = discount.min_purchase - CO_SUBTOTAL;
            showFeedback(
                `This code requires a minimum order of ₱${fmt(discount.min_purchase)}. Add ₱${fmt(needed)} more to unlock it.`,
                'warning',
                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
            );
            clearSummaryDiscount();
            return;
        }

        // Calculate discount amount
        const isPercent = discount.type.toLowerCase() === 'percentage';
        const discAmt   = isPercent
            ? CO_SUBTOTAL * (discount.value / 100)
            : Math.min(discount.value, CO_SUBTOTAL);
        const newTotal  = CO_SUBTOTAL - discAmt;
        const typeLabel = isPercent ? `${discount.value}%` : `₱${fmt(discount.value)}`;

        // Update order summary
        document.getElementById('discount-summary-label').innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            ${code} &mdash; ${typeLabel} off`;
        document.getElementById('discount-summary-amount').textContent  = `-₱${fmt(discAmt)}`;
        document.getElementById('order-total-display').textContent       = `₱${fmt(newTotal)}`;
        document.getElementById('discount-summary-row').style.display    = 'flex';

        // Show success feedback
        showFeedback(
            `Code applied! You save ₱${fmt(discAmt)} on this order.`,
            'success',
            '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        );
        document.getElementById('remove-code-btn').style.display = 'inline-flex';

        // Highlight the matching card
        document.querySelectorAll('.disc-item').forEach(el => {
            el.classList.remove('disc-applied');
            const btn = el.querySelector('.btn-use-code');
            if (btn && !btn.disabled) btn.textContent = 'Use Code';
        });
        const activeCard = document.getElementById(`disc-item-${code}`);
        if (activeCard) {
            activeCard.classList.add('disc-applied');
            const btn = activeCard.querySelector('.btn-use-code');
            if (btn) btn.textContent = 'Applied ✓';
        }

        currentAppliedCode = code;
    }

    // ── Remove applied discount ───────────────────────────────────────────
    function removeDiscountCode() {
        document.getElementById('discount_code').value = '';
        document.getElementById('code-feedback').style.display   = 'none';
        document.getElementById('remove-code-btn').style.display = 'none';
        clearSummaryDiscount();

        // Reset all card states
        document.querySelectorAll('.disc-item').forEach(el => {
            el.classList.remove('disc-applied');
            const btn = el.querySelector('.btn-use-code');
            if (btn && !btn.disabled) btn.textContent = 'Use Code';
        });
        currentAppliedCode = null;
    }

    function clearSummaryDiscount() {
        document.getElementById('discount-summary-row').style.display = 'none';
        document.getElementById('order-total-display').textContent     = `₱${fmt(CO_SUBTOTAL)}`;
    }

    // ── Helpers ───────────────────────────────────────────────────────────
    function showFeedback(msg, type, iconPath) {
        const el = document.getElementById('code-feedback');
        el.className = `code-feedback code-feedback-${type}`;
        el.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;">
                ${iconPath}
            </svg>
            <span>${msg}</span>`;
        el.style.display = 'flex';
    }

    function fmt(amount) {
        return parseFloat(amount).toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    }
</script>
@endpush
@endsection
