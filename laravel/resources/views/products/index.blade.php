@extends('layouts.app')

@section('title', 'Products')

@section('content')
<h1 style="color: var(--dark-brown); text-align:center;">Products</h1>

<form method="GET" action="{{ route('products.index') }}" class="filter-bar">
    <input class="search-input" type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" style="max-width:420px;">
    <select class="form-control" name="brand">
        <option value="">All Brands</option>
        @foreach($brands as $b)<option value="{{ $b }}" {{ request('brand') === $b ? 'selected' : '' }}>{{ $b }}</option>@endforeach
    </select>
    <select class="form-control" name="type">
        <option value="">All Types</option>
        @foreach($types as $t)<option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>@endforeach
    </select>
    <select class="form-control" name="status">
        <option value="">All Status</option>
        <option value="In Stock" {{ request('status') === 'In Stock' ? 'selected' : '' }}>In Stock</option>
        <option value="Low Stock" {{ request('status') === 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
        <option value="Out of Stock" {{ request('status') === 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
    </select>
    <input class="form-control" type="number" name="min_price" placeholder="Min price" value="{{ request('min_price') }}" style="width: 120px;">
    <input class="form-control" type="number" name="max_price" placeholder="Max price" value="{{ request('max_price') }}" style="width: 120px;">
    <select class="form-control" name="sort">
        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price Low-High</option>
        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price High-Low</option>
        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
</form>

<div class="product-grid">
    @forelse($products as $product)
        <div class="product-card">
            <div class="media">
                @if($product->image_url)
                    @php $src = preg_match('/^https?:\\/\\//i', $product->image_url) ? $product->image_url : Storage::url($product->image_url); @endphp
                    <img src="{{ $src }}" alt="{{ $product->name }}">
                @else
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:3rem;">📦</div>
                @endif
            </div>
            <div class="product-info">
                <div style="font-weight:bold;">{{ $product->name }}</div>
                <div style="color: var(--secondary); font-size: 0.9rem;">{{ $product->series }} - {{ $product->brand }}</div>
                <div style="font-weight:bold;">₱{{ number_format($product->price, 2) }}</div>
                @php $statusClass = match($product->status){'In Stock'=>'badge-success','Low Stock'=>'badge-warning','Out of Stock'=>'badge-danger', default=>'badge-secondary'}; @endphp
                <span class="badge {{ $statusClass }}">{{ $product->status }}</span>
                <div class="product-actions">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-block">View Details</a>
                </div>
            </div>
        </div>
    @empty
        <p>No products found.</p>
    @endforelse
</div>
<div style="margin-top: 2rem;">{{ $products->withQueryString()->links() }}</div>
@endsection
