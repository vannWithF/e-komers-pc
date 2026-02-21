@extends('layouts.app')

@section('content')

<style>
    .setup-wrapper {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', sans-serif;
    }

    .setup-card {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .form-title {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 25px;
        color: #111;
        border-left: 5px solid #4A90E2;
        padding-left: 15px;
    }

    .input-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #444;
    }

    input[type="text"], textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #f0f0f0;
        border-radius: 8px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    input:focus, textarea:focus {
        outline: none;
        border-color: #4A90E2;
    }

    /* Grid Produk */
    .product-selection {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin: 20px 0;
    }

    .product-item {
        position: relative;
        display: flex;
        align-items: center;
        padding: 12px;
        border: 2px solid #f0f0f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .product-item:hover {
        background-color: #f8fbff;
        border-color: #4A90E2;
    }

    /* Sembunyikan Checkbox Asli */
    .product-item input[type="checkbox"] {
        margin-right: 12px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    /* Style saat checkbox dicentang */
    .product-item:has(input:checked) {
        background-color: #eef6ff;
        border-color: #4A90E2;
        box-shadow: 0 4px 10px rgba(74, 144, 226, 0.1);
    }

    .product-name {
        font-size: 0.95rem;
        font-weight: 500;
        color: #333;
    }

    .btn-save {
        background: #4A90E2;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1rem;
        width: 100%;
        cursor: pointer;
        margin-top: 20px;
        transition: transform 0.2s, background 0.3s;
    }

    .btn-save:hover {
        background: #357ABD;
        transform: translateY(-2px);
    }
</style>

<div class="setup-wrapper">
    <div class="setup-card">
        <h2 class="form-title">Konfigurasi Setup Baru</h2>

        <form action="{{ route('setups.store') }}" method="POST">
            @csrf

            <div class="input-group">
                <label>Nama Setup</label>
                <input type="text" name="name" placeholder="Misal: Gaming Room 2024" required>
            </div>

            <div class="input-group">
                <label>Deskripsi</label>
                <textarea name="description" placeholder="Ceritakan tentang setup ini..." rows="4"></textarea>
            </div>

            <h3 style="margin-top: 30px; font-size: 1.1rem; color: #666;">Pilih Produk untuk Setup:</h3>

            <div class="product-selection">
                @foreach($products as $product)
                    <label class="product-item">
                        <input type="checkbox" name="products[]" value="{{ $product->id }}">
                        <span class="product-name">{{ $product->name }}</span>
                    </label>
                @endforeach
            </div>

            <button type="submit" class="btn-save">
                Simpan Konfigurasi Setup
            </button>
        </form>
    </div>
</div>

@endsection