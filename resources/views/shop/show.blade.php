@extends('layouts.app')

@section('content')

<style>
    .product-detail-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .product-flex {
        display: flex;
        gap: 50px;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
    }

    /* Left Side: Image */
    .product-gallery {
        flex: 1;
        max-width: 500px;
    }

    .main-image {
        width: 100%;
        border-radius: 15px;
        object-fit: cover;
        background-color: #f8fafc;
        border: 1px solid #edf2f7;
    }

    /* Right Side: Content */
    .product-info-section {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-category-tag {
        color: #4f46e5;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .product-name-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .product-price-large {
        font-size: 1.75rem;
        color: #4f46e5;
        font-weight: 800;
        margin-bottom: 25px;
    }

    .description-text {
        color: #4a5568;
        line-height: 1.7;
        margin-bottom: 30px;
        font-size: 1.05rem;
    }

    .stock-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 25px;
    }

    .stock-available { background: #dcfce7; color: #166534; }
    .stock-empty { background: #fee2e2; color: #991b1b; }

    /* Variations */
    .variation-group {
        margin-bottom: 25px;
    }

    .variation-group label {
        display: block;
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 10px;
        color: #2d3748;
    }

    .custom-select {
        width: 100%;
        max-width: 300px;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-family: inherit;
        background: white;
    }

    /* Action Buttons */
    .action-container {
        margin-top: auto;
        padding-top: 30px;
        border-top: 1px solid #edf2f7;
    }

    .btn-add-cart {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 18px 35px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-add-cart:hover {
        background: #4338ca;
        transform: translateY(-2px);
    }

    .btn-login-redirect {
        display: block;
        text-align: center;
        background: #f1f5f9;
        color: #475569;
        text-decoration: none;
        padding: 15px;
        border-radius: 10px;
        font-weight: 600;
    }

    @media (max-width: 850px) {
        .product-flex { flex-direction: column; padding: 20px; }
        .product-gallery { max-width: 100%; }
    }
</style>

<div class="product-detail-container">
    <div class="product-flex">
        
        <div class="product-gallery">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="main-image" alt="{{ $product->name }}">
            @else
                <div class="main-image" style="height: 400px; display: flex; align-items: center; justify-content: center; color: #cbd5e0;">
                    No Image Available
                </div>
            @endif
        </div>

        <div class="product-info-section">
            <span class="product-category-tag">{{ $product->category->name ?? 'Gadget' }}</span>
            <h2 class="product-name-title">{{ $product->name }}</h2>
            
            <div class="product-price-large">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <span class="stock-badge {{ $product->stock > 0 ? 'stock-available' : 'stock-empty' }}">
                {{ $product->stock > 0 ? 'Stok Tersedia: ' . $product->stock : 'Stok Habis' }}
            </span>

            <p class="description-text">
                {{ $product->description }}
            </p>

            @if($product->colors)
                <div class="variation-group">
                    <label>Pilih Warna</label>
                    <select class="custom-select">
                        @foreach($product->colors as $color)
                            <option value="{{ $color }}">{{ $color }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="action-container">
                @auth
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-add-cart">
                                🛒 Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button class="btn-add-cart" style="background: #cbd5e0; cursor: not-allowed; box-shadow: none;">
                            Stok Tidak Tersedia
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-login-redirect">
                        🔒 Login untuk Membeli Produk
                    </a>
                @endauth
            </div>
        </div>

    </div>
</div>

@endsection