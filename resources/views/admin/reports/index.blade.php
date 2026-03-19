@extends('layouts.app')

@section('title', 'Reports - Admin')

@push('styles')
<style>
    .admin-container { display: flex; gap: 2rem; padding: 2rem 0; }
    .admin-sidebar { width: 280px; background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); height: fit-content; }
    .admin-sidebar h2 { color: var(--primary); font-size: 1.25rem; margin-bottom: 2rem; font-weight: 700; }
    .sidebar-nav { display: flex; flex-direction: column; gap: 0.5rem; }
    .sidebar-link { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem; text-decoration: none; color: #666; border-radius: 12px; transition: all 0.2s; font-weight: 500; }
    .sidebar-link:hover { background: var(--bg); color: var(--primary); }
    .sidebar-link.active { background: var(--primary); color: white; }
    .admin-main { flex: 1; min-width: 0; }
    .admin-header h1 { color: var(--dark-brown); font-size: 2.25rem; font-weight: 700; margin: 0 0 2rem 0; }

    .report-card { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 2rem; }
    .report-card h3 { color: var(--dark-brown); font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; }

    .filter-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; align-items: end; }
    .form-group { margin-bottom: 0; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #555; font-size: 0.85rem; }
    .form-control { width: 100%; padding: 0.6rem 1rem; border: 2px solid #F3F1EA; border-radius: 10px; background: #fafafa; font-size: 0.9rem; }

    .chart-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; }
    .chart-container { background: white; padding: 1.5rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); height: 400px; overflow: hidden; position: relative; }
    .chart-full { grid-column: span 2; height: 450px; }

    .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 1rem; }
    .admin-table th { background: var(--accent); color: white; text-align: left; padding: 1rem; font-weight: 600; font-size: 0.9rem; }
    .admin-table th:first-child { border-top-left-radius: 12px; }
    .admin-table th:last-child { border-top-right-radius: 12px; }
    .admin-table td { padding: 1rem; border-bottom: 1px solid #F3F1EA; color: #444; font-size: 0.9rem; }
    .total-row { background: #fafafa; font-weight: 700; }

    .btn-print { background: #a89078; color: white; padding: 0.5rem 1.5rem; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer; }

    @media print {
        .admin-sidebar, .filter-card, .btn-print, .admin-header { display: none !important; }
        .admin-container { display: block; padding: 0; }
        .report-card { box-shadow: none; border: 1px solid #eee; }
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <h1 class="admin-header">Reports</h1>

        <div class="report-card filter-card">
            <h3>Select Report Type</h3>
            <form method="GET" action="{{ route('admin.reports.index') }}">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Report Type</label>
                        <select name="type" class="form-control" onchange="this.form.submit()">
                            <option value="weekly_sales" {{ $type == 'weekly_sales' ? 'selected' : '' }}>Weekly Sales</option>
                            <option value="monthly_sales" {{ $type == 'monthly_sales' ? 'selected' : '' }}>Monthly Sales</option>
                            <option value="profit_expense" {{ $type == 'profit_expense' ? 'selected' : '' }}>Profit & Expense</option>
                            <option value="top_products" {{ $type == 'top_products' ? 'selected' : '' }}>Top Products</option>
                            <option value="customer_orders" {{ $type == 'customer_orders' ? 'selected' : '' }}>Customer Orders</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" value="{{ $start }}" class="form-control" onchange="this.form.submit()">
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" value="{{ $end }}" class="form-control" onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>

        <div class="report-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3>{{ ucwords(str_replace('_', ' ', $type)) }} Report</h3>
                <button onclick="window.print()" class="btn-print">Print Report</button>
            </div>
            <p style="color: #999; font-size: 0.9rem; margin-bottom: 2rem;">Period: {{ \Carbon\Carbon::parse($start)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}</p>

            @if($reportData->isEmpty())
                <div style="background: #e0f2fe; color: #0369a1; padding: 1rem; border-radius: 10px; font-size: 0.9rem;">
                    No sales data for this period.
                </div>
            @else
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Orders</th>
                            <th style="text-align: right;">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $date => $data)
                        <tr>
                            <td>{{ $date }}</td>
                            <td>{{ $data['orders_count'] }}</td>
                            <td style="text-align: right;">₱{{ number_format($data['total_sales'], 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td>TOTAL</td>
                            <td>{{ $totalOrders }}</td>
                            <td style="text-align: right;">₱{{ number_format($totalRevenue, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>

        <div class="chart-grid">
            <div class="chart-container chart-full">
                <h3 style="margin-bottom: 1rem;">Sales Overview (Date Range)</h3>
                {!! $barChart->container() !!}
            </div>
            <div class="chart-container">
                <h3 style="margin-bottom: 1rem;">Yearly Sales Growth</h3>
                {!! $yearlyChart->container() !!}
            </div>
            <div class="chart-container">
                <h3 style="margin-bottom: 1rem;">Sales by Product (%)</h3>
                {!! $pieChart->container() !!}
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{!! $barChart->script() !!}
{!! $yearlyChart->script() !!}
{!! $pieChart->script() !!}
@endpush
@endsection
