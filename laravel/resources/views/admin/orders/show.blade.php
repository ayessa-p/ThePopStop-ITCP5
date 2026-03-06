@extends('layouts.app')
@section('title', 'Order #' . $order->id)
@section('content')
<h1>Order #{{ $order->id }}</h1>
<p>Customer: {{ $order->user->full_name ?? $order->user->name }} ({{ $order->user->email }})</p>
<p>Status: {{ $order->status }} | Date: {{ $order->created_at->format('M d, Y H:i') }}</p>
<p>Shipping: {{ $order->shipping_address }}</p>
<form method="POST" action="{{ route('admin.orders.status', $order) }}" style="margin-bottom: 1rem;">
    @csrf
    @method('PUT')
    <label>Update Status:</label>
    <select name="status">
        @foreach(['Pending','Processing','Shipped','Delivered','Cancelled'] as $s)
            <option value="{{ $s }}" {{ $order->status==$s ? 'selected' : '' }}>{{ $s }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem;">Product</th>
            <th style="padding: 0.5rem;">Qty</th>
            <th style="padding: 0.5rem;">Price</th>
            <th style="padding: 0.5rem;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems as $item)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $item->product->name }}</td>
                <td style="padding: 0.5rem;">{{ $item->quantity }}</td>
                <td style="padding: 0.5rem;">P{{ number_format($item->unit_price, 2) }}</td>
                <td style="padding: 0.5rem;">P{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr><td colspan="3" style="padding: 0.5rem; text-align: right;">Subtotal</td><td>P{{ number_format($order->subtotal, 2) }}</td></tr>
        <tr><td colspan="3" style="padding: 0.5rem; text-align: right;">Discount</td><td>-P{{ number_format($order->discount_amount, 2) }}</td></tr>
        <tr style="font-weight: bold;"><td colspan="3" style="padding: 0.5rem; text-align: right;">Total</td><td>P{{ number_format($order->final_amount, 2) }}</td></tr>
    </tfoot>
</table>
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
@endsection
