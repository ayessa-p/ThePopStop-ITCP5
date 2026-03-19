@extends('layouts.app')
@section('title', 'Add Product - Admin')

@push('styles')
@include('admin.partials.form-styles')
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">

        <a href="{{ route('admin.products.index') }}" class="af-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Products
        </a>

        <div class="af-page-header">
            <h1>Add New Product</h1>
            <p>Fill in the details below to add a new product to the catalog.</p>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- ── Basic Info ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Basic Information
                </div>

                <div class="af-grid-2">
                    <div class="af-field af-span-2">
                        <label class="af-label">Product Name <span class="af-required">*</span></label>
                        <input type="text" name="name" class="af-input" value="{{ old('name') }}" required placeholder="e.g. Labubu The Monsters Series">
                        @error('name')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Series <span class="af-required">*</span></label>
                        <input type="text" name="series" class="af-input" value="{{ old('series') }}" required placeholder="e.g. The Monsters">
                        @error('series')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Brand <span class="af-required">*</span></label>
                        <input type="text" name="brand" class="af-input" value="{{ old('brand') }}" required placeholder="e.g. Pop Mart">
                        @error('brand')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Character</label>
                        <input type="text" name="character" class="af-input" value="{{ old('character') }}" placeholder="e.g. Labubu">
                    </div>

                    <div class="af-field">
                        <label class="af-label">SKU <span class="af-required">*</span></label>
                        <input type="text" name="sku" class="af-input" value="{{ old('sku') }}" required placeholder="e.g. PM-LAB-001">
                        @error('sku')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field af-span-2">
                        <label class="af-label">Description</label>
                        <textarea name="description" class="af-textarea" rows="3" placeholder="Describe this product...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Pricing & Inventory ── --}}
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
                            <input type="number" name="price" class="af-input" step="0.01" min="0" value="{{ old('price') }}" required placeholder="0.00">
                        </div>
                        @error('price')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Cost Price</label>
                        <div class="af-prefix-wrap">
                            <span class="af-prefix">&#8369;</span>
                            <input type="number" name="cost_price" class="af-input" step="0.01" min="0" value="{{ old('cost_price') }}" placeholder="0.00">
                        </div>
                    </div>

                    <div class="af-field">
                        <label class="af-label">Stock Quantity <span class="af-required">*</span></label>
                        <input type="number" name="stock_quantity" class="af-input" min="0" value="{{ old('stock_quantity', 0) }}" required placeholder="0">
                        @error('stock_quantity')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Low Stock Threshold</label>
                        <input type="number" name="low_stock_threshold" class="af-input" min="0" value="{{ old('low_stock_threshold', 5) }}" placeholder="5">
                        <span class="af-hint">Alert when stock falls below this number.</span>
                    </div>
                </div>
            </div>

            {{-- ── Classification ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Classification
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label">Category</label>
                        <input type="text" name="category" class="af-input" value="{{ old('category') }}" placeholder="e.g. Figurine, Plush">
                    </div>

                    <div class="af-field">
                        <label class="af-label">Type</label>
                        <input type="text" name="type" class="af-input" value="{{ old('type') }}" placeholder="e.g. Blind Box, Limited Edition">
                    </div>
                </div>
            </div>

            {{-- ── Product Image ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Product Image
                </div>

                <div class="af-field">
                    <div class="af-file-zone" id="image-drop-zone">
                        <input type="file" name="image" accept="image/*" id="product-image-input"
                            onchange="handleFileSelect(this, 'image-filename', 'img-preview-wrap', 'img-preview')">
                        <div class="af-file-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="af-file-title">Drop image here or <span>browse</span></div>
                        <div class="af-file-sub">PNG, JPG, WEBP up to 5MB</div>
                        <div id="image-filename" style="display:none; margin-top:.65rem; font-size:.8rem; font-weight:700; color:var(--primary); background:rgba(139,0,0,.07); border-radius:6px; padding:.3rem .7rem; display:none;"></div>
                    </div>
                    <div id="img-preview-wrap" style="display:none; margin-top:.75rem;">
                        <img id="img-preview" class="af-img-preview" src="" alt="Preview">
                    </div>
                </div>
            </div>

            {{-- ── Actions ── --}}
            <div class="af-btn-row">
                <button type="submit" class="af-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Product
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
    function handleFileSelect(input, labelId, wrapId, previewId) {
        const file = input.files[0];
        if (!file) return;
        const label = document.getElementById(labelId);
        if (label) { label.textContent = file.name; label.style.display = 'inline-block'; }
        const wrap = document.getElementById(wrapId);
        const preview = document.getElementById(previewId);
        if (wrap && preview) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; wrap.style.display = 'block'; };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection
