@extends('layouts.app')

@section('title', 'Register - The Pop Stop')

@push('styles')
<style>
    .register-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 3rem 1rem;
    }
    .register-card {
        background: white;
        width: 100%;
        max-width: 620px;
        padding: 2.75rem 3rem;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.07);
    }
    .register-card-header {
        text-align: center;
        margin-bottom: 2.25rem;
    }
    .register-card-header h1 {
        color: var(--primary);
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: .4rem;
    }
    .register-card-header p {
        color: #999;
        font-size: .9rem;
    }
    .form-section-label {
        font-size: .7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #bbb;
        margin: 1.75rem 0 1rem 0;
        display: flex;
        align-items: center;
        gap: .6rem;
    }
    .form-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #f0ede6;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .form-group {
        margin-bottom: 1.1rem;
    }
    .form-group label {
        display: block;
        font-size: .8rem;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: .4rem;
    }
    .reg-input,
    .reg-textarea {
        width: 100%;
        padding: .8rem 1rem;
        border: 2px solid #ece9e1;
        border-radius: 10px;
        font-size: .93rem;
        color: #333;
        background: #fff;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        font-family: inherit;
        box-sizing: border-box;
    }
    .reg-input:focus,
    .reg-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(139,0,0,.09);
    }
    .reg-textarea {
        resize: vertical;
        min-height: 70px;
        line-height: 1.5;
    }
    .error-message {
        color: #c0392b;
        font-size: .78rem;
        margin-top: .25rem;
        display: flex;
        align-items: center;
        gap: .3rem;
    }
    .file-input-wrapper {
        position: relative;
    }
    .file-input-label {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .8rem 1rem;
        border: 2px dashed #ddd;
        border-radius: 10px;
        cursor: pointer;
        color: #999;
        font-size: .88rem;
        transition: border-color .2s, color .2s;
    }
    .file-input-label:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    .file-input-label svg { flex-shrink: 0; }
    input[type="file"].hidden-file-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .btn-register {
        width: 100%;
        padding: 1rem;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        margin-top: 1.5rem;
        transition: background .2s, transform .1s;
        letter-spacing: .2px;
        font-family: inherit;
    }
    .btn-register:hover {
        background: var(--accent);
        transform: translateY(-1px);
    }
    .btn-register:active { transform: translateY(0); }
    .login-link {
        text-align: center;
        margin-top: 1.5rem;
        color: #999;
        font-size: .9rem;
    }
    .login-link a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
    }
    .login-link a:hover { text-decoration: underline; }

    @media (max-width: 560px) {
        .register-card { padding: 2rem 1.5rem; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="register-wrapper">
    <div class="register-card">

        <div class="register-card-header">
            <h1>Create Account</h1>
            <p>Join The Pop Stop and start your collection</p>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            {{-- Account Info --}}
            <div class="form-section-label">Account Info</div>

            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username <span style="color:var(--primary);">*</span></label>
                    <input type="text" name="username" id="username" class="reg-input" value="{{ old('username') }}" required autocomplete="username">
                    @error('username')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">Display Name <span style="color:var(--primary);">*</span></label>
                    <input type="text" name="name" id="name" class="reg-input" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address <span style="color:var(--primary);">*</span></label>
                <input type="email" name="email" id="email" class="reg-input" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password <span style="color:var(--primary);">*</span></label>
                    <input type="password" name="password" id="password" class="reg-input" required autocomplete="new-password">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password <span style="color:var(--primary);">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="reg-input" required autocomplete="new-password">
                </div>
            </div>

            {{-- Personal Info --}}
            <div class="form-section-label">Personal Info</div>

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" class="reg-input" value="{{ old('full_name') }}">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" class="reg-input" value="{{ old('phone') }}" placeholder="e.g. 0912-345-6789">
            </div>

            <div class="form-group">
                <label for="address">Delivery Address</label>
                <textarea name="address" id="address" class="reg-textarea" rows="2" placeholder="Street, City, Province, ZIP">{{ old('address') }}</textarea>
            </div>

            {{-- Profile Photo --}}
            <div class="form-section-label">Profile Photo</div>

            <div class="form-group">
                <div class="file-input-wrapper">
                    <label class="file-input-label" for="profile_photo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span id="file-label-text">Click to upload a profile photo (optional)</span>
                    </label>
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden-file-input"
                        onchange="document.getElementById('file-label-text').textContent = this.files[0] ? this.files[0].name : 'Click to upload a profile photo (optional)'">
                </div>
            </div>

            <button type="submit" class="btn-register">Create Account</button>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign in here</a>
            </div>

        </form>
    </div>
</div>
@endsection
