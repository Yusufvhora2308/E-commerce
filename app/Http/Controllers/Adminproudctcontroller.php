<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Categoryy;
use App\Models\Product;

use App\Models\Product_image;

class Adminproudctcontroller extends Controller
{
    // Show Add Product Form
    public function addproduct()
    {
        $brands = Brand::all();
        $categories = Categoryy::all();

        return view('admin.adminaddproduct', compact('brands', 'categories'));
    }

    // Store Product
public function store(Request $req)
{
    $req->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|min:10',
        'price' => 'required|numeric|min:1',
        'discount' => 'required|numeric|min:0|max:100',
        'stock' => 'required|integer|min:0|max:10000',

        // 🔴 MULTIPLE IMAGES VALIDATION
        'images' => 'required',
        'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

        'weight' => 'required|string|max:50',
        'dimensions' => 'required|string|max:100',
        'warranty' => 'required|string|max:100',
        'rating' => 'required|numeric|min:0|max:5',
        'brand_id' => 'required|exists:brands,id',
        'category_id' => 'required|exists:categoryys,id',
    ]);

    // 🔹 SAVE PRODUCT
    $product = new Product();
    $product->name = $req->name;
    $product->description = $req->description;
    $product->price = $req->price;
    $product->discount = $req->discount ?? 0;
    $product->stock = $req->stock;
    $product->weight = $req->weight;
    $product->dimensions = $req->dimensions;
    $product->warranty = $req->warranty;
    $product->rating = $req->rating ?? 0;
    $product->brand_id = $req->brand_id;
    $product->category_id = $req->category_id;
    $product->save();

    // 🔹 SAVE MULTIPLE IMAGES
    if ($req->hasFile('images')) {
        foreach ($req->file('images') as $image) {

            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);

            Product_image::create([
                'product_id' => $product->id,
                'image' => $imageName,
            ]);
        }
    }

    return redirect()
        ->route('admin.showproduct')
        ->with('success', 'Product Added Successfully with Multiple Images!');
}

public function showproduct(Request $request)
{
  $query = Product::with(['brand','category','images'])->latest();


    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%")
              ->orWhereHas('brand', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('category', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
    }

    $products = $query->Paginate(10);
    return view('admin.adminshowproduct', compact('products'));
}


  public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Categoryy::all();
        return view('admin.admineditproduct', compact('product','brands','categories'));
    }


  public function updateproduct(Request $req, $id)
{
    $product = Product::with('images')->findOrFail($id);

    $rules = [
        'name'        => 'required|string|max:255',
        'description' => 'required|string|min:10',
        'price'       => 'required|numeric|min:1',
        'discount'    => 'required|numeric|min:0|max:100',
        'stock'       => 'required|integer|min:0|max:10000',
        'weight'      => 'required|string|max:50',
        'dimensions'  => 'required|string|max:100',
        'warranty'    => 'required|string|max:100',
        'rating'      => 'required|numeric|min:0|max:5',
        'brand_id'    => 'required|exists:brands,id',
        'category_id' => 'required|exists:categoryys,id',
        'status'      => 'required|in:active,inactive',
    ];

    // 🔴 If no existing images → images required
    if ($product->images->count() == 0) {
        $rules['images'] = 'required';
        $rules['images.*'] = 'image|mimes:jpg,jpeg,png,webp|max:2048';
    } else {
        // Optional images
        $rules['images.*'] = 'image|mimes:jpg,jpeg,png,webp|max:2048';
    }

    $req->validate($rules);

    // UPDATE PRODUCT
    $product->update([
        'name'        => $req->name,
        'description' => $req->description,
        'price'       => $req->price,
        'discount'    => $req->discount,
        'stock'       => $req->stock,
        'weight'      => $req->weight,
        'dimensions'  => $req->dimensions,
        'warranty'    => $req->warranty,
        'rating'      => $req->rating,
        'brand_id'    => $req->brand_id,
        'category_id' => $req->category_id,
        'status'      => $req->status,
    ]);

    // SAVE MULTIPLE IMAGES
    if ($req->hasFile('images')) {
        foreach ($req->file('images') as $image) {
            $name = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $name);

            Product_image::create([
                'product_id' => $product->id,
                'image'      => $name
            ]);
        }
    }

    return redirect()
        ->route('admin.showproduct')
        ->with('success', 'Product updated successfully!');
}

// Delete Product
public function deleteproduct($id)
{
    $product = Product::findOrFail($id);

    if ($product->image && file_exists(public_path('uploads/products/'.$product->image))) {
        unlink(public_path('uploads/products/'.$product->image));
    }

    $product->delete();

    return redirect()->route('admin.showproduct')->with('success', 'Product deleted successfully!');
}

public function deleteImage($id)
{
    $image = Product_image::findOrFail($id);

    if (file_exists(public_path('uploads/products/'.$image->image))) {
        unlink(public_path('uploads/products/'.$image->image));
    }

    $image->delete();

    return response()->json(['success' => true]);
}



}  