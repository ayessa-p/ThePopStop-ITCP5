<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Mail\PurchaseOrderStatusUpdated;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('admin');
    }

    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['supplier', 'purchaseOrderItems'])
            ->orderByDesc('order_date')
            ->paginate(15);

        return view('admin.purchase-orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('brand')->get();
        $products = Product::orderBy('name')->get(['id', 'name', 'sku']);
        return view('admin.purchase-orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'notes' => 'nullable|string',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'unit_costs' => 'required|array',
            'unit_costs.*' => 'numeric|min:0',
        ]);

        $po = PurchaseOrder::create([
            'supplier_id' => $validated['supplier_id'],
            'order_date' => $validated['order_date'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'Ordered',
        ]);

        foreach ($validated['product_ids'] as $i => $productId) {
            if (empty($productId) || empty($validated['quantities'][$i] ?? 0) || empty($validated['unit_costs'][$i] ?? null)) {
                continue;
            }
            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'product_id' => $productId,
                'quantity' => (int) $validated['quantities'][$i],
                'unit_cost' => (float) $validated['unit_costs'][$i],
            ]);
        }

        return redirect()->route('admin.purchase-orders.index')->with('success', 'Purchase order created.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'purchaseOrderItems.product']);
        return view('admin.purchase-orders.show', compact('purchaseOrder'));
    }

    public function receipt(PurchaseOrder $purchaseOrder)
    {
        $pdf = \PDF::loadView('admin.purchase-orders.receipt', compact('purchaseOrder'));
        return $pdf->stream('purchase-order-' . $purchaseOrder->id . '.pdf');
    }

    public function updateStatus(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'status' => 'required|in:Ordered,Shipped,Received',
        ]);

        $oldStatus = $purchaseOrder->status;
        $purchaseOrder->update(['status' => $request->status]);

        if ($request->status === 'Received' && $oldStatus !== 'Received') {
            foreach ($purchaseOrder->purchaseOrderItems as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
                $item->product->updateStatus();
            }
        }

        Mail::to($purchaseOrder->supplier->email)->send(new PurchaseOrderStatusUpdated($purchaseOrder));

        return redirect()->route('admin.purchase-orders.index')->with('success', 'Purchase order status updated.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();
        return redirect()->route('admin.purchase-orders.index')->with('success', 'Purchase order deleted.');
    }
}
