@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #1a1a1a;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    .orders-wrapper {
        max-width: 1100px;
        margin: 60px auto;
        padding: 0 30px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* HEADER - Modern Clean */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 50px;
        animation: fadeIn 0.8s ease-out;
    }

    .header-section h2 {
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -2.5px;
        color: var(--charcoal);
        margin: 0;
    }

    .header-section h2 span {
        color: var(--titanium-orange);
    }

    .order-count {
        font-size: 0.9rem;
        font-weight: 800;
        color: #86868b;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    /* ORDER LIST - Card Based */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card-modern {
        background: white;
        border-radius: 30px;
        padding: 30px 40px;
        display: grid;
        grid-template-columns: 1.5fr 1.5fr 1fr 1fr 1fr;
        align-items: center;
        border: 1px solid #f0f0f2;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .order-card-modern:hover {
        transform: scale(1.02);
        box-shadow: 0 30px 60px rgba(0,0,0,0.04);
        border-color: var(--titanium-orange);
    }

    /* Info Grouping */
    .info-group { display: flex; flex-direction: column; }
    .info-label { 
        font-size: 0.7rem; 
        font-weight: 800; 
        color: #a1a1a6; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        margin-bottom: 5px;
    }
    .info-value { 
        font-size: 1.1rem; 
        font-weight: 800; 
        color: var(--charcoal); 
        letter-spacing: -0.5px;
    }

    .invoice-id { color: var(--titanium-orange) !important; }

    /* STATUS PILLS - Custom Glossy */
    .badge-modern {
        padding: 8px 16px;
        border-radius: 14px;
        font-size: 0.75rem;
        font-weight: 900;
        text-transform: uppercase;
        text-align: center;
        letter-spacing: 0.5px;
        width: fit-content;
    }

    .status-pending { background: #fff8e1; color: #b78103; }
    .status-paid { background: #e8f5e9; color: #2e7d32; }
    .status-shipped { background: #e3f2fd; color: #1565c0; }
    .status-completed { background: var(--charcoal); color: white; }

    /* ACTION BUTTON */
    .btn-view {
        width: 45px;
        height: 45px;
        background: #f2f2f7;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
        margin-left: auto;
    }

    .order-card-modern:hover .btn-view {
        background: var(--titanium-orange);
        color: white;
        transform: rotate(90deg);
    }

    /* EMPTY STATE - Minimalist */
    .empty-state-titanium {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        padding: 80px 40px;
        border-radius: 50px;
        border: 2px dashed #d1d1d6;
        text-align: center;
    }

    .empty-icon { font-size: 4rem; margin-bottom: 20px; display: block; }
    
    .btn-start-shopping {
        display: inline-block;
        margin-top: 30px;
        background: var(--charcoal);
        color: white;
        padding: 18px 40px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 800;
        transition: 0.3s;
    }

    .btn-start-shopping:hover {
        background: var(--titanium-orange);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(255, 107, 53, 0.3);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 900px) {
        .order-card-modern {
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 25px;
        }
        .btn-view { display: none; }
    }
</style>

<div class="orders-wrapper">
    <div class="header-section">
        <div class="header-content">
            <span class="order-count">Deployment History</span>
            <h2>My <span>Orders.</span></h2>
        </div>
    </div>

    @if($orders->count())
        <div class="orders-list">
            @foreach($orders as $order)
                <a href="{{ route('user.orders.show', $order) }}" class="order-card-modern">
                    <div class="info-group">
                        <span class="info-label">Reference</span>
                        <span class="info-value invoice-id">#{{ $order->invoice ?? $order->id }}</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Total Investment</span>
                        <span class="info-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Status</span>
                        @php
                            $status = strtolower($order->status);
                            $badgeClass = match($status) {
                                'pending' => 'status-pending',
                                'paid' => 'status-paid',
                                'shipped' => 'status-shipped',
                                'completed' => 'status-completed',
                                default => 'status-pending'
                            };
                        @endphp
                        <span class="badge-modern {{ $badgeClass }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <div class="info-group hidden-mobile">
                        <span class="info-label">Timestamp</span>
                        <span class="info-value" style="color: #86868b; font-size: 0.95rem;">
                            {{ $order->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <div class="btn-view">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>

        <div style="margin-top: 50px;">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state-titanium">
            <span class="empty-icon">🛰️</span>
            <h3 style="font-size: 1.8rem; font-weight: 900; letter-spacing: -1px;">No Shipments Found.</h3>
            <p style="color: #86868b; font-weight: 600;">Your hangar is empty. Ready to build your dream setup?</p>
            <a href="{{ route('shop.index') }}" class="btn-start-shopping">
                Initialize First Order
            </a>
        </div>
    @endif
</div>

@endsection