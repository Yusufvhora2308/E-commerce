<?php

namespace App\Http\Controllers;

use App\Models\Product;

class Aboutcontroller extends Controller
{
    public function index()
    {
        $mobile = Product::with('images')
            ->whereHas('category', fn($q) => $q->where('name','Mobile'))
            ->latest()
            ->first();

        $laptop = Product::with('images')
            ->whereHas('category', fn($q) => $q->where('name','Laptop'))
            ->latest()
            ->first();

        $products = Product::with('images')
            ->latest()
            ->take(12)
            ->get();

        return view('users.aboutus', compact('mobile','laptop','products'));
    }
}
