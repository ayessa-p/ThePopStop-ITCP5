@extends('layouts.app')

@section('title', 'Manage Discounts - Admin')

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
    .discounts-section { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
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

    .col-code { width: 15%; }
    .col-desc { width: 25%; }
    .col-type { width: 12%; }
    .col-value { width: 10%; }
    .col-min { width: 12%; }
    .col-valid { width: 18%; }
    .col-status { width: 8%; }
    .col-actions { width: 120px; }

    .badge-status { padding: 0.4rem 0.8rem; border-radius: 50px; font-weight: 600; font-size: 0.75rem; }
    .status-active { background: #d1fae5; color: #065f46; }
    .status-inactive { background: #fee2e2; color: #991b1b; }

    .action-buttons { display: flex; flex-direction: column; gap: 0.4rem; align-items: center; }
    .btn-action { width: 80px; padding: 0.3rem; border-radius: 50px; text-align: center; text-decoration: none; font-weight: 600; font-size: 0.75rem; border: none; cursor: pointer; transition: all 0.2s; color: white; }
    .btn-edit { background: #a89078; }
    .btn-delete { background: #dc3545; }
    .btn-action:hover { opacity: 0.8; transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <header class="admin-header">
            <h1>Manage Discounts</h1>
            <a href="{{ route('admin.discounts.create') }}" class="btn-add">+ Add New Discount</a>
        </header>

        <div class="discounts-section">
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-code">Code</th>
                            <th class="col-desc">Description</th>
                            <th class="col-type">Type</th>
                            <th class="col-value">Value</th>
                            <th class="col-min">Min Purchase</th>
                            <th class="col-valid">Valid Period</th>
                            <th class="col-status">Status</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($discounts as $d)
                        <tr>
                            <td><strong>{{ $d->code }}</strong></td>
                            <td>{{ $d->description }}</td>
                            <td>{{ $d->discount_type }}</td>
                            <td>{{ $d->discount_type == 'Percentage' ? number_format($d->discount_value, 2) . '%' : '₱' . number_format($d->discount_value, 2) }}</td>
                            <td>₱{{ number_format($d->min_purchase, 2) }}</td>
                            <td style="font-size: 0.8rem;">
                                {{ $d->start_date ? $d->start_date->format('M d, Y') : 'N/A' }} - <br>
                                {{ $d->end_date ? $d->end_date->format('M d, Y') : 'N/A' }}
                            </td>
                            <td>
                                <span class="badge-status {{ $d->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $d->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.discounts.edit', $d) }}" class="btn-action btn-edit">Edit</a>
                                    <form action="{{ route('admin.discounts.destroy', $d) }}" method="POST" onsubmit="return confirm('Delete this discount?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2rem;">{{ $discounts->links() }}</div>
        </div>
    </main>
</div>
@endsection
