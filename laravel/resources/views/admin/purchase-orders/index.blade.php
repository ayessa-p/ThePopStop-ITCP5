@extends('layouts.app')
@section('title', 'Purchase Orders')
@section('content')
<h1>Purchase Orders</h1>
<p><a href="{{ route('admin.purchase-orders.create') }}" class="btn btn-primary">Create PO</a></p>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem;">ID</th>
            <th style="padding: 0.5rem;">Supplier</th>
            <th style="padding: 0.5rem;">Date</th>
            <th style="padding: 0.5rem;">Status</th>
            <th style="padding: 0.5rem;">Total</th>
            <th style="padding: 0.5rem;"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseOrders as $po)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $po->id }}</td>
                <td style="padding: 0.5rem;">{{ $po->supplier->brand ?? '-' }}</td>
                <td style="padding: 0.5rem;">{{ $po->order_date->format('Y-m-d') }}</td>
                <td style="padding: 0.5rem;">{{ $po->status }}</td>
                <td style="padding: 0.5rem;">P{{ number_format($po->total_cost, 2) }}</td>
                <td style="padding: 0.5rem;"><a href="{{ route('admin.purchase-orders.show', $po) }}" class="btn btn-secondary btn-sm">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $purchaseOrders->links() }}
@endsection
