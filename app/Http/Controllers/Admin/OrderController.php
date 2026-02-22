<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah');
    }

        public function updateLogistic(Request $request, Order $order)
    {
        $request->validate([
            'logistic_status' => 'required'
        ]);

        $order->logistic_status = $request->logistic_status;

        if ($request->logistic_status === 'shipped') {
            $order->shipped_at = now();
        }

        if ($request->logistic_status === 'delivered') {
            $order->delivered_at = now();
        }

        $order->save();

        return back()->with('success', 'Status logistik diperbarui');
    }
}

