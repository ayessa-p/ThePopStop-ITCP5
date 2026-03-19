<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
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
            $query = Review::with(['user', 'product', 'order']);
            return DataTables::eloquent($query)
                ->addColumn('user_name', fn (Review $r) => $r->user->full_name ?? $r->user->username)
                ->addColumn('product_name', fn (Review $r) => $r->product->name ?? '-')
                ->addColumn('actions', function (Review $review) {
                    return '<form action="' . route('admin.reviews.destroy', $review) . '" method="POST" class="d-inline">' .
                        csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn-delete" onclick="return confirm(\'Delete this review?\')">Delete</button></form>';
                })
                ->rawColumns(['actions'])
                ->toJson();
        }

        return view('admin.reviews.index');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
