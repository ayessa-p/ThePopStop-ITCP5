@extends('layouts.app')
@section('title', 'Add User - Admin')

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
            <h1>Add New User</h1>
            <p>Create a new customer or admin account.</p>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            {{-- ── Account Credentials ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Account Credentials
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label">Username <span class="af-required">*</span></label>
                        <input type="text" name="username" class="af-input" value="{{ old('username') }}" required placeholder="e.g. juan_collector" autocomplete="off">
                        @error('username')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Email Address <span class="af-required">*</span></label>
                        <input type="email" name="email" class="af-input" value="{{ old('email') }}" required placeholder="e.g. juan@email.com" autocomplete="off">
                        @error('email')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Password <span class="af-required">*</span></label>
                        <div class="af-pw-wrap" style="position:relative;display:flex;align-items:center;">
                            <input type="password" name="password" id="pw1" class="af-input" required placeholder="Min. 8 characters" style="padding-right:2.75rem;" autocomplete="new-password">
                            <button type="button" onclick="togglePw('pw1',this)" tabindex="-1"
                                style="position:absolute;right:.85rem;background:none;border:none;cursor:pointer;color:#bbb;display:flex;align-items:center;transition:color .2s;"
                                onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#bbb'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Confirm Password <span class="af-required">*</span></label>
                        <div style="position:relative;display:flex;align-items:center;">
                            <input type="password" name="password_confirmation" id="pw2" class="af-input" required placeholder="Re-enter password" style="padding-right:2.75rem;" autocomplete="new-password">
                            <button type="button" onclick="togglePw('pw2',this)" tabindex="-1"
                                style="position:absolute;right:.85rem;background:none;border:none;cursor:pointer;color:#bbb;display:flex;align-items:center;transition:color .2s;"
                                onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#bbb'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Personal Information ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Personal Information
                </div>

                <div class="af-grid-2">
                    <div class="af-field af-span-2">
                        <label class="af-label">Full Name <span class="af-required">*</span></label>
                        <input type="text" name="full_name" class="af-input" value="{{ old('full_name') }}" required placeholder="e.g. Juan dela Cruz">
                        @error('full_name')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Phone Number</label>
                        <input type="text" name="phone" class="af-input" value="{{ old('phone') }}" placeholder="e.g. 09XX-XXX-XXXX">
                    </div>

                    <div class="af-field">
                        <label class="af-label">Role <span class="af-required">*</span></label>
                        <select name="role" class="af-select" required>
                            <option value="customer" {{ old('role', 'customer') === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin"    {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="af-field af-span-2">
                        <label class="af-label">Delivery Address</label>
                        <textarea name="address" class="af-textarea" rows="2" placeholder="Street, Barangay, City, Province, ZIP">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Actions ── --}}
            <div class="af-btn-row">
                <button type="submit" class="af-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create User
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
