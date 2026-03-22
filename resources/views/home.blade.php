@extends('layouts.app')

@section('title', 'The Pop Stop - Collectible Figurines')

@section('content')
<div class="hero">
    <h1>Welcome to The Pop Stop</h1>
    <p>Your destination for premium collectible figurines</p>

    <form method="GET" action="{{ route('home') }}" class="search-form">
        <div class="input-group">
            <input class="search-input" type="text" name="search" placeholder="Search by name, series, or brand..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary search-button">Search</button>
            @if(request('search'))<a href="{{ route('home') }}" class="btn btn-secondary">Clear</a>@endif
        </div>
    </form>

    <a href="{{ route('products.index') }}" class="btn btn-primary">Shop All Products</a>
</div>

<div class="brand-section">
    <h2 style="text-align: center; margin-bottom: 2rem; color: var(--dark-brown);">Shop by Brand</h2>
    <div class="brand-tags">
        @foreach($brands as $b)
            <a href="{{ route('home', ['brand' => $b]) }}" class="btn {{ request('brand') === $b ? 'btn-primary' : 'btn-secondary' }}">{{ $b }}</a>
        @endforeach
        @if(request('brand'))<a href="{{ route('home') }}" class="btn btn-secondary">Clear Filter</a>@endif
    </div>
</div>

<h2 style="margin-bottom: 1rem; color: var(--dark-brown);">{{ request('brand') ? request('brand') . ' Products' : 'Featured Products' }}</h2>
<div class="product-grid">
    @forelse($products as $product)
        <div class="product-card">
            <div class="media">
                <img src="{{ $product->photo_url }}" alt="{{ $product->name }}">
            </div>
            <div class="product-info">
                <div style="font-weight: bold;">{{ $product->name }}</div>
                <div style="color: var(--secondary); font-size: 0.9rem;">{{ $product->series }} - {{ $product->brand }}</div>
                <div style="font-weight: bold;">₱{{ number_format($product->price, 2) }}</div>
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
    {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>

<div style="text-align: center; margin-top: 2rem;">
    <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
</div>
@endsection
