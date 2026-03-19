@extends('layouts.app')
@section('title', 'Edit Discount - Admin')

@push('styles')
    @include('admin.partials.form-styles')
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">

        <a href="{{ route('admin.discounts.index') }}" class="af-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Discounts
        </a>

        <div class="af-page-header">
            <h1>Edit Discount</h1>
            <p>Editing promo code <strong>{{ $discount->code }}</strong></p>
        </div>

        <form method="POST" action="{{ route('admin.discounts.update', $discount) }}">
            @csrf
            @method('PUT')

            {{-- ── Discount Details ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Discount Details
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label">Code <span class="af-required">*</span></label>
                        <input type="text" name="code" class="af-input"
                            value="{{ old('code', $discount->code) }}"
                            required
                            style="text-transform:uppercase; font-weight:700; letter-spacing:.5px;"
                            oninput="this.value=this.value.toUpperCase()"
                            placeholder="e.g. WELCOME10">
                        @error('code')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Description</label>
                        <input type="text" name="description" class="af-input"
                            value="{{ old('description', $discount->description) }}"
                            placeholder="e.g. 10% off for new customers">
                    </div>

                    <div class="af-field">
                        <label class="af-label">Discount Type <span class="af-required">*</span></label>
                        <select name="discount_type" class="af-select" required id="discount-type-select" onchange="updateValueHint()">
                            <option value="percentage" {{ old('discount_type', $discount->discount_type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="fixed"      {{ old('discount_type', $discount->discount_type) === 'fixed'      ? 'selected' : '' }}>Fixed Amount (&#8369;)</option>
                        </select>
                        @error('discount_type')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Discount Value <span class="af-required">*</span></label>
                        <div class="af-prefix-wrap">
                            <span class="af-prefix" id="value-prefix">
                                {{ old('discount_type', $discount->discount_type) === 'fixed' ? '₱' : '%' }}
                            </span>
                            <input type="number" name="discount_value" class="af-input"
                                step="0.01" min="0"
                                value="{{ old('discount_value', $discount->discount_value) }}"
                                required placeholder="0.00">
                        </div>
                        <div class="af-hint" id="value-hint">Enter a % value for Percentage, or &#8369; amount for Fixed.</div>
                        @error('discount_value')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field af-span-2">
                        <label class="af-label">Minimum Purchase Amount</label>
                        <div class="af-prefix-wrap">
                            <span class="af-prefix">&#8369;</span>
                            <input type="number" name="min_purchase" class="af-input"
                                step="0.01" min="0"
                                value="{{ old('min_purchase', $discount->min_purchase) }}"
                                placeholder="0.00">
                        </div>
                        <div class="af-hint">Leave at 0 for no minimum purchase requirement.</div>
                    </div>
                </div>
            </div>

            {{-- ── Validity Period ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Validity Period
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label">Start Date</label>
                        <input type="date" name="start_date" class="af-input"
                            value="{{ $discount->start_date ? $discount->start_date->format('Y-m-d') : '' }}">
                        <div class="af-hint">Leave empty to make it available immediately.</div>
                    </div>

                    <div class="af-field">
                        <label class="af-label">End Date</label>
                        <input type="date" name="end_date" class="af-input"
                            value="{{ $discount->end_date ? $discount->end_date->format('Y-m-d') : '' }}">
                        <div class="af-hint">Leave empty for no expiry date.</div>
                    </div>
                </div>
            </div>

            {{-- ── Settings ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </div>

                <label class="af-toggle-row" style="cursor:pointer;">
                    <div class="af-toggle-info">
                        <span class="af-toggle-title">Active</span>
                        <span class="af-toggle-sub">When enabled, customers can apply this code at checkout.</span>
                    </div>
                    <label class="af-switch">
                        <input type="checkbox" name="is_active" value="1" {{ $discount->is_active ? 'checked' : '' }}>
                        <span class="af-switch-track"></span>
                    </label>
                </label>
            </div>

            {{-- ── Actions ── --}}
            <div class="af-btn-row">
                <button type="submit" class="af-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.discounts.index') }}" class="af-btn-cancel">
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
    function updateValueHint() {
        const type   = document.getElementById('discount-type-select').value;
        const prefix = document.getElementById('value-prefix');
        const hint   = document.getElementById('value-hint');
        if (type === 'percentage') {
            prefix.textContent = '%';
            hint.textContent   = 'Enter the percentage to deduct (e.g. 10 = 10% off).';
        } else {
            prefix.textContent = '₱';
            hint.textContent   = 'Enter the fixed peso amount to deduct from the order total.';
        }
    }
    // Run on page load in case of old() value
    updateValueHint();
</script>
@endpush

@endsection
