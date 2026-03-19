<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('series', 'like', "%{$s}%")
                    ->orWhere('brand', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('series')) {
            $query->where('series', $request->series);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('created_at'),
        };

        $products = $query->paginate(12);
        $brands = Product::select('brand')->distinct()->orderBy('brand')->pluck('brand');
        $series = Product::select('series')->distinct()->orderBy('series')->pluck('series');
        $types = Product::select('type')->distinct()->whereNotNull('type')->orderBy('type')->pluck('type');

        $cartCount = auth()->check() ? auth()->user()->cartItems()->sum('quantity') : 0;

        return view('products.index', compact('products', 'brands', 'series', 'types', 'cartCount'));
    }

    public function show(Product $product)
    {
        $product->load(['productPhotos', 'reviews.user']);
        $reviews = $product->reviews()->with('user')->orderByDesc('created_at')->get();
        $avgRating = $reviews->avg('rating') ? round($reviews->avg('rating'), 1) : 0;

        $canReview = false;
        $userReview = null;
        if (auth()->check()) {
            $canReview = $this->canReviewProduct(auth()->id(), $product->id);
            $userReview = $product->reviews()->where('user_id', auth()->id())->first();
        }

        $cartCount = auth()->check() ? auth()->user()->cartItems()->sum('quantity') : 0;

        return view('products.show', compact('product', 'reviews', 'avgRating', 'canReview', 'userReview', 'cartCount'));
    }

    protected function canReviewProduct(int $userId, int $productId): bool
    {
        return \DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->where('order_items.product_id', $productId)
            ->where('orders.status', 'Delivered')
            ->exists();
    }
}
