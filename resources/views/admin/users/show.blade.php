@extends('layouts.app')

@section('title', 'Order History - Admin')

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
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .admin-header h1 { color: var(--dark-brown); font-size: 2.25rem; font-weight: 700; margin: 0; }
    .customer-info-section { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 2rem; }
    .order-history-section { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .admin-table { width: 100% !important; border-collapse: separate; border-spacing: 0; margin: 0 !important; }
    .admin-table th { background: var(--accent); color: white; text-align: left; padding: 1rem; font-weight: 600; font-size: 0.9rem; }
    .admin-table th:first-child { border-top-left-radius: 12px; }
    .admin-table th:last-child { border-top-right-radius: 12px; }
    .admin-table td { padding: 1.25rem 1rem; border-bottom: 1px solid #F3F1EA; color: #444; font-size: 0.9rem; vertical-align: middle; }
</style>
@endpush

@section('content')
<div class="admin-container">
    <aside class="admin-sidebar">
        <h2>Admin Menu</h2>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link"><span>📊</span> Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link"><span>📦</span> Products</a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link"><span>🛒</span> Orders</a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link active"><span>👥</span> Users</a>
            <a href="{{ route('admin.suppliers.index') }}" class="sidebar-link"><span>🏭</span> Suppliers</a>
            <a href="{{ route('admin.purchase-orders.index') }}" class="sidebar-link"><span>📋</span> Purchase Orders</a>
            <a href="{{ route('admin.discounts.index') }}" class="sidebar-link"><span>🎟️</span> Discounts</a>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link"><span>📈</span> Reports</a>
        </nav>
    </aside>

    <main class="admin-main">
        <header class="admin-header">
            <h1>Order History - {{ $user->username }}</h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">← Back to Users</a>
        </header>

        <div class="customer-info-section">
            <h2>Customer Information</h2>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Full Name:</strong> {{ $user->full_name }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
        </div>

        <div class="order-history-section">
            <h2>Order History ({{ $user->orders->count() }} orders)</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td>{{ $order->orderItems->sum('quantity') }} Item(s)</td>
                        <td>₱{{ number_format($order->subtotal - (float) $order->discount_amount, 2) }}</td>
                        <td>{{ $order->status }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary btn-sm">View Details</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
