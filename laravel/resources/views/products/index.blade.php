@extends('layouts.app')

@section('title', 'Products')

@section('content')
<h1 style="color: var(--dark-brown);">Products</h1>

<form method="GET" action="{{ route('products.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" style="padding: 0.5rem;">
    <select name="brand" style="padding: 0.5rem;">
        <option value="">All Brands</option>
        @foreach($brands as $b)<option value="{{ $b }}" {{ request('brand') === $b ? 'selected' : '' }}>{{ $b }}</option>@endforeach
    </select>
    <select name="type" style="padding: 0.5rem;">
        <option value="">All Types</option>
        @foreach($types as $t)<option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>@endforeach
    </select>
    <select name="status" style="padding: 0.5rem;">
        <option value="">All Status</option>
        <option value="In Stock" {{ request('status') === 'In Stock' ? 'selected' : '' }}>In Stock</option>
        <option value="Low Stock" {{ request('status') === 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
        <option value="Out of Stock" {{ request('status') === 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
    </select>
    <input type="number" name="min_price" placeholder="Min price" value="{{ request('min_price') }}" style="padding: 0.5rem; width: 100px;">
    <input type="number" name="max_price" placeholder="Max price" value="{{ request('max_price') }}" style="padding: 0.5rem; width: 100px;">
    <select name="sort" style="padding: 0.5rem;">
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
            <div style="height: 200px; background: var(--light-beige);">
                @if($product->image_url)
                    @php $src = preg_match('/^https?:\\/\\//i', $product->image_url) ? $product->image_url : Storage::url($product->image_url); @endphp
                    <img src="{{ $src }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:3rem;">📦</div>
                @endif
            </div>
            <div class="product-info">
                <div style="font-weight:bold;">{{ $product->name }}</div>
                <div style="color: var(--secondary); font-size: 0.9rem;">{{ $product->series }} - {{ $product->brand }}</div>
                <div style="font-weight:bold;">₱{{ number_format($product->price, 2) }}</div>
                <div style="font-size: 0.85rem;">{{ $product->status }}</div>
                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary" style="width:100%; margin-top: 0.5rem;">View Details</a>
            </div>
        </div>
    @empty
        <p>No products found.</p>
    @endforelse
</div>
<div style="margin-top: 2rem;">{{ $products->withQueryString()->links() }}</div>
@endsection
