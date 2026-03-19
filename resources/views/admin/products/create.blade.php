@extends('layouts.app')
@section('title', 'Add Product')
@section('content')
<h1>Add Product</h1>
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="margin-bottom: 1rem;"><label>Name *</label><input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Series *</label><input type="text" name="series" value="{{ old('series') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Brand *</label><input type="text" name="brand" value="{{ old('brand') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Price *</label><input type="number" name="price" step="0.01" value="{{ old('price') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Cost Price</label><input type="number" name="cost_price" step="0.01" value="{{ old('cost_price') }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>SKU *</label><input type="text" name="sku" value="{{ old('sku') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Description</label><textarea name="description" rows="3" style="width: 100%; padding: 0.5rem;">{{ old('description') }}</textarea></div>
    <div style="margin-bottom: 1rem;"><label>Character</label><input type="text" name="character" value="{{ old('character') }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Stock Quantity *</label><input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Category</label><input type="text" name="category" value="{{ old('category') }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Type</label><input type="text" name="type" value="{{ old('type') }}" placeholder="Blind Box, Limited Edition, Open Box" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Image</label><input type="file" name="image" accept="image/*"></div>
    <button type="submit" class="btn btn-primary">Create Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
