@extends('layouts.app')
@section('title', 'Product Reviews')
@section('content')
<h1>Product Reviews (DataTable)</h1>
<div class="datatable-container">
<table id="reviews-table" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Product</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Date</th>
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
    $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.reviews.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_name', name: 'user.full_name' },
            { data: 'product_name', name: 'product.name' },
            { data: 'rating', name: 'rating' },
            { data: 'review_text', name: 'review_text' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
@endsection
