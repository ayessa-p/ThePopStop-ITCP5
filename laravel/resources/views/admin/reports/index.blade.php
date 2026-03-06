@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<h1>Reports and Analytics</h1>
<form method="GET" style="margin-bottom: 2rem;">
    <label>Start</label><input type="date" name="start_date" value="{{ $start ?? '' }}">
    <label>End</label><input type="date" name="end_date" value="{{ $end ?? '' }}">
    <button type="submit" class="btn btn-primary">Apply</button>
</form>
<p>Total Revenue (period): P{{ number_format($totalRevenue ?? 0, 2) }} | Orders: {{ $orderCount ?? 0 }}</p>
<h2>Sales by Date (Bar)</h2>
@if(isset($barChart))
<div>{!! $barChart->container() !!}</div>
@endif
<h2>Sales by Product (Pie)</h2>
@if(isset($pieChart))
<div>{!! $pieChart->container() !!}</div>
@endif
@push('scripts')
@if(isset($barChart)){!! $barChart->script() !!}@endif
@if(isset($pieChart)){!! $pieChart->script() !!}@endif
@endpush
@endsection
