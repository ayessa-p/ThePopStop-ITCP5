@extends('layouts.app')
@section('title', $supplier->brand)
@section('content')
<h1>{{ $supplier->brand }}</h1>
<p>Contact: {{ $supplier->contact_person }} | Email: {{ $supplier->email }} | Phone: {{ $supplier->phone }}</p>
<p>Address: {{ $supplier->address }}</p>
<h2>Purchase Orders</h2>
@foreach($supplier->purchaseOrders as $po)
    <p><a href="{{ route('admin.purchase-orders.show', $po) }}">PO #{{ $po->id }}</a> - {{ $po->order_date->format('Y-m-d') }} - {{ $po->status }}</p>
@endforeach
<a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">Back</a>
@endsection
