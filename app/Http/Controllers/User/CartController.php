<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     * Data diambil dari Session 'cart'.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    /**
     * Menambahkan produk ke dalam keranjang (Session).
     */
    public function add($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Ambil data keranjang saat ini dari session
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambah quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum ada, buat entry baru
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "quantity" => 1
            ];
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    /**
     * Menghapus satu item produk dari keranjang.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk dihapus');
    }

    /**
     * Mengosongkan seluruh isi keranjang.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')
            ->with('success', 'Semua produk di keranjang dihapus');
    }
}

