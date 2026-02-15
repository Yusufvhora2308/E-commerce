<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Categoryy;

class admindashboard extends Controller
{
    public function index()
    {
        // Order Counts
        $totalOrders     = Order::count();
        $deliveredOrders = Order::where('status', 'Delivered')->count();
        $pendingOrders   = Order::where('status', 'Pending')->count();

        // Amount Calculations
        $totalAmount         = Order::sum('total');
        $deliveredAmount     = Order::where('status', 'Delivered')->sum('total');

        // Product, Brand, Category Counts
        $totalProducts  = Product::count();
        $totalBrands    = Brand::count();
        $totalCategories = Categoryy::count();

        // Recent Orders (with items)
        $recentOrders = Order::with('items')
                        ->latest()
                        ->take(10)
                        ->get();

        return view('admin.admindash', compact(
            'totalOrders',
            'deliveredOrders',
            'pendingOrders',
            'totalAmount',
            'deliveredAmount',
            'totalProducts',
            'totalBrands',
            'totalCategories',
            'recentOrders'
        ));
    }
}
