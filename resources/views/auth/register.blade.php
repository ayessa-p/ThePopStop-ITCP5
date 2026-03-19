@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div style="max-width: 500px; margin: 2rem auto;">
    <h2>Register</h2>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 1rem;">
            <label for="username">Username *</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required style="width:100%; padding: 0.5rem;">
            @error('username')<span style="color:red;">{{ $message }}</span>@enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="name">Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required style="width:100%; padding: 0.5rem;">
            @error('name')<span style="color:red;">{{ $message }}</span>@enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width:100%; padding: 0.5rem;">
            @error('email')<span style="color:red;">{{ $message }}</span>@enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password">Password *</label>
            <input type="password" name="password" id="password" required style="width:100%; padding: 0.5rem;">
            @error('password')<span style="color:red;">{{ $message }}</span>@enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password_confirmation">Confirm Password *</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required style="width:100%; padding: 0.5rem;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="full_name">Full Name</label>
            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" style="width:100%; padding: 0.5rem;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" style="width:100%; padding: 0.5rem;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="address">Address</label>
            <textarea name="address" id="address" rows="2" style="width:100%; padding: 0.5rem;">{{ old('address') }}</textarea>
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="profile_photo">Profile Photo</label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
    </form>
</div>
@endsection
