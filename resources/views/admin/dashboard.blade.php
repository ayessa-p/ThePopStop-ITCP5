@extends('layouts.app')

@section('title', 'Admin Dashboard - The Pop Stop')

@push('styles')
<style>
    .admin-container {
        display: flex;
        gap: 2rem;
        padding: 2rem 0;
    }

    /* Sidebar Styles */
    .admin-sidebar {
        width: 280px;
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        height: fit-content;
    }

    .admin-sidebar h2 {
        color: var(--primary);
        font-size: 1.25rem;
        margin-bottom: 2rem;
        font-weight: 700;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        text-decoration: none;
        color: #666;
        border-radius: 12px;
        transition: all 0.2s;
        font-weight: 500;
    }

    .sidebar-link:hover {
        background: var(--bg);
        color: var(--primary);
    }

    .sidebar-link.active {
        background: var(--primary); /* Maroon active */
        color: white;
    }

    /* Content Area Styles */
    .admin-main {
        flex: 1;
        min-width: 0; /* Prevent layout breaking */
    }

    .admin-header h1 {
        color: var(--dark-brown);
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    /* Stat Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Force 4 columns */
        gap: 1rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--accent), var(--primary)); /* Maroon gradient */
        padding: 1.5rem;
        border-radius: 15px;
        color: white;
        text-align: center;
        box-shadow: 0 8px 20px rgba(139, 0, 0, 0.15);
    }

    .stat-card h3 {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 0.75rem;
        font-weight: 500;
    }

    .stat-card .value {
        font-size: 2rem;
        font-weight: 700;
    }

    /* Table Sections */
    .dashboard-section {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .section-header h2 {
        color: var(--primary);
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
    }

    .admin-table th {
        background: var(--primary);
        color: white;
        text-align: left;
        padding: 0.75rem 1rem;
        font-weight: 600;
    }

    .admin-table th:first-child { border-radius: 8px 0 0 8px; }
    .admin-table th:last-child { border-radius: 0 8px 8px 0; }

    .admin-table td {
        padding: 1rem;
        border-bottom: 1px solid #F3F1EA;
        color: #444;
    }

    .btn-view {
        background: var(--primary);
        color: white;
        padding: 0.4rem 1.25rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: background 0.2s;
    }

    .btn-view:hover {
        background: var(--accent);
    }

    .status-badge {
        padding: 0.35rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-low { color: #A68B7C; }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-header">
            <h1>Dashboard</h1>
        </header>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Products</h3>
                <div class="value">{{ $totalProducts }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Customers</h3>
                <div class="value">{{ $totalUsers }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Orders</h3>
                <div class="value">{{ $totalOrders }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="value">₱{{ number_format($revenue, 2) }}</div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2>Recent Orders</h2>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->full_name ?? $order->user->name }}</td>
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td>₱{{ number_format($order->subtotal - (float) $order->discount_amount, 2) }}</td>
                        <td>{{ $order->status }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn-view">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Low Stock Alert -->
        <div class="dashboard-section">
            <div class="section-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <h2>Low Stock Alert</h2>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Current Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku ?? 'N/A' }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td class="status-low">Low Stock</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
