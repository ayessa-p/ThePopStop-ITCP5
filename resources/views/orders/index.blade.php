@extends('layouts.app')
@section('title', 'My Orders')

@push('styles')
<style>
    .orders-page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-bottom: .25rem;
    }
    .orders-page-subtitle {
        color: #999;
        font-size: .9rem;
        margin-bottom: 2rem;
    }

    /* Empty state */
    .orders-empty {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 4rem 2rem;
        text-align: center;
        color: #bbb;
    }
    .orders-empty svg { color: #ddd; margin-bottom: 1rem; }
    .orders-empty h3 { font-size: 1.15rem; font-weight: 700; color: #aaa; margin-bottom: .5rem; }
    .orders-empty p { font-size: .9rem; margin-bottom: 1.5rem; }

    /* Order card */
    .order-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        margin-bottom: 1rem;
        overflow: hidden;
        transition: box-shadow .2s;
    }
    .order-card:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,.1);
    }

    /* Card header */
    .order-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-bottom: 1.5px solid #f0ede6;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .order-id-block {
        display: flex;
        align-items: center;
        gap: .6rem;
    }
    .order-id-block svg { color: var(--primary); flex-shrink: 0; }
    .order-id-text {
        font-size: .95rem;
        font-weight: 700;
        color: var(--dark-brown);
    }
    .order-date-text {
        font-size: .78rem;
        color: #aaa;
        font-weight: 500;
    }
    .order-header-right {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    /* Status badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .85rem;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .3px;
        white-space: nowrap;
    }
    .status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .status-pending   { background: #fef9ec; color: #b45309; }
    .status-pending .dot   { background: #f59e0b; }
    .status-processing { background: #eff6ff; color: #1d4ed8; }
    .status-processing .dot { background: #3b82f6; }
    .status-shipped   { background: #f0fdf4; color: #15803d; }
    .status-shipped .dot   { background: #22c55e; }
    .status-delivered { background: #f0fdf4; color: #065f46; }
    .status-delivered .dot { background: #10b981; }
    .status-cancelled { background: #fff1f2; color: #be123c; }
    .status-cancelled .dot { background: #f43f5e; }

    /* Card body */
    .order-card-body {
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .order-meta {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }
    .order-meta-item {
        display: flex;
        flex-direction: column;
        gap: .15rem;
    }
    .meta-label {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #bbb;
    }
    .meta-value {
        font-size: .92rem;
        font-weight: 600;
        color: #444;
    }
    .meta-value.amount {
        color: var(--primary);
        font-size: 1rem;
        font-weight: 800;
    }

    /* Action buttons */
    .order-actions {
        display: flex;
        gap: .5rem;
        flex-shrink: 0;
    }
    .btn-order-action {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .5rem 1rem;
        border-radius: 8px;
        font-size: .82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all .15s;
        border: 2px solid transparent;
        cursor: pointer;
        white-space: nowrap;
    }
    .btn-order-view {
        background: #f5f2eb;
        color: var(--dark-brown);
        border-color: #e8e4dc;
    }
    .btn-order-view:hover {
        background: var(--dark-brown);
        color: #fff;
        border-color: var(--dark-brown);
    }
    .btn-order-receipt {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    .btn-order-receipt:hover {
        background: var(--accent);
        border-color: var(--accent);
    }

    /* Divider */
    .order-card-divider {
        height: 1px;
        background: #f5f2eb;
        margin: 0 1.5rem;
    }

    /* Pagination */
    .pagination-wrap {
        margin-top: 1.5rem;
    }

    @media (max-width: 640px) {
        .order-card-header { flex-direction: column; align-items: flex-start; }
        .order-card-body { flex-direction: column; align-items: flex-start; }
        .order-meta { gap: 1rem; }
        .order-actions { width: 100%; }
        .btn-order-action { flex: 1; justify-content: center; }
    }
</style>
@endpush

@section('content')

<h1 class="orders-page-title">My Orders</h1>
<p class="orders-page-subtitle">Track and manage all your purchases</p>

@php
    function orderStatusClass($status) {
        return match($status) {
            'Pending'    => 'status-pending',
            'Processing' => 'status-processing',
            'Shipped'    => 'status-shipped',
            'Delivered'  => 'status-delivered',
            'Cancelled'  => 'status-cancelled',
            default      => 'status-pending',
        };
    }
@endphp

@forelse($orders as $order)
    <div class="order-card">

        {{-- Header --}}
        <div class="order-card-header">
            <div class="order-id-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <div>
                    <div class="order-id-text">Order #{{ $order->id }}</div>
                    <div class="order-date-text">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</div>
                </div>
            </div>
            <div class="order-header-right">
                <span class="status-badge {{ orderStatusClass($order->status) }}">
                    <span class="dot"></span>
                    {{ $order->status }}
                </span>
            </div>
        </div>

        {{-- Body --}}
        <div class="order-card-body">
            <div class="order-meta">
                <div class="order-meta-item">
                    <span class="meta-label">Total Amount</span>
                    <span class="meta-value amount">&#8369;{{ number_format($order->final_amount, 2) }}</span>
                </div>
                <div class="order-meta-item">
                    <span class="meta-label">Items</span>
                    <span class="meta-value">{{ $order->orderItems->sum('quantity') }} item(s)</span>
                </div>
                <div class="order-meta-item">
                    <span class="meta-label">Payment</span>
                    <span class="meta-value">{{ $order->payment_method }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="order-meta-item">
                        <span class="meta-label">Discount</span>
                        <span class="meta-value" style="color:#065f46;">-&#8369;{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
            </div>

            <div class="order-actions">
                @if($order->status === 'Delivered')
                    <a href="{{ route('orders.show', $order) }}#items-ordered" class="btn-order-action" style="background:#065f46; color:#fff; border-color:#065f46;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.09 1.236.321 1.728l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.769-.492-.648-1.728.321-1.728h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Review
                    </a>
                @endif
                <a href="{{ route('orders.show', $order) }}" class="btn-order-action btn-order-view">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View
                </a>
                <a href="{{ route('orders.receipt', $order) }}" class="btn-order-action btn-order-receipt">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Receipt
                </a>
            </div>
        </div>

    </div>
@empty
    <div class="orders-empty">
        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <h3>No orders yet</h3>
        <p>You haven&rsquo;t placed any orders yet. Start shopping!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
    </div>
@endforelse

<div class="pagination-wrap">
    {{ $orders->links() }}
</div>

@endsection
