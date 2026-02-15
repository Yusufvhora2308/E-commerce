<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Shipping_Charge;

class ShippingChargeController extends Controller
{
    //

      // List page
    public function index()
    {
        $charges = Shipping_Charge::orderBy('id', 'DESC')->paginate(10);
        return view('admin.adminshipping', compact('charges'));
    }

    // Edit page
    public function edit($id)
    {
        $charge = Shipping_Charge::findOrFail($id);
        return view('admin.adminshippingedit', compact('charge'));
    }

    // Update shipping charge
    public function update(Request $req, $id)
    {
        $charge = Shipping_Charge::findOrFail($id);
        $charge->charge_amount = $req->charge_amount;
        $charge->save();

        return redirect()->route('shipping.index')->with('success', 'Shipping charge updated successfully!');
    }
}
