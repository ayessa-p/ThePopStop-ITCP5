@extends('layouts.app')
@section('title', 'Import Products')
@section('content')
<h1>Import Products (Excel)</h1>
<p>Upload an Excel file with columns: name, series, brand, price, sku, stock_quantity (required). Optional: cost_price, description, character, category, type, image_url (main picture), additional_images (comma-separated list of secondary images).</p>
<p><strong>Image Paths:</strong> Use local paths relative to the products folder (e.g., <code>hirono1.jpg</code> or <code>products/hirono1.jpg</code>). Ensure all images are uploaded to <code>storage/app/public/products/</code> on your device.</p>
<form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
    <button type="submit" class="btn btn-primary">Import</button>
</form>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
@endsection
