@extends('layouts.app')
@section('title', 'Order #' . $order->id)
@section('content')
<h1 style="color: var(--dark-brown);">Order #{{ $order->id }}</h1>
<p>Date: {{ $order->created_at->format('M d, Y H:i') }} | Status: {{ $order->status }}</p>
<p>Shipping: {{ $order->shipping_address }}</p>
<p>Payment: {{ $order->payment_method }}</p>
<table style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem; text-align: left;">Product</th>
            <th style="padding: 0.5rem;">Qty</th>
            <th style="padding: 0.5rem; text-align: right;">Price</th>
            <th style="padding: 0.5rem; text-align: right;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems as $item)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $item->product->name }}</td>
                <td style="padding: 0.5rem;">{{ $item->quantity }}</td>
                <td style="padding: 0.5rem; text-align: right;">P{{ number_format($item->unit_price, 2) }}</td>
                <td style="padding: 0.5rem; text-align: right;">P{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr><td colspan="3" style="padding: 0.5rem; text-align: right;">Subtotal</td><td style="text-align: right;">P{{ number_format($order->subtotal, 2) }}</td></tr>
        <tr><td colspan="3" style="padding: 0.5rem; text-align: right;">Discount</td><td style="text-align: right;">-P{{ number_format($order->discount_amount, 2) }}</td></tr>
        <tr style="font-weight: bold;"><td colspan="3" style="padding: 0.5rem; text-align: right;">Total</td><td style="text-align: right;">P{{ number_format($order->final_amount, 2) }}</td></tr>
    </tfoot>
</table>
<a href="{{ route('orders.receipt', $order) }}" class="btn btn-primary">View Receipt</a>
<a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
@endsection
