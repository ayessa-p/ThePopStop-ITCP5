@extends('layouts.app')
@section('title', 'Product Reviews')

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
    .reviews-section { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }

    .admin-table-wrapper { width: 100%; overflow: hidden; margin-top: 1rem; border-radius: 12px; }
    .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 0; }
    .admin-table th { background: var(--accent); color: white; text-align: left; padding: 1rem; font-weight: 600; font-size: 0.9rem; border-bottom: none; }
    .admin-table th:first-child { border-top-left-radius: 12px; }
    .admin-table th:last-child { border-top-right-radius: 12px; }
    .admin-table td { padding: 1.25rem 1rem; border-bottom: 1px solid #F3F1EA; color: #444; font-size: 0.9rem; vertical-align: top; word-wrap: break-word; }
    .admin-table tr:last-child td:first-child { border-bottom-left-radius: 12px; }
    .admin-table tr:last-child td:last-child { border-bottom-right-radius: 12px; }
    .admin-table tr:hover td { background-color: #fafafa; }

    .star-rating { color: #fbbf24; font-size: 1rem; }
    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.75rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-delete:hover { opacity: 0.8; transform: translateY(-1px); }

    /* DataTables Custom UI Fixes */
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 1.5rem;
    }
    .dataTables_wrapper .dataTables_length select {
        padding: 0.4rem 2rem 0.4rem 1rem;
        border-radius: 8px;
        border: 1px solid #E8E4DC;
        background-color: white;
        margin: 0 0.5rem;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23666'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1.5rem;
    }
    .dataTables_wrapper .dataTables_filter input {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 1px solid #E8E4DC;
        margin-left: 0.5rem;
        outline: none;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary);
    }
    .dataTables_wrapper .dataTables_info {
        padding-top: 1.5rem;
        color: #666;
        font-size: 0.9rem;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 1.5rem;
        display: flex;
        gap: 0.25rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 1rem !important;
        border-radius: 8px !important;
        border: 1px solid #E8E4DC !important;
        background: white !important;
        color: #666 !important;
        cursor: pointer;
        transition: all 0.2s;
        margin: 0 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #FDFCFA !important;
        border-color: var(--primary) !important;
        color: var(--primary) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.5;
        cursor: default;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.next,
    .dataTables_wrapper .dataTables_paginate .paginate_button.previous {
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <header class="admin-header">
            <h1>Product Reviews</h1>
        </header>

        <div class="reviews-section">
            <div class="admin-table-wrapper">
                <table id="reviews-table" class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script>
$(function() {
    $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.reviews.index") }}',
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search reviews...",
            lengthMenu: "Show _MENU_ entries",
            paginate: {
                previous: "←",
                next: "→"
            }
        },
        columns: [
            { data: 'id', name: 'id', width: '50px' },
            { data: 'user_name', name: 'user.full_name', width: '150px' },
            { data: 'product_name', name: 'product.name', width: '200px' },
            { 
                data: 'rating', 
                name: 'rating',
                width: '100px',
                render: function(data) {
                    let stars = '<div class="star-rating">';
                    for(let i=1; i<=5; i++) {
                        stars += (i <= data) ? '★' : '☆';
                    }
                    stars += '</div>';
                    return stars;
                }
            },
            { data: 'review_text', name: 'review_text' },
            { 
                data: 'created_at', 
                name: 'created_at',
                width: '120px', 
                render: function(data) {
                    return new Date(data).toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, width: '100px' }
        ]
    });
});
</script>
@endpush
@endsection
