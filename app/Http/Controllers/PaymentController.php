<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        // Pastikan hanya pemilik order
        if($order->user_id !== auth()->id()){
            abort(403);
        }

        return view('payment.show', compact('order'));
    }

    public function pay(Order $order)
    {
        if($order->user_id !== auth()->id()){
            abort(403);
        }

        if($order->status !== 'pending'){
            return redirect()->route('shop.index');
        }

        $order->update([
            'status' => 'paid'
        ]);

        return redirect()->route('payment.success', $order->id);
    }
}
