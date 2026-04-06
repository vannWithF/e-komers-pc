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
    /**
     * Menampilkan halaman ringkasan pesanan sebelum pembayaran.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        // Pastikan user sudah melengkapi nomor HP/data pengiriman
        if (!auth()->user()->phone) {
            return redirect()->route('shipping.edit')
                ->with('error', 'Lengkapi data pengiriman dulu');
        }

        // Jangan izinkan checkout jika keranjang kosong
        if(empty($cart)){
            return redirect()->route('cart.index');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Memproses database transaksi dari data keranjang session.
     */
    public function process()
    {
        $cart = session()->get('cart', []);

        if(empty($cart)){
            return redirect()->route('cart.index');
        }

        $total = 0;
        // Hitung total harga barang
        foreach($cart as $id => $item){
            $total += $item['price'] * $item['quantity'];
        }

        $shipping = 20000; // Biaya ongkir flat

        // 1. Buat Header Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'invoice' => 'INV-' . strtoupper(Str::random(8)),
            'total_price' => $total + $shipping,
            'shipping_cost' => $shipping,
            'status' => 'pending'
        ]);

        // 2. Buat Detail Order
        foreach($cart as $id => $item){

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // 3. Kurangi stok produk secara real-time
            $product = Product::find($id);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // 4. Kosongkan keranjang setelah order dibuat
        session()->forget('cart');

        // Lanjut ke halaman pembayaran (Midtrans/Manual)
        return redirect()->route('payment.show', $order->id);
    }
}
