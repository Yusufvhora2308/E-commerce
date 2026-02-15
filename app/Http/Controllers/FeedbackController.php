<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;

class FeedbackController extends Controller
{
    //


     // Show list
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.adminfeedback', compact('contacts'));
    }

    public function show($id)
{
    $contact = Contact::findOrFail($id);    
    return view('admin.adminviewfeedback', compact('contact'));
}


    
}
