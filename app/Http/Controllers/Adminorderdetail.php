<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\DB;

use App\Models\Product;

class Adminorderdetail extends Controller
{
    // Show orders + search + filter + pagination
    public function index(Request $request)
    {
        $query = Order::with(['items', 'user']);

        // Search
        if ($request->filled('search')) {
    $search = trim($request->search);

    $query->where(function ($q) use ($search) {

        // Order ID
        $q->where('id', 'LIKE', "%{$search}%")

        // First name OR Last name
        ->orWhere('first_name', 'LIKE', "%{$search}%")
        ->orWhere('last_name', 'LIKE', "%{$search}%")

        // ✅ Full Name Search
        ->orWhereRaw(
            "CONCAT(first_name, ' ', last_name) LIKE ?",
            ["%{$search}%"]
        )

        // Email
        ->orWhereHas('user', function ($u) use ($search) {
            $u->where('email', 'LIKE', "%{$search}%");
        });
    });
}

        // Filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.adminorderdetail', compact('orders'));
    }

    // Accept Order
 public function accept($id)
{
    DB::transaction(callback: function () use ($id) {

        $order = Order::with('items')->findOrFail($id);

        // Agar already accepted ho
        if ($order->status === 'Accepted') {
            return;
        }

        foreach ($order->items as $item) {

            $product = Product::find($item->product_id);

            if (!$product) {
                throw new \Exception('Product not found');
            }

            // ❌ Agar stock kam hai
            if ($product->stock < $item->quantity) {
                throw new \Exception('Not enough stock for '.$item->product_name);
            }

            // ✅ STOCK DECREMENT
            $product->stock -= $item->quantity;
            $product->save();
        }

        // ✅ ORDER STATUS UPDATE
        $order->status = 'Accepted';
        $order->save();
    });

    return back()->with('success', 'Order accepted  successfully!');
}


    // Deliver Order
    public function deliver($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'Accepted') {
            return back()->with('error', 'Only Accepted orders can be delivered!');
        }

        $order->status = 'Delivered';
        $order->save();

        return back()->with('success', 'Order Delivered Successfully!');
    }

    // Cancel Order
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'Delivered') {
            return back()->with('error', 'Delivered orders cannot be cancelled!');
        }

        $order->status = 'Cancelled';
        $order->save();

        return back()->with('success', 'Order Cancelled Successfully!');
    }

    // Bill View Page
    public function billview($id)
    {
        $order = Order::with('items', 'user')->findOrFail($id);
        return view('admin.adminbillview', compact('order'));
    }

    // Download Bill as PDF
    public function billPDF($id)
{
    $order = Order::with('items','user')->findOrFail($id);

    $pdf = Pdf::loadView('admin.adminbillpdf', compact('order'));
    return $pdf->download("Order_{$order->id}_Bill.pdf");
}
}
