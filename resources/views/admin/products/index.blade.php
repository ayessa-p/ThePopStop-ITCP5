@extends('layouts.app')

@section('title', 'Manage Products - Admin')

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
        background: var(--primary);
        color: white;
    }

    /* Content Area Styles */
    .admin-main {
        flex: 1;
        min-width: 0;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .admin-header h1 {
        color: var(--dark-brown);
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0;
    }

    .btn-add {
        background: var(--primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: background 0.2s;
    }

    .btn-import {
        background: #a89078;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: background 0.2s;
    }

    .btn-add:hover {
        background: var(--accent);
    }

    .btn-import:hover {
        background: #967d63;
    }

    /* Table Styles */
    .products-section {
        background: white;
        padding: 1.25rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow-x: auto; /* Re-enable overflow for horizontal scrolling if needed */
    }

    .admin-table {
        width: 100% !important;
        border-collapse: collapse;
        margin: 0 !important;
    }

    .admin-table th {
        background: var(--primary);
        color: white;
        text-align: left;
        padding: 0.75rem 0.5rem;
        font-weight: 600;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    /* Column Widths adjusted for better fit */
    .admin-table th:nth-child(1) { width: 30px; }  /* ID */
    .admin-table th:nth-child(2) { width: 50px; }  /* Image */
    .admin-table th:nth-child(3) { min-width: 150px; } /* Name - give it room */
    .admin-table th:nth-child(4) { width: 70px; }  /* Series */
    .admin-table th:nth-child(5) { width: 70px; }  /* Brand */
    .admin-table th:nth-child(6) { width: 80px; }  /* Price */
    .admin-table th:nth-child(7) { width: 80px; }  /* Cost */
    .admin-table th:nth-child(8) { width: 40px; }  /* Stock */
    .admin-table th:nth-child(9) { width: 80px; }  /* Status */
    .admin-table th:nth-child(10) { width: 90px; } /* Actions */

    .admin-table th:first-child { border-radius: 8px 0 0 8px; }
    .admin-table th:last-child { border-radius: 0 8px 8px 0; }

    .admin-table td {
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid #F3F1EA;
        color: #444;
        font-size: 0.75rem;
        vertical-align: middle;
        line-height: 1.2;
        word-wrap: normal;
        overflow: visible;
    }

    .product-thumb {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #eee;
    }

    .status-badge {
        font-weight: 700;
        font-size: 0.8rem;
    }

    .status-instock { color: #28a745; }
    .status-low { color: var(--primary); }
    .status-outofstock { color: #dc3545; }

    /* Action Buttons */
    .action-stack {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        width: 100%;
    }

    .btn-action {
        width: 100%;
        padding: 0.35rem;
        border-radius: 50px;
        text-align: center;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.7rem;
        border: none;
        cursor: pointer;
        transition: opacity 0.2s;
        display: block;
        box-sizing: border-box;
    }

    .btn-action.photos { background: var(--secondary); color: white; }
    .btn-action.edit { background: var(--primary); color: white; }
    .btn-action.delete { background: #E26D5C; color: white; }
    .btn-action.restore { background: #28a745; color: white; }

    .btn-action:hover { opacity: 0.8; }

    /* DataTables Layout Fixes */
    .dataTables_wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .dataTables_wrapper .dataTables_filter {
        float: none !important;
        text-align: left !important;
    }
    .dataTables_wrapper .dataTables_length {
        float: none !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #F3F1EA;
        border-radius: 10px;
        padding: 0.4rem 0.75rem;
        outline: none;
        width: 250px;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 2px solid #F3F1EA;
        border-radius: 8px;
        padding: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-header">
            <h1>Manage Products</h1>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.products.import-form') }}" class="btn-import">
                    Import from Excel
                </a>
                <a href="{{ route('admin.products.create') }}" class="btn-add">
                    + Add New Product
                </a>
            </div>
        </header>

        <div class="products-section">
            <table id="products-table" class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Series</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Cost</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script>
$(function() {
    $('#products-table').DataTable({
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.products.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'series', name: 'series' },
            { data: 'brand', name: 'brand' },
            { data: 'price', name: 'price' },
            { data: 'cost_price', name: 'cost_price' },
            { data: 'stock_quantity', name: 'stock_quantity' },
            {
                data: 'status',
                name: 'status',
                render: function(data) {
                    let cls = 'status-instock';
                    if (data === 'Low Stock') cls = 'status-low';
                    if (data === 'Out of Stock') cls = 'status-outofstock';
                    return `<span class="status-badge ${cls}">${data}</span>`;
                }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search products..."
        }
    });
});
</script>
@endpush
@endsection
