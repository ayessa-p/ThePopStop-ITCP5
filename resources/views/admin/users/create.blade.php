@extends('layouts.app')
@section('title', 'Add User')
@section('content')
<h1>Add User</h1>
<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <div style="margin-bottom: 1rem;"><label>Username *</label><input type="text" name="username" value="{{ old('username') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Email *</label><input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Password *</label><input type="password" name="password" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Confirm Password *</label><input type="password" name="password_confirmation" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Full Name *</label><input type="text" name="full_name" value="{{ old('full_name') }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Phone</label><input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Address</label><textarea name="address" rows="2" style="width: 100%; padding: 0.5rem;">{{ old('address') }}</textarea></div>
    <div style="margin-bottom: 1rem;"><label>Role *</label><select name="role" required><option value="customer">Customer</option><option value="admin">Admin</option></select></div>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
