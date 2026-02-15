<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class Profilecontroller extends Controller
{
    // Show user profile
    public function index()
    {
        $user = Auth::user();

        // Fetch confirmed orders of the logged-in user
          $orders = $user->orders()->with('items')->orderBy('created_at','desc')->get();


        return view('Users.userprofile', compact('user', 'orders'));
    }

    // Update user profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function changepass()
    {
        return view('Users.userchangepass');
    }


    public function updatePassword(Request $request)
{
    $request->validate([
        'old_password'      => 'required',
        'new_password'      => 'required|min:6',
        'confirm_password'  => 'required|same:new_password',
    ]);

    $user = Auth::user();

    // Check Old Password
    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'Old password is incorrect']);
    }

    // Update Password
    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return redirect()->back()->with('success', 'Password updated successfully!');
}

}
