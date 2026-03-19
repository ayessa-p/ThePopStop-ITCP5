@extends('layouts.app')

@section('title', 'Manage Orders - Admin')

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
    .orders-section { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .status-filters { display: flex; gap: 0.75rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .status-filter { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; padding: 0.6rem 1.25rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; border: 2px solid var(--primary); background: white; color: var(--primary); }
    .status-filter.active, .status-filter:hover { background: var(--primary); color: white; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .admin-table-wrapper { width: 100%; overflow-x: auto; margin: 0; padding: 0; }
    .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 0; }
    .admin-table th { background: var(--primary); color: white; text-align: left; padding: 1.25rem 1rem; font-weight: 600; font-size: 0.9rem; border-bottom: none; white-space: nowrap; }
    .admin-table th:first-child { border-top-left-radius: 12px; }
    .admin-table th:last-child { border-top-right-radius: 12px; }
    .admin-table td { padding: 1.25rem 1rem; border-bottom: 1px solid #F3F1EA; color: #444; font-size: 0.9rem; vertical-align: middle; }
    .admin-table tr:last-child td:first-child { border-bottom-left-radius: 12px; }
    .admin-table tr:last-child td:last-child { border-bottom-right-radius: 12px; }
    .admin-table tr:hover td { background-color: #fafafa; }
    
    .col-id { width: 5%; }
    .col-customer { width: 15%; }
    .col-email { width: 20%; }
    .col-date { width: 15%; }
    .col-items { width: 10%; }
    .col-total { width: 10%; }
    .col-status { width: 10%; }
    .col-actions { width: 15%; }
    .action-stack { display: flex; flex-direction: column; gap: 0.4rem; align-items: center; }
    .btn-action { width: 90px; padding: 0.4rem; border-radius: 50px; text-align: center; text-decoration: none; font-weight: 600; font-size: 0.8rem; border: none; cursor: pointer; transition: background 0.2s; }
    .btn-action.view { background: var(--secondary); color: white; }
    .btn-action.update { background: var(--primary); color: white; }
    .btn-action:hover { opacity: 0.8; }
    .modal { display: none; position: fixed; z-index: 100; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fefefe; margin: 15% auto; padding: 2rem; border-radius: 15px; width: 90%; max-width: 450px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .modal-header h2 { color: var(--dark-brown); margin: 0; font-size: 1.5rem; }
    .close-btn { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
    .close-btn:hover, .close-btn:focus { color: black; }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #555; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border: 2px solid #ddd; border-radius: 8px; }
    .btn-submit { background: var(--primary); color: white; padding: 0.75rem 2rem; border: none; border-radius: 50px; font-weight: 600; cursor: pointer; }
</style>
@endpush

@section('content')
<div class="admin-container">
    <aside class="admin-sidebar">
        <h2>Admin Menu</h2>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link"><span>📊</span> Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link"><span>📦</span> Products</a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link active"><span>🛒</span> Orders</a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link"><span>👥</span> Users</a>
            <a href="{{ route('admin.suppliers.index') }}" class="sidebar-link"><span>🏭</span> Suppliers</a>
            <a href="{{ route('admin.purchase-orders.index') }}" class="sidebar-link"><span>📋</span> Purchase Orders</a>
            <a href="{{ route('admin.discounts.index') }}" class="sidebar-link"><span>🎟️</span> Discounts</a>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link"><span>📈</span> Reports</a>
        </nav>
    </aside>

    <main class="admin-main">
        <header class="admin-header"><h1>Manage Orders</h1></header>
        <div class="orders-section">
            <div class="status-filters">
                <a href="{{ route('admin.orders.index') }}" class="status-filter {{ !request('status') ? 'active' : '' }}">All Orders ({{ array_sum($statusCounts) }})</a>
                @php
                    $icons = ['Pending' => '📝', 'Processing' => '⚙️', 'Shipped' => '🚚', 'Delivered' => '✅', 'Cancelled' => '❌'];
                @endphp
                @foreach($statusCounts as $status => $count)
                    <a href="{{ route('admin.orders.index', ['status' => $status]) }}" class="status-filter {{ request('status') == $status ? 'active' : '' }}">
                        <span>{{ $icons[$status] ?? '' }}</span> {{ $status }} ({{ $count }})
                    </a>
                @endforeach
            </div>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-id">Order ID</th>
                            <th class="col-customer">Customer</th>
                            <th class="col-email">Email</th>
                            <th class="col-date">Date</th>
                            <th class="col-items">Items</th>
                            <th class="col-total">Total</th>
                            <th class="col-status">Status</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->full_name ?? $order->user->name }}</td>
                            <td style="word-break: break-all;">{{ $order->user->email }}</td>
                            <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            <td>{{ $order->orderItems->sum('quantity') }} Item(s)</td>
                            <td style="white-space: nowrap;">₱{{ number_format($order->subtotal - (float) $order->discount_amount, 2) }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <div class="action-stack">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn-action view">View</a>
                                    <button class="btn-action update" onclick="openModal('{{ $order->id }}', '{{ $order->status }}')">Update</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2rem;">{{ $orders->withQueryString()->links() }}</div>
        </div>
    </main>
</div>

<div id="updateStatusModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Update Order Status</h2>
            <span class="close-btn" onclick="closeModal()">&times;</span>
        </div>
        <form id="updateStatusForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="status">Order Status *</label>
                <select name="status" id="status" class="form-control">
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Update Status</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(orderId, currentStatus) {
        const modal = document.getElementById('updateStatusModal');
        const form = document.getElementById('updateStatusForm');
        form.action = `/admin/orders/${orderId}/status`;
        document.getElementById('status').value = currentStatus;
        modal.style.display = 'block';
    }
    function closeModal() {
        document.getElementById('updateStatusModal').style.display = 'none';
    }
    window.onclick = function(event) {
        const modal = document.getElementById('updateStatusModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endpush
@endsection
