@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<h1 style="color: var(--dark-brown);">Admin Dashboard</h1>
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin: 2rem 0;">
    <div style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #eee;">
        <h3>Products</h3>
        <p style="font-size: 2rem; font-weight: bold;">{{ $totalProducts }}</p>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">Manage</a>
    </div>
    <div style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #eee;">
        <h3>Users</h3>
        <p style="font-size: 2rem; font-weight: bold;">{{ $totalUsers }}</p>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Manage</a>
    </div>
    <div style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #eee;">
        <h3>Orders</h3>
        <p style="font-size: 2rem; font-weight: bold;">{{ $totalOrders }}</p>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Manage</a>
    </div>
    <div style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #eee;">
        <h3>Revenue</h3>
        <p style="font-size: 2rem; font-weight: bold;">P{{ number_format($revenue, 2) }}</p>
    </div>
</div>
<h2>Recent Orders</h2>
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
        @foreach($recentOrders as $order)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $order->id }}</td>
                <td style="padding: 0.5rem;">{{ $order->user->full_name ?? $order->user->name }}</td>
                <td style="padding: 0.5rem;">{{ $order->status }}</td>
                <td style="padding: 0.5rem;">{{ $order->created_at->format('M d, Y') }}</td>
                <td style="padding: 0.5rem;"><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<p style="margin-top: 1rem;"><a href="{{ route('admin.products.index') }}">Products</a> | <a href="{{ route('admin.orders.index') }}">Orders</a> | <a href="{{ route('admin.users.index') }}">Users</a> | <a href="{{ route('admin.reports.index') }}">Reports</a> | <a href="{{ route('admin.reviews.index') }}">Reviews</a></p>
@endsection
