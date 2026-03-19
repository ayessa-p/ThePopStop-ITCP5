<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

    public function index(Request $request)
    {
        $type = $request->get('type', 'monthly_sales');
        $start = $request->get('start_date', now()->subMonths(6)->startOfMonth()->toDateString());
        $end = $request->get('end_date', now()->toDateString());

        $startDate = Carbon::parse($start)->startOfDay();
        $endDate = Carbon::parse($end)->endOfDay();

        // 1. Bar Chart: Sales by Date Range (Grouped by Day/Month/Year based on range)
        $ordersQuery = Order::where('status', '!=', 'Cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at');

        $orders = $ordersQuery->get();
        
        // Grouping for bar chart
        $salesByDate = $orders->groupBy(fn ($o) => $o->created_at->format('Y-m-d'))
            ->map(fn ($group) => $group->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount));

        $barChart = new Chart;
        $barChart->labels($salesByDate->keys()->toArray());
        $barChart->dataset('Sales (₱)', 'bar', $salesByDate->values()->toArray())->options([
            'backgroundColor' => '#8B0000', // Maroon
            'borderColor' => '#000000',
            'borderWidth' => 1,
            'responsive' => true,
            'maintainAspectRatio' => false,
            'animation' => [
                'duration' => 0 // Disable animation to stop it from "moving"
            ]
        ]);

        // 2. Yearly Sales Chart (Line or Bar)
        $yearlySales = Order::where('status', '!=', 'Cancelled')
            ->whereYear('created_at', '>=', now()->subYears(5)->year)
            ->get()
            ->groupBy(fn ($o) => $o->created_at->year)
            ->map(fn ($group) => $group->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount))
            ->sortKeys();

        $yearlyChart = new Chart;
        $yearlyChart->labels($yearlySales->keys()->toArray());
        $yearlyChart->dataset('Yearly Sales (₱)', 'line', $yearlySales->values()->toArray())->options([
            'backgroundColor' => 'rgba(139, 0, 0, 0.1)',
            'borderColor' => '#8B0000',
            'borderWidth' => 3,
            'fill' => true,
            'tension' => 0.4,
            'responsive' => true,
            'maintainAspectRatio' => false,
            'animation' => [
                'duration' => 0 // Disable animation
            ]
        ]);

        // 3. Pie Chart: Sales % by Product
        $productSales = OrderItem::whereHas('order', fn ($q) => $q->where('status', '!=', 'Cancelled')
            ->whereBetween('created_at', [$startDate, $endDate]))
            ->selectRaw('product_id, sum(quantity * unit_price) as total')
            ->groupBy('product_id')
            ->with('product:id,name')
            ->get();

        $totalSalesSum = $productSales->sum('total');
        $pieLabels = $productSales->map(fn ($i) => $i->product?->name ?? 'Product #' . $i->product_id)->toArray();
        $pieValues = $totalSalesSum > 0
            ? $productSales->map(fn ($i) => round($i->total / $totalSalesSum * 100, 2))->toArray()
            : [];

        $pieChart = new Chart;
        $pieChart->labels($pieLabels);
        $pieChart->dataset('Sales %', 'pie', $pieValues)->options([
            'backgroundColor' => ['#8B0000', '#A52A2A', '#D2691E', '#DEB887', '#F5DEB3', '#000000'],
            'responsive' => true,
            'maintainAspectRatio' => false,
            'animation' => [
                'duration' => 0 // Disable animation
            ]
        ]);

        // 4. Data for the Table (as shown in screenshot)
        $reportData = $orders->groupBy(fn ($o) => $o->created_at->format('M d, Y'))
            ->map(function ($group) {
                return [
                    'orders_count' => $group->count(),
                    'total_sales' => $group->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount)
                ];
            });

        $totalRevenue = $orders->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount);
        $totalOrders = $orders->count();

        return view('admin.reports.index', compact(
            'barChart',
            'yearlyChart',
            'pieChart',
            'reportData',
            'totalRevenue',
            'totalOrders',
            'start',
            'end',
            'type'
        ));
    }
}
