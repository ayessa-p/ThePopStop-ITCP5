@extends('layouts.app')

@section('title', 'Login - The Pop Stop')

@push('styles')
<style>
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 4rem 1rem;
    }
    .login-card {
        background: white;
        width: 100%;
        max-width: 500px;
        padding: 3.5rem;
        border-radius: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        text-align: center;
    }
    .login-card h1 {
        color: var(--primary); /* Maroon */
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 2.5rem;
    }
    .form-group {
        text-align: left;
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        color: var(--dark-brown); /* Dark brown/black */
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }
    .login-input {
        width: 100%;
        padding: 1rem 1.25rem;
        background: #fff;
        border: 2px solid #eee;
        border-radius: 12px;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .login-input:focus {
        border-color: var(--primary);
    }
    .btn-login {
        width: 100%;
        padding: 1.1rem;
        background: var(--primary); /* Maroon */
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
        transition: background 0.2s;
    }
    .btn-login:hover {
        background: var(--accent);
    }
    .register-link {
        margin-top: 2rem;
        color: var(--dark-brown);
        font-size: 1rem;
    }
    .register-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }
    .register-link a:hover {
        text-decoration: underline;
    }
    .error-message {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <h1>Login</h1>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" name="email" id="email" class="login-input" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" name="password" id="password" class="login-input" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">Login</button>

            <div class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </div>
        </form>
    </div>
</div>
@endsection
