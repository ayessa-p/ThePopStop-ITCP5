<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::withTrashed();
            return DataTables::eloquent($query)
                ->addColumn('image', function (Product $p) {
                    return '<img src="' . $p->photo_url . '" class="product-thumb" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">';
                })
                ->editColumn('price', fn(Product $p) => '₱' . number_format($p->price, 2))
                ->editColumn('cost_price', fn(Product $p) => '₱' . number_format($p->cost_price, 2))
                ->addColumn('actions', function (Product $p) {
                    if ($p->trashed()) {
                        return '<form action="' . route('admin.products.restore', $p->id) . '" method="POST" class="d-inline">' .
                            csrf_field() .
                            '<button type="submit" class="btn-action restore">Restore</button></form>';
                    }
                    return '<div class="action-stack">' .
                        '<a href="' . route('admin.products.photos.index', $p) . '" class="btn-action photos"><span>📷</span> Photos</a> ' .
                        '<a href="' . route('admin.products.edit', $p) . '" class="btn-action edit">Edit</a> ' .
                        '<form action="' . route('admin.products.destroy', $p) . '" method="POST" class="d-inline">' .
                        csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn-action delete" onclick="return confirm(\'Delete?\')">Delete</button></form>' .
                        '</div>';
                })
                ->rawColumns(['image', 'actions'])
                ->toJson();
        }

        return view('admin.products.index');
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        unset($data['image']);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('products', 'public');
        } else {
            $data['image_url'] = null;
        }

        $product = Product::create($data);
        $product->updateStatus();

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        $product->load(['productPhotos', 'reviews.user']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        unset($data['image']);

        if ($request->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $product->updateStatus();

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function restore(int $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.index')->with('success', 'Product restored.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            @set_time_limit(300);
            @ini_set('max_execution_time', '300');
            Excel::import(new ProductsImport, $request->file('file'));
            return back()->with('success', 'Products imported successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
