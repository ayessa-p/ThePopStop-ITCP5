@extends('layouts.app')

@section('title', 'Order Details #' . $order->id . ' - Admin')

@push('styles')
<style>
    .admin-container { display: flex; gap: 2rem; padding: 2rem 0; }
    .admin-sidebar { width: 280px; background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); height: fit-content; }
    .admin-sidebar h2 { color: var(--primary); font-size: 1.25rem; margin-bottom: 2rem; font-weight: 700; }
    .sidebar-nav { display: flex; flex-direction: column; gap: 0.5rem; }
    .sidebar-link { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem; text-decoration: none; color: #666; border-radius: 12px; transition: all 0.2s; font-weight: 500; }
    .sidebar-link:hover { background: var(--bg); color: var(--primary); }
    .sidebar-link.active { background: var(--primary); color: white; }
    .admin-main { flex: 1; min-width: 0; }
    .admin-header h1 { color: var(--dark-brown); font-size: 2.25rem; font-weight: 700; margin-bottom: 2rem; }
    .details-section { background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem; }
    .info-block h2 { color: var(--dark-brown); font-size: 1.25rem; margin-bottom: 1.5rem; font-weight: 700; }
    .info-item { display: flex; margin-bottom: 1rem; font-size: 0.95rem; }
    .info-item strong { color: #555; width: 120px; flex-shrink: 0; }
    .info-item span { color: #777; }
    .status-badge { padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; color: white; }
    .status-delivered { background: #28a745; }
    .status-pending { background: #ffc107; }
    .items-table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
    .items-table th { background: var(--primary); color: white; text-align: left; padding: 1rem; font-weight: 600; font-size: 0.9rem; }
    .items-table th:first-child { border-radius: 12px 0 0 12px; }
    .items-table th:last-child { border-radius: 0 12px 12px 0; }
    .items-table td { padding: 1rem; border-bottom: 1px solid #F3F1EA; color: #444; font-size: 0.9rem; }
    .totals-section { margin-top: 2rem; float: right; width: 100%; max-width: 350px; }
    .totals-item { display: flex; justify-content: space-between; padding: 0.75rem 0; font-size: 1rem; }
    .totals-item.total { font-weight: 700; font-size: 1.2rem; color: var(--primary); border-top: 2px solid #eee; margin-top: 0.5rem; padding-top: 1rem; }
    .btn-back { background: var(--primary); color: white; padding: 0.75rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; margin-top: 2rem; transition: background 0.2s; }
    .btn-back:hover { background: var(--accent); }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <header class="admin-header"><h1>Order Details #{{ $order->id }}</h1></header>
        <div class="details-section">
            <div class="info-grid">
                <div class="info-block">
                    <h2>Order Information</h2>
                    <div class="info-item"><strong>Order ID:</strong><span>#{{ $order->id }}</span></div>
                    <div class="info-item"><strong>Order Date:</strong><span>{{ $order->created_at->format('M d, Y h:i A') }}</span></div>
                    <div class="info-item"><strong>Status:</strong><span><span class="status-badge status-{{ strtolower($order->status) }}">{{ $order->status }}</span></span></div>
                    <div class="info-item"><strong>Payment:</strong><span>{{ $order->payment_method }}</span></div>
                </div>
                <div class="info-block">
                    <h2>Customer Information</h2>
                    <div class="info-item"><strong>Name:</strong><span>{{ $order->user->full_name ?? $order->user->name }}</span></div>
                    <div class="info-item"><strong>Email:</strong><span>{{ $order->user->email }}</span></div>
                    <div class="info-item"><strong>Phone:</strong><span>{{ $order->user->phone_number }}</span></div>
                    <div class="info-item"><strong>Shipping:</strong><span>{{ $order->shipping_address }}</span></div>
                </div>
            </div>
            <h2>Order Items</h2>
            <table class="items-table">
                <thead><tr><th>Product</th><th>SKU</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->sku ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{ number_format($item->unit_price, 2) }}</td>
                        <td>₱{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="totals-section">
                <div class="totals-item"><span>Subtotal</span><span>₱{{ number_format($order->subtotal, 2) }}</span></div>
                <div class="totals-item"><span>Discount</span><span>-₱{{ number_format($order->discount_amount, 2) }}</span></div>
                <div class="totals-item total"><span>Total</span><span>₱{{ number_format($order->final_amount, 2) }}</span></div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-back">← Back to Orders</a>
    </main>
</div>
@endsection
