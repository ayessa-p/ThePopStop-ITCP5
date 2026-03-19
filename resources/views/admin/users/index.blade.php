@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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
    .users-section { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .search-bar { display: flex; gap: 1rem; margin-bottom: 2rem; }
    .search-input { flex: 1; padding: 0.75rem 1rem; border: 2px solid #ddd; border-radius: 8px; }
    .btn-add-user { background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; }

    .admin-table-wrapper { width: 100%; overflow: hidden; margin-top: 1rem; border-radius: 12px; }
    .admin-table { width: 100% !important; border-collapse: separate; border-spacing: 0; margin: 0 !important; table-layout: fixed; }
    .admin-table th { background: var(--accent); color: white; text-align: left; padding: 0.75rem 0.5rem; font-weight: 600; font-size: 0.85rem; }
    .admin-table th:first-child { border-top-left-radius: 12px; }
    .admin-table th:last-child { border-top-right-radius: 12px; }
    .admin-table td { padding: 1rem 0.5rem; border-bottom: 1px solid #F3F1EA; color: #444; font-size: 0.85rem; vertical-align: middle; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis; }
    .admin-table tr:hover td { background-color: #fafafa; }

    /* Column widths adjusted to fit container */
    .col-email { width: 25%; }
    .col-fullname { width: 20%; }
    .col-role { width: 10%; }
    .col-status { width: 10%; }
    .col-activity { width: 10%; }
    .col-created { width: 12%; }
    .col-actions { width: 13%; }

    /* DataTables Overrides */
    .dataTables_wrapper .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; color: #666; font-size: 0.9rem; }
    .dataTables_wrapper .bottom { display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; }
    .dataTables_length select { padding: 0.3rem 2rem 0.3rem 0.5rem !important; }
    .dataTables_filter { display: none; } /* We use our own search bar */

    .badge { padding: 0.4rem 0.8rem; border-radius: 50px; font-weight: 600; font-size: 0.75rem; }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-danger { background: #fee2e2; color: #991b1b; }

    .action-stack { display: flex; flex-direction: column; gap: 0.4rem; align-items: center; }
    .btn-action { display: block; width: 90px; padding: 0.4rem; border-radius: 50px; text-align: center; text-decoration: none; font-weight: 600; font-size: 0.75rem; border: none; cursor: pointer; transition: all 0.2s; }
    .btn-action.view { background: var(--secondary); color: white; }
    .btn-action.edit { background: var(--primary); color: white; }
    .btn-action.deactivate { background: #E26D5C; color: white; }
    .btn-action.delete { background: #dc3545; color: white; }
    .btn-action:hover { opacity: 0.8; transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <header class="admin-header">
            <h1>Manage Users</h1>
            <a href="{{ route('admin.users.create') }}" class="btn-add-user">+ Add New User</a>
        </header>
        <div class="users-section">
            <div class="search-bar">
                <input type="text" id="search-input" class="search-input" placeholder="Search by username, email, or name...">
            </div>
            <div class="admin-table-wrapper">
                <table id="users-table" class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-email">Email</th>
                            <th class="col-fullname">Full Name</th>
                            <th class="col-role">Role</th>
                            <th class="col-status">Status</th>
                            <th class="col-activity">Activity</th>
                            <th class="col-created">Created</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(function() {
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: '{{ route("admin.users.index") }}',
        columns: [
            { data: 'email', name: 'email', className: 'col-email' },
            { data: 'full_name', name: 'full_name', className: 'col-fullname' },
            { data: 'role', name: 'role', className: 'col-role' },
            { data: 'is_active', name: 'is_active', className: 'col-status', render: function(data) {
                return data ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            }},
            { data: 'orders_count', name: 'orders_count', className: 'col-activity', render: function(data, type, row) {
                return `<a href="/admin/users/${row.id}/orders" style="color: var(--primary); font-weight: 600; text-decoration: none;">${data} orders</a>`;
            }},
            { data: 'created_at', name: 'created_at', className: 'col-created', render: function(data) {
                if(!data) return '';
                let date = new Date(data);
                return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            }},
            { data: 'actions', name: 'actions', className: 'col-actions', orderable: false, searchable: false }
        ],
        "dom": '<"top"i>rt<"bottom"lp><"clear">',
        "language": {
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "lengthMenu": "Show _MENU_ entries"
        }
    });

    $('#search-input').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>
@endpush
