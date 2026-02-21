@extends('layouts.app')

@section('content')

<style>
    .form-container {
        max-width: 750px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .edit-card {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-top: 5px solid #f59e0b; /* Warna kuning khas 'Edit' */
    }

    .header-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .header-group h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .btn-cancel {
        text-decoration: none;
        color: #718096;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    .btn-cancel:hover {
        color: #e53e3e;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        color: #2d3748;
        background-color: #f8fafc; /* Sedikit berbeda untuk membedakan mode edit */
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #f59e0b;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    textarea {
        min-height: 120px;
        line-height: 1.5;
    }

    .btn-update {
        background-color: #f59e0b;
        color: white;
        font-weight: 700;
        padding: 14px;
        border: none;
        border-radius: 8px;
        width: 100%;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 10px;
        transition: background 0.3s, transform 0.1s;
    }

    .btn-update:hover {
        background-color: #d97706;
    }

    .btn-update:active {
        transform: scale(0.99);
    }

    @media (max-width: 500px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-container">
    <div class="edit-card">
        <div class="header-group">
            <h1>📝 Edit Produk</h1>
            <a href="{{ route('admin.products.index') }}" class="btn-cancel">Batal</a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" 
              method="POST" 
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" value="{{ $product->price }}" required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi Produk</label>
                <textarea name="description">{{ $product->description }}</textarea>
            </div>

            <button type="submit" class="btn-update">
                Simpan Perubahan
            </button>

        </form>
    </div>
</div>

@endsection