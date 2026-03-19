@extends('layouts.app')

@section('title', 'Add Supplier - Admin')

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
    .admin-header { margin-bottom: 2rem; }
    .admin-header h1 { color: var(--dark-brown); font-size: 2.25rem; font-weight: 700; margin: 0; }

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
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <a href="{{ route('admin.suppliers.index') }}" class="back-link">← Back to Suppliers</a>

        <div class="form-card">
            <header class="admin-header" style="margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                <h1 style="font-size: 1.5rem;">Add New Supplier</h1>
            </header>

            <form method="POST" action="{{ route('admin.suppliers.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Brand *</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="form-control" required placeholder="Enter brand name">
                </div>

                <div class="form-group">
                    <label class="form-label">Contact Person</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="form-control" placeholder="Enter contact person name">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter email address">
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Enter phone number">
                </div>

                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea name="address" rows="3" class="form-control" placeholder="Enter business address">{{ old('address') }}</textarea>
                </div>

                <button type="submit" class="btn-submit">Create Supplier</button>
            </form>
        </div>
    </main>
</div>
@endsection
