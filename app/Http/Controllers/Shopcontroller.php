<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\Brand;

use App\Models\Categoryy;

use App\Models\Wishlist;

use App\Models\Cart;

class Shopcontroller extends Controller
{
    //

  public function index(Request $request)
{
    $mobile = Product::whereHas('category', function($q){
        $q->where('name','Mobile');
    })->latest()->first();

    $laptop = Product::whereHas('category', function($q){
        $q->where('name','Laptop');
    })->latest()->first();

    $brands = Brand::all();
    $categories = Categoryy::all();

    $query = Product::query();

    // SEARCH FILTER
    if ($request->search) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    }

    // Filter by Brand
    if ($request->brand) {
        $query->where('brand_id', $request->brand);
    }

    // Filter by Category
    if ($request->category) {
        $query->where('category_id', $request->category);
    }

    // Filter by Price
    if ($request->min_price) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->max_price) {
        $query->where('price', '<=', $request->max_price);
    }

    // Filter by Rating
    if ($request->rating) {
        $query->where('rating', '>=', $request->rating);
    }

    // Filter by Availability (stock > 0)
    if ($request->availability == 'in_stock') {
        $query->where('stock', '>', 0);
    }

    // Filter Featured
    if ($request->featured == "1") {
        $query->where('featured', true);
    }

    // Filter by status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // SORTING
    if ($request->sort) {
        if ($request->sort == 'low_high') {
            $query->orderBy('price', 'asc');
        }
        if ($request->sort == 'high_low') {
            $query->orderBy('price', 'desc');
        }
    } else {
        $query->latest(); // default sorting by newest
    }

    $products = $query->paginate(12);




     // ✅ IMPORTANT PART
        $wishlistIds = [];
        if (auth()->check()) {
            $wishlistIds = Wishlist::where('user_id', auth()->id())
                ->pluck('product_id')
                ->toArray();
        }

            $cartProductIds = [];

            $cartProductIds = Cart::where('user_id', auth()->id())
            ->pluck('product_id')
            ->toArray();



    return view('Users.Shop', compact('products', 'brands', 'categories','mobile','laptop','wishlistIds','cartProductIds'));
}
}
