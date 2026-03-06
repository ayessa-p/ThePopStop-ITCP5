@extends('layouts.app')
@section('title', 'Product Photos')
@section('content')
<h1>Photos for: {{ $product->name }}</h1>
<p><a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a></p>
<form method="POST" action="{{ route('admin.products.photos.store', $product) }}" enctype="multipart/form-data" style="margin-bottom: 2rem;">
    @csrf
    <input type="file" name="photos[]" multiple accept="image/*">
    <button type="submit" class="btn btn-primary">Upload Photos</button>
</form>
<div style="display: flex; flex-wrap: wrap; gap: 1rem;">
    @foreach($product->productPhotos as $photo)
        <div style="border: 1px solid #eee; padding: 0.5rem; border-radius: 8px;">
            <img src="{{ Storage::url($photo->photo_url) }}" alt="" style="width: 150px; height: 150px; object-fit: cover;">
            <p>{{ $photo->is_primary ? 'Primary' : '' }} Order: {{ $photo->display_order }}</p>
            <form action="{{ route('admin.products.photos.primary', [$product, $photo]) }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn btn-secondary btn-sm">Set Primary</button></form>
            <form action="{{ route('admin.products.photos.destroy', [$product, $photo]) }}" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button></form>
        </div>
    @endforeach
</div>
@endsection
