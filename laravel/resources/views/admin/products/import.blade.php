@extends('layouts.app')
@section('title', 'Import Products')
@section('content')
<h1>Import Products (Excel)</h1>
<p>Upload an Excel file with columns: name, series, brand, price, sku, stock_quantity (required). Optional: cost_price, description, character, category, type, image_url (public HTTP link; Google Drive share links supported).</p>
<form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
    <button type="submit" class="btn btn-primary">Import</button>
</form>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
@endsection
