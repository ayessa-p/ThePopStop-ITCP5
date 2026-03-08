@extends('layouts.app')

@section('title', 'The Pop Stop - Collectible Figurines')

@section('content')
<div class="hero">
    <h1>Welcome to The Pop Stop</h1>
    <p>Your destination for premium collectible figurines</p>

    <form method="GET" action="{{ route('home') }}" class="search-form">
        <div class="input-group">
        <input class="search-input" type="text" name="search" placeholder="Search by name, series, or brand..." value="{{ request('search') }}">
        <select class="search-select" name="search_mode">
            <option value="like" {{ (request('search_mode','like')==='like')?'selected':'' }}>LIKE</option>
            <option value="model" {{ (request('search_mode')==='model')?'selected':'' }}>Model</option>
            <option value="scout" {{ (request('search_mode')==='scout')?'selected':'' }}>Scout</option>
        </select>
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
                @if($product->image_url)
                    @php $src = preg_match('/^https?:\\/\\//i', $product->image_url) ? $product->image_url : Storage::url($product->image_url); @endphp
                    <img src="{{ $src }}" alt="{{ $product->name }}">
                @else
                    <span style="font-size: 3rem;">📦</span>
                @endif
            </div>
            <div class="product-info">
                <div style="font-weight: bold;">{{ $product->name }}</div>
                <div style="color: var(--secondary); font-size: 0.9rem;">{{ $product->series }} - {{ $product->brand }}</div>
                <div style="font-weight: bold;">₱{{ number_format($product->price, 2) }}</div>
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
<div style="text-align: center; margin-top: 2rem;">
    <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
</div>
@endsection
