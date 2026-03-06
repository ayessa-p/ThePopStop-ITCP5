@extends('layouts.app')
@section('title', 'Add Supplier')
@section('content')
<h1>Add Supplier</h1>
<form method="POST" action="{{ route('admin.suppliers.store') }}">
    @csrf
    <div style="margin-bottom: 1rem;"><label>Brand *</label><input type="text" name="brand" value="{{ old('brand') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Contact Person</label><input type="text" name="contact_person" value="{{ old('contact_person') }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Phone</label><input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Address</label><textarea name="address" rows="2" style="width: 100%; padding: 0.5rem;">{{ old('address') }}</textarea></div>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
