@extends('layouts.app')

@section('content')
<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #1a1a1a;
        --soft-bg: #f5f5f7;
    }

    .order-container {
        max-width: 1000px;
        margin: 60px auto;
        padding: 0 25px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 1. ULTRA MODERN STEPPER */
    .stepper-wrap {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 40px;
    }

    .step-box {
        background: white;
        padding: 20px;
        border-radius: 25px;
        text-align: center;
        border: 1px solid #eef2f7;
        position: relative;
        transition: 0.3s;
    }

    .step-box.active {
        background: var(--charcoal);
        border-color: var(--charcoal);
    }

    .step-box .icon {
        font-size: 1.5rem;
        margin-bottom: 8px;
        display: block;
    }

    .step-box .label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #86868b;
    }

    .step-box.active .label { color: var(--titanium-orange); }

    /* 2. MAIN GRID LAYOUT */
    .order-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
        align-items: start;
    }

    /* 3. INVOICE CARD */
    .receipt-main {
        background: white;
        border-radius: 40px;
        padding: 40px;
        border: 1px solid #f0f0f2;
        box-shadow: 0 20px 50px rgba(0,0,0,0.02);
    }

    .receipt-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        padding-bottom: 25px;
        border-bottom: 2px dashed #f0f0f2;
    }

    .invoice-title h1 {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -1.5px;
        margin: 0;
    }

    .status-pill {
        background: var(--soft-bg);
        padding: 8px 20px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--charcoal);
    }

    /* Table Items */
    .product-row {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px 0;
        border-bottom: 1px solid #f5f5f7;
    }

    .product-img {
        width: 70px;
        height: 70px;
        background: var(--soft-bg);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .product-meta { flex: 1; }
    .product-meta h4 { margin: 0; font-size: 1rem; font-weight: 800; }
    .product-meta span { font-size: 0.85rem; color: #86868b; font-weight: 600; }

    .subtotal-area { font-weight: 900; color: var(--charcoal); }

    /* 4. SIDEBAR SUMMARY */
    .order-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .side-card {
        background: white;
        border-radius: 35px;
        padding: 30px;
        border: 1px solid #f0f0f2;
    }

    .summary-title {
        font-size: 0.8rem;
        font-weight: 900;
        text-transform: uppercase;
        color: #86868b;
        margin-bottom: 20px;
        display: block;
    }

    .total-price {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--charcoal);
        letter-spacing: -1.5px;
        margin-bottom: 25px;
    }

    /* 5. ACTION BUTTONS */
    .btn-action {
        width: 100%;
        padding: 22px;
        border-radius: 20px;
        border: none;
        font-weight: 800;
        font-size: 0.95rem;
        cursor: pointer;
        transition: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-complete {
        background: var(--charcoal);
        color: white;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .btn-complete:hover:not(:disabled) {
        background: var(--titanium-orange);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
    }

    .btn-complete:disabled {
        background: #e5e5e7;
        color: #a1a1a6;
        cursor: not-allowed;
    }

    .locked-card {
        background: #fff8f8;
        border: 1px solid #ffebeb;
        padding: 15px;
        border-radius: 20px;
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #e03131;
    }

    @media (max-width: 900px) {
        .order-grid { grid-template-columns: 1fr; }
        .stepper-wrap { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="order-container">
    
    <div class="stepper-wrap">
        <div class="step-box active">
            <span class="icon">📝</span>
            <span class="label">Ordered</span>
        </div>
        <div class="step-box {{ in_array($order->logistic_status, ['shipped', 'delivered', 'completed']) ? 'active' : '' }}">
            <span class="icon">🚀</span>
            <span class="label">Dispatched</span>
        </div>
        <div class="step-box {{ in_array($order->logistic_status, ['delivered', 'completed']) ? 'active' : '' }}">
            <span class="icon">📦</span>
            <span class="label">Arrived</span>
        </div>
        <div class="step-box {{ $order->logistic_status == 'completed' ? 'active' : '' }}">
            <span class="icon">🔥</span>
            <span class="label">Finished</span>
        </div>
    </div>

    <div class="order-grid">
        
        <main class="receipt-main">
            <div class="receipt-header">
                <div class="invoice-title">
                    <span style="font-weight: 800; color: var(--titanium-orange); font-size: 0.8rem;">OFFICIAL RECEIPT</span>
                    <h1>#{{ $order->invoice }}</h1>
                    <p style="color: #86868b; font-size: 0.9rem; margin-top: 5px;">Created on {{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div class="status-pill">{{ strtoupper($order->status) }}</div>
            </div>

            <div class="items-display">
                <span class="summary-title">Manifest Items</span>
                @foreach($order->items as $item)
                    <div class="product-row">
                        <div class="product-img">
                            @if($item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" style="width: 100%; height: 100%; object-fit: contain;">
                            @else
                                ⚙️
                            @endif
                        </div>
                        <div class="product-meta">
                            <h4>{{ $item->product->name }}</h4>
                            <span>{{ $item->quantity }} Units × Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="subtotal-area">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 40px; text-align: center;">
                <a href="{{ route('user.orders.index') }}" style="color: #86868b; text-decoration: none; font-size: 0.85rem; font-weight: 700;">
                    ← Return to Fleet History
                </a>
            </div>
        </main>

        <aside class="order-sidebar">
            <div class="side-card">
                <span class="summary-title">Transaction Total</span>
                <div class="total-price">
                    <span style="font-size: 1rem; color: #86868b;">Rp</span> 
                    {{ number_format($order->total_price, 0, ',', '.') }}
                </div>

                <div class="action-zone">
                    @if($order->logistic_status === 'completed')
                        <div style="background: #e8f5e9; color: #2e7d32; padding: 20px; border-radius: 20px; text-align: center; font-weight: 900;">
                            TRANSACTION FINISHED
                        </div>
                    @else
                        <form action="{{ route('user.orders.complete', $order->id) }}" method="POST">
                            @csrf
                            @php $isDelivered = ($order->logistic_status === 'delivered'); @endphp
                            
                            <button type="submit" class="btn-action btn-complete" {{ !$isDelivered ? 'disabled' : '' }}>
                                {{ $isDelivered ? 'Complete Mission' : 'Awaiting Cargo' }}
                            </button>

                            @if(!$isDelivered)
                                <div class="locked-msg locked-card">
                                    <span>🔒</span>
                                    Confirmed after courier arrives
                                </div>
                            @endif
                        </form>
                    @endif
                </div>
            </div>

            <div class="side-card" style="background: var(--charcoal); color: white;">
                <span class="summary-title" style="color: var(--titanium-orange);">Support Info</span>
                <p style="font-size: 0.85rem; line-height: 1.6; opacity: 0.8;">If you encounter any issues with your hardware, please contact our tactical support team.</p>
                <div style="margin-top: 15px; font-weight: 900; font-size: 0.9rem;">24/7 HELPLINE Active</div>
            </div>
        </aside>
    </div>
</div>
@endsection