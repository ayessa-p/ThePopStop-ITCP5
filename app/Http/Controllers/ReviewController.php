<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:2000',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        if (! $this->canReview(auth()->id(), $product->id)) {
            return back()->with('error', 'You can only review products you have purchased and received.');
        }

        $orderId = $request->order_id;
        
        if (!$orderId) {
            $orderId = Order::where('user_id', auth()->id())
                ->where('status', 'Delivered')
                ->whereHas('orderItems', fn ($q) => $q->where('product_id', $product->id))
                ->latest()
                ->value('id');
        }

        if ($product->reviews()->where('user_id', auth()->id())->where('order_id', $orderId)->exists()) {
            return back()->with('error', 'You have already reviewed this product for this order.');
        }

        $validated['review_text'] = $this->filterBadWords($validated['review_text'] ?? '');

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'order_id' => $orderId,
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'],
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:2000',
        ]);

        $validated['review_text'] = $this->filterBadWords($validated['review_text'] ?? '');
        $review->update($validated);

        return back()->with('success', 'Review updated.');
    }

    protected function canReview(int $userId, int $productId): bool
    {
        return Order::where('user_id', $userId)
            ->where('status', 'Delivered')
            ->whereHas('orderItems', fn ($q) => $q->where('product_id', $productId))
            ->exists();
    }

    protected function filterBadWords(string $text): string
    {
        $words = ['damn', 'hell', 'crap', 'stupid', 'idiot', 'putangina', 'gago', 'tangina', 'bobo'];
        foreach ($words as $word) {
            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', str_repeat('*', strlen($word)), $text);
        }
        return $text;
    }
}
