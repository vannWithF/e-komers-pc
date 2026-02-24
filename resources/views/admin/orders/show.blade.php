@extends('layouts.admin')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --glass-surface: rgba(255, 255, 255, 0.3);
        --glass-thick: rgba(255, 255, 255, 0.6);
        --border-light: rgba(255, 255, 255, 0.5);
        --text-deep: #2d1a12;
    }

    /* ROOT WRAPPER: Menghilangkan struktur grid kaku */
    .detail-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
        animation: slideDown 0.8s cubic-bezier(0, 1, 0, 1);
        max-width: 1200px;
        margin: 0 auto;
        padding-bottom: 50px;
    }

    /* ZONE 1: HERO HEADER (Info Utama) */
    .hero-glass-card {
        background: var(--glass-surface);
        backdrop-filter: blur(40px) saturate(200%);
        -webkit-backdrop-filter: blur(40px) saturate(200%);
        border-radius: 45px;
        padding: 40px;
        border: 1px solid var(--border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 25px 50px -12px rgba(232, 90, 36, 0.1);
    }

    .hero-id-tag {
        background: var(--titanium-orange);
        color: white;
        padding: 10px 25px;
        border-radius: 20px;
        font-weight: 900;
        font-size: 1.2rem;
        display: inline-block;
        margin-bottom: 15px;
        box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3);
    }

    /* ZONE 2: SPLIT CONTENT (Items vs Actions) */
    .content-split {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    /* Left Side: Order Slats (Pengganti Tabel) */
    .items-section {
        flex: 1.5;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .item-slat {
        background: var(--glass-thick);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 20px 30px;
        border: 1px solid var(--border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .item-slat:hover {
        transform: scale(1.02) translateX(10px);
        background: white;
    }

    /* Right Side: Action Stack */
    .action-stack {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
        position: sticky;
        top: 20px;
    }

    .action-box {
        background: var(--glass-surface);
        backdrop-filter: blur(30px);
        border-radius: 35px;
        padding: 30px;
        border: 1px solid var(--border-light);
    }

    /* Typography & Buttons */
    .label-micro {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--text-muted);
        display: block;
        margin-bottom: 8px;
    }

    .price-total {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--text-deep);
        letter-spacing: -2px;
    }

    /* Custom Input Select iPhone Style */
    .liquid-select {
        width: 100%;
        padding: 18px;
        border-radius: 20px;
        border: 2px solid transparent;
        background: white;
        font-weight: 700;
        font-family: inherit;
        color: var(--text-deep);
        margin-bottom: 15px;
        cursor: pointer;
        transition: 0.3s;
    }

    .liquid-select:focus {
        border-color: var(--titanium-orange);
        outline: none;
        box-shadow: 0 0 0 5px rgba(255, 107, 53, 0.1);
    }

    .btn-liquid {
        width: 100%;
        background: var(--text-deep);
        color: white;
        border: none;
        padding: 18px;
        border-radius: 20px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: 0.4s;
    }

    .btn-liquid:hover {
        background: var(--titanium-orange);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(255, 107, 53, 0.3);
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 900px) {
        .content-split { flex-direction: column; }
        .hero-glass-card { flex-direction: column; gap: 20px; text-align: center; }
    }
</style>

<div class="detail-container">
    
    <div class="hero-glass-card">
        <div>
            <span class="hero-id-tag">#{{ $order->invoice }}</span>
            <p class="label-micro">Transaction Date</p>
            <h2 style="font-weight: 800;">{{ $order->created_at->format('d F Y') }} <span style="font-weight: 400; opacity: 0.5;">• {{ $order->created_at->format('H:i') }}</span></h2>
        </div>
        <div style="text-align: right;">
            <p class="label-micro">Grand Total</p>
            <h1 class="price-total"><span style="font-size: 1.2rem; vertical-align: middle;">RP</span> {{ number_format($order->total_price, 0, ',', '.') }}</h1>
        </div>
    </div>

    <div class="content-split">
        
        <div class="items-section">
            <p class="label-micro" style="margin-left: 20px;">Items In Order ({{ count($order->items) }})</p>
            @foreach($order->items as $item)
            <div class="item-slat">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="width: 50px; height: 50px; background: white; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border: 1px solid var(--border-light);">
                        📦
                    </div>
                    <div>
                        <h4 style="font-weight: 800; color: var(--text-deep);">{{ $item->product->name }}</h4>
                        <p style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Qty: {{ $item->quantity }} units</p>
                    </div>
                </div>
                <div style="text-align: right;">
                    <p class="label-micro">Subtotal</p>
                    <p style="font-weight: 900; color: var(--titanium-orange);">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach

            <div class="item-slat" style="margin-top: 20px; background: var(--text-deep); border: none;">
                <div style="color: white;">
                    <p class="label-micro" style="color: rgba(255,255,255,0.5);">Customer Info</p>
                    <h4 style="font-weight: 800;">{{ $order->user->name }}</h4>
                    <p style="font-size: 0.8rem; opacity: 0.7;">{{ $order->user->email }}</p>
                </div>
                <div style="width: 45px; height: 45px; border-radius: 50%; background: var(--titanium-orange); display: flex; align-items: center; justify-content: center; color: white; font-weight: 900;">
                    {{ substr($order->user->name, 0, 1) }}
                </div>
            </div>
        </div>

        <div class="action-stack">
            
            <div class="action-box">
                <p class="label-micro">Payment Governance</p>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf @method('PUT')
                    <select name="status" class="liquid-select">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    </select>
                    <button type="submit" class="btn-liquid">Update Payment</button>
                </form>
            </div>

            <div class="action-box">
                <p class="label-micro">Logistics Progress</p>
                <form method="POST" action="{{ route('admin.orders.updateLogistic', $order->id) }}">
                    @csrf @method('PATCH')
                    <select name="logistic_status" class="liquid-select">
                        <option value="processing" {{ $order->logistic_status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->logistic_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->logistic_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    <button type="submit" class="btn-liquid" style="background: var(--titanium-orange);">Update Shipping</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection