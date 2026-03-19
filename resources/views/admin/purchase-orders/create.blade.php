@extends('layouts.app')

@section('title', 'Create Purchase Order - Admin')

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
    
    .form-card { background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #555; font-size: 0.9rem; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border: 2px solid #F3F1EA; border-radius: 10px; background: #fafafa; transition: all 0.2s; }
    .form-control:focus { border-color: var(--primary); background: white; outline: none; box-shadow: 0 0 0 4px rgba(139,0,0,0.05); }
    
    .btn-submit { background: #a89078; color: white; padding: 0.8rem 2rem; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; width: 100%; transition: all 0.2s; font-size: 1rem; margin-top: 2rem; }
    .btn-submit:hover { background: #967d63; transform: translateY(-1px); }
    
    .back-link { display: inline-flex; align-items: center; gap: 0.5rem; color: #666; text-decoration: none; font-weight: 600; margin-bottom: 1.5rem; transition: color 0.2s; }
    .back-link:hover { color: var(--primary); }

    .items-section { margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee; }
    .item-row { display: grid; grid-template-columns: 1fr 100px 150px 50px; gap: 1rem; margin-bottom: 1rem; align-items: end; }
    .btn-remove { background: #fee2e2; color: #991b1b; border: none; padding: 0.75rem; border-radius: 10px; cursor: pointer; }
    .btn-add-item { background: #f3f1ea; color: #666; border: none; padding: 0.5rem 1rem; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 0.85rem; margin-top: 1rem; }
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
        
        <div class="form-card">
            <header style="margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                <h1 style="font-size: 1.5rem; color: var(--dark-brown); font-weight: 700; margin: 0;">Create Purchase Order</h1>
            </header>

            <form method="POST" action="{{ route('admin.purchase-orders.store') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Supplier *</label>
                    <select name="supplier_id" class="form-control" required>
                        @foreach($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->brand }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Order Date *</label>
                    <input type="date" name="order_date" value="{{ date('Y-m-d') }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="2" class="form-control" placeholder="Add any notes here...">{{ old('notes') }}</textarea>
                </div>

                <div class="items-section">
                    <h3 style="font-size: 1.1rem; color: var(--dark-brown); font-weight: 700; margin-bottom: 1rem;">Order Items</h3>
                    <div id="items-container">
                        <div class="item-row">
                            <div class="form-group" style="margin: 0;">
                                <label class="form-label">Product</label>
                                <select name="product_ids[]" class="form-control">
                                    @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin: 0;">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantities[]" min="1" value="1" class="form-control">
                            </div>
                            <div class="form-group" style="margin: 0;">
                                <label class="form-label">Unit Cost (₱)</label>
                                <input type="number" name="unit_costs[]" step="0.01" min="0" value="0" class="form-control">
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <button type="button" class="btn-add-item" onclick="addItem()">+ Add More Products</button>
                </div>

                <button type="submit" class="btn-submit">Create Purchase Order</button>
            </form>
        </div>
    </main>
</div>

@push('scripts')
<script>
    function addItem() {
        const container = document.getElementById('items-container');
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        // Add remove button to the new row
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn-remove';
        removeBtn.innerHTML = '&times;';
        removeBtn.onclick = function() { this.parentElement.remove(); };
        
        newRow.lastElementChild.appendChild(removeBtn);
        container.appendChild(newRow);
    }
</script>
@endpush
@endsection
