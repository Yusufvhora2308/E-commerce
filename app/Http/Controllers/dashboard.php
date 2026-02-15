<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;

use App\Models\Cart;


class dashboard extends Controller
{
    public function dashboard()
    {
        $mobile = Product::with('images')->whereHas('category', function($q){
            $q->where('name','Mobile');
        })->latest()->first();

        $laptop = Product::with('images')->whereHas('category', function($q){
            $q->where('name','Laptop');
        })->latest()->first();

        $products = Product::with('images')->latest()->take(12)->get()->map(function($product) {
            $product->rating = rand(30, 50) / 10;
            $product->reviews_count = rand(10, 200);
            $product->is_new = rand(0, 1);
            $product->on_sale = rand(0, 1);
            $product->original_price = $product->price + 50;
            $product->sale_price = $product->price;
            $product->discount_percentage = 20;
            return $product;
        });

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


        return view(
            'Users.dashboard',
            compact('mobile','laptop','products','wishlistIds','cartProductIds')
        );
    }

  public function show($id)
{
    $product = Product::findOrFail($id);

    $cartProductIds = [];

    if (auth()->check()) {
        $cartProductIds = Cart::where('user_id', auth()->id())
            ->pluck('product_id')
            ->toArray();
    }

    return view('Users.quickview', compact('product','cartProductIds'));
}

}
