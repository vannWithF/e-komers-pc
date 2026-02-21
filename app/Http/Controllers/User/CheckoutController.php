<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (!auth()->user()->phone) {
        return redirect()->route('shipping.edit')
            ->with('error', 'Lengkapi data pengiriman dulu');
    }

        if(empty($cart)){
            return redirect()->route('cart.index');
        }

        return view('checkout.index', compact('cart'));
    }

    public function process()
    {
        $cart = session()->get('cart', []);

        if(empty($cart)){
            return redirect()->route('cart.index');
        }

        $total = 0;

        foreach($cart as $id => $item){
            $total += $item['price'] * $item['quantity'];
        }

        $shipping = 20000; // flat shipping simple UKK

        $order = Order::create([
            'user_id' => auth()->id(),
            'invoice' => 'INV-' . strtoupper(Str::random(8)),
            'total_price' => $total + $shipping,
            'shipping_cost' => $shipping,
            'status' => 'pending'
        ]);

        foreach($cart as $id => $item){

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Kurangi stock
            $product = Product::find($id);
            $product->decrement('stock', $item['quantity']);
        }

        session()->forget('cart');

        return redirect()->route('payment.show', $order->id);
    }
}
