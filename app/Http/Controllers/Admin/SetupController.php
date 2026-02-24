<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Setup;
use App\Models\Product;
use App\Models\Order;

class SetupController extends Controller
{
    public function index()
    {
        $setups = Setup::with('products')->latest()->get();
        $totalRevenue = Order::sum('total_price');

        return view('admin.setups.index', compact('setups', 'totalRevenue'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.setups.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'products' => 'required|array',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('setups', 'public');
        }

        $setup = Setup::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath
        ]);

        $setup->products()->attach($request->products);

        return redirect()
            ->route('admin.setups.index')
            ->with('success', 'Setup berhasil dibuat.');
    }

    public function edit(Setup $setup)
    {
        $products = Product::all();
        $selectedProducts = $setup->products->pluck('id')->toArray();

        return view('admin.setups.edit', compact('setup', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Setup $setup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'products' => 'required|array',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($setup->image) {
                Storage::disk('public')->delete($setup->image);
            }

            $setup->image = $request->file('image')
                ->store('setups', 'public');
        }

        $setup->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        $setup->products()->sync($request->products);

        return redirect()
            ->route('admin.setups.index')
            ->with('success', 'Setup berhasil diupdate.');
    }

    public function destroy(Setup $setup)
    {
        if ($setup->image) {
            Storage::disk('public')->delete($setup->image);
        }

        $setup->products()->detach();
        $setup->delete();

        return redirect()
            ->route('admin.setups.index')
            ->with('success', 'Setup berhasil dihapus.');
    }
}