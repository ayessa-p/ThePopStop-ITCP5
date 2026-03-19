@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<h1 style="color: var(--dark-brown);">My Orders</h1>
@forelse($orders as $order)
    <div style="border: 1px solid #eee; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">
        <p><strong>Order #{{ $order->id }}</strong> - {{ $order->created_at->format('M d, Y H:i') }} - {{ $order->status }}</p>
        <p>Total: P{{ number_format($order->final_amount, 2) }}</p>
        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary btn-sm">View</a>
        <a href="{{ route('orders.receipt', $order) }}" class="btn btn-primary btn-sm">Receipt</a>
    </div>
@empty
    <p>You have no orders yet.</p>
@endforelse
{{ $orders->links() }}
@endsection
