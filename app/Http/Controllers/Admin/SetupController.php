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
    /**
     * Menampilkan daftar setup di dashboard admin.
     */
    public function index()
    {
        // Eager load products untuk optimalisasi query
        $setups = Setup::with('products')->latest()->get();
        $totalRevenue = Order::sum('total_price');

        return view('admin.setups.index', compact('setups', 'totalRevenue'));
    }

    /**
     * Form pembuatan setup baru.
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.setups.create', compact('products'));
    }

    /**
     * Menyimpan setup baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'required|array',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('setups', 'public');
        }

        // Kalkulasi harga setup otomatis dari total harga produk komponennya
        $calculatedPrice = Product::whereIn('id', $request->products)->sum('price');

        $setup = Setup::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $calculatedPrice,
            'image' => $imagePath
        ]);

        // Simpan relasi many-to-many ke table setup_items
        $setup->products()->attach($request->products);

        return redirect()
            ->route('admin.setups.index')
            ->with('success', 'Setup berhasil dibuat.');
    }

    public function edit(Setup $setup)
    {
        $products = Product::all();
        $selectedProducts = $setup->products->pluck('id')->toArray();

        return view('admin.setups.create', compact('setup', 'products', 'selectedProducts'));
    }

    /**
     * Mengupdate data setup dan sinkronisasi produk komponen.
     */
    public function update(Request $request, Setup $setup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'required|array',
        ]);

        if ($request->hasFile('image')) {
            if ($setup->image) {
                Storage::disk('public')->delete($setup->image);
            }
            $setup->image = $request->file('image')->store('setups', 'public');
        }

        $calculatedPrice = Product::whereIn('id', $request->products)->sum('price');

        $setup->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $calculatedPrice
        ]);

        // Sinkronisasi produk (menghapus yang tidak ada di request, menambah yang baru)
        $setup->products()->sync($request->products);

        return redirect()
            ->route('admin.setups.index')
            ->with('success', 'Setup berhasil diupdate.');
    }

    /**
     * Menghapus setup dan relasi produknya.
     */
    public function destroy(Setup $setup)
    {
        if ($setup->image) {
            Storage::disk('public')->delete($setup->image);
        }

        // Putus hubungan many-to-many sebelum delete setup
        $setup->products()->detach();
        $setup->delete();

        return redirect()
            ->route('admin.setups.index')
            ->with('success', 'Setup berhasil dihapus.');
    }
}