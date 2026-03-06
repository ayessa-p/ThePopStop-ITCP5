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

        $query = Product::where('status', '!=', 'Out of Stock');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('series', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($brand !== '') {
            $query->where('brand', $brand);
        }

        $products = $query->orderByDesc('created_at')->limit(8)->get();
        $brands = Product::select('brand')->distinct()->orderBy('brand')->pluck('brand');

        $cartCount = 0;
        if (auth()->check()) {
            $cartCount = auth()->user()->cartItems()->sum('quantity');
        }

        return view('home', compact('products', 'brands', 'search', 'brand', 'cartCount'));
    }
}
