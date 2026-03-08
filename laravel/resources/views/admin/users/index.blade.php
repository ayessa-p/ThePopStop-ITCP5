@extends('layouts.app')
@section('title', 'Admin - Users')
@section('content')
<h1>Manage Users</h1>
<p><a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a></p>
<div class="datatable-container">
<table id="users-table" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Active</th>
            <th>Orders</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.users.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'is_active', name: 'is_active' },
            { data: 'orders_count', name: 'orders_count' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
@endsection
