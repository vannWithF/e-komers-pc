@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #121212;
        --glass-bg: rgba(255, 255, 255, 0.6);
    }

    .shop-wrapper {
        display: grid;
        grid-template-columns: 280px 1fr; /* Sidebar + Content */
        gap: 40px;
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 30px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* --- 1. MODERN SIDEBAR FILTER --- */
    .filter-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border-radius: 35px;
        padding: 30px;
        border: 1px solid rgba(255,255,255,0.4);
        box-shadow: 0 20px 40px rgba(0,0,0,0.03);
    }

    .filter-title {
        font-size: 0.75rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--titanium-orange);
        margin-bottom: 25px;
        display: block;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .filter-item {
        text-decoration: none;
        padding: 14px 20px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
        color: #64748b;
        transition: 0.3s all cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-item:hover {
        background: rgba(255, 107, 53, 0.1);
        color: var(--titanium-orange);
        transform: translateX(10px);
    }

    .filter-item.active {
        background: var(--charcoal);
        color: white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .filter-item .count {
        font-size: 0.7rem;
        background: rgba(0,0,0,0.05);
        padding: 4px 8px;
        border-radius: 8px;
    }

    /* --- 2. PRODUCT AREA --- */
    .main-content h1 {
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -2px;
        margin-bottom: 30px;
    }

    .product-bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }

    /* --- 3. NEO-BENTO PRODUCT CARD --- */
    .bento-card {
        background: white;
        border-radius: 40px;
        padding: 15px;
        border: 1px solid #f0f0f0;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        display: flex;
        flex-direction: column;
        height: 480px;
    }

    .bento-card:hover {
        transform: translateY(-12px) scale(1.01);
        border-color: var(--titanium-orange);
        box-shadow: 0 40px 80px rgba(0,0,0,0.08);
    }

    /* Visual Section */
    .bento-visual {
        background: #f8f8fa;
        border-radius: 30px;
        height: 260px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .bento-visual img {
        width: 80%;
        height: 80%;
        object-fit: contain;
        transition: 0.6s transform cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bento-card:hover .bento-visual img {
        transform: scale(1.15) rotate(5deg);
    }

    /* Badge Floating */
    .type-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: white;
        padding: 8px 15px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 800;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    /* Content Section */
    .bento-content {
        padding: 25px 15px 10px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .bento-content h4 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 900;
        color: var(--charcoal);
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .bento-meta {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .bento-price {
        display: flex;
        flex-direction: column;
    }

    .bento-price span {
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
    }

    .bento-price strong {
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--charcoal);
        letter-spacing: -1px;
    }

    /* Action Circle */
    .btn-bento {
        width: 60px;
        height: 60px;
        background: var(--charcoal);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: 0.3s;
    }

    .bento-card:hover .btn-bento {
        background: var(--titanium-orange);
        border-radius: 50%;
        transform: scale(1.1);
    }

    @media (max-width: 1024px) {
        .shop-wrapper { grid-template-columns: 1fr; }
        .filter-sidebar { display: none; } /* Bisa ganti jadi horizontal scroll di mobile */
    }
</style>

<div class="shop-wrapper">
    <aside class="filter-sidebar">
        <span class="filter-title">Discover Hardware</span>
        <div class="filter-group">
            <a href="{{ route('shop.index') }}" class="filter-item {{ !request('category') ? 'active' : '' }}">
                All Inventory <span class="count">🔥</span>
            </a>
            @foreach($categories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" 
                   class="filter-item {{ request()->is('category/'.$category->slug) ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div style="margin-top: 40px; padding: 20px; background: var(--charcoal); border-radius: 25px; color: white;">
            <p style="font-size: 0.7rem; font-weight: 800; opacity: 0.6; margin-bottom: 10px;">PROMO</p>
            <h5 style="font-size: 0.9rem; margin-bottom: 15px;">Titanium Build Up to 15% Off</h5>
            <a href="#" style="color: var(--titanium-orange); font-size: 0.8rem; font-weight: 900; text-decoration: none;">View Detail</a>
        </div>
    </aside>

    <main class="main-content">
        <h1>Warunk <span>PC-Station.</span></h1>

        <div class="product-bento-grid">
            @foreach($products as $product)
                <div class="bento-card">
                    <div class="bento-visual">
                        <span class="type-badge">TI-SERIES</span>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                        @else
                            <span style="font-size: 4rem;">📦</span>
                        @endif
                    </div>

                    <div class="bento-content">
                        <h4>{{ $product->name }}</h4>
                        
                        <div class="bento-meta">
                            <div class="bento-price">
                                <span>MARKET PRICE</span>
                                <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                            </div>
                            
                            <a href="{{ route('shop.show', $product->slug) }}" class="btn-bento">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 60px;">
            {{ $products->links() }}
        </div>
    </main>
</div>

@endsection