<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Brand;

class Adminbrandcontroller extends Controller
{
    //

    public function index()
    {
        return view('admin.adminbrand');
    }

    public function brandvalidate(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Get original file name  
    $imageName = $request->image->getClientOriginalName();

    // Upload image with original name
    $request->image->move(public_path('uploads/brands'), $imageName);

    $add = new Brand();
    $add->name = $request->name;
    $add->description = $request->description;
    $add->image = $imageName; // original name stored here
    $add->save();

    return redirect()->route('admin.showbrand')->with('success', 'Brand Added Successfully!');
}

    public function showbrand(Request $request)
{
    $search = $request->input('search');

    $brands = Brand::query()
        ->when($search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

    return view('admin.adminshowbrand', compact('brands'));
}



    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.admineditbrand', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/brands'), $imageName);
            $brand->image = $imageName;
        }

        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->save();

        return redirect()->route('admin.showbrand')->with('success', 'Brand Updated Successfully!');
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);

        $imagePath = public_path('uploads/brands/' . $brand->image);
        if (file_exists($imagePath)) unlink($imagePath);

        $brand->delete();

        return redirect()->back()->with('success', 'Brand Deleted Successfully!');
    }

}
