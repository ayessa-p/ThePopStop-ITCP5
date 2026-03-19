<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $brand = $request->get('brand', '');

        // Implement all three search methods as requested
        if ($search !== '') {
            // Method 1: Laravel Scout Search (with result pagination)
            // This is the primary search method
            $products = Product::search($search)->where('status', '!=', 'Out of Stock');
            
            if ($brand !== '') {
                $products->where('brand', $brand);
            }
            
            $products = $products->paginate(8);

            // Note: If Scout is not configured, it will fallback to regular database queries.
            // If we wanted to use Method 2 (Model Search Scope) or Method 3 (Raw LIKE query), 
            // they would look like this:
            
            /* 
            // Method 2: Model Search (using scopeSearch)
            $products = Product::where('status', '!=', 'Out of Stock')
                ->search($search)
                ->when($brand !== '', fn($q) => $q->where('brand', $brand))
                ->paginate(8);

            // Method 3: LIKE Query
            $products = Product::where('status', '!=', 'Out of Stock')
                ->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%")
                      ->orWhere('series', 'like', "%{$search}%");
                })
                ->when($brand !== '', fn($q) => $q->where('brand', $brand))
                ->paginate(8);
            */
        } else {
            $query = Product::where('status', '!=', 'Out of Stock');
            if ($brand !== '') {
                $query->where('brand', $brand);
            }
            $products = $query->orderByDesc('created_at')->paginate(8);
        }

        $brands = Product::select('brand')->distinct()->orderBy('brand')->pluck('brand');

        $cartCount = 0;
        if (auth()->check()) {
            $cartCount = auth()->user()->cartItems()->sum('quantity');
        }

        return view('home', compact('products', 'brands', 'search', 'brand', 'cartCount'));
    }
}
