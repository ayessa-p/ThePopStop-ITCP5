@extends('layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    .image-slider {
        position: relative;
        width: 100%;
        background: transparent;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .slider-main-img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
        transition: opacity 0.3s;
    }
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.3);
        color: white;
        border: none;
        padding: 1rem 0.5rem;
        cursor: pointer;
        font-size: 1.5rem;
        transition: background 0.2s;
        z-index: 10;
    }
    .slider-btn:hover {
        background: rgba(0,0,0,0.6);
    }
    .slider-prev { left: 0; border-radius: 0 8px 8px 0; }
    .slider-next { right: 0; border-radius: 8px 0 0 8px; }
    
    .thumbnail-list {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    .thumb-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s;
    }
    .thumb-img.active {
        border-color: var(--primary);
    }

    /* Reviews Section Styles */
    .reviews-container {
        margin-top: 3rem;
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #F3F1EA;
    }
    .reviews-header h2 {
        color: var(--dark-brown);
        font-size: 1.5rem;
        margin: 0;
    }
    .avg-rating-badge {
        background: #FDFCFA;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        color: #fbbf24;
        font-weight: 700;
        border: 1px solid #F5F2EB;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .review-item {
        padding: 1.5rem;
        border-bottom: 1px solid #F3F1EA;
        transition: background 0.2s;
    }
    .review-item:last-child { border-bottom: none; }
    .review-user-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .review-user-name {
        font-weight: 700;
        color: var(--dark-brown);
    }
    .review-date {
        color: #999;
        font-size: 0.85rem;
    }
    .review-stars {
        color: #fbbf24;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    .review-text {
        color: #555;
        line-height: 1.6;
        font-size: 0.95rem;
    }
    .review-form-card {
        background: #FDFCFA;
        border: 1px solid #F5F2EB;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .review-form-card h3 {
        margin-top: 0;
        font-size: 1.1rem;
        color: var(--dark-brown);
        margin-bottom: 1rem;
    }
    .star-select {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .star-select input { display: none; }
    .star-select label {
        cursor: pointer;
        font-size: 1.5rem;
        color: #ddd;
        transition: color 0.2s;
    }
    .star-select input:checked ~ label,
    .star-select label:hover,
    .star-select label:hover ~ label {
        color: #fbbf24;
    }
    .review-textarea {
        width: 100%;
        padding: 1rem;
        border: 1px solid #E8E4DC;
        border-radius: 8px;
        font-family: inherit;
        resize: vertical;
        margin-bottom: 1rem;
    }
    .btn-review-submit {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-review-submit:hover {
        background: var(--accent);
        transform: translateY(-1px);
    }
    .user-review-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }
    .btn-edit-review {
        background: white;
        color: var(--primary);
        border: 1px solid var(--primary);
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-edit-review:hover {
        background: var(--primary);
        color: white;
    }
</style>
@endpush

@section('content')
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <div>
        @php
            $allImages = [];
            // Add the main Excel image first if it's not already covered by gallery primary
            $primaryGalleryPhoto = $product->productPhotos->where('is_primary', true)->first();
            
            // Collect all images: Gallery images first, then main Excel image if not primary
            foreach($product->productPhotos as $p) {
                $allImages[] = $p->url;
            }
            
            // If main Excel image is not in gallery, add it
            $mainExcelUrl = $product->image_url ? (preg_match('/^https?:\/\//i', $product->image_url) ? $product->image_url : route('image.serve', ['path' => ltrim($product->image_url, '/')])) : null;
            if ($mainExcelUrl && !in_array($mainExcelUrl, $allImages)) {
                array_unshift($allImages, $mainExcelUrl);
            }
        @endphp

        <div class="image-slider">
            @if(count($allImages) > 1)
                <button class="slider-btn slider-prev" onclick="changeImage(-1)">&#10094;</button>
            @endif
            
            <img id="main-product-image" src="{{ $product->photo_url }}" alt="{{ $product->name }}" class="slider-main-img">
            
            @if(count($allImages) > 1)
                <button class="slider-btn slider-next" onclick="changeImage(1)">&#10095;</button>
            @endif
        </div>
        
        @if(count($allImages) > 1)
            <div class="thumbnail-list">
                @foreach($allImages as $index => $imgUrl)
                    <img src="{{ $imgUrl }}" alt="" class="thumb-img {{ $product->photo_url == $imgUrl ? 'active' : '' }}" onclick="setMainImage('{{ $imgUrl }}', {{ $index }})">
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

<div class="reviews-container">
    <div class="reviews-header">
        <h2>Reviews ({{ $reviews->count() }})</h2>
        <div class="avg-rating-badge">
            <span>Average: {{ number_format($avgRating, 1) }}/5</span>
            <span style="color: #fbbf24;">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($avgRating))
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </span>
        </div>
    </div>

    @auth
        @if($canReview && !$userReview)
            <div class="review-form-card">
                <h3>Write a Review</h3>
                <form method="POST" action="{{ route('reviews.store', $product) }}">
                    @csrf
                    <div class="star-select">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                            <label for="star{{ $i }}">★</label>
                        @endfor
                    </div>
                    <textarea name="review_text" class="review-textarea" placeholder="Share your thoughts on this product..." rows="4"></textarea>
                    <button type="submit" class="btn-review-submit">Submit Review</button>
                </form>
            </div>
        @elseif($userReview)
            <div class="user-review-summary" id="user-review-display">
                <div>
                    <span style="font-weight: 700; color: #166534;">Your review:</span>
                    <span style="color: #fbbf24; margin: 0 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $userReview->rating ? '★' : '☆' }}
                        @endfor
                    </span>
                    <span style="color: #4b5563;">"{{ $userReview->review_text }}"</span>
                </div>
                <button type="button" class="btn-edit-review" onclick="toggleEditReview()">Edit Review</button>
            </div>

            <div class="review-form-card" id="edit-review-form" style="display: none;">
                <h3>Update Your Review</h3>
                <form method="POST" action="{{ route('reviews.update', $userReview) }}">
                    @csrf
                    @method('PUT')
                    <div class="star-select">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="edit-star{{ $i }}" name="rating" value="{{ $i }}" {{ $userReview->rating == $i ? 'checked' : '' }} required>
                            <label for="edit-star{{ $i }}">★</label>
                        @endfor
                    </div>
                    <textarea name="review_text" class="review-textarea" rows="4">{{ $userReview->review_text }}</textarea>
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="btn-review-submit">Update Review</button>
                        <button type="button" onclick="toggleEditReview()" style="background: none; border: none; color: #666; cursor: pointer; font-size: 0.9rem;">Cancel</button>
                    </div>
                </form>
            </div>
        @endif
    @endauth

    <div class="reviews-list">
        @forelse($reviews as $r)
            <div class="review-item">
                <div class="review-user-info">
                    <span class="review-user-name">{{ $r->user->full_name ?? $r->user->username }}</span>
                    <span class="review-date">{{ $r->created_at->format('M d, Y') }}</span>
                </div>
                <div class="review-stars">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $r->rating ? '★' : '☆' }}
                    @endfor
                </div>
                <div class="review-text">{{ $r->review_text }}</div>
            </div>
        @empty
            <p style="text-align: center; color: #999; padding: 2rem;">No reviews yet. Be the first to review!</p>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    let currentImageIndex = 0;
    const images = @json($allImages);
    const mainImg = document.getElementById('main-product-image');
    const thumbnails = document.querySelectorAll('.thumb-img');

    function setMainImage(url, index) {
        mainImg.style.opacity = 0;
        setTimeout(() => {
            mainImg.src = url;
            mainImg.style.opacity = 1;
        }, 200);
        
        currentImageIndex = index;
        
        thumbnails.forEach(t => t.classList.remove('active'));
        if(thumbnails[index]) thumbnails[index].classList.add('active');
    }

    function changeImage(direction) {
        currentImageIndex += direction;
        if (currentImageIndex >= images.length) currentImageIndex = 0;
        if (currentImageIndex < 0) currentImageIndex = images.length - 1;
        
        setMainImage(images[currentImageIndex], currentImageIndex);
    }

    function toggleEditReview() {
        const display = document.getElementById('user-review-display');
        const form = document.getElementById('edit-review-form');
        
        if (form.style.display === 'none') {
            form.style.display = 'block';
            display.style.display = 'none';
        } else {
            form.style.display = 'none';
            display.style.display = 'flex';
        }
    }
</script>
@endpush
@endsection
