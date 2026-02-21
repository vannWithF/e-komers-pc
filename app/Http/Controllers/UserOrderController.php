<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                        ->latest()
                        ->paginate(10);

        return view('users.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan hanya pemilik
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('users.orders.show', compact('order'));
    }

    public function complete(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status === 'shipped') {
            $order->update([
                'status' => 'completed'
            ]);
        }

        return redirect()->back()->with('success', 'Pesanan diselesaikan');
    }
}
