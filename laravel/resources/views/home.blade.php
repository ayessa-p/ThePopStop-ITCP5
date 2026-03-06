@extends('layouts.app')

@section('title', 'The Pop Stop - Collectible Figurines')

@section('content')
<div class="hero" style="text-align: center; padding: 2rem 0;">
    <h1>Welcome to The Pop Stop</h1>
    <p>Your destination for premium collectible figurines</p>

    <form method="GET" action="{{ route('home') }}" style="max-width: 600px; margin: 2rem auto; display: flex; gap: 0.5rem;">
        <input type="text" name="search" placeholder="Search by name, series, or brand..." value="{{ request('search') }}" style="flex:1; padding: 0.8rem; border: 2px solid var(--primary); border-radius: 8px;">
        <button type="submit" class="btn btn-primary">Search</button>
        @if(request('search'))<a href="{{ route('home') }}" class="btn btn-secondary">Clear</a>@endif
    </form>

    <a href="{{ route('products.index') }}" class="btn btn-primary">Shop All Products</a>
</div>

<div class="brand-section" style="margin: 2rem 0;">
    <h2 style="text-align: center; margin-bottom: 2rem; color: var(--dark-brown);">Shop by Brand</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
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
            <div style="height: 200px; background: var(--light-beige); display: flex; align-items: center; justify-content: center;">
                @if($product->image_url)
                    @php $src = preg_match('/^https?:\\/\\//i', $product->image_url) ? $product->image_url : Storage::url($product->image_url); @endphp
                    <img src="{{ $src }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                    <span style="font-size: 3rem;">📦</span>
                @endif
            </div>
            <div class="product-info">
                <div style="font-weight: bold;">{{ $product->name }}</div>
                <div style="color: var(--secondary); font-size: 0.9rem;">{{ $product->series }} - {{ $product->brand }}</div>
                <div style="font-weight: bold;">₱{{ number_format($product->price, 2) }}</div>
                <div style="font-size: 0.85rem;">{{ $product->status }}</div>
                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary" style="width:100%; margin-top: 0.5rem;">View Details</a>
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
