@extends('layouts.app')
@section('title', 'Edit User - Admin')

@push('styles')
    @include('admin.partials.form-styles')
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">

        <a href="{{ route('admin.users.index') }}" class="af-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Users
        </a>

        <div class="af-page-header">
            <h1>Edit User</h1>
            <p>Updating account for <strong>{{ $user->username }}</strong></p>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ── Account Info ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Account Information
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="af-input"
                            value="{{ old('username', $user->username) }}"
                            placeholder="e.g. juan_collector" autocomplete="off">
                        @error('username')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label" for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="af-input"
                            value="{{ old('email', $user->email) }}"
                            placeholder="e.g. juan@email.com">
                        @error('email')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label" for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="af-input"
                            value="{{ old('full_name', $user->full_name) }}"
                            placeholder="e.g. Juan dela Cruz">
                    </div>

                    <div class="af-field">
                        <label class="af-label" for="role">Role</label>
                        <select id="role" name="role" class="af-select">
                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ── Contact & Address ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Contact &amp; Address
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label" for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="af-input"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="e.g. 09XX-XXX-XXXX">
                    </div>

                    <div class="af-field af-span-2">
                        <label class="af-label" for="address">Delivery Address</label>
                        <textarea id="address" name="address" class="af-textarea" rows="2"
                            placeholder="Street, Barangay, City, Province, ZIP">{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Change Password ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Change Password
                </div>

                <div class="af-info-box" style="margin-bottom:1.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Leave both fields blank to keep the user's current password unchanged.
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label" for="password">New Password</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <input type="password" id="password" name="password" class="af-input"
                                placeholder="Enter new password"
                                style="padding-right:2.75rem;"
                                autocomplete="new-password">
                            <button type="button" onclick="togglePw('password', this)" tabindex="-1"
                                style="position:absolute;right:.85rem;background:none;border:none;cursor:pointer;color:#bbb;display:flex;align-items:center;transition:color .2s;"
                                onmouseover="this.style.color='var(--primary)'"
                                onmouseout="this.style.color='#bbb'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label" for="password_confirmation">Confirm New Password</label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="af-input"
                                placeholder="Re-enter new password"
                                style="padding-right:2.75rem;"
                                autocomplete="new-password">
                            <button type="button" onclick="togglePw('password_confirmation', this)" tabindex="-1"
                                style="position:absolute;right:.85rem;background:none;border:none;cursor:pointer;color:#bbb;display:flex;align-items:center;transition:color .2s;"
                                onmouseover="this.style.color='var(--primary)'"
                                onmouseout="this.style.color='#bbb'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Actions ── --}}
            <div class="af-btn-row">
                <button type="submit" class="af-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.users.index') }}" class="af-btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
            </div>

        </form>
    </main>
</div>

@push('scripts')
<script>
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
        btn.style.color = input.type === 'text' ? 'var(--primary)' : '#bbb';
    }
</script>
@endpush

@endsection
