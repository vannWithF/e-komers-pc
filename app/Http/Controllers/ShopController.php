<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Setup;

class ShopController extends Controller
{
public function index()
{
    $products = Product::where('is_active', true)
        ->latest()
        ->paginate(8);

    $categories = Category::all();

    $setups = Setup::latest()->take(3)->get(); // 🔥 TAMBAHKAN INI

    return view('shop.index', compact('products', 'categories', 'setups'));
}

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('shop.show', compact('product'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(8);
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }

public function setups()
{
    $setups = Setup::latest()->get();
    return view('shop.setups', compact('setups'));
}

public function addSetupToCart(Setup $setup)
{
    $cart = session()->get('cart', []);

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

