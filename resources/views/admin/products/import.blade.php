@extends('layouts.app')
@section('title', 'Import Products - Admin')

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
            <h1>Import Products</h1>
            <p>Upload an Excel or CSV file to bulk-import products into the catalog.</p>
        </div>

        {{-- ── Required Columns Info ── --}}
        <div class="af-card">
            <div class="af-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                File Format &amp; Column Reference
            </div>

            <div class="af-info-box" style="margin-bottom: 1.25rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Accepted formats: <strong>.xlsx</strong>, <strong>.xls</strong>, <strong>.csv</strong>. The first row must be the column header row.</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">

                {{-- Required columns --}}
                <div>
                    <div style="font-size:.72rem; font-weight:800; text-transform:uppercase; letter-spacing:.7px; color:#bbb; margin-bottom:.75rem;">
                        Required Columns
                    </div>
                    <div style="display:flex; flex-direction:column; gap:.4rem;">
                        @foreach(['name','series','brand','price','sku','stock_quantity'] as $col)
                        <div style="display:flex; align-items:center; gap:.6rem; padding:.5rem .85rem; background:#fff8f8; border:1.5px solid #fecdd3; border-radius:8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#be123c" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <code style="font-size:.82rem; font-weight:700; color:#be123c;">{{ $col }}</code>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Optional columns --}}
                <div>
                    <div style="font-size:.72rem; font-weight:800; text-transform:uppercase; letter-spacing:.7px; color:#bbb; margin-bottom:.75rem;">
                        Optional Columns
                    </div>
                    <div style="display:flex; flex-direction:column; gap:.4rem;">
                        @foreach(['cost_price','description','character','category','type','image_url','additional_images'] as $col)
                        <div style="display:flex; align-items:center; gap:.6rem; padding:.5rem .85rem; background:#f5f9ff; border:1.5px solid #bfdbfe; border-radius:8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#1d4ed8" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <code style="font-size:.82rem; font-weight:700; color:#1d4ed8;">{{ $col }}</code>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Image path note --}}
            <div class="af-warning-box" style="margin-top:1.25rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <strong>Image Paths:</strong> Use paths relative to the products folder — e.g.
                    <code style="background:rgba(0,0,0,.06);padding:.1rem .4rem;border-radius:4px;font-size:.82rem;">hirono1.jpg</code> or
                    <code style="background:rgba(0,0,0,.06);padding:.1rem .4rem;border-radius:4px;font-size:.82rem;">products/hirono1.jpg</code>.
                    Make sure all images are uploaded to
                    <code style="background:rgba(0,0,0,.06);padding:.1rem .4rem;border-radius:4px;font-size:.82rem;">storage/app/public/products/</code>
                    before importing. For <strong>additional_images</strong>, separate multiple paths with a comma.
                </div>
            </div>
        </div>

        {{-- ── Upload Form ── --}}
        <div class="af-card">
            <div class="af-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload File
            </div>

            <form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
                @csrf

                <div class="af-field">
                    <div class="af-file-zone" id="import-drop-zone">
                        <input
                            type="file"
                            name="file"
                            id="import-file-input"
                            accept=".xlsx,.xls,.csv"
                            required
                            onchange="handleImportFile(this)"
                        >
                        <div class="af-file-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="af-file-title">Drop your spreadsheet here or <span>browse</span></div>
                        <div class="af-file-sub">.xlsx &middot; .xls &middot; .csv</div>
                        <div id="import-filename" style="display:none; margin-top:.75rem; font-size:.82rem; font-weight:700; color:var(--primary); background:rgba(139,0,0,.07); border-radius:6px; padding:.35rem .85rem;"></div>
                    </div>
                </div>

                <div class="af-btn-row">
                    <button type="submit" class="af-btn-submit" id="import-submit-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Import Products
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="af-btn-cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </main>
</div>

@push('scripts')
<script>
    function handleImportFile(input) {
        const file = input.files[0];
        if (!file) return;
        const label = document.getElementById('import-filename');
        label.textContent = file.name;
        label.style.display = 'inline-block';

        // Change drop zone border to primary on file selected
        document.getElementById('import-drop-zone').style.borderColor = 'var(--primary)';
        document.getElementById('import-drop-zone').style.background  = 'rgba(139,0,0,.02)';
    }
</script>
@endpush

@endsection
