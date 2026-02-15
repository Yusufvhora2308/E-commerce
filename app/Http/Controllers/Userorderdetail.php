<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class Userorderdetail extends Controller
{
    //

    public function index()
    {

           $user = Auth::user();

        // Fetch confirmed orders of the logged-in user
          $orders = $user->orders()->with('items')->orderBy('created_at','desc')->get();
          
        return view('users.userorderdetail',compact('user', 'orders'));
    }
}
