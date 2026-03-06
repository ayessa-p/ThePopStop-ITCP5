@extends('layouts.app')
@section('title', 'PO #' . $purchaseOrder->id)
@section('content')
<h1>Purchase Order #{{ $purchaseOrder->id }}</h1>
<p>Supplier: {{ $purchaseOrder->supplier->brand }} | Date: {{ $purchaseOrder->order_date->format('Y-m-d') }} | Status: {{ $purchaseOrder->status }}</p>
<p>Notes: {{ $purchaseOrder->notes }}</p>
<form method="POST" action="{{ route('admin.purchase-orders.update-status', $purchaseOrder) }}" style="margin-bottom: 1rem;">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" value="Received">
    <button type="submit" class="btn btn-primary">Mark as Received (update stock)</button>
</form>
<form method="POST" action="{{ route('admin.purchase-orders.update-status', $purchaseOrder) }}" style="margin-bottom: 1rem;">
    @csrf
    @method('PUT')
    <select name="status">@foreach(['Ordered','Shipped','Received'] as $s)<option value="{{ $s }}" {{ $purchaseOrder->status==$s ? 'selected':'' }}>{{ $s }}</option>@endforeach</select>
    <button type="submit" class="btn btn-secondary">Update Status</button>
</form>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem;">Product</th>
            <th style="padding: 0.5rem;">Qty</th>
            <th style="padding: 0.5rem;">Unit Cost</th>
            <th style="padding: 0.5rem;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseOrder->purchaseOrderItems as $item)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $item->product->name }}</td>
                <td style="padding: 0.5rem;">{{ $item->quantity }}</td>
                <td style="padding: 0.5rem;">P{{ number_format($item->unit_cost, 2) }}</td>
                <td style="padding: 0.5rem;">P{{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="font-weight: bold;"><td colspan="3" style="padding: 0.5rem; text-align: right;">Total</td><td style="padding: 0.5rem;">P{{ number_format($purchaseOrder->total_cost, 2) }}</td></tr>
    </tfoot>
</table>
<a href="{{ route('admin.purchase-orders.index') }}" class="btn btn-secondary">Back</a>
@endsection
