@extends('layouts.app')
@section('title', 'Add Supplier - Admin')

@push('styles')
    @include('admin.partials.form-styles')
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">

        <a href="{{ route('admin.suppliers.index') }}" class="af-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Suppliers
        </a>

        <div class="af-page-header">
            <h1>Add New Supplier</h1>
            <p>Add a brand supplier to source products from.</p>
        </div>

        <form method="POST" action="{{ route('admin.suppliers.store') }}">
            @csrf

            {{-- ── Supplier Information ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Supplier Information
                </div>

                <div class="af-grid-2">
                    <div class="af-field af-span-2">
                        <label class="af-label">Brand Name <span class="af-required">*</span></label>
                        <input type="text" name="brand" class="af-input"
                            value="{{ old('brand') }}"
                            required
                            placeholder="e.g. Pop Mart, Funko">
                        @error('brand')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Contact Person</label>
                        <input type="text" name="contact_person" class="af-input"
                            value="{{ old('contact_person') }}"
                            placeholder="e.g. Maria Santos">
                    </div>

                    <div class="af-field">
                        <label class="af-label">Phone Number</label>
                        <input type="text" name="phone" class="af-input"
                            value="{{ old('phone') }}"
                            placeholder="e.g. 09XX-XXX-XXXX">
                    </div>

                    <div class="af-field af-span-2">
                        <label class="af-label">Email Address</label>
                        <input type="email" name="email" class="af-input"
                            value="{{ old('email') }}"
                            placeholder="e.g. supplier@brand.com">
                    </div>

                    <div class="af-field af-span-2">
                        <label class="af-label">Business Address</label>
                        <textarea name="address" class="af-textarea" rows="2"
                            placeholder="Street, Barangay, City, Province, ZIP">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Actions ── --}}
            <div class="af-btn-row">
                <button type="submit" class="af-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Supplier
                </button>
                <a href="{{ route('admin.suppliers.index') }}" class="af-btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
            </div>

        </form>
    </main>
</div>
@endsection
