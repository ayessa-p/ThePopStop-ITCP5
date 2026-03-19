@extends('layouts.app')

@section('title', 'Reports - Admin')

@push('styles')
@include('admin.partials.form-styles')
<style>
    /* ── Page header ── */
    .reports-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .reports-page-header h1 {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin: 0;
    }
    .reports-page-header p {
        font-size: .85rem;
        color: #aaa;
        margin: .2rem 0 0;
    }

    /* ── Action buttons row ── */
    .report-actions {
        display: flex;
        gap: .6rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .btn-report-action {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .65rem 1.25rem;
        border-radius: 9px;
        font-size: .83rem;
        font-weight: 700;
        cursor: pointer;
        border: 2px solid transparent;
        text-decoration: none;
        font-family: inherit;
        transition: all .18s;
        white-space: nowrap;
    }
    .btn-rpt-print {
        background: #f5f2eb;
        color: var(--dark-brown);
        border-color: #e8e4dc;
    }
    .btn-rpt-print:hover {
        background: #ede9df;
        border-color: #d5cfc4;
        color: var(--dark-brown);
    }
    .btn-rpt-pdf {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    .btn-rpt-pdf:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    /* ── Filter card ── */
    .filter-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem;
    }
    .filter-card-title {
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .9px;
        color: #bbb;
        margin-bottom: 1.1rem;
        padding-bottom: .75rem;
        border-bottom: 1.5px solid #f0ede6;
        display: flex;
        align-items: center;
        gap: .55rem;
    }
    .filter-card-title svg { color: var(--primary); flex-shrink: 0; }
    .filter-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr;
        gap: 1rem 1.25rem;
        align-items: end;
    }

    /* ── Report result card ── */
    .result-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 1.75rem;
        margin-bottom: 1.5rem;
    }
    .result-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1.5px solid #f0ede6;
        flex-wrap: wrap;
    }
    .result-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dark-brown);
        margin: 0 0 .25rem;
    }
    .result-period {
        font-size: .78rem;
        color: #aaa;
        font-weight: 500;
    }

    /* ── Summary stat pills ── */
    .summary-pills {
        display: flex;
        gap: .6rem;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }
    .summary-pill {
        display: flex;
        flex-direction: column;
        gap: .15rem;
        padding: .65rem 1rem;
        background: #faf8f4;
        border: 1.5px solid #f0ede6;
        border-radius: 10px;
        min-width: 110px;
    }
    .pill-label {
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #bbb;
    }
    .pill-value {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dark-brown);
    }
    .pill-value.accent { color: var(--primary); }

    /* ── Data table ── */
    .rpt-table {
        width: 100%;
        border-collapse: collapse;
    }
    .rpt-table thead tr {
        background: #f7f5f0;
    }
    .rpt-table th {
        padding: .7rem 1rem;
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #aaa;
        text-align: left;
        white-space: nowrap;
    }
    .rpt-table th:first-child { border-radius: 8px 0 0 8px; }
    .rpt-table th:last-child  { border-radius: 0 8px 8px 0; text-align: right; }
    .rpt-table th:nth-child(2){ text-align: center; }

    .rpt-table tbody tr {
        border-bottom: 1px solid #f5f2eb;
        transition: background .12s;
    }
    .rpt-table tbody tr:last-child { border-bottom: none; }
    .rpt-table tbody tr:hover { background: #fdfcfa; }
    .rpt-table td {
        padding: .85rem 1rem;
        font-size: .9rem;
        color: #444;
        vertical-align: middle;
    }
    .rpt-table td:last-child { text-align: right; font-weight: 700; color: var(--dark-brown); }
    .rpt-table td:nth-child(2){ text-align: center; color: #888; }

    .rpt-table tfoot tr {
        background: #f5f2eb;
        border-top: 2px solid #e8e4dc;
    }
    .rpt-table tfoot td {
        padding: .9rem 1rem;
        font-size: .92rem;
        font-weight: 800;
        color: var(--dark-brown);
    }
    .rpt-table tfoot td:first-child { color: var(--primary); text-transform: uppercase; font-size: .8rem; letter-spacing: .5px; }
    .rpt-table tfoot td:last-child  { text-align: right; color: var(--primary); font-size: 1rem; }
    .rpt-table tfoot td:nth-child(2){ text-align: center; }

    /* ── Empty state ── */
    .rpt-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .75rem;
        padding: 3rem 1.5rem;
        text-align: center;
        color: #bbb;
        background: #faf8f4;
        border-radius: 10px;
        border: 1.5px dashed #e0dbd2;
    }
    .rpt-empty p { font-size: .88rem; margin: 0; }

    /* ── Chart section ── */
    .charts-section { margin-bottom: 1.5rem; }
    .charts-section-title {
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .9px;
        color: #bbb;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .charts-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #f0ede6;
    }

    .chart-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }
    .chart-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: .75rem;
    }
    .chart-card-full {
        grid-column: 1 / -1;
    }
    .chart-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .chart-card-title {
        font-size: .9rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin: 0;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .chart-card-title svg { color: var(--primary); flex-shrink: 0; }
    .chart-card-sub {
        font-size: .73rem;
        color: #bbb;
        font-weight: 500;
    }
    /* Canvas wrapper — gives Chart.js a definite height */
    .chart-body {
        position: relative;
        flex: 1;
        min-height: 0;
    }
    .chart-body-tall  { height: 300px; }
    .chart-body-short { height: 260px; }
    /* Make the div/canvas injected by ConsoleTVs/Charts fill their wrapper */
    .chart-body > div {
        position: absolute !important;
        inset: 0 !important;
        width: 100% !important;
        height: 100% !important;
    }
    .chart-body canvas {
        width:  100% !important;
        height: 100% !important;
    }

    /* ── Print styles ── */
    @media print {
        /* Hide UI chrome — but NOT charts */
        .admin-sidebar,
        .filter-card,
        .report-actions,
        .charts-section,       /* hide the interactive canvas charts */
        nav,
        .site-header,
        .site-footer { display: none !important; }

        body { background: #fff !important; font-size: 10pt; }
        .admin-container { display: block !important; }
        .admin-main { padding: 0 !important; }
        .result-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            page-break-inside: avoid;
        }

        /* Print-only branded header */
        .print-header {
            display: block !important;
            text-align: center;
            padding: 16px 0 12px;
            border-bottom: 2px solid #8B0000;
            margin-bottom: 16px;
        }
        .print-header .ph-brand {
            font-size: 20pt;
            font-weight: 800;
            color: #8B0000;
            letter-spacing: 0.5px;
        }
        .print-header .ph-sub  { font-size: 9pt;  color: #888; margin-top: 2px; }
        .print-header .ph-report { font-size: 13pt; font-weight: 700; color: #333; margin-top: 6px; }
        .print-header .ph-period { font-size: 9pt;  color: #999; margin-top: 2px; }

        /* Summary pills */
        .summary-pills { margin-bottom: 12px; }
        .summary-pill  { border: 1px solid #ddd !important; background: #fafafa !important; }

        /* Table */
        .rpt-table th { background: #8B0000 !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .rpt-table tfoot tr { background: #f5f2eb !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .rpt-table tfoot td:first-child,
        .rpt-table tfoot td:last-child { color: #8B0000 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        /* ── Print-only static charts ── */
        .print-only-charts {
            display: block !important;
            page-break-before: always;
        }
        .poc-title {
            font-size: 11pt;
            font-weight: 800;
            color: #333;
            margin: 0 0 6pt;
            padding-bottom: 6pt;
            border-bottom: 1.5pt solid #8B0000;
        }
        .poc-section-label {
            font-size: 7.5pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
            color: #aaa;
            margin: 10pt 0 5pt;
        }
        .poc-chart-full {
            width: 100%;
            border: 1pt solid #e8e4dc;
            border-radius: 5pt;
            padding: 10pt;
            margin-bottom: 10pt;
            box-sizing: border-box;
            page-break-inside: avoid;
        }
        .poc-chart-full img { width: 100%; height: auto; display: block; }
        .poc-chart-row {
            display: table;
            width: 100%;
            border-spacing: 8pt;
            page-break-inside: avoid;
        }
        .poc-chart-half {
            display: table-cell;
            width: 50%;
            border: 1pt solid #e8e4dc;
            border-radius: 5pt;
            padding: 10pt;
            box-sizing: border-box;
            vertical-align: top;
        }
        .poc-chart-half img { width: 100%; height: auto; display: block; }
        .poc-chart-caption {
            font-size: 7pt;
            color: #aaa;
            margin-top: 4pt;
            text-align: center;
        }
        .poc-note {
            margin-top: 10pt;
            padding: 7pt 10pt;
            background: #faf8f4 !important;
            border: 1pt solid #e8e4dc;
            border-radius: 4pt;
            font-size: 7.5pt;
            color: #888;
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @page { margin: 1.4cm 1.6cm; }
    }

    /* Print-only elements — hidden on screen */
    .print-header       { display: none; }
    .print-only-charts  { display: none; }

    @media (max-width: 900px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }
        .chart-grid   { grid-template-columns: 1fr; }
        .chart-card-full { grid-column: 1; }
    }
    @media (max-width: 560px) {
        .filter-grid { grid-template-columns: 1fr; }
        .reports-page-header { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')

@php
    $typeLabel = match($type) {
        'weekly_sales'    => 'Weekly Sales',
        'monthly_sales'   => 'Monthly Sales',
        'yearly_sales'    => 'Yearly Sales',
        'profit_expense'  => 'Profit & Expense',
        'top_products'    => 'Top Products',
        'customer_orders' => 'Customer Orders',
        default           => ucwords(str_replace('_', ' ', $type)),
    };
    $dateColLabel = match($type) {
        'yearly_sales' => 'Year',
        'weekly_sales' => 'Week',
        default        => 'Date',
    };
@endphp

<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">

        {{-- ── Page header ── --}}
        <div class="reports-page-header">
            <div>
                <h1>Reports</h1>
                <p>Analyze sales performance and export data.</p>
            </div>
            <div class="report-actions">
                <button onclick="window.print()" class="btn-report-action btn-rpt-print">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
                <a href="{{ route('admin.reports.pdf', ['type' => $type, 'start_date' => $start, 'end_date' => $end]) }}"
                   class="btn-report-action btn-rpt-pdf" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        {{-- ── Filter card ── --}}
        <div class="filter-card">
            <div class="filter-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Report Filters
            </div>

            <form method="GET" action="{{ route('admin.reports.index') }}">
                <div class="filter-grid">
                    <div class="af-field">
                        <label class="af-label">Report Type</label>
                        <select name="type" class="af-select" onchange="this.form.submit()">
                            <option value="weekly_sales"    {{ $type === 'weekly_sales'    ? 'selected' : '' }}>Weekly Sales</option>
                            <option value="monthly_sales"   {{ $type === 'monthly_sales'   ? 'selected' : '' }}>Monthly Sales</option>
                            <option value="yearly_sales"    {{ $type === 'yearly_sales'    ? 'selected' : '' }}>Yearly Sales</option>
                            <option value="profit_expense"  {{ $type === 'profit_expense'  ? 'selected' : '' }}>Profit &amp; Expense</option>
                            <option value="top_products"    {{ $type === 'top_products'    ? 'selected' : '' }}>Top Products</option>
                            <option value="customer_orders" {{ $type === 'customer_orders' ? 'selected' : '' }}>Customer Orders</option>
                        </select>
                    </div>
                    <div class="af-field">
                        <label class="af-label">Start Date</label>
                        <input type="date" name="start_date" value="{{ $start }}" class="af-input" onchange="this.form.submit()">
                    </div>
                    <div class="af-field">
                        <label class="af-label">End Date</label>
                        <input type="date" name="end_date" value="{{ $end }}" class="af-input" onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>

        {{-- ── Print-only header (hidden on screen) ── --}}
        <div class="print-header">
            <div class="ph-brand">The Pop Stop</div>
            <div class="ph-sub">Official Sales Report &mdash; Confidential</div>
            <div class="ph-report">{{ $typeLabel }} Report</div>
            <div class="ph-period">
                Period: {{ \Carbon\Carbon::parse($start)->format('M d, Y') }} &mdash; {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}
            </div>
        </div>

        {{-- ── Report result ── --}}
        <div class="result-card">

            <div class="result-card-header">
                <div>
                    <h2 class="result-title">{{ $typeLabel }} Report</h2>
                    <div class="result-period">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:3px;margin-top:-1px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($start)->format('M d, Y') }} &mdash; {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}
                    </div>
                </div>
            </div>

            {{-- Summary pills --}}
            <div class="summary-pills">
                <div class="summary-pill">
                    <span class="pill-label">Total Orders</span>
                    <span class="pill-value accent">{{ number_format($totalOrders) }}</span>
                </div>
                <div class="summary-pill">
                    <span class="pill-label">Total Revenue</span>
                    <span class="pill-value accent">&#8369;{{ number_format($totalRevenue, 2) }}</span>
                </div>
                <div class="summary-pill">
                    <span class="pill-label">Avg per Order</span>
                    <span class="pill-value">&#8369;{{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : '0.00' }}</span>
                </div>
                <div class="summary-pill">
                    <span class="pill-label">Records</span>
                    <span class="pill-value">{{ $reportData->count() }}</span>
                </div>
            </div>

            @if($reportData->isEmpty())
                <div class="rpt-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p>No sales data found for the selected period.<br>Try adjusting the date range or report type.</p>
                </div>
            @else
                <table class="rpt-table">
                    <thead>
                        <tr>
                            <th>{{ $dateColLabel }}</th>
                            <th>Orders</th>
                            <th>Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $label => $row)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ number_format($row['orders_count']) }}</td>
                                <td>&#8369;{{ number_format($row['total_sales'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Grand Total</td>
                            <td>{{ number_format($totalOrders) }}</td>
                            <td>&#8369;{{ number_format($totalRevenue, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif

        </div>

        {{-- ══════════════════════════════════════════════════════════════════
             PRINT-ONLY STATIC CHARTS (hidden on screen, visible when printing)
             Uses QuickChart.io static images — always render reliably on paper.
        ══════════════════════════════════════════════════════════════════ --}}
        <div class="print-only-charts">
            <div class="poc-title">Visual Analytics &mdash; {{ $typeLabel }} Report</div>

            {{-- Bar chart full width --}}
            <div class="poc-section-label">Sales Overview &mdash; Daily Totals for Selected Period</div>
            <div class="poc-chart-full">
                <img src="{{ $barChartImgUrl }}" alt="Sales Overview Bar Chart">
                <div class="poc-chart-caption">
                    {{ \Carbon\Carbon::parse($start)->format('M d, Y') }} &mdash; {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}
                </div>
            </div>

            {{-- Yearly + Pie side by side --}}
            <div class="poc-section-label">Yearly Trend &amp; Product Breakdown</div>
            <div class="poc-chart-row">
                <div class="poc-chart-half">
                    <img src="{{ $yearlyChartImgUrl }}" alt="Yearly Sales Growth Chart">
                    <div class="poc-chart-caption">Yearly Sales Growth &mdash; Last 5 Years</div>
                </div>
                <div class="poc-chart-half">
                    <img src="{{ $pieChartImgUrl }}" alt="Sales by Product Pie Chart">
                    <div class="poc-chart-caption">Sales by Product &mdash; Revenue Share (%)</div>
                </div>
            </div>

            <div class="poc-note">
                <strong>Notes:</strong> All figures in Philippine Peso (&#8369;). Cancelled orders are excluded.
                Charts are generated from data for the period
                {{ \Carbon\Carbon::parse($start)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}.
                Printed on {{ now()->format('M d, Y \a\t h:i A') }}.
            </div>
        </div>

        {{-- ── Interactive canvas charts (screen only) ── --}}
        <div class="charts-section">

            <div class="charts-section-title">Visual Analytics</div>

            <div class="chart-grid">

                {{-- Bar chart — full width --}}
                <div class="chart-card chart-card-full">
                    <div class="chart-card-header">
                        <h3 class="chart-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Sales Overview
                        </h3>
                        <span class="chart-card-sub">Daily totals for selected date range</span>
                    </div>
                    <div class="chart-body chart-body-tall">
                        {!! $barChart->container() !!}
                    </div>
                </div>

                {{-- Yearly line chart --}}
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h3 class="chart-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            Yearly Sales Growth
                        </h3>
                        <span class="chart-card-sub">Last 5 years</span>
                    </div>
                    <div class="chart-body chart-body-short">
                        {!! $yearlyChart->container() !!}
                    </div>
                </div>

                {{-- Pie chart --}}
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h3 class="chart-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                            Sales by Product
                        </h3>
                        <span class="chart-card-sub">Revenue share (%)</span>
                    </div>
                    <div class="chart-body chart-body-short">
                        {!! $pieChart->container() !!}
                    </div>
                </div>

            </div>
        </div>

    </main>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
{!! $barChart->script() !!}
{!! $yearlyChart->script() !!}
{!! $pieChart->script() !!}
@endpush

@endsection
