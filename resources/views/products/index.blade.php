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
    <select class="form-control" name="series">
        <option value="">All Series</option>
        @foreach($series as $s)<option value="{{ $s }}" {{ request('series') === $s ? 'selected' : '' }}>{{ $s }}</option>@endforeach
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
                <img src="{{ $product->photo_url }}" alt="{{ $product->name }}">
            </div>
            <div class="product-info">
                <div style="font-weight:bold;">{{ $product->name }}</div>
                <div style="color: var(--secondary); font-size: 0.9rem;">{{ $product->series }} - {{ $product->brand }}</div>
                <div style="font-weight:bold;">₱{{ number_format($product->price, 2) }}</div>
                <div class="product-actions">
                    @php $statusClass = match($product->status){'In Stock'=>'badge-success','Low Stock'=>'badge-warning','Out of Stock'=>'badge-danger', default=>'badge-secondary'}; @endphp
                    <span class="badge {{ $statusClass }}">{{ $product->status }}</span>
                    <div style="display: flex; gap: 0.5rem; width: 100%; align-items: stretch;">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-secondary" style="flex: 1; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 600;">View Details</a>
                        @auth
                            @if($product->status !== 'Out of Stock')
                                <form method="POST" action="{{ route('cart.store') }}" style="display: flex;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary" title="Add to Cart" style="padding: 0.5rem 0.75rem; display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No products found.</p>
    @endforelse
</div>
<div style="margin-top: 2rem; display: flex; justify-content: center;">
    {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
</div>
@endsection
