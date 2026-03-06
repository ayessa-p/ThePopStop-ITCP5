@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div style="max-width: 400px; margin: 2rem auto;">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div style="margin-bottom: 1rem;">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus style="width:100%; padding: 0.5rem;">
            @error('email')<span style="color:red; font-size:0.9rem;">{{ $message }}</span>@enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required style="width:100%; padding: 0.5rem;">
            @error('password')<span style="color:red;">{{ $message }}</span>@enderror
        </div>
        <div style="margin-bottom: 1rem;">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
    </form>
</div>
@endsection
