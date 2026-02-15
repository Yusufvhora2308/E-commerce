<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use App\Models\User;


class Logincontroller extends Controller
{
    //this method will show login page for customer

    public function index()
    {
        return view('login');
    }
    //this method will authenticate user
public function authenicate(Request $req)
{
    $validate = Validator::make($req->all(),[
        'email'=>'required|email',
        'password'=>'required'
    ]);

    if($validate->fails())
    {
        return redirect()->route('account.login')
            ->withInput()
            ->withErrors($validate);
    }

    // Attempt login
    if(Auth::attempt(['email' => $req->email, 'password' => $req->password]))
    {
        // STATUS CHECK — user cannot login if inactive
        if(Auth::user()->status === 'inactive')
        {
            Auth::logout();

            return redirect()->route('account.login')
                ->with('error', 'Your account is inactive. Please Wait the admin Approvel.');
        }

        // If active → login success
        return redirect()->route('account.dashboard');
    }

    // Wrong credentials
    return redirect()->route('account.login')
        ->with('error', 'Either email or password is incorrect');
}


    public function register()
    {
        return view('register');
    }

    //this page show register page

 public function proccessregister(Request $req)
{
    $validate = Validator::make($req->all(),[
        'name' => 'required|min:3',
        'email' => [
            'required',
            'email',
            'unique:users',
            'regex:/^[A-Za-z0-9._%+-]+@gmail\.(com|in)$/'
        ],
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
        ],
    ]);

    if ($validate->fails()) {
        return redirect()->route('account.register')
                         ->withInput()
                         ->withErrors($validate);
    }

    $user = new User();
    $user->name = $req->name;
    $user->email = $req->email;
    $user->password = Hash::make($req->password);
    $user->status = 'active'; // ⭐ important if status check exists
    $user->save();

    // ✅ AUTO LOGIN
    Auth::login($user);

    return redirect()->route('account.dashboard');
}


    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
