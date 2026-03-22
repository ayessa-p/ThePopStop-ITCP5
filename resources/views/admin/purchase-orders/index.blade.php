@extends('layouts.app')

@section('title', 'Purchase Orders - Admin')

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
    .po-section { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .btn-create { background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; }
    .btn-create:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139,0,0,0.2); }

    .admin-table-wrapper { width: 100%; overflow: hidden; margin-top: 1rem; border-radius: 12px; }
    .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 0; }
    .admin-table th { background: var(--accent); color: white; text-align: left; padding: 1rem; font-weight: 600; font-size: 0.9rem; border-bottom: none; white-space: nowrap; }
    .admin-table th:first-child { border-top-left-radius: 12px; }
    .admin-table th:last-child { border-top-right-radius: 12px; }
    .admin-table td { padding: 1.25rem 1rem; border-bottom: 1px solid #F3F1EA; color: #444; font-size: 0.9rem; vertical-align: top; word-wrap: break-word; }
    .admin-table tr:last-child td:first-child { border-bottom-left-radius: 12px; }
    .admin-table tr:last-child td:last-child { border-bottom-right-radius: 12px; }
    .admin-table tr:hover td { background-color: #fafafa; }

    .col-id { width: 10%; }
    .col-supplier { width: 20%; }
    .col-date { width: 15%; }
    .col-items { width: 8%; }
    .col-cost { width: 15%; }
    .col-status { width: 12%; }
    .col-actions { width: 20%; }

    .action-buttons { display: flex; flex-direction: column; gap: 0.5rem; }
    .btn-action {
        background: var(--primary);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.75rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        width: 120px;
    }
    .btn-action:hover {
        background: var(--accent);
        transform: translateY(-1px);
    }

    /* Modal */
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
    .modal-content { background: white; padding: 2.5rem; border-radius: 20px; width: 100%; max-width: 450px; position: relative; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
    .modal-header { margin-bottom: 1.5rem; }
    .modal-header h2 { font-size: 1.5rem; color: var(--dark-brown); font-weight: 700; margin: 0; }
    .close-modal { position: absolute; top: 1.5rem; right: 1.5rem; font-size: 1.5rem; color: #999; cursor: pointer; border: none; background: none; }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #555; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border: 2px solid #F3F1EA; border-radius: 10px; background: #fafafa; outline: none; }
    .btn-submit { background: var(--primary); color: white; padding: 0.8rem; border: none; border-radius: 10px; font-weight: 700; width: 100%; cursor: pointer; transition: 0.2s; }
    .btn-submit:hover { background: var(--accent); }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <header class="admin-header">
            <h1>Purchase Orders</h1>
            <a href="{{ route('admin.purchase-orders.create') }}" class="btn-create">+ Create Purchase Order</a>
        </header>

        <div class="po-section">
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-id">PO ID</th>
                            <th class="col-supplier">Supplier</th>
                            <th class="col-date">Order Date</th>
                            <th class="col-items">Items</th>
                            <th class="col-cost">Total Cost</th>
                            <th class="col-status">Status</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrders as $po)
                        <tr>
                            <td>#{{ $po->id }}</td>
                            <td>{{ $po->supplier->brand ?? '-' }}</td>
                            <td>{{ $po->order_date->format('M d, Y') }}</td>
                            <td>{{ $po->purchaseOrderItems->sum('quantity') }}</td>
                            <td>₱{{ number_format($po->total_cost, 2) }}</td>
                            <td>{{ $po->status }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.purchase-orders.show', $po) }}" class="btn-action">View</a>
                                    <button type="button" class="btn-action" onclick="openStatusModal('{{ $po->id }}', '{{ $po->status }}')">Update Status</button>
                                    <form action="{{ route('admin.purchase-orders.destroy', $po) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this purchase order?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action" style="background-color: #dc3545;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2rem;">{{ $purchaseOrders->links() }}</div>
        </div>
    </main>
</div>

<div id="statusModal" class="modal">
    <div class="modal-content">
        <button class="close-modal" onclick="closeModal()">&times;</button>
        <div class="modal-header">
            <h2>Update PO Status</h2>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Status *</label>
                <select name="status" id="poStatus" class="form-control">
                    <option value="Ordered">Ordered</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Received">Received</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Update Status</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openStatusModal(id, currentStatus) {
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');
        const select = document.getElementById('poStatus');

        form.action = `/admin/purchase-orders/${id}/status`;
        select.value = currentStatus;
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('statusModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('statusModal')) {
            closeModal();
        }
    }
</script>
@endpush
@endsection
