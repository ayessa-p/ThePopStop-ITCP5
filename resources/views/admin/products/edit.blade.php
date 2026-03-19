@extends('layouts.app')
@section('title', 'Edit Product - Admin')

@push('styles')
    @include('admin.partials.form-styles')
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">

        <a href="{{ route('admin.products.index') }}" class="af-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Products
        </a>

        <div class="af-page-header">
            <h1>Edit Product</h1>
            <p>Update the details for <strong>{{ $product->name }}</strong></p>
        </div>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ── Basic Info ─────────────────────────────────────── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Basic Information
                </div>

                <div class="af-grid-2">
                    <div class="af-field af-span-2">
                        <label class="af-label">Product Name <span class="af-required">*</span></label>
                        <input type="text" name="name" class="af-input" value="{{ old('name', $product->name) }}" required placeholder="e.g. Labubu Macaron Series">
                        @error('name')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Series <span class="af-required">*</span></label>
                        <input type="text" name="series" class="af-input" value="{{ old('series', $product->series) }}" required placeholder="e.g. Macaron Series">
                        @error('series')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Brand <span class="af-required">*</span></label>
                        <input type="text" name="brand" class="af-input" value="{{ old('brand', $product->brand) }}" required placeholder="e.g. Pop Mart">
                        @error('brand')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Character</label>
                        <input type="text" name="character" class="af-input" value="{{ old('character', $product->character) }}" placeholder="e.g. Labubu">
                    </div>

                    <div class="af-field">
                        <label class="af-label">SKU <span class="af-required">*</span></label>
                        <input type="text" name="sku" class="af-input" value="{{ old('sku', $product->sku) }}" required placeholder="e.g. PM-LAB-001">
                        @error('sku')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field af-span-2">
                        <label class="af-label">Description</label>
                        <textarea name="description" class="af-textarea" rows="3" placeholder="Write a short product description...">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Pricing & Inventory ─────────────────────────── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pricing &amp; Inventory
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label">Selling Price <span class="af-required">*</span></label>
                        <div class="af-prefix-wrap">
                            <span class="af-prefix">&#8369;</span>
                            <input type="number" name="price" class="af-input" step="0.01" min="0" value="{{ old('price', $product->price) }}" required placeholder="0.00">
                        </div>
                        @error('price')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Cost Price</label>
                        <div class="af-prefix-wrap">
                            <span class="af-prefix">&#8369;</span>
                            <input type="number" name="cost_price" class="af-input" step="0.01" min="0" value="{{ old('cost_price', $product->cost_price) }}" placeholder="0.00">
                        </div>
                        <div class="af-hint">Internal reference only — not shown to customers.</div>
                    </div>

                    <div class="af-field">
                        <label class="af-label">Stock Quantity <span class="af-required">*</span></label>
                        <input type="number" name="stock_quantity" class="af-input" min="0" value="{{ old('stock_quantity', $product->stock_quantity) }}" required placeholder="0">
                        @error('stock_quantity')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Current Status</label>
                        <input type="text" class="af-input" value="{{ $product->status }}" disabled style="background:#faf8f4;color:#aaa;cursor:not-allowed;">
                        <div class="af-hint">Auto-calculated from stock quantity.</div>
                    </div>
                </div>
            </div>

            {{-- ── Classification ─────────────────────────────── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Classification
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label">Category</label>
                        <input type="text" name="category" class="af-input" value="{{ old('category', $product->category) }}" placeholder="e.g. Collectible Figurine">
                    </div>

                    <div class="af-field">
                        <label class="af-label">Type</label>
                        <input type="text" name="type" class="af-input" value="{{ old('type', $product->type) }}" placeholder="e.g. Blind Box, Limited Edition">
                        <div class="af-hint">Blind Box · Limited Edition · Open Box · Standard</div>
                    </div>
                </div>
            </div>

            {{-- ── Product Image ────────────────────────────────── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Product Image
                </div>

                <div class="af-grid-2" style="align-items:start;">

                    {{-- Current image preview --}}
                    <div class="af-field">
                        <label class="af-label">Current Image</label>
                        @if($product->photo_url)
                            <img id="current-img-preview" src="{{ $product->photo_url }}" alt="{{ $product->name }}" class="af-img-preview">
                        @else
                            <div id="current-img-preview" style="width:100%;height:140px;background:#faf8f4;border:2px solid #f0ede6;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#ddd;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Upload new --}}
                    <div class="af-field">
                        <label class="af-label">Replace Image</label>
                        <div class="af-file-zone" id="drop-zone">
                            <input type="file" name="image" accept="image/*" id="image-input">
                            <div class="af-file-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div class="af-file-title"><span>Click to upload</span> or drag &amp; drop</div>
                            <div class="af-file-sub">PNG, JPG, WEBP up to 5 MB</div>
                            <div class="af-hint" style="margin-top:.5rem;">Leave empty to keep the current image.</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── Actions ─────────────────────────────────────── --}}
            <div class="af-btn-row">
                <button type="submit" class="af-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.products.index') }}" class="af-btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
            </div>

        </form>
    </main>
</div>

@push('scripts')
<script>
    // Live image preview when a new file is picked
    document.getElementById('image-input').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById('current-img-preview');
            if (el.tagName === 'IMG') {
                el.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'af-img-preview';
                img.id = 'current-img-preview';
                el.replaceWith(img);
            }
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush

@endsection
