@extends('layouts.app')
@section('title', 'Create PO')
@section('content')
<h1>Create Purchase Order</h1>
<form method="POST" action="{{ route('admin.purchase-orders.store') }}">
    @csrf
    <p><label>Supplier *</label><select name="supplier_id" required>@foreach($suppliers as $s)<option value="{{ $s->id }}">{{ $s->brand }}</option>@endforeach</select></p>
    <p><label>Order Date *</label><input type="date" name="order_date" value="{{ date('Y-m-d') }}" required></p>
    <p><label>Notes</label><textarea name="notes" rows="2">{{ old('notes') }}</textarea></p>
    <h3>Items</h3>
    <p>Product: <select name="product_ids[]">@foreach($products as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select> Qty: <input type="number" name="quantities[]" min="1" value="1"> Unit cost: <input type="number" name="unit_costs[]" step="0.01" min="0" value="0"></p>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="{{ route('admin.purchase-orders.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
