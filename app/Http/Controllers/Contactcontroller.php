<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;

class Contactcontroller extends Controller
{
    //

    public function index()
    {
        return view('Users.contact');
    }

      public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $data = new Contact();

        $data->name=$request->name;
        $data->email=$request->email;
        $data->subject=$request->subject;
        $data->message=$request->message;

        $data->save();

        return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}
