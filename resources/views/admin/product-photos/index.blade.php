@extends('layouts.app')

@section('title', 'Manage Product Photos - Admin')

@push('styles')
<style>
    .admin-container {
        display: flex;
        gap: 2rem;
        padding: 2rem 0;
    }

    /* Sidebar Styles */
    .admin-sidebar {
        width: 280px;
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        height: fit-content;
    }

    .admin-sidebar h2 {
        color: var(--primary);
        font-size: 1.25rem;
        margin-bottom: 2rem;
        font-weight: 700;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        text-decoration: none;
        color: #666;
        border-radius: 12px;
        transition: all 0.2s;
        font-weight: 500;
    }

    .sidebar-link:hover {
        background: var(--bg);
        color: var(--primary);
    }

    .sidebar-link.active {
        background: var(--primary);
        color: white;
    }

    /* Content Area Styles */
    .admin-main {
        flex: 1;
        min-width: 0;
    }

    .admin-header {
        margin-bottom: 2rem;
    }

    .admin-header h1 {
        color: var(--dark-brown);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .product-info-sub {
        color: #888;
        font-size: 0.9rem;
    }

    /* Section Boxes */
    .photo-section {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .photo-section h2 {
        color: var(--dark-brown);
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }

    /* Upload Area */
    .upload-box {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .file-input-label {
        color: #666;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .file-hint {
        color: #aaa;
        font-size: 0.75rem;
        margin-left: 1rem;
    }

    .btn-upload {
        background: var(--primary);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        width: fit-content;
        transition: background 0.2s;
    }

    .btn-upload:hover {
        background: var(--accent);
    }

    /* Photo Grid */
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    .photo-card {
        background: white;
        border: 2px solid #F3F1EA;
        border-radius: 15px;
        padding: 1rem;
        text-align: center;
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .photo-card.primary-photo {
        border-color: var(--primary);
        background: #fff;
    }

    .primary-label {
        background: var(--primary);
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.25rem;
        border-radius: 4px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .photo-wrapper {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 10px;
        overflow: hidden;
        background: #f9f9f9;
    }

    .photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-top: auto;
    }

    .btn-photo-action {
        width: 100%;
        padding: 0.5rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .btn-photo-action.set-primary {
        background: var(--primary);
        color: white;
    }

    .btn-photo-action.delete {
        background: #E26D5C;
        color: white;
    }

    .btn-photo-action:hover {
        opacity: 0.8;
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-header">
            <h1>Manage Product Photos</h1>
            <p class="product-info-sub">Product: {{ $product->name }}</p>
        </header>

        @php
            $hasGalleryPrimary = $product->productPhotos->where('is_primary', true)->count() > 0;
        @endphp

        <!-- Upload Section -->
        <section class="photo-section">
            <h2>Upload New Photos</h2>
            <form method="POST" action="{{ route('admin.products.photos.store', $product) }}" enctype="multipart/form-data" class="upload-box">
                @csrf
                <div class="file-input-group">
                    <p class="file-input-label">Select Photos (Multiple)</p>
                    <div style="display: flex; align-items: center; gap: 1rem; margin-top: 0.5rem;">
                        <input type="file" name="photos[]" id="photos" multiple accept="image/*" class="form-control-file">
                        <span class="file-hint">You can select multiple images at once. Supported: JPG, PNG, GIF, WEBP</span>
                    </div>
                </div>
                <button type="submit" class="btn-upload">Upload Photos</button>
            </form>
        </section>

        <!-- Current Photos Section -->
        <section class="photo-section">
            <h2>Current Photos ({{ $product->productPhotos->count() + 1 }})</h2>
            <div class="photo-grid">
                <!-- Main Product Image (from image_url) -->
                <div class="photo-card {{ !$hasGalleryPrimary ? 'primary-photo' : '' }}">
                    @if(!$hasGalleryPrimary)
                        <div class="primary-label">Primary Photo</div>
                    @else
                        <div class="primary-label" style="background: #888;">Main Image (Excel)</div>
                    @endif
                    <div class="photo-wrapper">
                        @php
                            $mainUrl = $product->image_url ? (preg_match('/^https?:\/\//i', $product->image_url) ? $product->image_url : route('image.serve', ['path' => ltrim($product->image_url, '/')])) : 'https://ui-avatars.com/api/?name=' . urlencode($product->name);
                        @endphp
                        <img src="{{ $mainUrl }}" alt="Main Product Image">
                    </div>
                    <div class="photo-actions">
                        @if($hasGalleryPrimary)
                            <form action="{{ route('admin.products.photos.clear-primary', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-photo-action set-primary">Set as Primary</button>
                            </form>
                        @endif
                        <p style="font-size: 0.7rem; color: #888; text-align: center; margin-top: 0.5rem;">This image comes from your Excel data.</p>
                    </div>
                </div>

                @foreach($product->productPhotos as $photo)
                    <div class="photo-card {{ $photo->is_primary ? 'primary-photo' : '' }}">
                        @if($photo->is_primary)
                            <div class="primary-label">Primary Photo</div>
                        @endif
                        <div class="photo-wrapper">
                            <img src="{{ $photo->url }}" alt="Product Photo">
                        </div>
                        <div class="photo-actions">
                            @if(!$photo->is_primary)
                                <form action="{{ route('admin.products.photos.primary', [$product, $photo]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-photo-action set-primary">Set as Primary</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.products.photos.destroy', [$product, $photo]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-photo-action delete" onclick="return confirm('Delete this photo?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <div style="margin-top: 2rem;">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">← Back to Products</a>
        </div>
    </main>
</div>
@endsection
