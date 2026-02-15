<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Adminsettingcontroller extends Controller
{
    public function index()
    {
        return view('admin.adminsetting');
    }

    public function update(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        // Get admin using admin guard
        $admin = auth()->guard('admin')->user();

        if (!$admin) {
            return back()->with('error', 'Admin not authenticated!');
        }

        // Check old password
        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->with('error', 'Old password is incorrect!');
        }

        // Update new password
        $admin->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
