@extends('layouts.app')
@section('title', 'Discounts')
@section('content')
<h1>Discounts</h1>
<p><a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">Add Discount</a></p>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--primary); color: white;">
            <th style="padding: 0.5rem;">Code</th>
            <th style="padding: 0.5rem;">Type</th>
            <th style="padding: 0.5rem;">Value</th>
            <th style="padding: 0.5rem;">Min</th>
            <th style="padding: 0.5rem;">Active</th>
            <th style="padding: 0.5rem;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($discounts as $d)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 0.5rem;">{{ $d->code }}</td>
                <td style="padding: 0.5rem;">{{ $d->discount_type }}</td>
                <td style="padding: 0.5rem;">{{ $d->discount_value }}</td>
                <td style="padding: 0.5rem;">{{ $d->min_purchase }}</td>
                <td style="padding: 0.5rem;">{{ $d->is_active ? 'Yes' : 'No' }}</td>
                <td style="padding: 0.5rem;"><a href="{{ route('admin.discounts.edit', $d) }}" class="btn btn-secondary btn-sm">Edit</a> <form action="{{ route('admin.discounts.destroy', $d) }}" method="POST" style="display:inline;">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Delete</button></form></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $discounts->links() }}
@endsection
