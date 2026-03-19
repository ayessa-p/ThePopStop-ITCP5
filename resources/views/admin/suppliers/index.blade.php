@extends('layouts.app')

@section('title', 'Manage Suppliers - Admin')

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
    .suppliers-section { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .btn-add { background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; }
    .btn-add:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139,0,0,0.2); }

    .admin-table-wrapper { width: 100%; overflow: hidden; margin-top: 1rem; border-radius: 12px; }
    .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 0; table-layout: fixed; }
    .admin-table th { background: var(--accent); color: white; text-align: left; padding: 1rem; font-weight: 600; font-size: 0.9rem; border-bottom: none; }
    .admin-table th:first-child { border-top-left-radius: 12px; }
    .admin-table th:last-child { border-top-right-radius: 12px; }
    .admin-table td { padding: 1.25rem 1rem; border-bottom: 1px solid #F3F1EA; color: #444; font-size: 0.9rem; vertical-align: middle; word-wrap: break-word; }
    .admin-table tr:last-child td:first-child { border-bottom-left-radius: 12px; }
    .admin-table tr:last-child td:last-child { border-bottom-right-radius: 12px; }
    .admin-table tr:hover td { background-color: #fafafa; }

    .col-id { width: 60px; }
    .col-brand { width: 15%; }
    .col-contact { width: 20%; }
    .col-email { width: 20%; }
    .col-phone { width: 15%; }
    .col-actions { width: 140px; }

    .action-buttons { display: flex; gap: 0.5rem; align-items: center; }
    .btn-action { padding: 0.4rem 1rem; border-radius: 50px; text-align: center; text-decoration: none; font-weight: 600; font-size: 0.75rem; border: none; cursor: pointer; transition: all 0.2s; color: white; }
    .btn-action.edit { background: var(--primary); }
    .btn-action.delete { background: #dc3545; }
    .btn-action:hover { opacity: 0.8; transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <header class="admin-header">
            <h1>Manage Suppliers</h1>
            <a href="{{ route('admin.suppliers.create') }}" class="btn-add">+ Add New Supplier</a>
        </header>

        <div class="suppliers-section">
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th class="col-brand">Brand</th>
                            <th class="col-contact">Contact Person</th>
                            <th class="col-email">Email</th>
                            <th class="col-phone">Phone</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $s)
                        <tr>
                            <td>{{ $s->id }}</td>
                            <td><strong>{{ $s->brand }}</strong></td>
                            <td>{{ $s->contact_person }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->phone }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.suppliers.edit', $s) }}" class="btn-action edit">Edit</a>
                                    <form action="{{ route('admin.suppliers.destroy', $s) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this supplier?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2rem;">{{ $suppliers->links() }}</div>
        </div>
    </main>
</div>
@endsection
