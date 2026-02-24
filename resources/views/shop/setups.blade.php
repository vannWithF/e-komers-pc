@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #121212;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    .setups-container {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 25px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* HEADER - Elegant Center */
    .section-header {
        text-align: center;
        margin-bottom: 80px;
        animation: fadeIn 1s ease;
    }

    .section-header h2 {
        font-size: 3.5rem;
        font-weight: 900;
        letter-spacing: -3px;
        color: var(--charcoal);
        margin: 0;
    }

    .section-header p {
        color: var(--titanium-orange);
        font-size: 1.1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-top: 10px;
    }

    /* SETUP CARD - Cinematic Modern */
    .setup-card {
        display: grid;
        grid-template-columns: 1fr 1.1fr; /* Image & Info Split */
        background: white;
        border-radius: 50px;
        overflow: hidden;
        margin-bottom: 60px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 30px 60px rgba(0,0,0,0.05);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .setup-card:hover {
        transform: scale(1.02);
        box-shadow: 0 50px 100px rgba(255, 107, 53, 0.1);
        border-color: var(--titanium-orange);
    }

    /* LEFT: IMAGE SECTION */
    .setup-image-wrap {
        position: relative;
        overflow: hidden;
        height: 550px;
    }

    .setup-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.8s transform cubic-bezier(0.16, 1, 0.3, 1);
    }

    .setup-card:hover .setup-image-wrap img {
        transform: scale(1.1);
    }

    /* Floating Badge on Image */
    .verified-label {
        position: absolute;
        top: 30px;
        left: 30px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 800;
        backdrop-filter: blur(10px);
        letter-spacing: 1px;
        z-index: 2;
    }

    /* RIGHT: CONTENT SECTION */
    .setup-content {
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: linear-gradient(135deg, #ffffff 0%, #f9f9fb 100%);
    }

    .setup-content h3 {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--charcoal);
        letter-spacing: -1.5px;
        margin: 0 0 20px 0;
        line-height: 1.1;
    }

    .setup-description {
        font-size: 1.05rem;
        color: #6e6e73;
        line-height: 1.7;
        margin-bottom: 35px;
        position: relative;
        padding-left: 20px;
        border-left: 3px solid var(--titanium-orange);
    }

    /* PRICE TAG */
    .setup-price-box {
        margin-bottom: 40px;
    }

    .price-label {
        font-size: 0.8rem;
        font-weight: 800;
        color: #aeaeae;
        display: block;
        margin-bottom: 5px;
    }

    .price-value {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--charcoal);
        letter-spacing: -1px;
    }

    /* FOOTER & BUTTON */
    .setup-footer {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .btn-bundle {
        background: var(--charcoal);
        color: white;
        border: none;
        padding: 20px 35px;
        border-radius: 22px;
        font-weight: 800;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.4s;
    }

    .btn-bundle:hover {
        background: var(--titanium-orange);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(255, 107, 53, 0.3);
    }

    .bundle-meta {
        font-size: 0.75rem;
        color: #86868b;
        font-weight: 600;
        line-height: 1.4;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 950px) {
        .setup-card { grid-template-columns: 1fr; }
        .setup-image-wrap { height: 350px; }
        .setup-content { padding: 40px; }
        .section-header h2 { font-size: 2.5rem; }
    }
</style>

<div class="setups-container">
    <div class="section-header">
        <h2>Curated Build.</h2>
        <p>Titanium Performance Bundles</p>
    </div>

    @foreach($setups as $setup)
        <div class="setup-card">
            
            {{-- 🔥 CINEMATIC IMAGE --}}
            <div class="setup-image-wrap">
                <span class="verified-label">TITANIUM MASTERPIECE</span>
                @if($setup->image)
                    <img src="{{ asset('storage/'.$setup->image) }}" alt="{{ $setup->name }}">
                @else
                    <div style="width:100%; height:100%; background:#f2f2f7; display:flex; align-items:center; justify-content:center; font-size:5rem;">🖥️</div>
                @endif
            </div>

            {{-- 🔥 PREMIUM INFO --}}
            <div class="setup-content">
                <h3>{{ $setup->name }}</h3>
                <p class="setup-description">
                    {{ $setup->description }}
                </p>

                <div class="setup-price-box">
                    <span class="price-label">ESTIMATED TOTAL</span>
                    <div class="price-value">
                        Rp {{ number_format($setup->price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="setup-footer">
                    <form action="{{ route('cart.setup.add', $setup->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-bundle">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Get This Bundle
                        </button>
                    </form>
                    
                    <div class="bundle-meta">
                        ⭐ Expert-Curated Components<br>
                        📦 Priority Assembly
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection