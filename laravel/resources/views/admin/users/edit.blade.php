@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<h1>Edit User</h1>
<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')
    <div style="margin-bottom: 1rem;"><label>Username *</label><input type="text" name="username" value="{{ old('username', $user->username) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Email *</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Password (leave blank to keep)</label><input type="password" name="password" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Confirm Password</label><input type="password" name="password_confirmation" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Full Name *</label><input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Phone</label><input type="text" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 0.5rem;"></div>
    <div style="margin-bottom: 1rem;"><label>Address</label><textarea name="address" rows="2" style="width: 100%; padding: 0.5rem;">{{ old('address', $user->address) }}</textarea></div>
    <div style="margin-bottom: 1rem;"><label>Role *</label><select name="role" required><option value="customer" {{ $user->role=='customer'?'selected':'' }}>Customer</option><option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option></select></div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
