@extends('layouts.app')
@section('title', 'Order #' . $order->id)

@push('styles')
<style>
    .order-detail-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-bottom: .25rem;
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-wrap: wrap;
    }
    .order-detail-subtitle {
        color: #999;
        font-size: .9rem;
        margin-bottom: 2rem;
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
        vertical-align: middle;
    }
    .status-badge .dot {
        width: 6px; height: 6px;
        border-radius: 50%; flex-shrink: 0;
    }
    .status-pending    { background: #fef9ec; color: #b45309; }
    .status-pending .dot    { background: #f59e0b; }
    .status-processing { background: #eff6ff; color: #1d4ed8; }
    .status-processing .dot { background: #3b82f6; }
    .status-shipped    { background: #f0fdf4; color: #15803d; }
    .status-shipped .dot    { background: #22c55e; }
    .status-delivered  { background: #f0fdf4; color: #065f46; }
    .status-delivered .dot  { background: #10b981; }
    .status-cancelled  { background: #fff1f2; color: #be123c; }
    .status-cancelled .dot  { background: #f43f5e; }

    /* Layout */
    .order-detail-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 1.75rem;
        align-items: start;
    }

    /* Cards */
    .od-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 1.75rem;
        margin-bottom: 1.25rem;
    }
    .od-card:last-child { margin-bottom: 0; }
    .od-card-title {
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
    .od-card-title svg { color: var(--primary); flex-shrink: 0; }

    /* Info grid */
    .od-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem 1.5rem;
    }
    .od-info-item { }
    .od-info-label {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #bbb;
        margin-bottom: .3rem;
    }
    .od-info-value {
        font-size: .92rem;
        font-weight: 600;
        color: #444;
        line-height: 1.4;
    }

    /* Items Table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-table thead tr {
        background: #f7f5f0;
    }
    .items-table th {
        padding: .7rem 1rem;
        text-align: left;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #999;
        white-space: nowrap;
    }
    .items-table th:last-child { text-align: right; }
    .items-table th:nth-child(2),
    .items-table th:nth-child(3) { text-align: center; }
    .items-table th:first-child { border-radius: 8px 0 0 8px; }
    .items-table th:last-child  { border-radius: 0 8px 8px 0; }

    .items-table tbody tr {
        border-bottom: 1px solid #f5f2eb;
        transition: background .15s;
    }
    .items-table tbody tr:last-child { border-bottom: none; }
    .items-table tbody tr:hover { background: #fdfcfa; }
    .items-table td {
        padding: .9rem 1rem;
        font-size: .9rem;
        color: #444;
        vertical-align: middle;
    }
    .items-table td:nth-child(2),
    .items-table td:nth-child(3) { text-align: center; }
    .items-table td:last-child { text-align: right; font-weight: 700; color: var(--dark-brown); }

    .item-name-cell {
        font-weight: 600;
        color: var(--dark-brown);
    }

    /* Totals */
    .totals-section {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1.5px solid #f0ede6;
    }
    .totals-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .35rem 0;
        font-size: .9rem;
        color: #666;
    }
    .totals-row.grand {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-top: .4rem;
        padding-top: .6rem;
        border-top: 2px solid #e8e4dc;
    }
    .totals-row.discount-row { color: #065f46; }

    /* Right sidebar */
    .sidebar-sticky { position: sticky; top: 90px; }

    .od-info-block {
        display: flex;
        flex-direction: column;
        gap: .85rem;
    }
    .od-block-item {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        padding: .85rem;
        background: #faf8f4;
        border-radius: 10px;
    }
    .od-block-item svg { color: var(--primary); flex-shrink: 0; margin-top: 1px; }
    .od-block-content { }
    .od-block-label {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #bbb;
        margin-bottom: .2rem;
    }
    .od-block-value {
        font-size: .88rem;
        font-weight: 600;
        color: #444;
        line-height: 1.4;
    }

    /* Actions */
    .od-actions {
        display: flex;
        flex-direction: column;
        gap: .6rem;
        margin-top: 1.25rem;
    }
    .btn-od-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .75rem 1rem;
        border-radius: 10px;
        font-size: .88rem;
        font-weight: 700;
        text-decoration: none;
        transition: all .2s;
        border: 2px solid transparent;
        cursor: pointer;
        font-family: inherit;
        letter-spacing: .2px;
    }
    .btn-od-receipt {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    .btn-od-receipt:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }
    .btn-od-back {
        background: #f5f2eb;
        color: var(--dark-brown);
        border-color: #e8e4dc;
    }
    .btn-od-back:hover {
        background: #ede9df;
        border-color: #dbd6cc;
        color: var(--dark-brown);
    }

    @media (max-width: 820px) {
        .order-detail-layout { grid-template-columns: 1fr; }
        .sidebar-sticky { position: static; }
        .od-info-grid { grid-template-columns: 1fr 1fr; }
        .od-actions { flex-direction: row; }
        .btn-od-action { flex: 1; }
    }
    @media (max-width: 480px) {
        .od-info-grid { grid-template-columns: 1fr; }
        .od-actions { flex-direction: column; }
    }
</style>
@endpush

@section('content')

@php
    $statusClass = match($order->status) {
        'Pending'    => 'status-pending',
        'Processing' => 'status-processing',
        'Shipped'    => 'status-shipped',
        'Delivered'  => 'status-delivered',
        'Cancelled'  => 'status-cancelled',
        default      => 'status-pending',
    };
@endphp

<h1 class="order-detail-title">
    Order #{{ $order->id }}
    <span class="status-badge {{ $statusClass }}">
        <span class="dot"></span>
        {{ $order->status }}
    </span>
</h1>
<p class="order-detail-subtitle">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>

<div class="order-detail-layout">

    {{-- ===== LEFT COLUMN ===== --}}
    <div>

        {{-- Order Items --}}
        <div class="od-card">
            <h2 class="od-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Items Ordered
                <span style="margin-left:auto;font-size:.78rem;font-weight:600;color:#bbb;">{{ $order->orderItems->sum('quantity') }} item(s)</span>
            </h2>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td class="item-name-cell">{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>&#8369;{{ number_format($item->unit_price, 2) }}</td>
                            <td>&#8369;{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals-section">
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span>&#8369;{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="totals-row discount-row">
                        <span>Discount Applied</span>
                        <span>&minus;&#8369;{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="totals-row">
                    <span>Shipping</span>
                    <span style="background:#d1fae5;color:#065f46;font-size:.72rem;font-weight:700;padding:.15rem .5rem;border-radius:999px;">Free</span>
                </div>
                <div class="totals-row grand">
                    <span>Total Paid</span>
                    <span>&#8369;{{ number_format($order->final_amount, 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== RIGHT COLUMN ===== --}}
    <div class="sidebar-sticky">

        {{-- Order Info --}}
        <div class="od-card">
            <h2 class="od-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Order Details
            </h2>

            <div class="od-info-block">
                <div class="od-block-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div class="od-block-content">
                        <div class="od-block-label">Shipping Address</div>
                        <div class="od-block-value">{{ $order->shipping_address }}</div>
                    </div>
                </div>

                <div class="od-block-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    <div class="od-block-content">
                        <div class="od-block-label">Payment Method</div>
                        <div class="od-block-value">{{ $order->payment_method }}</div>
                    </div>
                </div>

                <div class="od-block-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div class="od-block-content">
                        <div class="od-block-label">Order Date</div>
                        <div class="od-block-value">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="od-actions">
                <a href="{{ route('orders.receipt', $order) }}" class="btn-od-action btn-od-receipt">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    View Receipt
                </a>
                <a href="{{ route('orders.index') }}" class="btn-od-action btn-od-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Orders
                </a>
            </div>
        </div>

    </div>

</div>

@endsection
