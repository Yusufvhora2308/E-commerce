<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    // ADD / TOGGLE WISHLIST
    public function add($productId)
    {
        $userId = auth()->id();

        $wishlist = Wishlist::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return response()->json(['status' => 'added']);
    }

    // SHOW WISHLIST (✅ images relation load)
    public function index()
    {
        $wishlists = Wishlist::with('product.images')
            ->where('user_id', auth()->id())
            ->get();

        return view('Users.wishlist', compact('wishlists'));
    }

    // REMOVE
    public function remove($productId)
{
    Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->delete();

    return response()->json(['success' => true]);
}

}
