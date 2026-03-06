@extends('layouts.app')
@section('title', 'Admin - Products')
@section('content')
<h1>Manage Products</h1>
<p><a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a> <a href="{{ route('admin.products.import-form') }}" class="btn btn-secondary">Import Excel</a></p>
<form method="GET" style="margin-bottom: 1rem;">
    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-secondary">Search</button>
</form>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem;">ID</th>
            <th style="padding: 0.5rem;">Name</th>
            <th style="padding: 0.5rem;">SKU</th>
            <th style="padding: 0.5rem;">Brand</th>
            <th style="padding: 0.5rem;">Price</th>
            <th style="padding: 0.5rem;">Stock</th>
            <th style="padding: 0.5rem;">Status</th>
            <th style="padding: 0.5rem;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $p)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $p->id }}</td>
                <td style="padding: 0.5rem;">{{ $p->name }}</td>
                <td style="padding: 0.5rem;">{{ $p->sku }}</td>
                <td style="padding: 0.5rem;">{{ $p->brand }}</td>
                <td style="padding: 0.5rem;">P{{ number_format($p->price, 2) }}</td>
                <td style="padding: 0.5rem;">{{ $p->stock_quantity }}</td>
                <td style="padding: 0.5rem;">{{ $p->status }}</td>
                <td style="padding: 0.5rem;">
                    @if($p->trashed())
                        <form action="{{ route('admin.products.restore', $p->id) }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-secondary btn-sm">Restore</button></form>
                    @else
                        <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <a href="{{ route('admin.products.photos.index', $p) }}" class="btn btn-secondary btn-sm">Photos</a>
                        <form action="{{ route('admin.products.destroy', $p) }}" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button></form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-top: 1rem;">
    {{ $products->withQueryString()->links('pagination::default') }}
</div>
@endsection
