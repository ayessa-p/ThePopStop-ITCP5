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

        if ($search !== '') {
            // Laravel Scout Search (with result pagination)
            $products = Product::search($search)
                ->query(function ($query) use ($brand) {
                    $query->where('status', '!=', 'Out of Stock');
                    if ($brand !== '') {
                        $query->where('brand', $brand);
                    }
                })
                ->paginate(8);

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
