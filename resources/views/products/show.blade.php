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
</script>
@endpush
@endsection
