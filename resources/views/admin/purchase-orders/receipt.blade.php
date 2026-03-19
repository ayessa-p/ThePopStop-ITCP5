<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Purchase Order Receipt</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background-color: #8B0000; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 1px;">The Pop Stop</h1>
        </div>

        <!-- Content -->
        <div style="padding: 30px; color: #333333;">
            <h2 style="color: #8B0000; margin-top: 0;">Purchase Order Receipt</h2>
            <p style="margin-bottom: 5px;">Purchase Order <strong>#{{ $purchaseOrder->id }}</strong> from <strong>{{ $purchaseOrder->supplier->brand ?? '-' }}</strong></p>

            <!-- Status Box -->
            <div style="background-color: #F3F1EA; padding: 15px; border-radius: 4px; margin: 20px 0; border-left: 4px solid #8B0000;">
                <span style="font-weight: bold; color: #8B0000;">Status: {{ $purchaseOrder->status }}</span>
            </div>

            <!-- Order Table -->
            <h3 style="color: #8B0000; border-bottom: 2px solid #F3F1EA; padding-bottom: 10px;">Order Details</h3>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="background-color: #8B0000; color: #ffffff;">
                        <th style="padding: 10px; text-align: left; font-size: 14px;">Product</th>
                        <th style="padding: 10px; text-align: center; font-size: 14px;">Qty</th>
                        <th style="padding: 10px; text-align: right; font-size: 14px;">Price</th>
                        <th style="padding: 10px; text-align: right; font-size: 14px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchaseOrder->purchaseOrderItems as $item)
                    <tr style="border-bottom: 1px solid #F3F1EA;">
                        <td style="padding: 10px; font-size: 14px;">
                            <div style="font-weight: bold;">{{ $item->product->name }}</div>
                        </td>
                        <td style="padding: 10px; text-align: center; font-size: 14px;">{{ $item->quantity }}</td>
                        <td style="padding: 10px; text-align: right; font-size: 14px;">P{{ number_format($item->unit_cost, 2) }}</td>
                        <td style="padding: 10px; text-align: right; font-size: 14px;">P{{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="padding: 10px 10px 10px; text-align: right; font-weight: bold; font-size: 16px; color: #8B0000;">Total Cost:</td>
                        <td style="padding: 10px 10px 10px; text-align: right; font-weight: bold; font-size: 16px; color: #8B0000;">P{{ number_format($purchaseOrder->total_cost, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div style="background-color: #1F1B1B; padding: 15px; text-align: center;">
            <p style="color: #ffffff; margin: 0; font-size: 12px;">&copy; {{ date('Y') }} The Pop Stop. All rights reserved.</p>
        </div>
    </div>
</body>
</html>