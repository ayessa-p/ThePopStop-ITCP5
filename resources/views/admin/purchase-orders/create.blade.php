@extends('layouts.app')
@section('title', 'Create Purchase Order - Admin')

@push('styles')
    @include('admin.partials.form-styles')
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">

        <a href="{{ route('admin.purchase-orders.index') }}" class="af-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Purchase Orders
        </a>

        <div class="af-page-header">
            <h1>Create Purchase Order</h1>
            <p>Place a new restocking order with one of your suppliers.</p>
        </div>

        <form method="POST" action="{{ route('admin.purchase-orders.store') }}">
            @csrf

            {{-- ── Order Info ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Order Information
                </div>

                <div class="af-grid-2">
                    <div class="af-field">
                        <label class="af-label">Supplier <span class="af-required">*</span></label>
                        <select name="supplier_id" class="af-select" required>
                            <option value="" disabled selected>Select a supplier...</option>
                            @foreach($suppliers as $s)
                                <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->brand }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field">
                        <label class="af-label">Order Date <span class="af-required">*</span></label>
                        <input type="date" name="order_date" class="af-input"
                            value="{{ old('order_date', date('Y-m-d')) }}" required>
                        @error('order_date')<div class="af-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="af-field af-span-2">
                        <label class="af-label">Notes</label>
                        <textarea name="notes" class="af-textarea" rows="2"
                            placeholder="Add any internal notes or special instructions...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Order Items ── --}}
            <div class="af-card">
                <div class="af-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Order Items
                    <span style="margin-left:auto; font-size:.72rem; font-weight:600; color:#bbb;">Add one or more products</span>
                </div>

                {{-- Column headers --}}
                <div style="display:grid; grid-template-columns:1fr 100px 140px 44px; gap:.75rem; padding:0 1rem .5rem; margin-bottom:.25rem;">
                    <span style="font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.6px; color:#ccc;">Product</span>
                    <span style="font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.6px; color:#ccc;">Quantity</span>
                    <span style="font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.6px; color:#ccc;">Unit Cost (&#8369;)</span>
                    <span></span>
                </div>

                <div id="items-container">
                    {{-- First row (no remove button) --}}
                    <div class="po-item-row" id="item-row-0">
                        <div class="af-field">
                            <select name="product_ids[]" class="af-select">
                                <option value="" disabled selected>Select product...</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="af-field">
                            <input type="number" name="quantities[]" class="af-input"
                                min="1" value="1" placeholder="1">
                        </div>
                        <div class="af-field">
                            <div class="af-prefix-wrap">
                                <span class="af-prefix">&#8369;</span>
                                <input type="number" name="unit_costs[]" class="af-input"
                                    step="0.01" min="0" value="0.00" placeholder="0.00">
                            </div>
                        </div>
                        {{-- placeholder to keep grid alignment --}}
                        <div></div>
                    </div>
                </div>

                <button type="button" class="btn-po-add" onclick="addItemRow()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Another Product
                </button>
            </div>

            {{-- ── Actions ── --}}
            <div class="af-btn-row">
                <button type="submit" class="af-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Purchase Order
                </button>
                <a href="{{ route('admin.purchase-orders.index') }}" class="af-btn-cancel">
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
    // Build the products options list once so we can reuse it
    const productOptions = `{!! collect($products)->map(fn($p) => '<option value="'.$p->id.'">'.$p->name.'</option>')->implode('') !!}`;

    let rowCount = 1;

    function addItemRow() {
        const container = document.getElementById('items-container');
        const idx       = rowCount++;

        const row = document.createElement('div');
        row.className = 'po-item-row';
        row.id        = `item-row-${idx}`;

        row.innerHTML = `
            <div class="af-field">
                <select name="product_ids[]" class="af-select">
                    <option value="" disabled selected>Select product...</option>
                    ${productOptions}
                </select>
            </div>
            <div class="af-field">
                <input type="number" name="quantities[]" class="af-input"
                    min="1" value="1" placeholder="1">
            </div>
            <div class="af-field">
                <div class="af-prefix-wrap">
                    <span class="af-prefix">&#8369;</span>
                    <input type="number" name="unit_costs[]" class="af-input"
                        step="0.01" min="0" value="0.00" placeholder="0.00">
                </div>
            </div>
            <button type="button" class="btn-po-remove" onclick="removeRow('item-row-${idx}')" title="Remove row">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;

        container.appendChild(row);

        // Smooth scroll to new row
        row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function removeRow(rowId) {
        const row = document.getElementById(rowId);
        if (row) {
            row.style.transition = 'opacity .15s ease, transform .15s ease';
            row.style.opacity    = '0';
            row.style.transform  = 'translateX(8px)';
            setTimeout(() => row.remove(), 150);
        }
    }
</script>
@endpush

@endsection
