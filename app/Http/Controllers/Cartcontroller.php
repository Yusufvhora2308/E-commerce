<?php 
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show cart page
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $cartSession = [];

        foreach ($carts as $cart) {
            if ($cart->product && $cart->product->stock > 0) {
                $cartSession[$cart->product_id] = [
                    'name' => $cart->product->name,
                    'price' => $cart->product->price,
                    'quantity' => min($cart->quantity, $cart->product->stock),
                ];
            } else {
                $cart->delete();
            }
        }

        session(['cart' => $cartSession]);

        return view('Users.cart', compact('carts'));
    }

    // Add to cart
    public function add($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::where('user_id', auth()->id())
                ->where('product_id', $id)
                ->first();

        if ($cart) {
            if ($cart->quantity + 1 > $product->stock) {
                return response()->json(['error'=>true,'message'=>'Maximum stock reached!']);
            }
            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id'=>auth()->id(),
                'product_id'=>$id,
                'quantity'=>1
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['success'=>true]);
        }

        return back()->with('success','Added to cart!');
    }

    // Increment
    public function increment($id)
    {
        $cart = Cart::findOrFail($id);
        $product = $cart->product;

        if ($cart->quantity >= $product->stock) {
            return response()->json(['error'=>true, 'message'=>'Out of stock']);
        }

        $cart->quantity++;
        $cart->save();

        return response()->json([
            'success'=>true,
            'qty'=>$cart->quantity,
            'total'=>number_format($product->price * $cart->quantity, 2)
        ]);
    }

    // Decrement
    public function decrement($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->quantity == 1) {
            return response()->json(['error'=>true, 'message'=>'Minimum quantity reached']);
        }

        $cart->quantity--;
        $cart->save();

        return response()->json([
            'success'=>true,
            'qty'=>$cart->quantity,
            'total'=>number_format($cart->product->price * $cart->quantity, 2)
        ]);
    }

    // Remove item
    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }

    // ================= Checkout =================
 

}
