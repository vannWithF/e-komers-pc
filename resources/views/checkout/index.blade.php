@extends('layouts.app')

@section('content')

<style>
    :root {
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

    .checkout-wrapper {
        max-width: 700px;
        margin: 60px auto;
        padding: 0 25px;
        animation: titaniumReveal 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .checkout-card {
        background: var(--glass-bg);
        backdrop-filter: blur(30px) saturate(180%);
        -webkit-backdrop-filter: blur(30px) saturate(180%);
        border-radius: 45px;
        padding: 50px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    /* Aksesori Dekorasi ala Industrial */
    .checkout-card::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(255, 107, 53, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    h2 {
        font-size: 2.5rem;
        font-weight: 900;
        letter-spacing: -2px;
        color: var(--text-dark);
        margin-bottom: 40px;
        text-align: left;
    }

    /* Order Summary List */
    .order-summary {
        margin-bottom: 35px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-weight: 600;
        color: var(--text-dark);
    }

    .item-name {
        display: flex;
        flex-direction: column;
    }

    .item-name small {
        font-size: 0.75rem;
        color: var(--titanium-orange);
        font-weight: 800;
        text-transform: uppercase;
        margin-top: 4px;
    }

    /* Price Breakdown */
    .price-breakdown {
        background-color: var(--titanium-gray);
        padding: 30px;
        border-radius: 30px;
        margin-top: 10px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        color: #86868b;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 2px dashed #d1d1d6;
    }

    .total-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: #86868b;
    }

    .total-amount {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--text-dark);
        letter-spacing: -1.5px;
    }

    /* Titanium Button */
    .btn-order-titanium {
        width: 100%;
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-titanium));
        color: white;
        border: none;
        padding: 24px;
        border-radius: 22px;
        font-size: 1.1rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        margin-top: 35px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 20px 40px rgba(232, 90, 36, 0.3);
    }

    .btn-order-titanium:hover {
        transform: translateY(-5px);
        filter: brightness(1.1);
        box-shadow: 0 25px 50px rgba(232, 90, 36, 0.4);
    }

    .btn-order-titanium:active {
        transform: scale(0.97);
    }

    .security-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-align: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: #c1c1c6;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @keyframes titaniumReveal {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="checkout-wrapper">
    <div class="checkout-card">
        <h2>Review Order.</h2>

        <div class="order-summary">
            @php $total = 0; @endphp
            @foreach($cart as $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp
                <div class="item-row">
                    <div class="item-name">
                        <span>{{ $item['name'] }}</span>
                        <small>{{ $item['quantity'] }} Units — Titanium Grade</small>
                    </div>
                    <span style="font-weight: 800;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="price-breakdown">
            <div class="price-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="price-row">
                <span>Express Shipping</span>
                <span style="color: var(--deep-titanium);">Rp 20.000</span>
            </div>
            
            <div class="total-row">
                <div class="total-label">Total Payment</div>
                <div class="total-amount">Rp {{ number_format($total + 20000, 0, ',', '.') }}</div>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <button type="submit" class="btn-order-titanium">
                Place Order Now
            </button>
        </form>

        <span class="security-note">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C9.243 2 7 4.243 7 7V10H6C4.897 10 4 10.897 4 12V20C4 21.103 4.897 22 6 22H18C19.103 22 20 21.103 20 20V12C20 10.897 19.103 10 18 10H17V7C17 4.243 14.757 2 12 2ZM9 7C9 5.346 10.346 4 12 4C13.654 4 15 5.346 15 7V10H9V7ZM12 18C10.897 18 10 17.103 10 16C10 14.897 10.897 14 12 14C13.103 14 14 14.897 14 16C14 17.103 13.103 18 12 18Z"/>
            </svg>
            End-to-End Encrypted Transaction
        </span>
    </div>
</div>

@endsection