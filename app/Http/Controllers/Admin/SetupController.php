<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setup;
use App\Models\Product;

class SetupController extends Controller
{
    public function index()
    {
        $setups = Setup::latest()->get();
        return view('admin.setups.index', compact('setups'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.setups.create', compact('products'));
    }

    public function store(Request $request)
    {
        $setup = Setup::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $setup->products()->attach($request->products);

        return redirect()->route('setups.index');
    }
}
