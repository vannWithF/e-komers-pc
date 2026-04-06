@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --charcoal: #121212;
        --soft-gray: #f5f5f7;
        --glass: rgba(255, 255, 255, 0.8);
    }

    /* Background Animation */
    body {
        background: radial-gradient(circle at top right, #fff5f2, #f5f5f7) !important;
    }

    .shop-container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 40px 30px;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 50px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    aside {
        position: sticky;
        top: 40px; /* Reduced top gap slightly if it is too low */
        align-self: start;
    }

    /* --- 1. THE ARCHITECT SIDEBAR --- */
    .sidebar-glass {
        height: fit-content;
        max-height: calc(100vh - 80px);
        overflow-y: auto;
        background: var(--glass);
        backdrop-filter: blur(20px);
        border-radius: 40px;
        padding: 40px;
        border: 1px solid white;
        box-shadow: 0 30px 60px rgba(0,0,0,0.03);
    }
    
    .sidebar-glass::-webkit-scrollbar {
        display: none; /* Hide scrollbar for a cleaner look */
    }

    .sidebar-header {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--charcoal);
        opacity: 0.4;
        margin-bottom: 30px;
        display: block;
    }

    .nav-pill {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        border-radius: 20px;
        text-decoration: none;
        color: var(--charcoal);
        font-weight: 700;
        margin-bottom: 10px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid transparent;
    }

    .nav-pill:hover {
        background: white;
        transform: translateX(12px);
        color: var(--titanium-orange);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .nav-pill.active {
        background: var(--charcoal);
        color: white;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    /* --- 2. BUNDLE HORIZONTAL SECTION --- */
    .hero-title {
        font-size: 4rem;
        font-weight: 900;
        letter-spacing: -4px;
        line-height: 0.9;
        margin-bottom: 40px;
        color: var(--charcoal);
    }

    .hero-title span {
        color: var(--titanium-orange);
        display: block;
    }

    .setup-carousel {
        display: flex;
        gap: 30px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding-bottom: 30px;
        scrollbar-width: none;
    }

    .setup-carousel::-webkit-scrollbar { display: none; }

    .setup-card {
        flex: 0 0 80%;
        scroll-snap-align: center;
        background: var(--charcoal);
        border-radius: 50px;
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        overflow: hidden;
        min-height: 480px;
        transition: 0.5s;
    }

    .setup-img-box {
        position: relative;
        background: #1a1a1a;
    }

    .setup-img-box img {
        width: 100%; height: 100%; object-fit: cover;
        opacity: 0.8;
        transition: 0.8s;
    }

    .setup-card:hover .setup-img-box img {
        transform: scale(1.05);
        opacity: 1;
    }

    .setup-details {
        padding: 60px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .badge-premium {
        background: var(--titanium-orange);
        color: white;
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 900;
        width: fit-content;
        margin-bottom: 20px;
    }

    /* --- 3. BENTO GRID 2.0 --- */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .bento-box {
        background: white;
        border-radius: 45px;
        padding: 25px;
        border: 1px solid white;
        box-shadow: 0 20px 50px rgba(0,0,0,0.02);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        height: 520px;
    }

    .bento-box:hover {
        transform: translateY(-15px) rotate(1deg);
        box-shadow: 0 40px 80px rgba(0,0,0,0.06);
        border-color: var(--titanium-orange);
    }

    .bento-preview {
        background: var(--soft-gray);
        border-radius: 35px;
        height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .bento-preview img {
        width: 70%;
        transition: 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bento-box:hover .bento-preview img {
        transform: scale(1.2) rotate(-5deg);
    }

    .price-large {
        font-size: 1.8rem;
        font-weight: 900;
        letter-spacing: -1px;
    }

    .buy-btn {
        width: 65px;
        height: 65px;
        background: var(--charcoal);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: 0.4s;
    }

    .bento-box:hover .buy-btn {
        background: var(--titanium-orange);
        border-radius: 50%;
        transform: scale(1.1);
    }

    @media (max-width: 1100px) {
        .shop-container { grid-template-columns: 1fr; }
        .sidebar-glass { display: none; }
        .setup-card { grid-template-columns: 1fr; }
        .hero-title { font-size: 2.5rem; }
    }
</style>

<div class="shop-container">
    <aside>
        <div class="sidebar-glass">
            <span class="sidebar-header">Main Console</span>
            <nav>
                <a href="{{ route('shop.index') }}" class="nav-pill {{ !request('category') ? 'active' : '' }}">
                    All Systems <span>→</span>
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('shop.category', $category->slug) }}" 
                       class="nav-pill {{ request()->is('category/'.$category->slug) ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </nav>

            <div style="margin-top: 50px; padding: 30px; background: linear-gradient(135deg, #121212 0%, #2a2a2a 100%); border-radius: 30px; color: white; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -10px; right: -10px; font-size: 4rem; opacity: 0.1;">⚙️</div>
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--titanium-orange); margin-bottom: 10px;">LOYALTY PROGRAM</p>
                <h4 style="font-size: 0.9rem; font-weight: 700;">Join the Operative Circle</h4>
                <button style="margin-top: 15px; background: white; border: none; padding: 10px 20px; border-radius: 12px; font-size: 0.75rem; font-weight: 900; cursor: pointer;">Initialize</button>
            </div>
        </div>
    </aside>

    <main>
        <h1 class="hero-title">Warunk <span>PC-Station.</span></h1>

        <div class="setup-carousel">
            @foreach($setups as $setup)
            <div class="setup-card">
                <div class="setup-img-box">
                    <div class="badge-premium" style="position: absolute; top: 30px; left: 30px; z-index: 2;">MASTER BUNDLE</div>
                    @if($setup->image)
                        <img src="{{ asset('storage/'.$setup->image) }}" alt="{{ $setup->name }}">
                    @else
                        <div style="height:100%; background:#222; display:flex; align-items:center; justify-content:center; font-size:4rem;">🖥️</div>
                    @endif
                </div>
                <div class="setup-details">
                    <h2 style="font-size: 2.5rem; font-weight: 900; letter-spacing: -2px; line-height: 1; margin-bottom: 15px;">{{ $setup->name }}</h2>
                    <p style="color: #aeaeae; line-height: 1.6; margin-bottom: 30px;">{{ $setup->description }}</p>
                    
                    <div style="margin-bottom: 40px;">
                        <span style="font-size: 0.7rem; font-weight: 800; color: var(--titanium-orange); display: block; margin-bottom: 5px;">DEPLOYMENT COST</span>
                        <div class="price-large">Rp {{ number_format($setup->price, 0, ',', '.') }}</div>
                    </div>

                    <form action="{{ route('cart.setup.add', $setup->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: white; color: var(--charcoal); border: none; padding: 22px 40px; border-radius: 20px; font-weight: 900; font-size: 0.9rem; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 15px;">
                            Establish Link 
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 80px;">
            <h2 style="font-size: 2rem; font-weight: 900; letter-spacing: -1.5px;">Current Inventory.</h2>
            <p style="font-size: 0.85rem; color: #86868b; font-weight: 600;">{{ $products->total() }} Units Available</p>
        </div>

        <div class="product-grid">
            @foreach($products as $product)
            <div class="bento-box">
                <div class="bento-preview">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    @else
                        <span style="font-size: 4rem;">📦</span>
                    @endif
                </div>
                
                <div style="padding-top: 25px; display: flex; flex-direction: column; flex-grow: 1;">
                    <h4 style="font-size: 1.3rem; font-weight: 900; line-height: 1.1; margin-bottom: auto;">{{ $product->name }}</h4>
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 30px;">
                        <div>
                            <span style="font-size: 0.65rem; font-weight: 800; color: #aeaeae; display: block; margin-bottom: 4px;">UNIT PRICE</span>
                            <div class="price-large" style="font-size: 1.5rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                        
                        <a href="{{ route('shop.show', $product->slug) }}" class="buy-btn">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 80px;">
            {{ $products->links() }}
        </div>
    </main>
</div>

@endsection

