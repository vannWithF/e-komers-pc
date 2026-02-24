<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function edit()
    {
        return view('users.shipping');
    }

   public function update(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'address' => 'required',
        'city' => 'required',
        'postal_code' => 'required'
    ]);

    auth()->user()->update($request->only([
        'phone',
        'address',
        'city',
        'postal_code'
    ]));

    return redirect()->route('checkout.index');
}

    
}