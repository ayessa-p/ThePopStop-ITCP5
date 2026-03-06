@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
<h1>Edit Product</h1>
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div style="margin-bottom: 1rem;"><label>Name *</label><input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Series *</label><input type="text" name="series" value="{{ old('series', $product->series) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Brand *</label><input type="text" name="brand" value="{{ old('brand', $product->brand) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Price *</label><input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Cost Price</label><input type="number" name="cost_price" step="0.01" value="{{ old('cost_price', $product->cost_price) }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>SKU *</label><input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Description</label><textarea name="description" rows="3" style="width: 100%; padding: 0.5rem;">{{ old('description', $product->description) }}</textarea></div>
    <div style="margin-bottom: 1rem;"><label>Character</label><input type="text" name="character" value="{{ old('character', $product->character) }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Stock Quantity *</label><input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Category</label><input type="text" name="category" value="{{ old('category', $product->category) }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Type</label><input type="text" name="type" value="{{ old('type', $product->type) }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Image (leave empty to keep)</label><input type="file" name="image" accept="image/*"></div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
