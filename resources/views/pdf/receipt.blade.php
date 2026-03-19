<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Receipt #{{ $order->id }}</title></head>
<body style="font-family: Arial, sans-serif;">
<h1>The Pop Stop - Receipt</h1>
<p>Order #{{ $order->id }} | {{ $order->created_at->format('M d, Y H:i') }}</p>
<p>Customer: {{ $order->user->full_name ?? $order->user->name }} ({{ $order->user->email }})</p>
<p>Shipping: {{ $order->shipping_address }}</p>
<table style="width: 100%; border-collapse: collapse;">
<thead><tr style="background: #8B4513; color: white;"><th style="padding: 0.5rem;">Product</th><th style="padding: 0.5rem;">Qty</th><th style="padding: 0.5rem;">Price</th><th style="padding: 0.5rem;">Subtotal</th></tr></thead>
<tbody>
@foreach($order->orderItems as $item)
<tr style="border-bottom: 1px solid #ddd;"><td style="padding: 0.5rem;">{{ $item->product->name }}</td><td style="padding: 0.5rem;">{{ $item->quantity }}</td><td style="padding: 0.5rem;">P{{ number_format($item->unit_price, 2) }}</td><td style="padding: 0.5rem;">P{{ number_format($item->quantity * $item->unit_price, 2) }}</td></tr>
@endforeach
</tbody>
<tfoot>
<tr><td colspan="3" style="padding: 0.5rem; text-align: right;">Subtotal</td><td>P{{ number_format($order->subtotal, 2) }}</td></tr>
<tr><td colspan="3" style="padding: 0.5rem; text-align: right;">Discount</td><td>-P{{ number_format($order->discount_amount, 2) }}</td></tr>
<tr style="font-weight: bold;"><td colspan="3" style="padding: 0.5rem; text-align: right;">Total</td><td>P{{ number_format($order->final_amount, 2) }}</td></tr>
</tfoot>
</table>
<p style="margin-top: 2rem;">Thank you for your order!</p>
</body>
</html>
