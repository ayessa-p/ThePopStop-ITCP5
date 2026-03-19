<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $reportLabel }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            background: #fff;
        }

        /* ── Header ── */
        .header {
            background: #8B0000;
            color: #fff;
            padding: 22px 32px;
        }
        .header-inner  { display: table; width: 100%; }
        .header-left   { display: table-cell; vertical-align: middle; }
        .header-right  { display: table-cell; vertical-align: middle; text-align: right; }

        .brand-name   { font-size: 22px; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 2px; }
        .brand-sub    { font-size: 10px; opacity: 0.8; }
        .report-title { font-size: 14px; font-weight: 700; margin-bottom: 3px; }
        .report-period{ font-size: 9.5px; opacity: 0.85; }

        /* ── Summary strip ── */
        .subheader { background: #f5f2eb; border-bottom: 2px solid #e8e4dc; padding: 10px 32px; display: table; width: 100%; }
        .subheader-item {
            display: table-cell;
            text-align: center;
            border-right: 1px solid #ddd;
            padding: 0 18px;
        }
        .subheader-item:first-child { text-align: left;  padding-left: 0; }
        .subheader-item:last-child  { text-align: right; padding-right: 0; border-right: none; }
        .sh-label { font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #aaa; margin-bottom: 3px; }
        .sh-value { font-size: 13px; font-weight: 700; color: #333; }
        .sh-value.accent { color: #8B0000; }

        /* ── Body ── */
        .body { padding: 22px 32px 32px; }

        /* ── Section title ── */
        .section-title {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #bbb;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1.5px solid #f0ede6;
            display: table;
            width: 100%;
        }
        .section-title .left  { display: table-cell; }
        .section-title .right { display: table-cell; text-align: right; }

        /* ── Data Table ── */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table thead tr { background: #8B0000; color: #fff; }
        table.data-table thead th {
            padding: 8px 12px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-align: left;
        }
        table.data-table thead th:last-child   { text-align: right; }
        table.data-table thead th:nth-child(2) { text-align: center; }

        table.data-table tbody tr:nth-child(even) { background: #fdfcfa; }
        table.data-table tbody td {
            padding: 7px 12px;
            font-size: 10px;
            color: #444;
            border-bottom: 1px solid #f0ede6;
        }
        table.data-table tbody td:last-child   { text-align: right; font-weight: 600; }
        table.data-table tbody td:nth-child(2) { text-align: center; color: #666; }

        table.data-table tfoot tr { background: #f5f2eb; border-top: 2px solid #e8e4dc; }
        table.data-table tfoot td {
            padding: 9px 12px;
            font-size: 10.5px;
            font-weight: 700;
            color: #333;
        }
        table.data-table tfoot td:first-child {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #8B0000;
        }
        table.data-table tfoot td:last-child   { text-align: right; color: #8B0000; font-size: 11.5px; }
        table.data-table tfoot td:nth-child(2) { text-align: center; }

        /* ── Empty state ── */
        .no-data {
            text-align: center;
            padding: 28px;
            color: #bbb;
            font-size: 11px;
            background: #faf8f4;
            border: 1.5px dashed #e0dbd2;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        /* ── Charts section ── */
        .charts-section { margin-top: 4px; }

        /* Full-width chart */
        .chart-full {
            width: 100%;
            margin-bottom: 14px;
            background: #fff;
            border: 1.5px solid #f0ede6;
            border-radius: 8px;
            padding: 14px 16px 10px;
        }
        .chart-full img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Two-column charts */
        .chart-row { display: table; width: 100%; border-spacing: 12px 0; margin-bottom: 14px; }
        .chart-half {
            display: table-cell;
            width: 50%;
            background: #fff;
            border: 1.5px solid #f0ede6;
            border-radius: 8px;
            padding: 14px 16px 10px;
            vertical-align: top;
        }
        .chart-half img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Chart card header inside each chart */
        .chart-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #aaa;
            margin-bottom: 8px;
        }
        .chart-label span {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #8B0000;
            border-radius: 2px;
            margin-right: 5px;
            vertical-align: middle;
        }

        /* ── Yearly summary table ── */
        table.year-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.year-table th {
            padding: 6px 10px;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #999;
            font-weight: 700;
            border-bottom: 1.5px solid #f0ede6;
        }
        table.year-table td {
            padding: 6px 10px;
            font-size: 10px;
            border-bottom: 1px solid #f0ede6;
            color: #444;
        }
        table.year-table td:last-child { text-align: right; font-weight: 700; color: #8B0000; }

        /* ── Page break ── */
        .page-break { page-break-before: always; }

        /* ── Footer ── */
        .footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            padding: 7px 32px;
            background: #faf8f4;
            border-top: 1px solid #e8e4dc;
            display: table;
            width: 100%;
        }
        .footer-left  { display: table-cell; font-size: 7.5px; color: #bbb; vertical-align: middle; }
        .footer-right { display: table-cell; font-size: 7.5px; color: #bbb; vertical-align: middle; text-align: right; }
    </style>
</head>
<body>

    {{-- ── Fixed footer (appears on every page) ── --}}
    <div class="footer">
        <div class="footer-left">
            The Pop Stop &bull; thepopstopmail@gmail.com &bull; Western Bicutan, Taguig City, Philippines
        </div>
        <div class="footer-right">
            Generated {{ now()->format('M d, Y \a\t h:i A') }}
        </div>
    </div>

    {{-- ── Branded header ── --}}
    <div class="header">
        <div class="header-inner">
            <div class="header-left">
                <div class="brand-name">The Pop Stop</div>
                <div class="brand-sub">Official Sales Report &mdash; Confidential</div>
            </div>
            <div class="header-right">
                <div class="report-title">{{ $reportLabel }}</div>
                <div class="report-period">
                    Period:&nbsp;{{ \Carbon\Carbon::parse($start)->format('M d, Y') }}
                    &mdash;
                    {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}
                </div>
            </div>
        </div>
    </div>

    {{-- ── Summary strip ── --}}
    <div class="subheader">
        <div class="subheader-item">
            <div class="sh-label">Report Type</div>
            <div class="sh-value">{{ ucwords(str_replace('_', ' ', $type)) }}</div>
        </div>
        <div class="subheader-item">
            <div class="sh-label">Total Orders</div>
            <div class="sh-value accent">{{ number_format($totalOrders) }}</div>
        </div>
        <div class="subheader-item">
            <div class="sh-label">Total Revenue</div>
            <div class="sh-value accent">&#8369;{{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="subheader-item">
            <div class="sh-label">Avg per Order</div>
            <div class="sh-value">
                &#8369;{{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : '0.00' }}
            </div>
        </div>
        <div class="subheader-item">
            <div class="sh-label">Generated On</div>
            <div class="sh-value">{{ now()->format('M d, Y') }}</div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════════
         PAGE 1 — DATA TABLE
    ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="body">

        {{-- ── Data breakdown table ── --}}
        <div class="section-title">
            <span class="left">Sales Breakdown by {{ $dateLabel }}</span>
            <span class="right">{{ $reportData->count() }} record(s)</span>
        </div>

        @if($reportData->isEmpty())
            <div class="no-data">
                No sales data found for the selected period.
            </div>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ $dateLabel }}</th>
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

        {{-- ── Yearly sales summary ── --}}
        @if(isset($yearlySales) && $yearlySales->isNotEmpty())
            <div class="section-title" style="margin-top: 6px;">
                <span class="left">Yearly Sales Summary (Last 5 Years)</span>
            </div>
            <table class="year-table">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th style="text-align:right;">Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($yearlySales as $year => $amount)
                        <tr>
                            <td>{{ $year }}</td>
                            <td style="text-align:right;">&#8369;{{ number_format($amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    {{-- ══════════════════════════════════════════════════════════════════════════
         PAGE 2 — CHARTS
    ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="page-break"></div>

    <div class="body">

        <div class="section-title">
            <span class="left">Visual Analytics &mdash; Charts</span>
            <span class="right">{{ \Carbon\Carbon::parse($start)->format('M d, Y') }} &mdash; {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}</span>
        </div>

        {{-- ── Bar chart: Sales Overview (full width) ── --}}
        <div class="chart-full">
            <div class="chart-label">
                <span></span>Sales Overview &mdash; Daily Totals for Selected Date Range
            </div>
            @if(!empty($barChartImgUrl))
                <img src="{{ $barChartImgUrl }}" alt="Sales Overview Chart">
            @else
                <div class="no-data">Chart data unavailable.</div>
            @endif
        </div>

        {{-- ── Bottom row: Yearly line + Pie side by side ── --}}
        <div class="chart-row">

            {{-- Yearly sales line chart --}}
            <div class="chart-half">
                <div class="chart-label">
                    <span></span>Yearly Sales Growth &mdash; Last 5 Years
                </div>
                @if(!empty($yearlyChartImgUrl))
                    <img src="{{ $yearlyChartImgUrl }}" alt="Yearly Sales Chart">
                @else
                    <div class="no-data" style="font-size:10px; padding:16px;">No yearly data.</div>
                @endif
            </div>

            {{-- Pie chart: sales by product --}}
            <div class="chart-half">
                <div class="chart-label">
                    <span></span>Sales by Product &mdash; Revenue Share (%)
                </div>
                @if(!empty($pieChartImgUrl))
                    <img src="{{ $pieChartImgUrl }}" alt="Sales by Product Pie Chart">
                @else
                    <div class="no-data" style="font-size:10px; padding:16px;">No product data.</div>
                @endif
            </div>

        </div>

        {{-- ── Chart notes ── --}}
        <div style="margin-top: 8px; padding: 10px 14px; background: #faf8f4; border: 1.5px solid #f0ede6; border-radius: 6px; font-size: 8.5px; color: #bbb; line-height: 1.6;">
            <strong style="color:#aaa;">Chart Notes:</strong>
            The Sales Overview bar chart shows daily revenue totals for the selected date range.
            The Yearly Sales Growth chart shows annual revenue trends for the last 5 years.
            The Sales by Product chart shows each product's percentage share of total revenue for the selected period.
            All figures are in Philippine Peso (&#8369;). Cancelled orders are excluded from all calculations.
        </div>

    </div>

</body>
</html>
