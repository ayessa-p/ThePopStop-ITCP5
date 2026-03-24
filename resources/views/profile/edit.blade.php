@extends('layouts.app')
@section('title', 'Edit Profile')

@push('styles')
<style>
    .profile-page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin-bottom: .25rem;
    }
    .profile-page-subtitle {
        color: #999;
        font-size: .9rem;
        margin-bottom: 2rem;
    }
    .profile-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
        align-items: start;
    }
    .pro-card-avatar {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.05);
        padding: 2.5rem 1.5rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: sticky;
        top: 100px;
    }
    .pro-avatar-circle {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 1.25rem;
        border: 5px solid #F3F1EA;
        box-shadow: 0 4px 15px rgba(0,0,0,.1);
        background: var(--light-beige);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .pro-avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .pro-avatar-name {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin: 0 0 .25rem 0;
    }
    .pro-avatar-email {
        font-size: .85rem;
        color: #999;
        margin-bottom: 1.75rem;
        word-break: break-all;
    }
    .pro-avatar-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .7rem 1.25rem;
        background: #F3F1EA;
        border: 1px solid #E8E4DC;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 700;
        color: #666;
        cursor: pointer;
        transition: all .2s;
        width: 100%;
    }
    .pro-avatar-btn:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        transform: translateY(-1px);
    }
    #profile_photo { display: none; }

    /* Main cards */
    .pro-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 1.75rem;
        margin-bottom: 1.25rem;
    }
    .pro-card:last-child { margin-bottom: 0; }
    .pro-card-title {
        display: flex;
        align-items: center;
        gap: .6rem;
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin: 0 0 1.4rem 0;
        padding-bottom: .9rem;
        border-bottom: 1.5px solid #f0ede6;
    }
    .pro-card-title svg { color: var(--primary); flex-shrink: 0; }
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem 1.25rem;
    }
    .pro-field { margin-bottom: 1.1rem; }
    .pro-field:last-child { margin-bottom: 0; }
    .pro-label {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: .4rem;
    }
    .pro-input,
    .pro-textarea {
        width: 100%;
        padding: .72rem 1rem;
        border: 2px solid #e8e4dc;
        border-radius: 10px;
        font-size: .93rem;
        color: #333;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        font-family: inherit;
    }
    .pro-input:focus,
    .pro-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(139,0,0,.09);
    }
    .pro-textarea {
        resize: vertical;
        min-height: 80px;
        line-height: 1.55;
    }
    .pro-hint {
        font-size: .75rem;
        color: #bbb;
        margin-top: .3rem;
    }
    .pro-error {
        color: #c0392b;
        font-size: .8rem;
        margin-top: .3rem;
    }
    .pro-password-wrap {
        position: relative;
    }
    .pro-password-wrap .pro-input {
        padding-right: 2.75rem;
    }
    .toggle-pw {
        position: absolute;
        right: .85rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #aaa;
        padding: 0;
        display: flex;
        align-items: center;
        transition: color .2s;
    }
    .toggle-pw:hover { color: var(--primary); }

    .btn-save-profile {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .8rem 2rem;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: .95rem;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .1s;
        font-family: inherit;
        letter-spacing: .2px;
    }
    .btn-save-profile:hover {
        background: var(--accent);
        transform: translateY(-1px);
    }
    .btn-save-profile:active { transform: translateY(0); }

    @media (max-width: 820px) {
        .profile-layout { grid-template-columns: 1fr; }
        .profile-sidebar-card { position: static; }
        .form-grid-2 { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<h1 class="profile-page-title">Edit Profile</h1>
<p class="profile-page-subtitle">Manage your account information and preferences</p>

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="profile-layout">

        {{-- ===== LEFT: Avatar card ===== --}}
        <div class="pro-card pro-card-avatar">
            <div class="pro-avatar-circle">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}" id="avatar-preview">
            </div>
            <h2 class="pro-avatar-name">{{ $user->username }}</h2>
            <div class="pro-avatar-email">{{ $user->email }}</div>
            
            <label for="profile_photo" class="pro-avatar-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Change Photo
            </label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/*" style="display:none;" onchange="previewImage(this)">
        </div>

        {{-- ===== RIGHT: Form cards ===== --}}
        <div>

            {{-- Account Info --}}
            <div class="pro-card">
                <h2 class="pro-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Account Information
                </h2>
                <div class="form-grid-2">
                    <div class="pro-field" style="grid-column: 1 / -1;">
                        <label class="pro-label" for="username">Username <span style="color:var(--primary);">*</span></label>
                        <input type="text" name="username" id="username" class="pro-input" value="{{ old('username', $user->username) }}" required>
                        @error('username')<div class="pro-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="pro-field" style="grid-column: 1 / -1;">
                        <label class="pro-label" for="email">Email Address <span style="color:var(--primary);">*</span></label>
                        <input type="email" name="email" id="email" class="pro-input" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="pro-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Personal Details --}}
            <div class="pro-card">
                <h2 class="pro-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                    </svg>
                    Personal Details
                </h2>
                <div class="form-grid-2">
                    <div class="pro-field">
                        <label class="pro-label" for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="pro-input" value="{{ old('full_name', $user->full_name) }}" placeholder="e.g. Juan dela Cruz">
                    </div>
                    <div class="pro-field">
                        <label class="pro-label" for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="pro-input" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 09XX-XXX-XXXX">
                    </div>
                    <div class="pro-field" style="grid-column: 1 / -1;">
                        <label class="pro-label" for="address">Delivery Address</label>
                        <textarea name="address" id="address" class="pro-textarea" rows="2" placeholder="Street, Barangay, City, Province, ZIP">{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="pro-card">
                <h2 class="pro-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Change Password
                </h2>
                <div class="form-grid-2">
                    <div class="pro-field">
                        <label class="pro-label" for="password">New Password</label>
                        <div class="pro-password-wrap">
                            <input type="password" name="password" id="password" class="pro-input" placeholder="Enter new password">
                            <button type="button" class="toggle-pw" onclick="togglePw('password', this)" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="pro-hint">Leave blank to keep your current password.</div>
                        @error('password')<div class="pro-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="pro-field">
                        <label class="pro-label" for="password_confirmation">Confirm New Password</label>
                        <div class="pro-password-wrap">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="pro-input" placeholder="Re-enter new password">
                            <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation', this)" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Save Button --}}
            <div style="display:flex; align-items:center; justify-content:flex-end; gap:1rem; margin-top:.5rem;">
                <button type="submit" class="btn-save-profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>

        </div>
    </div>
</form>

@push('scripts')
<script>
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('svg');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

@endsection
