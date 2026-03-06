<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('admin');
    }

    public function index(Product $product)
    {
        $product->load('productPhotos');
        return view('admin.product-photos.index', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $maxOrder = $product->productPhotos()->max('display_order') ?? 0;

        foreach ($request->file('photos') as $file) {
            if (! $file->isValid()) {
                continue;
            }
            $path = $file->store('products', 'public');
            $product->productPhotos()->create([
                'photo_url' => $path,
                'is_primary' => false,
                'display_order' => ++$maxOrder,
            ]);
        }

        return back()->with('success', 'Photos uploaded.');
    }

    public function destroy(Product $product, ProductPhoto $photo)
    {
        if ($photo->product_id !== $product->id) {
            abort(403);
        }
        Storage::disk('public')->delete($photo->photo_url);
        $photo->delete();
        return back()->with('success', 'Photo deleted.');
    }

    public function setPrimary(Product $product, ProductPhoto $photo)
    {
        if ($photo->product_id !== $product->id) {
            abort(403);
        }
        $product->productPhotos()->update(['is_primary' => false]);
        $photo->update(['is_primary' => true]);
        return back()->with('success', 'Primary photo updated.');
    }
}
