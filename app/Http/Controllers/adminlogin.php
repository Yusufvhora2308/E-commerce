<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

class adminlogin extends Controller
{
    //
    public function index()
    {
        return view('adminlogin');
    }
        //this method will  Admin authenticate user
    public function authenicate(Request $req)
    {
        $validate = Validator::make($req->all(),[
            'email'=>'required |email',
            'password'=>'required'
        ]);

        if($validate->passes())
        {
            if(Auth::guard('admin')->attempt(['email'=>$req->email,'password'=>$req->password]))
            {
                if(Auth::guard('admin')->user()->role != "admin")
                {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','you are not authorized to access this page');
                }
                return redirect()->route('admin.dashboard');
            }
            else 
            {
                return redirect()->route('admin.login')->with('error',  'Either email or password is inccorect');
            }
        }
        else
        {
            return redirect()->route('admin.login')->withInput()->withErrors($validate);
        }
    }
    //this method logout admin user
    public function logout()
    {
        Auth::guard('admin')->logout();

         return redirect()->route('admin.login');

    }
}
