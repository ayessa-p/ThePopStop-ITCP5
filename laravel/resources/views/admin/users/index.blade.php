@extends('layouts.app')
@section('title', 'Admin - Users')
@section('content')
<h1>Manage Users</h1>
<p><a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a></p>
<form method="GET" style="margin-bottom: 1rem;">
    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
    <select name="role"><option value="">All</option><option value="customer" {{ request('role')=='customer'?'selected':'' }}>Customer</option><option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option></select>
    <button type="submit" class="btn btn-secondary">Filter</button>
</form>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem;">ID</th>
            <th style="padding: 0.5rem;">Username</th>
            <th style="padding: 0.5rem;">Email</th>
            <th style="padding: 0.5rem;">Role</th>
            <th style="padding: 0.5rem;">Active</th>
            <th style="padding: 0.5rem;">Orders</th>
            <th style="padding: 0.5rem;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $u)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $u->id }}</td>
                <td style="padding: 0.5rem;">{{ $u->username }}</td>
                <td style="padding: 0.5rem;">{{ $u->email }}</td>
                <td style="padding: 0.5rem;">{{ $u->role }}</td>
                <td style="padding: 0.5rem;">{{ $u->is_active ? 'Yes' : 'No' }}</td>
                <td style="padding: 0.5rem;">{{ $u->orders_count ?? 0 }}</td>
                <td style="padding: 0.5rem;">
                    <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form action="{{ route('admin.users.toggle-active', $u) }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-secondary btn-sm">{{ $u->is_active ? 'Deactivate' : 'Activate' }}</button></form>
                    @if($u->id !== auth()->id())<form action="{{ route('admin.users.destroy', $u) }}" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button></form>@endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $users->withQueryString()->links() }}
@endsection
