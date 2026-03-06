@extends('layouts.app')
@section('title', 'Admin - Suppliers')
@section('content')
<h1>Suppliers</h1>
<p><a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">Add Supplier</a></p>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem;">ID</th>
            <th style="padding: 0.5rem;">Brand</th>
            <th style="padding: 0.5rem;">Contact</th>
            <th style="padding: 0.5rem;">Email</th>
            <th style="padding: 0.5rem;">Phone</th>
            <th style="padding: 0.5rem;">POs</th>
            <th style="padding: 0.5rem;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($suppliers as $s)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $s->id }}</td>
                <td style="padding: 0.5rem;">{{ $s->brand }}</td>
                <td style="padding: 0.5rem;">{{ $s->contact_person }}</td>
                <td style="padding: 0.5rem;">{{ $s->email }}</td>
                <td style="padding: 0.5rem;">{{ $s->phone }}</td>
                <td style="padding: 0.5rem;">{{ $s->purchase_orders_count ?? 0 }}</td>
                <td style="padding: 0.5rem;"><a href="{{ route('admin.suppliers.edit', $s) }}" class="btn btn-secondary btn-sm">Edit</a> <a href="{{ route('admin.suppliers.show', $s) }}" class="btn btn-secondary btn-sm">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $suppliers->links() }}
@endsection
