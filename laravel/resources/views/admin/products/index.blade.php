@extends('layouts.app')
@section('title', 'Admin - Products')
@section('content')
<h1>Manage Products</h1>
<p><a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a> <a href="{{ route('admin.products.import-form') }}" class="btn btn-secondary">Import Excel</a></p>
<div class="datatable-container">
<table id="products-table" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>SKU</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script>
$(function() {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.products.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'sku', name: 'sku' },
            { data: 'brand', name: 'brand' },
            { data: 'price', name: 'price' },
            { data: 'stock_quantity', name: 'stock_quantity' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
@endsection
