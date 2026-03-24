@extends('layouts.app')

@section('title', 'Receipt #' . $order->id)

@push('styles')
<style>
    .receipt-wrapper {
        max-width: 780px;
        margin: 0 auto 2rem;
    }

    .receipt-page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-bottom: .25rem;
    }
    .receipt-page-subtitle {
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

    /* Receipt Card */
    .receipt-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,.07);
        overflow: hidden;
    }

    /* Receipt Header */
    .receipt-header {
        background: linear-gradient(135deg, var(--accent), var(--primary));
        padding: 2.25rem 2.5rem;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    .receipt-brand {
        display: flex;
        flex-direction: column;
        gap: .3rem;
    }
    .receipt-brand-name {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: .5px;
    }
    .receipt-brand-sub {
        font-size: .85rem;
        opacity: .8;
    }
    .receipt-order-ref {
        text-align: right;
    }
    .receipt-order-label {
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: .7;
        margin-bottom: .3rem;
    }
    .receipt-order-id {
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: .5px;
    }
    .receipt-order-date {
        font-size: .8rem;
        opacity: .75;
        margin-top: .2rem;
    }

    /* Meta Info Strip */
    .receipt-meta-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1.5px solid #f0ede6;
    }
    .receipt-meta-item {
        padding: 1.25rem 2rem;
        border-right: 1.5px solid #f0ede6;
    }
    .receipt-meta-item:last-child { border-right: none; }
    .receipt-meta-label {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #bbb;
        margin-bottom: .35rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }
    .receipt-meta-label svg { color: var(--primary); }
    .receipt-meta-value {
        font-size: .9rem;
        font-weight: 600;
        color: #444;
        line-height: 1.4;
    }

    /* Items Section */
    .receipt-section {
        padding: 1.75rem 2.5rem;
        border-bottom: 1.5px solid #f0ede6;
    }
    .receipt-section:last-child { border-bottom: none; }
    .receipt-section-title {
        font-size: .75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: #bbb;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .receipt-section-title svg { color: var(--primary); }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-table thead tr {
        background: #f7f5f0;
        border-radius: 8px;
    }
    .items-table th {
        padding: .65rem 1rem;
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #aaa;
        text-align: left;
        white-space: nowrap;
    }
    .items-table th:first-child { border-radius: 8px 0 0 8px; }
    .items-table th:last-child  { border-radius: 0 8px 8px 0; text-align: right; }
    .items-table th:nth-child(2),
    .items-table th:nth-child(3) { text-align: center; }

    .items-table tbody tr {
        border-bottom: 1px solid #f5f2eb;
    }
    .items-table tbody tr:last-child { border-bottom: none; }
    .items-table tbody tr:hover { background: #fdfcfa; }

    .items-table td {
        padding: .85rem 1rem;
        font-size: .9rem;
        color: #444;
        vertical-align: middle;
    }
    .items-table td:first-child { font-weight: 600; color: var(--dark-brown); }
    .items-table td:last-child  { text-align: right; font-weight: 700; color: var(--dark-brown); }
    .items-table td:nth-child(2),
    .items-table td:nth-child(3) { text-align: center; color: #666; }

    /* Totals */
    .totals-block {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1.5px solid #f0ede6;
        gap: .4rem;
    }
    .totals-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 260px;
        font-size: .88rem;
        color: #666;
    }
    .totals-row.discount { color: #065f46; }
    .totals-row.grand {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-top: .4rem;
        padding-top: .6rem;
        border-top: 2px solid #e8e4dc;
    }
    .free-badge {
        background: #d1fae5;
        color: #065f46;
        font-size: .72rem;
        font-weight: 700;
        padding: .15rem .5rem;
        border-radius: 999px;
    }

    /* Thank you note */
    .receipt-thank-you {
        background: #faf8f4;
        padding: 1.5rem 2.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .receipt-thank-you svg { color: var(--primary); flex-shrink: 0; }
    .receipt-thank-you p {
        font-size: .88rem;
        color: #777;
        margin: 0;
        line-height: 1.5;
    }
    .receipt-thank-you strong { color: var(--dark-brown); }

    /* Actions */
    .receipt-actions {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }
    .btn-receipt-action {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .72rem 1.35rem;
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
    .btn-receipt-back {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    .btn-receipt-back:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }
    .btn-receipt-print {
        background: #f5f2eb;
        color: var(--dark-brown);
        border-color: #e8e4dc;
    }
    .btn-receipt-print:hover {
        background: #ede9df;
        border-color: #dbd6cc;
        color: var(--dark-brown);
    }

    @media print {
        .site-header,
        .site-footer,
        .receipt-actions,
        .receipt-page-title,
        .receipt-page-subtitle { display: none !important; }
        body { background: #fff !important; margin: 0; }
        .receipt-wrapper { max-width: 100%; margin: 0; }
        .receipt-card {
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
        }
        .receipt-header {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .receipt-meta-strip,
        .receipt-section { page-break-inside: avoid; }
        @page { margin: 0.8cm 1cm; }
    }

    @media (max-width: 640px) {
        .receipt-header { flex-direction: column; align-items: flex-start; }
        .receipt-order-ref { text-align: left; }
        .receipt-meta-strip { grid-template-columns: 1fr; }
        .receipt-meta-item { border-right: none; border-bottom: 1.5px solid #f0ede6; }
        .receipt-meta-item:last-child { border-bottom: none; }
        .receipt-section { padding: 1.5rem 1.25rem; }
        .receipt-header { padding: 1.75rem 1.25rem; }
        .totals-row { width: 100%; }
        .totals-block { align-items: stretch; }
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

<div class="receipt-wrapper">

    <h1 class="receipt-page-title">Order Receipt</h1>
    <p class="receipt-page-subtitle">A copy of this receipt has been sent to your email address.</p>

    <div class="receipt-card">

        {{-- ===== Header ===== --}}
        <div class="receipt-header">
            <div class="receipt-brand">
                <div class="receipt-brand-name">The Pop Stop</div>
                <div class="receipt-brand-sub">Official Order Receipt</div>
            </div>
            <div class="receipt-order-ref">
                <div class="receipt-order-label">Order Reference</div>
                <div class="receipt-order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="receipt-order-date">{{ $order->created_at->format('F d, Y') }}</div>
            </div>
        </div>

        {{-- ===== Meta Strip ===== --}}
        <div class="receipt-meta-strip">
            <div class="receipt-meta-item">
                <div class="receipt-meta-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Customer
                </div>
                <div class="receipt-meta-value">{{ $order->user->full_name ?? $order->user->name }}</div>
                <div style="font-size:.78rem;color:#aaa;margin-top:.15rem;">{{ $order->user->email }}</div>
            </div>
            <div class="receipt-meta-item">
                <div class="receipt-meta-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    Payment Method
                </div>
                <div class="receipt-meta-value">{{ $order->payment_method }}</div>
            </div>
            <div class="receipt-meta-item">
                <div class="receipt-meta-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Order Status
                </div>
                <div class="receipt-meta-value">
                    <span class="status-badge {{ $statusClass }}">
                        <span class="dot"></span>
                        {{ $order->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ===== Shipping Address ===== --}}
        <div class="receipt-section">
            <div class="receipt-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Shipping Address
            </div>
            <p style="font-size:.9rem;color:#555;margin:0;line-height:1.6;">{{ $order->shipping_address }}</p>
        </div>

        {{-- ===== Order Items ===== --}}
        <div class="receipt-section">
            <div class="receipt-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Items Ordered &mdash; {{ $order->orderItems->sum('quantity') }} item(s)
            </div>

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
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>&#8369;{{ number_format($item->unit_price, 2) }}</td>
                            <td>&#8369;{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals-block">
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span>&#8369;{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="totals-row discount">
                        <span>Discount</span>
                        <span>&minus;&#8369;{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="totals-row">
                    <span>Shipping</span>
                    <span class="free-badge">Free</span>
                </div>
                <div class="totals-row grand">
                    <span>Total Paid</span>
                    <span>&#8369;{{ number_format($order->final_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- ===== Thank You Note ===== --}}
        <div class="receipt-thank-you">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <p>
                <strong>Thank you for your order!</strong><br>
                We appreciate your support. A copy of this receipt has been sent to <strong>{{ $order->user->email }}</strong>.
                If you have any questions, please contact us at <strong>thepopstopmail@gmail.com</strong>.
            </p>
        </div>

    </div>

    {{-- ===== Actions ===== --}}
    <div class="receipt-actions">
        <a href="{{ route('orders.index') }}" class="btn-receipt-action btn-receipt-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>
        <button onclick="window.print()" class="btn-receipt-action btn-receipt-print">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Receipt
        </button>
        <a href="{{ route('orders.receipt.pdf', $order) }}" class="btn-receipt-action btn-receipt-back" style="background:var(--primary);color:#fff;border-color:var(--primary);" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download PDF
        </a>
    </div>

</div>

@endsection
