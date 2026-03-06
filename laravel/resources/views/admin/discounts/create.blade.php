@extends('layouts.app')
@section('title', 'Add Discount')
@section('content')
<h1>Add Discount</h1>
<form method="POST" action="{{ route('admin.discounts.store') }}">
    @csrf
    <p><label>Code *</label><input type="text" name="code" value="{{ old('code') }}" required></p>
    <p><label>Description</label><input type="text" name="description" value="{{ old('description') }}"></p>
    <p><label>Type *</label><select name="discount_type" required><option value="percentage">Percentage</option><option value="fixed">Fixed</option></select></p>
    <p><label>Value *</label><input type="number" name="discount_value" step="0.01" value="{{ old('discount_value') }}" required></p>
    <p><label>Min Purchase *</label><input type="number" name="min_purchase" step="0.01" value="{{ old('min_purchase', 0) }}" required></p>
    <p><label>Start Date</label><input type="date" name="start_date" value="{{ old('start_date') }}"></p>
    <p><label>End Date</label><input type="date" name="end_date" value="{{ old('end_date') }}"></p>
    <p><label><input type="checkbox" name="is_active" value="1" checked> Active</label></p>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
