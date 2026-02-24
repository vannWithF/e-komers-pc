@extends('layouts.admin')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-orange: #e85a24;
        --glass-bg: rgba(255, 255, 255, 0.3);
        --glass-border: rgba(255, 255, 255, 0.5);
        --text-main: #2d1a12;
    }

    .form-container {
        max-width: 900px;
        margin: 0 auto;
        animation: liquidFlow 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* HEADER: Typography melayang */
    .page-header {
        margin-bottom: 40px;
        text-align: center;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 900;
        letter-spacing: -2px;
        color: var(--text-main);
    }

    /* LAYOUT: Fragmented Sections (Bukan satu kotak besar) */
    .form-layout {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .form-section {
        background: var(--glass-bg);
        backdrop-filter: blur(30px) saturate(150%);
        -webkit-backdrop-filter: blur(30px) saturate(150%);
        border-radius: 35px;
        padding: 35px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 15px 35px rgba(232, 90, 36, 0.05);
    }

    /* Input Group Styling */
    .input-wrapper {
        position: relative;
        margin-bottom: 5px;
    }

    .input-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--deep-orange);
        display: block;
        margin-left: 15px;
        margin-bottom: 8px;
    }

    /* Glass Inputs */
    input[type="text"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid var(--glass-border);
        padding: 18px 25px;
        border-radius: 22px;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-main);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        background: white;
        border-color: var(--titanium-orange);
        box-shadow: 0 10px 25px rgba(255, 107, 53, 0.1);
        transform: translateY(-2px);
    }

    /* Grid Khusus Harga & Stok */
    .numeric-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    /* Custom File Upload Box */
    .file-drop-zone {
        border: 2px dashed var(--glass-border);
        border-radius: 25px;
        padding: 40px;
        text-align: center;
        background: rgba(255,255,255,0.2);
        transition: 0.3s;
        cursor: pointer;
    }

    .file-drop-zone:hover {
        border-color: var(--titanium-orange);
        background: rgba(255,255,255,0.5);
    }

    /* Submit Button: Liquid Gradient */
    .submit-container {
        position: sticky;
        bottom: 25px;
        z-index: 10;
    }

    .btn-liquid-save {
        width: 100%;
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-orange));
        color: white;
        padding: 22px;
        border-radius: 25px;
        border: none;
        font-size: 1.1rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        box-shadow: 0 15px 30px rgba(232, 90, 36, 0.3);
        transition: 0.4s;
    }

    .btn-liquid-save:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 20px 40px rgba(232, 90, 36, 0.4);
        filter: brightness(1.1);
    }

    @keyframes liquidFlow {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="form-container">
    <header class="page-header">
        <h1 class="page-title">New Product</h1>
        <p style="font-weight: 700; color: var(--deep-orange); opacity: 0.7;">Fill the essence of your hardware inventory.</p>
    </header>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-layout">
            
            <div class="form-section">
                <div class="input-wrapper">
                    <label class="input-label">Product Identity</label>
                    <input type="text" name="name" placeholder="Enter product name..." required>
                </div>
                
                <div class="input-wrapper" style="margin-top: 20px;">
                    <label class="input-label">Inventory Category</label>
                    <select name="category_id">
                        <option value="" disabled selected>Select category...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-section">
                <div class="numeric-grid">
                    <div class="input-wrapper">
                        <label class="input-label">Valuation (IDR)</label>
                        <input type="number" name="price" placeholder="0" required>
                    </div>
                    <div class="input-wrapper">
                        <label class="input-label">Units</label>
                        <input type="number" name="stock" placeholder="0" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="input-wrapper">
                    <label class="input-label">Technical Specification</label>
                    <textarea name="description" placeholder="Describe the power of this product..."></textarea>
                </div>

                <div class="input-wrapper" style="margin-top: 25px;">
                    <label class="input-label">Visual Asset</label>
                    <div class="file-drop-zone" onclick="document.getElementById('fileInput').click()">
                        <span style="font-size: 2rem;">🖼️</span>
                        <p style="font-weight: 800; margin-top: 10px;">Drop image here or click to browse</p>
                        <input type="file" id="fileInput" name="image" accept="image/*" style="display: none;">
                    </div>
                </div>
            </div>

            <div class="submit-container">
                <button type="submit" class="btn-liquid-save">
                    Deploy Product
                </button>
            </div>

        </div>
    </form>
</div>

@endsection