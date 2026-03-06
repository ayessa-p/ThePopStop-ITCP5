@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <div>
        @if($product->image_url)
            @php $src = preg_match('/^https?:\\/\\//i', $product->image_url) ? $product->image_url : Storage::url($product->image_url); @endphp
            <img src="{{ $src }}" alt="{{ $product->name }}" style="width:100%; max-height: 400px; object-fit: contain;">
        @else
            <div style="height: 300px; background: var(--light-beige); display: flex; align-items: center; justify-content: center; font-size: 5rem;">📦</div>
        @endif
        @if($product->productPhotos->count() > 0)
            <div style="display: flex; gap: 0.5rem; margin-top: 1rem; flex-wrap: wrap;">
                @foreach($product->productPhotos as $photo)
                    <img src="{{ Storage::url($photo->photo_url) }}" alt="" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                @endforeach
            </div>
        @endif
    </div>
    <div>
        <h1 style="color: var(--dark-brown);">{{ $product->name }}</h1>
        <p><strong>Series:</strong> {{ $product->series }} | <strong>Brand:</strong> {{ $product->brand }}</p>
        <p><strong>SKU:</strong> {{ $product->sku }} | <strong>Type:</strong> {{ $product->type ?? '-' }}</p>
        <p style="font-size: 1.5rem; font-weight: bold;">₱{{ number_format($product->price, 2) }}</p>
        <p><span style="padding: 0.25rem 0.5rem; border-radius: 4px; background: {{ $product->status === 'In Stock' ? '#d4edda' : ($product->status === 'Low Stock' ? '#fff3cd' : '#f8d7da') }};">{{ $product->status }}</span></p>
        <p>{{ $product->description }}</p>
        @auth
            <form method="POST" action="{{ route('cart.store') }}" style="margin-top: 1rem;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" style="width: 80px; padding: 0.5rem;">
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        @else
            <p><a href="{{ route('login') }}">Login</a> to add to cart.</p>
        @endauth
    </div>
</div>

<div style="margin-top: 2rem;">
    <h2>Reviews ({{ $reviews->count() }}) - Average: {{ $avgRating }}/5</h2>
    @auth
        @if($canReview && !$userReview)
            <form method="POST" action="{{ route('reviews.store', $product) }}" style="margin-bottom: 2rem;">
                @csrf
                <label>Rating:</label>
                <select name="rating" required>
                    @for($i = 1; $i <= 5; $i++)<option value="{{ $i }}">{{ $i }}</option>@endfor
                </select>
                <textarea name="review_text" placeholder="Your review..." rows="3" style="width:100%; padding: 0.5rem;"></textarea>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        @elseif($userReview)
            <p>Your review: {{ $userReview->rating }}/5 - {{ $userReview->review_text }}</p>
            <form method="POST" action="{{ route('reviews.update', $userReview) }}">
                @csrf
                @method('PUT')
                <select name="rating" required>@for($i = 1; $i <= 5; $i++)<option value="{{ $i }}" {{ $userReview->rating == $i ? 'selected' : '' }}>{{ $i }}</option>@endfor</select>
                <textarea name="review_text" rows="2" style="width:100%;">{{ $userReview->review_text }}</textarea>
                <button type="submit" class="btn btn-secondary">Update Review</button>
            </form>
        @endif
    @endauth
    @foreach($reviews as $r)
        <div style="border: 1px solid #eee; padding: 1rem; margin-bottom: 0.5rem; border-radius: 8px;">
            <strong>{{ $r->user->full_name ?? $r->user->username }}</strong> - {{ $r->rating }}/5 - {{ $r->created_at->format('M d, Y') }}
            <p>{{ $r->review_text }}</p>
        </div>
    @endforeach
</div>
@endsection
