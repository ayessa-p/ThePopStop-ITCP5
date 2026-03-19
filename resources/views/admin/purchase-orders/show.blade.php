@extends('layouts.app')

@section('title', 'Purchase Order #' . $purchaseOrder->id . ' - Admin')

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
    
    .info-card { background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 2rem; }
    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 2rem; }
    .info-item label { display: block; color: #999; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem; }
    .info-item span { display: block; color: var(--dark-brown); font-size: 1.1rem; font-weight: 700; }

    .status-badge { padding: 0.5rem 1.5rem; border-radius: 50px; font-weight: 700; font-size: 0.9rem; background: #f3f1ea; color: #a89078; }
    
    .admin-table-wrapper { width: 100%; overflow: hidden; border-radius: 12px; border: 1px solid #eee; }
    .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 0; }
    .admin-table th { background: #f8f9fa; color: #666; text-align: left; padding: 1rem; font-weight: 600; font-size: 0.85rem; border-bottom: 1px solid #eee; }
    .admin-table td { padding: 1rem; border-bottom: 1px solid #eee; color: #444; font-size: 0.9rem; }
    .admin-table tr:last-child td { border-bottom: none; }
    
    .total-row { background: #fafafa; font-weight: 800; font-size: 1.1rem; color: var(--primary); }
    
    .back-link { display: inline-flex; align-items: center; gap: 0.5rem; color: #666; text-decoration: none; font-weight: 600; margin-bottom: 1.5rem; transition: color 0.2s; }
    .back-link:hover { color: var(--primary); }

    .actions-bar { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee; }
    .btn-action { padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 700; cursor: pointer; transition: all 0.2s; border: none; font-size: 0.9rem; }
    .btn-primary-action { background: var(--primary); color: white; }
    .btn-secondary-action { background: #f3f1ea; color: #666; }
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
            <a href="{{ route('admin.users.index') }}" class="sidebar-link"><span>👥</span> Users</a>
            <a href="{{ route('admin.suppliers.index') }}" class="sidebar-link"><span>🏭</span> Suppliers</a>
            <a href="{{ route('admin.purchase-orders.index') }}" class="sidebar-link active"><span>📋</span> Purchase Orders</a>
            <a href="{{ route('admin.discounts.index') }}" class="sidebar-link"><span>🎟️</span> Discounts</a>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link"><span>📈</span> Reports</a>
        </nav>
    </aside>

    <main class="admin-main">
        <a href="{{ route('admin.purchase-orders.index') }}" class="back-link">← Back to Purchase Orders</a>
        
        <div class="info-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 3rem;">
                <div>
                    <h1 style="font-size: 1.8rem; color: var(--dark-brown); font-weight: 800; margin: 0 0 0.5rem 0;">Purchase Order #{{ $purchaseOrder->id }}</h1>
                    <p style="color: #999; margin: 0;">Created on {{ $purchaseOrder->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <span class="status-badge">{{ $purchaseOrder->status }}</span>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <label>Supplier</label>
                    <span>{{ $purchaseOrder->supplier->brand ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <label>Order Date</label>
                    <span>{{ $purchaseOrder->order_date->format('M d, Y') }}</span>
                </div>
                <div class="info-item">
                    <label>Contact Person</label>
                    <span>{{ $purchaseOrder->supplier->contact_person ?? '-' }}</span>
                </div>
            </div>

            @if($purchaseOrder->notes)
            <div class="info-item" style="margin-bottom: 2rem;">
                <label>Notes</label>
                <p style="color: #666; line-height: 1.6; margin: 0;">{{ $purchaseOrder->notes }}</p>
            </div>
            @endif

            <h3 style="font-size: 1.1rem; color: var(--dark-brown); font-weight: 700; margin-bottom: 1.5rem;">Order Items</h3>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrder->purchaseOrderItems as $item)
                        <tr>
                            <td><strong>{{ $item->product->name }}</strong></td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->unit_cost, 2) }}</td>
                            <td style="text-align: right;">₱{{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">Grand Total</td>
                            <td style="text-align: right;">₱{{ number_format($purchaseOrder->total_cost, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="actions-bar">
                @if($purchaseOrder->status != 'Received')
                <form method="POST" action="{{ route('admin.purchase-orders.update-status', $purchaseOrder) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="Received">
                    <button type="submit" class="btn-action btn-primary-action" onclick="return confirm('Marking as Received will update your product inventory. Continue?')">Mark as Received</button>
                </form>
                @endif
                
                <form method="POST" action="{{ route('admin.purchase-orders.update-status', $purchaseOrder) }}" style="display: flex; gap: 0.5rem;">
                    @csrf
                    @method('PUT')
                    <select name="status" class="form-control" style="width: 150px; padding: 0.5rem;">
                        @foreach(['Ordered','Shipped','Received','Cancelled'] as $s)
                        <option value="{{ $s }}" {{ $purchaseOrder->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-action btn-secondary-action">Update Status</button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
