<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Order Receipt</title></head>
<body style="font-family: Arial, sans-serif;">
<div style="max-width: 600px; margin: 0 auto;">
<h1 style="color: #8B4513;">The Pop Stop - Order Receipt</h1>
<p>Thank you for your order!</p>
<p><strong>Order #{{ $order->id }}</strong></p>
<p>Date: {{ $order->created_at->format('M d, Y H:i') }}</p>
<p>Status: {{ $order->status }}</p>
<p>Subtotal: P{{ number_format($order->subtotal, 2) }}</p>
<p>Discount: -P{{ number_format($order->discount_amount, 2) }}</p>
<p><strong>Total: P{{ number_format($order->final_amount, 2) }}</strong></p>
<p>A PDF receipt is attached to this email.</p>
<p>Thank you for shopping with The Pop Stop!</p>
</div>
</body>
</html>
