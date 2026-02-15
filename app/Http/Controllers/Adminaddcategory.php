<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categoryy;

use App\Models\Brand;

class Adminaddcategory extends Controller
{
    //
    public function addcategory()
    {
         $brands = Brand::all();
        return view('admin.adminaddcategory',compact('brands'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get original image name
        $imageName = $request->image->getClientOriginalName();

        // Move image to public folder
        $request->image->move(public_path('uploads/categories'), $imageName);

        // Save in database
        $category = new Categoryy();
        $category->name = $request->name;
        $category->brand_id = $request->brand_id;
        $category->image = $imageName;
        $category->save();

        return redirect()->route('admin.showcategory')->with('success', 'Category Added Successfully!');
    }

    public function showcategory(Request $request)
{
    $search = $request->input('search');

   $categories = Categoryy::with('brand')
    ->when($search, function ($query, $search) {
        $query->where('name', 'like', "%{$search}%");
    })
    ->orderBy('id', 'desc')
    ->paginate(10);

    return view('admin.adminshowcategory', compact('categories'));
}


     public function edit($id)
    {
        $category = Categoryy::findOrFail($id);
            $brands = Brand::all();
        return view('admin.admineditcategory', compact('category','brands'));
    }

        public function update(Request $request, $id)
    {
        $category = Categoryy::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
                'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/categories'), $imageName);
            $category->image = $imageName;
        }

        $category->name = $request->name;
        $category->brand_id = $request->brand_id;
        $category->save();

        return redirect()->route('admin.showcategory')->with('success', 'Category Updated Successfully!');
    }

    // Delete category
    public function destroy($id)
    {
        $category = Categoryy::findOrFail($id);

        $imagePath = public_path('uploads/categories/' . $category->image);
        if(file_exists($imagePath)) unlink($imagePath);

        $category->delete();

        return redirect()->back()->with('success', 'Category Deleted Successfully!');
    }


}
