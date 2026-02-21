@extends('layouts.app')

@section('content')

<style>
    .form-wrapper {
        max-width: 700px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .form-card {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid #eaeaea;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }

    /* Input Styling */
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
        transition: all 0.3s ease;
        box-sizing: border-box; /* Biar padding gak ngerusak lebar */
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #4A90E2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* File Input Styling */
    input[type="file"] {
        background: #f8fafc;
        padding: 10px;
        border: 1px dashed #cbd5e0;
        width: 100%;
        border-radius: 8px;
        cursor: pointer;
    }

    /* Button Styling */
    .btn-submit {
        background-color: #10b981;
        color: white;
        font-weight: 600;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        font-size: 1rem;
        transition: background 0.3s ease, transform 0.1s;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background-color: #059669;
    }

    .btn-submit:active {
        transform: scale(0.98);
    }

    /* Helper Grid untuk Harga & Stok */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 480px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-wrapper">
    <div class="form-card">
        <h1 class="form-title">📦 Tambah Produk Baru</h1>

        <form action="{{ route('admin.products.store') }}" 
              method="POST" 
              enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" placeholder="Contoh: Sepatu Lari Pro" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id">
                    <option value="" disabled selected>Pilih Kategori...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" placeholder="0" required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" placeholder="0" required>
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi Produk</label>
                <textarea name="description" placeholder="Tuliskan spesifikasi lengkap produk di sini..."></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Produk</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">
                Simpan Produk
            </button>

        </form>
    </div>
</div>

@endsection