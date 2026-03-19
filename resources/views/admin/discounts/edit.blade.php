@extends('layouts.app')

@section('title', 'Edit Discount - Admin')

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
    
    .form-card { background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #555; font-size: 0.9rem; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border: 2px solid #F3F1EA; border-radius: 10px; background: #fafafa; transition: all 0.2s; }
    .form-control:focus { border-color: var(--primary); background: white; outline: none; box-shadow: 0 0 0 4px rgba(139,0,0,0.05); }
    
    .btn-submit { background: #a89078; color: white; padding: 0.8rem 2rem; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; width: 100%; transition: all 0.2s; font-size: 1rem; margin-top: 1rem; }
    .btn-submit:hover { background: #967d63; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(168,144,120,0.3); }
    
    .back-link { display: inline-flex; align-items: center; gap: 0.5rem; color: #666; text-decoration: none; font-weight: 600; margin-bottom: 1.5rem; transition: color 0.2s; }
    .back-link:hover { color: var(--primary); }
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
            <a href="{{ route('admin.purchase-orders.index') }}" class="sidebar-link"><span>📋</span> Purchase Orders</a>
            <a href="{{ route('admin.discounts.index') }}" class="sidebar-link active"><span>🎟️</span> Discounts</a>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link"><span>📈</span> Reports</a>
        </nav>
    </aside>

    <main class="admin-main">
        <a href="{{ route('admin.discounts.index') }}" class="back-link">← Back to Discounts</a>
        
        <div class="form-card">
            <header style="margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                <h1 style="font-size: 1.5rem; color: var(--dark-brown); font-weight: 700; margin: 0;">Edit Discount</h1>
            </header>

            <form method="POST" action="{{ route('admin.discounts.update', $discount) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label">Code *</label>
                    <input type="text" name="code" value="{{ old('code', $discount->code) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" value="{{ old('description', $discount->description) }}" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Discount Type *</label>
                    <select name="discount_type" class="form-control" required>
                        <option value="Percentage" {{ $discount->discount_type == 'Percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="Fixed" {{ $discount->discount_type == 'Fixed' ? 'selected' : '' }}>Fixed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Discount Value *</label>
                    <input type="number" name="discount_value" step="0.01" value="{{ old('discount_value', $discount->discount_value) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Minimum Purchase</label>
                    <input type="number" name="min_purchase" step="0.01" value="{{ old('min_purchase', $discount->min_purchase) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" value="{{ $discount->start_date ? $discount->start_date->format('Y-m-d') : '' }}" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" value="{{ $discount->end_date ? $discount->end_date->format('Y-m-d') : '' }}" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ $discount->is_active ? 'checked' : '' }}> Active
                    </label>
                </div>

                <button type="submit" class="btn-submit">Update Discount</button>
            </form>
        </div>
    </main>
</div>
@endsection
