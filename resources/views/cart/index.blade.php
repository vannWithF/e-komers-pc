@extends('layouts.app')

@section('content')

<style>
    :root {
        /* Warna Terinspirasi iPhone 17 Pro Max Titanium Orange */
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --burnt-orange: #b3421b;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.5);
        --text-dark: #1a1a1a;
        --titanium-gray: #f2f2f7;
    }

    body {
        background: #fdfdfd;
        color: var(--text-dark);
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .cart-container {
        max-width: 1100px;
        margin: 60px auto;
        padding: 0 25px;
        animation: titaniumReveal 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* HEADER */
    .cart-header {
        margin-bottom: 50px;
    }

    .cart-header h1 {
        font-size: 3.5rem;
        font-weight: 900;
        letter-spacing: -3px;
        color: var(--text-dark);
        margin: 0;
    }

    /* GRID LAYOUT */
    .cart-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 40px;
        align-items: start;
    }

    /* ITEM LIST */
    .cart-items-wrap {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .item-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px) saturate(180%);
        -webkit-backdrop-filter: blur(25px) saturate(180%);
        border: 1px solid var(--glass-border);
        border-radius: 35px;
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 25px;
        transition: 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    .item-card:hover {
        transform: scale(1.02);
        background: white;
        border-color: var(--titanium-orange);
        box-shadow: 0 30px 60px rgba(255, 107, 53, 0.1);
    }

    .item-icon-box {
        width: 85px;
        height: 85px;
        background: var(--titanium-gray);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        border: 1px solid #e5e5e7;
    }

    .item-detail { flex: 1; }
    .item-detail h3 {
        font-size: 1.4rem;
        font-weight: 800;
        margin: 0 0 5px 0;
        letter-spacing: -0.5px;
    }
    .item-detail p {
        color: #86868b;
        font-weight: 600;
        margin: 0;
    }

    .qty-badge {
        background: var(--text-dark);
        color: white;
        padding: 8px 16px;
        border-radius: 14px;
        font-weight: 800;
        font-size: 0.8rem;
    }

    .item-subtotal {
        text-align: right;
        min-width: 120px;
    }
    .item-subtotal strong {
        display: block;
        font-size: 1.2rem;
        font-weight: 900;
    }

    /* SUMMARY SIDEBAR (TITANIUM ORANGE THEME) */
    .cart-summary {
        background: linear-gradient(165deg, var(--titanium-orange), var(--deep-titanium));
        color: white;
        border-radius: 45px;
        padding: 45px;
        position: sticky;
        top: 40px;
        box-shadow: 0 40px 80px rgba(232, 90, 36, 0.3);
    }

    .summary-title {
        font-size: 1.6rem;
        font-weight: 900;
        margin-bottom: 35px;
        letter-spacing: -1px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-weight: 600;
        opacity: 0.9;
    }

    .total-divider {
        margin: 30px 0;
        border-top: 2px dashed rgba(255,255,255,0.3);
    }

    .total-amount-box {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .total-amount-box span { font-size: 0.9rem; opacity: 0.8; font-weight: 700; }
    .total-amount-box strong { font-size: 2.5rem; font-weight: 900; letter-spacing: -2px; line-height: 1; }

    /* ACTION BUTTONS */
    .btn-checkout-titanium {
        display: block;
        width: 100%;
        background: white;
        color: var(--deep-titanium);
        text-align: center;
        text-decoration: none;
        padding: 24px;
        border-radius: 22px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 40px;
        transition: 0.4s;
    }

    .btn-checkout-titanium:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .btn-remove-circle {
        background: rgba(255, 77, 77, 0.1);
        color: #ff4d4d;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s;
    }

    .btn-remove-circle:hover {
        background: #ff4d4d;
        color: white;
        transform: rotate(90deg);
    }

    /* EMPTY STATE */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 100px;
        background: var(--titanium-gray);
        border-radius: 50px;
    }

    @keyframes titaniumReveal {
        from { opacity: 0; transform: scale(0.98) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    @media (max-width: 950px) {
        .cart-grid { grid-template-columns: 1fr; }
        .cart-header h1 { font-size: 2.5rem; }
    }
</style>

<div class="cart-container">
    <div class="cart-header">
        <h1>Your Basket.</h1>
        <p style="font-weight: 800; color: var(--titanium-orange);">Review your premium hardware selection.</p>
    </div>

    <div class="cart-grid">
        @if(session('cart') && count(session('cart')) > 0)
            {{-- LIST BARANG --}}
            <div class="cart-items-wrap">
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <div class="item-card">
                        <div class="item-icon-box">🔌</div>
                        <div class="item-detail">
                            <h3>{{ $item['name'] }}</h3>
                            <p>Premium Asset</p>
                        </div>
                        <div class="qty-badge">
                            {{ $item['quantity'] }} UNIT
                        </div>
                        <div class="item-subtotal">
                            <span style="font-size: 0.7rem; font-weight: 800; opacity: 0.5;">PRICE</span>
                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                            
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-remove-circle" title="Remove Item">✕</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ORDER SUMMARY --}}
            <div class="cart-summary">
                <h2 class="summary-title">Summary</h2>
                
                <div class="summary-line">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="summary-line">
                    <span>Shipping</span>
                    <span style="background: rgba(255,255,255,0.2); padding: 2px 10px; border-radius: 8px;">FREE</span>
                </div>
                <div class="summary-line">
                    <span>Estimated Tax</span>
                    <span>Rp 0</span>
                </div>

                <div class="total-divider"></div>

                <div class="total-amount-box">
                    <div>
                        <span>Total Pay</span>
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-checkout-titanium">
                    Checkout Bundle
                </a>
                
                <div style="text-align: center; margin-top: 25px; opacity: 0.7; font-size: 0.75rem; font-weight: 600;">
                    🛡️ Secure Titanium Encrypted Transaction
                </div>
            </div>

        @else
            <div class="empty-state">
                <div style="font-size: 5rem; margin-bottom: 20px;">🛒</div>
                <h2 style="font-weight: 900;">Your basket is empty.</h2>
                <p style="color: #86868b; font-weight: 600; margin-bottom: 40px;">Add some high-performance hardware to get started.</p>
                <a href="/" class="btn-checkout-titanium" style="max-width: 300px; margin: 0 auto; background: var(--text-dark); color: white;">
                    Explore Products
                </a>
            </div>
        @endif
    </div>
</div>

@endsection