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
        grid-template-columns: 260px 1fr;
        gap: 1.75rem;
        align-items: start;
    }
    .profile-sidebar-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 2rem 1.5rem;
        text-align: center;
        position: sticky;
        top: 90px;
    }
    .profile-avatar-wrap {
        position: relative;
        width: 96px;
        height: 96px;
        margin: 0 auto 1rem;
    }
    .profile-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0ede6;
        background: var(--light-beige);
    }
    .profile-avatar-placeholder {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--primary));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    .profile-avatar-placeholder svg { color: #fff; }
    .profile-username {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: .25rem;
    }
    .profile-email-text {
        font-size: .8rem;
        color: #aaa;
        margin-bottom: 1.25rem;
        word-break: break-all;
    }
    .profile-photo-upload {
        display: block;
        width: 100%;
        padding: .6rem;
        background: #f5f2eb;
        border: 2px dashed #ddd;
        border-radius: 10px;
        cursor: pointer;
        font-size: .8rem;
        color: #888;
        text-align: center;
        transition: border-color .2s, color .2s;
    }
    .profile-photo-upload:hover {
        border-color: var(--primary);
        color: var(--primary);
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

        {{-- ===== LEFT: Avatar sidebar ===== --}}
        <div class="profile-sidebar-card">
            @if($user->profile_photo_url ?? null)
                <img src="{{ $user->profile_photo_url }}" alt="Profile photo" class="profile-avatar" id="avatar-preview">
            @else
                <div class="profile-avatar-placeholder" id="avatar-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <img src="" alt="" class="profile-avatar" id="avatar-preview" style="display:none;">
            @endif

            <div class="profile-username" style="margin-top:1rem;">{{ $user->username }}</div>
            <div class="profile-email-text">{{ $user->email }}</div>

            <label class="profile-photo-upload" for="profile_photo">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:.3rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Change Photo
            </label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
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
                    <div class="pro-field">
                        <label class="pro-label" for="username">Username <span style="color:var(--primary);">*</span></label>
                        <input type="text" name="username" id="username" class="pro-input" value="{{ old('username', $user->username) }}" required>
                        @error('username')<div class="pro-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="pro-field">
                        <label class="pro-label" for="name">Display Name <span style="color:var(--primary);">*</span></label>
                        <input type="text" name="name" id="name" class="pro-input" value="{{ old('name', $user->name) }}" required>
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
    // Toggle password visibility
    function togglePw(inputId, btn) {
        const input = document.getElementById(inputId);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.style.color = isText ? '' : 'var(--primary)';
    }

    // Avatar preview on file select
    document.getElementById('profile_photo').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush

@endsection
