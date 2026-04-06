<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Setup;

class ShopController extends Controller
{
    /**
     * Halaman depan toko: Menampilkan produk terbaru, kategori, dan setup piliihan.
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->latest()
            ->paginate(8);

        $categories = Category::all();

        // Mengambil 3 setup terbaru untuk ditampilkan di landing page
        $setups = Setup::latest()->take(3)->get();

        return view('shop.index', compact('products', 'categories', 'setups'));
    }

    /**
     * Menampilkan detail satu produk.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('shop.show', compact('product'));
    }

    /**
     * Filter produk berdasarkan kategori.
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(8);
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan daftar semua Setup PC yang tersedia.
     */
    public function setups()
    {
        $setups = Setup::latest()->get();
        return view('shop.setups', compact('setups'));
    }

    /**
     * Logika khusus: Menambahkan seluruh komponen dalam sebuah Setup ke dalam keranjang.
     */
    public function addSetupToCart(Setup $setup)
    {
        $cart = session()->get('cart', []);

        // Loop setiap produk yang terikat dalam Setup ini
        foreach ($setup->products as $product) {

            if(isset($cart[$product->id])) {
                $cart[$product->id]['quantity']++;
            } else {
                $cart[$product->id] = [
                    "name" => $product->name,
                    "price" => $product->price,
                    "image" => $product->image,
                    "quantity" => 1
                ];
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Setup berhasil ditambahkan ke keranjang');
    }
}

