<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('admin');
    }

    // ─── Shared data-building helper ────────────────────────────────────────────

    private function buildReportData(string $type, string $start, string $end): array
    {
        $startDate = Carbon::parse($start)->startOfDay();
        $endDate   = Carbon::parse($end)->endOfDay();

        $orders = Order::where('status', '!=', 'Cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        // ── Table data (grouping depends on type) ────────────────────────────
        $groupFormat = match ($type) {
            'yearly_sales' => 'Y',
            'weekly_sales' => 'W-Y',
            default        => 'M d, Y',
        };

        $reportData = $orders
            ->groupBy(fn ($o) => $o->created_at->format($groupFormat))
            ->map(fn ($group) => [
                'orders_count' => $group->count(),
                'total_sales'  => $group->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount),
            ]);

        $totalRevenue = $orders->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount);
        $totalOrders  = $orders->count();

        // ── Bar chart: sales over the selected date range (grouped by day) ───
        $salesByDate = $orders
            ->groupBy(fn ($o) => $o->created_at->format('Y-m-d'))
            ->map(fn ($group) => $group->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount));

        $barChart = new Chart;
        $barChart->labels($salesByDate->keys()->toArray());
        $barChart->dataset('Sales (₱)', 'bar', $salesByDate->values()->toArray())->options([
            'backgroundColor'     => '#8B0000',
            'borderColor'         => '#6b0000',
            'borderWidth'         => 0,
            'borderRadius'        => 4,
            'responsive'          => true,
            'maintainAspectRatio' => false,
            'animation'           => ['duration' => 0],
        ]);

        // ── Yearly sales chart (last 5 years, always visible) ────────────────
        $yearlySales = Order::where('status', '!=', 'Cancelled')
            ->whereYear('created_at', '>=', now()->subYears(5)->year)
            ->get()
            ->groupBy(fn ($o) => $o->created_at->year)
            ->map(fn ($group) => $group->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount))
            ->sortKeys();

        $yearlyChart = new Chart;
        $yearlyChart->labels($yearlySales->keys()->toArray());
        $yearlyChart->dataset('Yearly Sales (₱)', 'line', $yearlySales->values()->toArray())->options([
            'backgroundColor'     => 'rgba(139, 0, 0, 0.12)',
            'borderColor'         => '#8B0000',
            'borderWidth'         => 3,
            'pointBackgroundColor'=> '#8B0000',
            'pointRadius'         => 5,
            'pointHoverRadius'    => 7,
            'fill'                => true,
            'tension'             => 0.4,
            'responsive'          => true,
            'maintainAspectRatio' => false,
            'animation'           => ['duration' => 0],
        ]);

        // ── Pie chart: sales % by product ────────────────────────────────────
        $productSales = OrderItem::whereHas(
            'order',
            fn ($q) => $q->where('status', '!=', 'Cancelled')
                         ->whereBetween('created_at', [$startDate, $endDate])
        )
            ->selectRaw('product_id, sum(quantity * unit_price) as total')
            ->groupBy('product_id')
            ->with('product:id,name')
            ->get();

        $totalSalesSum = $productSales->sum('total');
        $pieLabels     = $productSales->map(fn ($i) => $i->product?->name ?? 'Product #' . $i->product_id)->toArray();
        $pieValues     = $totalSalesSum > 0
            ? $productSales->map(fn ($i) => round($i->total / $totalSalesSum * 100, 2))->toArray()
            : [];

        $pieColors = [
            '#8B0000', '#A52A2A', '#C0392B', '#D35400',
            '#E74C3C', '#922B21', '#CB4335', '#B03A2E',
            '#7B241C', '#641E16',
        ];

        $pieChart = new Chart;
        $pieChart->labels($pieLabels);
        $pieChart->dataset('Sales %', 'pie', $pieValues)->options([
            'backgroundColor'  => $pieColors,
            'hoverOffset'      => 6,
            'responsive'       => true,
            'maintainAspectRatio' => false,
            'animation'        => ['duration' => 0],
        ]);

        // ── QuickChart.io static image URLs (used by PDF & print fallback) ───
        [$barChartImgUrl, $yearlyChartImgUrl, $pieChartImgUrl] =
            $this->buildQuickChartUrls($salesByDate, $yearlySales, $pieLabels, $pieValues, $pieColors);

        return compact(
            'orders',
            'reportData',
            'totalRevenue',
            'totalOrders',
            'barChart',
            'yearlyChart',
            'yearlySales',
            'pieChart',
            'barChartImgUrl',
            'yearlyChartImgUrl',
            'pieChartImgUrl',
        );
    }

    // ─── Build QuickChart.io image URLs ─────────────────────────────────────────

    private function buildQuickChartUrls(
        $salesByDate,
        $yearlySales,
        array $pieLabels,
        array $pieValues,
        array $pieColors
    ): array {
        $base = 'https://quickchart.io/chart?bkg=white&';

        // ── Bar chart ────────────────────────────────────────────────────────
        $barLabels = $salesByDate->keys()
            ->map(fn ($d) => Carbon::parse($d)->format('M d'))
            ->values()
            ->toArray();

        $barConfig = [
            'type' => 'bar',
            'data' => [
                'labels'   => $barLabels,
                'datasets' => [[
                    'label'           => 'Sales (PHP)',
                    'data'            => $salesByDate->values()->map(fn ($v) => round($v, 2))->toArray(),
                    'backgroundColor' => '#8B0000',
                    'borderRadius'    => 3,
                ]],
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['display' => false],
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks'       => ['font' => ['size' => 11]],
                        'grid'        => ['color' => '#f0ede6'],
                    ],
                    'x' => [
                        'ticks' => [
                            'font'          => ['size' => 10],
                            'maxRotation'   => 45,
                            'maxTicksLimit' => 15,
                        ],
                        'grid' => ['display' => false],
                    ],
                ],
            ],
        ];

        $barChartImgUrl = $base . 'w=560&h=220&c=' . urlencode(json_encode($barConfig));

        // ── Yearly line chart ─────────────────────────────────────────────────
        $yearlyConfig = [
            'type' => 'line',
            'data' => [
                'labels'   => $yearlySales->keys()->values()->toArray(),
                'datasets' => [[
                    'data'                => $yearlySales->values()->map(fn ($v) => round($v, 2))->toArray(),
                    'borderColor'         => '#8B0000',
                    'backgroundColor'     => 'rgba(139,0,0,0.1)',
                    'fill'                => true,
                    'tension'             => 0.4,
                    'pointBackgroundColor'=> '#8B0000',
                    'pointRadius'         => 5,
                    'borderWidth'         => 2,
                ]],
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]],
                'scales'  => [
                    'y' => [
                        'beginAtZero' => false,
                        'ticks'       => ['font' => ['size' => 11]],
                        'grid'        => ['color' => '#f0ede6'],
                    ],
                    'x' => [
                        'ticks' => ['font' => ['size' => 11]],
                        'grid'  => ['display' => false],
                    ],
                ],
            ],
        ];

        $yearlyChartImgUrl = $base . 'w=265&h=200&c=' . urlencode(json_encode($yearlyConfig));

        // ── Pie chart ─────────────────────────────────────────────────────────
        $shortLabels = collect($pieLabels)
            ->map(fn ($l) => mb_strlen($l) > 22 ? mb_substr($l, 0, 19) . '...' : $l)
            ->toArray();

        $hasPieData = !empty($pieValues) && array_sum($pieValues) > 0;

        $pieConfig = [
            'type' => 'pie',
            'data' => [
                'labels'   => $hasPieData ? $shortLabels : ['No Data'],
                'datasets' => [[
                    'data'            => $hasPieData ? $pieValues : [1],
                    'backgroundColor' => $hasPieData
                        ? array_slice($pieColors, 0, count($pieValues))
                        : ['#e0dbd2'],
                ]],
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'position' => 'right',
                        'labels'   => [
                            'font'     => ['size' => 10],
                            'boxWidth' => 10,
                            'padding'  => 8,
                        ],
                    ],
                ],
            ],
        ];

        $pieChartImgUrl = $base . 'w=265&h=200&c=' . urlencode(json_encode($pieConfig));

        return [$barChartImgUrl, $yearlyChartImgUrl, $pieChartImgUrl];
    }

    // ─── Main reports page ───────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $type  = $request->get('type', 'monthly_sales');
        $start = $request->get('start_date', now()->subMonths(6)->startOfMonth()->toDateString());
        $end   = $request->get('end_date', now()->toDateString());

        $data = $this->buildReportData($type, $start, $end);

        return view('admin.reports.index', array_merge($data, compact('type', 'start', 'end')));
    }

    // ─── PDF download ────────────────────────────────────────────────────────────

    public function downloadPdf(Request $request)
    {
        $type  = $request->get('type', 'monthly_sales');
        $start = $request->get('start_date', now()->subMonths(6)->startOfMonth()->toDateString());
        $end   = $request->get('end_date', now()->toDateString());

        $data = $this->buildReportData($type, $start, $end);

        $reportLabel = match ($type) {
            'weekly_sales'    => 'Weekly Sales Report',
            'monthly_sales'   => 'Monthly Sales Report',
            'yearly_sales'    => 'Yearly Sales Report',
            'profit_expense'  => 'Profit & Expense Report',
            'top_products'    => 'Top Products Report',
            'customer_orders' => 'Customer Orders Report',
            default           => ucwords(str_replace('_', ' ', $type)) . ' Report',
        };

        $dateLabel = match ($type) {
            'yearly_sales' => 'Year',
            'weekly_sales' => 'Week',
            default        => 'Date',
        };

        $pdf = Pdf::loadView('admin.reports.pdf', array_merge($data, compact(
            'type', 'start', 'end', 'reportLabel', 'dateLabel'
        )))
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'sans-serif');

        $filename = strtolower(str_replace([' ', '&'], ['-', ''], $reportLabel))
            . '_' . $start . '_to_' . $end . '.pdf';

        return $pdf->download($filename);
    }
}
