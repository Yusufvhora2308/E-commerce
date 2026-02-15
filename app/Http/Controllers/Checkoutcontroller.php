<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

use App\Models\Orderitem;

use Illuminate\Support\Facades\Auth;

use App\Models\Shipping_Charge;

use App\Models\Cart;

class Checkoutcontroller extends Controller
{
    //
 public function checkout()
{
    $cart = session()->get('cart', []);
    $subtotal = 0;

    foreach($cart as $item){
        $subtotal += $item['price'] * $item['quantity'];
    }

    // Set standard shipping to 0
    $standardCharge = 0;

    // Express shipping from database
    $expressCharge  = Shipping_Charge::where('id', 2)->value('charge_amount'); 

    return view('users.checkout',compact('subtotal','standardCharge','expressCharge','cart'));
}


    public function placeOrder(Request $request)
{
    // -----------------------------
    // VALIDATION
    // -----------------------------
    $request->validate([
        'first_name'      => 'required|string|max:50',
        'last_name'       => 'required|string|max:50',
        'address'         => 'required|string|max:255',
        'city'            => 'required|string|max:100',
        'state'           => 'required|string|max:100',
        'zip'             => 'required|numeric',
        'shipping_method' => 'required|in:standard,express',
        'payment_id'      => 'required|string'
    ]);

    // -----------------------------
    // CHECK CART
    // -----------------------------
    $cart = session()->get('cart', []);
    if(!$cart || count($cart) == 0){
        return redirect()->back()->with('error', 'Cart is empty.');
    }

    // -----------------------------
    // CALCULATE SUBTOTAL
    // -----------------------------
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    // -----------------------------
    // SHIPPING
    // -----------------------------
   if ($request->shipping_method === 'standard') {
    $shipping_cost = 0; // always zero
} else {
    $shipping_cost = Shipping_Charge::where('id', 2)->value('charge_amount');
}


    $total = $subtotal + $shipping_cost;

    // -----------------------------
    // SAVE ORDER
    // -----------------------------
    $order = Order::create([
        'user_id'        => Auth::id(),
        'first_name'     => $request->first_name,
        'last_name'      => $request->last_name,
        'address'        => $request->address,
        'city'           => $request->city,
        'state'          => $request->state,
        'zip'            => $request->zip,
        'shipping_method'=> $request->shipping_method,
        'shipping_cost'  => $shipping_cost,
        'subtotal'       => $subtotal,
        'total'          => $total,
         'payment_id'     => $request->payment_id,
        'payment_method' => $request->payment_method,
        'payment_status' => 'success',
        'status'         => 'Pending'
    ]);

    // -----------------------------
    // SAVE ORDER ITEMS
    // -----------------------------
    foreach($cart as $id => $item){
        Orderitem::create([
            'order_id'     => $order->id,
            'product_id'   => $id,
            'product_name' => $item['name'],
            'quantity'     => $item['quantity'],
            'price'        => $item['price'],
            'total'        => $item['price'] * $item['quantity']
        ]);
    }

    // -----------------------------
    // CLEAR CART
    // -----------------------------
    Cart::where('user_id', Auth::id())->delete();


    return redirect()
        ->route('order.bill', $order->id)
        ->with('success', 'Order placed successfully!');
}

 public function bill($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('Users.orderbill', compact('order'));
    }

}
