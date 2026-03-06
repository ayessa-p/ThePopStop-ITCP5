@extends('layouts.app')
@section('title', 'Admin - Orders')
@section('content')
<h1>Manage Orders</h1>
<form method="GET" style="margin-bottom: 1rem;">
    <select name="status"><option value="">All</option><option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option><option value="Processing" {{ request('status')=='Processing'?'selected':'' }}>Processing</option><option value="Shipped" {{ request('status')=='Shipped'?'selected':'' }}>Shipped</option><option value="Delivered" {{ request('status')=='Delivered'?'selected':'' }}>Delivered</option><option value="Cancelled" {{ request('status')=='Cancelled'?'selected':'' }}>Cancelled</option></select>
    <button type="submit" class="btn btn-secondary">Filter</button>
</form>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem;">ID</th>
            <th style="padding: 0.5rem;">Customer</th>
            <th style="padding: 0.5rem;">Status</th>
            <th style="padding: 0.5rem;">Date</th>
            <th style="padding: 0.5rem;"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $o)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $o->id }}</td>
                <td style="padding: 0.5rem;">{{ $o->user->full_name ?? $o->user->name }}</td>
                <td style="padding: 0.5rem;">{{ $o->status }}</td>
                <td style="padding: 0.5rem;">{{ $o->created_at->format('M d, Y') }}</td>
                <td style="padding: 0.5rem;"><a href="{{ route('admin.orders.show', $o) }}" class="btn btn-secondary btn-sm">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->withQueryString()->links() }}
@endsection
