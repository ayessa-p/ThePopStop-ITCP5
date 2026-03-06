<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Order Status Update</title></head>
<body style="font-family: Arial, sans-serif;">
<div style="max-width: 600px; margin: 0 auto;">
<h1 style="color: #8B4513;">The Pop Stop - Order Status Update</h1>
<p>Dear {{ $order->user->full_name ?? $order->user->name }},</p>
<p>Your order <strong>#{{ $order->id }}</strong> status has been updated to: <strong>{{ $order->status }}</strong></p>
<p>Date: {{ $order->created_at->format('M d, Y H:i') }}</p>
<p>Total: P{{ number_format($order->final_amount, 2) }}</p>
<p>Thank you for shopping with The Pop Stop!</p>
</div>
</body>
</html>
