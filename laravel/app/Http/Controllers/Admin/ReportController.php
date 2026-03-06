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
        $period = $request->get('period', 'monthly');
        $start = $request->get('start_date', now()->subMonth()->toDateString());
        $end = $request->get('end_date', now()->toDateString());

        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        $ordersQuery = Order::with('orderItems')
            ->where('status', '!=', 'Cancelled')
            ->whereBetween('created_at', [$startDate->copy()->startOfDay(), $endDate->copy()->endOfDay()]);

        $salesData = clone $ordersQuery;
        $salesByDate = $salesData->get()->groupBy(fn ($o) => $o->created_at->format('Y-m-d'))->map(function ($orders) {
            return $orders->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount);
        });

        $barChart = new Chart;
        $barChart->labels($salesByDate->keys()->toArray());
        $barChart->dataset('Sales (₱)', 'bar', $salesByDate->values()->toArray())->options([
            'backgroundColor' => 'rgba(139, 69, 19, 0.8)',
        ]);

        $productSales = OrderItem::whereHas('order', fn ($q) => $q->where('status', '!=', 'Cancelled')
            ->whereBetween('created_at', [$startDate, $endDate]))
            ->selectRaw('product_id, sum(quantity * unit_price) as total')
            ->groupBy('product_id')
            ->with('product:id,name')
            ->get();

        $totalSales = $productSales->sum('total');
        $pieLabels = $productSales->map(fn ($i) => $i->product?->name ?? 'Product #' . $i->product_id)->toArray();
        $pieValues = $totalSales > 0
            ? $productSales->map(fn ($i) => round($i->total / $totalSales * 100, 2))->toArray()
            : [];

        $pieChart = new Chart;
        $pieChart->labels($pieLabels);
        $pieChart->dataset('Sales %', 'pie', $pieValues)->options([
            'backgroundColor' => ['#8B4513', '#D2691E', '#CD853F', '#DEB887', '#F5DEB3'],
        ]);

        $totalRevenue = Order::with('orderItems')
            ->where('status', '!=', 'Cancelled')
            ->whereBetween('created_at', [$startDate->copy()->startOfDay(), $endDate->copy()->endOfDay()])
            ->get()
            ->sum(fn ($o) => $o->subtotal - (float) $o->discount_amount);

        $orderCount = Order::where('status', '!=', 'Cancelled')
            ->whereBetween('created_at', [$startDate->copy()->startOfDay(), $endDate->copy()->endOfDay()])
            ->count();

        return view('admin.reports.index', compact(
            'barChart',
            'pieChart',
            'totalRevenue',
            'orderCount',
            'start',
            'end',
            'period'
        ));
    }
}
