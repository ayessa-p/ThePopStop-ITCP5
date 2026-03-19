@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<h1 style="color: var(--dark-brown);">Edit Profile</h1>
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div style="margin-bottom: 1rem;">
        <label>Username *</label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}" required style="width: 100%; padding: 0.5rem;">
        @error('username')<span style="color:red;">{{ $message }}</span>@enderror
    </div>
    <div style="margin-bottom: 1rem;">
        <label>Name *</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 0.5rem;">
    </div>
    <div style="margin-bottom: 1rem;">
        <label>Email *</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 0.5rem;">
        @error('email')<span style="color:red;">{{ $message }}</span>@enderror
    </div>
    <div style="margin-bottom: 1rem;">
        <label>Full Name</label>
        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" style="width: 100%; padding: 0.5rem;">
    </div>
    <div style="margin-bottom: 1rem;">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 0.5rem;">
    </div>
    <div style="margin-bottom: 1rem;">
        <label>Address</label>
        <textarea name="address" rows="2" style="width: 100%; padding: 0.5rem;">{{ old('address', $user->address) }}</textarea>
    </div>
    <div style="margin-bottom: 1rem;">
        <label>Profile Photo</label>
        <input type="file" name="profile_photo" accept="image/*">
    </div>
    <div style="margin-bottom: 1rem;">
        <label>New Password (leave blank to keep)</label>
        <input type="password" name="password" style="width: 100%; padding: 0.5rem;">
        <input type="password" name="password_confirmation" placeholder="Confirm" style="width: 100%; padding: 0.5rem; margin-top: 0.25rem;">
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
@endsection
