<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Adminusercontrller extends Controller
{
    // Show All Users (Only Customers)
    public function User(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('role', 'customer')

            // SEARCH LOGIC (grouped properly)
            ->when($search, function ($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })

            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.adminuserdetails', compact('users'));
    }


    // Show Edit Form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.adminedituserdetail', compact('user'));
    }


    // Update User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.userdetail')
                         ->with('success', 'User updated successfully!');
    }


    // Delete User
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.userdetail')
                         ->with('success', 'User deleted successfully!');
    }

    public function changeStatus($id)
{
    $user = User::findOrFail($id);

    $user->status = $user->status === 'active' ? 'inactive' : 'active';
    $user->save();

    return redirect()->route('admin.userdetail')
                     ->with('success', 'User status updated successfully!');
}


public function view($id)
{
    $user = User::findOrFail($id); // Get user or 404

    return view('admin.user_view', compact('user'));
}


}
