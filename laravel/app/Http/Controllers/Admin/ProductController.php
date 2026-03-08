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
                ->addColumn('actions', function (Product $p) {
                    if ($p->trashed()) {
                        return '<form action="' . route('admin.products.restore', $p->id) . '" method="POST" class="d-inline">' .
                            csrf_field() .
                            '<button type="submit" class="btn btn-sm btn-secondary">Restore</button></form>';
                    }
                    return '<a href="' . route('admin.products.edit', $p) . '" class="btn btn-sm btn-secondary">Edit</a> ' .
                        '<a href="' . route('admin.products.photos.index', $p) . '" class="btn btn-sm btn-secondary">Photos</a> ' .
                        '<form action="' . route('admin.products.destroy', $p) . '" method="POST" class="d-inline">' .
                        csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete?\')">Delete</button></form>';
                })
                ->rawColumns(['actions'])
                ->toJson();
        }

        $query = Product::withTrashed()->orderByDesc('created_at');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('sku', 'like', "%{$s}%")
                    ->orWhere('brand', 'like', "%{$s}%");
            });
        }

        $products = $query->paginate(15);

        return view('admin.products.index', compact('products'));
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
