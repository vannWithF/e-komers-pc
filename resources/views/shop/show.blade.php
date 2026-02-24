@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #1d1d1f;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    .product-detail-container {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 30px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 1. LAYOUT FLEX - Cinematic Split */
    .product-flex {
        display: flex;
        gap: 80px;
        align-items: flex-start;
    }

    /* 2. LEFT SIDE: GALLERY - Sticky Showcase */
    .product-gallery {
        flex: 1.2;
        position: sticky;
        top: 120px;
        animation: slideFromLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .main-image-wrap {
        background: #f5f5f7;
        border-radius: 50px;
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(0,0,0,0.02);
        transition: transform 0.5s ease;
    }

    .main-image-wrap:hover {
        transform: scale(1.02);
    }

    .main-image {
        width: 100%;
        max-height: 550px;
        object-fit: contain;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.08));
    }

    /* 3. RIGHT SIDE: CONTENT - Elegant Info */
    .product-info-section {
        flex: 1;
        animation: fadeIn 1s ease-out;
    }

    .category-badge {
        display: inline-block;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--titanium-orange);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 15px;
    }

    .product-name-title {
        font-size: 3.5rem;
        font-weight: 900;
        color: var(--charcoal);
        line-height: 1;
        letter-spacing: -3px;
        margin-bottom: 25px;
    }

    .price-box {
        display: flex;
        align-items: baseline;
        gap: 10px;
        margin-bottom: 35px;
    }

    .price-symbol {
        font-size: 1.5rem;
        font-weight: 700;
        color: #86868b;
    }

    .product-price-large {
        font-size: 2.8rem;
        font-weight: 900;
        color: var(--charcoal);
        letter-spacing: -1.5px;
    }

    /* Stock & Badges */
    .meta-badges {
        display: flex;
        gap: 12px;
        margin-bottom: 40px;
    }

    .badge-item {
        padding: 8px 18px;
        border-radius: 14px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .available { background: #e8f5e9; color: #2e7d32; }
    .unavailable { background: #ffebee; color: #c62828; }
    .titanium-badge { background: #f2f2f7; color: var(--charcoal); border: 1px solid #d1d1d6; }

    /* Description */
    .description-wrap h3 {
        font-size: 1.1rem;
        font-weight: 800;
        margin-bottom: 15px;
    }

    .description-text {
        color: #6e6e73;
        line-height: 1.8;
        font-size: 1.1rem;
        margin-bottom: 45px;
    }

    /* Variations */
    .variation-card {
        background: #fbfbfd;
        border-radius: 25px;
        padding: 25px;
        margin-bottom: 45px;
        border: 1px solid #f0f0f2;
    }

    .variation-card label {
        display: block;
        font-weight: 800;
        font-size: 0.85rem;
        color: #1d1d1f;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .custom-select {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e5e5e7;
        border-radius: 15px;
        font-weight: 600;
        font-family: inherit;
        background: white;
        appearance: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .custom-select:focus {
        border-color: var(--titanium-orange);
        outline: none;
    }

    /* 4. ACTION BUTTONS - High Intensity */
    .action-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .btn-add-cart-titanium {
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-titanium));
        color: white;
        border: none;
        padding: 25px;
        border-radius: 24px;
        font-size: 1.1rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 20px 40px rgba(232, 90, 36, 0.25);
    }

    .btn-add-cart-titanium:hover {
        transform: translateY(-5px);
        filter: brightness(1.1);
        box-shadow: 0 25px 50px rgba(232, 90, 36, 0.4);
    }

    .btn-disabled {
        background: #e5e5e7;
        color: #a1a1a6;
        cursor: not-allowed;
        box-shadow: none !important;
    }

    .btn-login-modern {
        display: block;
        text-align: center;
        background: var(--charcoal);
        color: white;
        text-decoration: none;
        padding: 22px;
        border-radius: 24px;
        font-weight: 800;
        transition: 0.3s;
    }

    /* Animations */
    @keyframes slideFromLeft {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 1000px) {
        .product-flex { flex-direction: column; gap: 40px; }
        .product-gallery { position: relative; top: 0; width: 100%; }
        .product-name-title { font-size: 2.5rem; }
    }
</style>

<div class="product-detail-container">
    <div class="product-flex">
        
        <div class="product-gallery">
            <div class="main-image-wrap">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="main-image" alt="{{ $product->name }}">
                @else
                    <div style="font-size: 5rem;">🔌</div>
                @endif
            </div>
            <p style="text-align: center; margin-top: 20px; color: #86868b; font-size: 0.8rem; font-weight: 600;">
                 Titanium Grade Certified Component
            </p>
        </div>

        <div class="product-info-section">
            <span class="category-badge">{{ $product->category->name ?? 'Next-Gen Gear' }}</span>
            <h2 class="product-name-title">{{ $product->name }}</h2>
            
            <div class="price-box">
                <span class="price-symbol">IDR</span>
                <div class="product-price-large">
                    {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>

            <div class="meta-badges">
                <span class="badge-item {{ $product->stock > 0 ? 'available' : 'unavailable' }}">
                    {{ $product->stock > 0 ? '● In Stock (' . $product->stock . ')' : '○ Out of Stock' }}
                </span>
                <span class="badge-item titanium-badge">17-PRO-SERIES</span>
            </div>

            <div class="description-wrap">
                <h3>About this hardware</h3>
                <p class="description-text">
                    {{ $product->description }}
                </p>
            </div>

            @if($product->colors)
                <div class="variation-card">
                    <label>Hardware Configuration / Color</label>
                    <div style="position: relative;">
                        <select class="custom-select">
                            @foreach($product->colors as $color)
                                <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </select>
                        <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            ▼
                        </div>
                    </div>
                </div>
            @endif

            <div class="action-container">
                @auth
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-add-cart-titanium">
                                Add to Systems Cart
                            </button>
                        </form>
                    @else
                        <button class="btn-add-cart-titanium btn-disabled">
                            Currently Unavailable
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-login-modern">
                        Sign In to Purchase
                    </a>
                @endauth
                <p style="text-align: center; font-size: 0.75rem; color: #86868b; margin-top: 10px;">
                    Free shipping for Titanium Member. Secure payment guaranteed.
                </p>
            </div>
        </div>

    </div>
</div>

@endsection