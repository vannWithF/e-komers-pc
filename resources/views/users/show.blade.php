@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #121212;
        --soft-bg: #f5f5f7;
    }

    .order-detail-container {
        max-width: 850px;
        margin: 60px auto;
        padding: 0 25px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 1. PAPER EFFECT CARD */
    .receipt-paper {
        background: white;
        border-radius: 40px;
        box-shadow: 0 40px 80px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f2;
        overflow: hidden;
        position: relative;
        animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Decorative Circle Cutouts (Efek Tiket) */
    .receipt-paper::before, .receipt-paper::after {
        content: "";
        position: absolute;
        width: 30px;
        height: 30px;
        background: var(--soft-bg); /* Sesuai warna background body */
        border-radius: 50%;
        top: 175px; /* Sesuaikan dengan posisi dashed line */
        z-index: 2;
    }
    .receipt-paper::before { left: -15px; }
    .receipt-paper::after { right: -15px; }

    /* 2. HEADER SECTION */
    .order-header {
        padding: 50px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background: linear-gradient(to bottom, #fbfbfd, white);
    }

    .invoice-brand h1 {
        font-size: 2.2rem;
        font-weight: 900;
        letter-spacing: -2px;
        color: var(--charcoal);
        margin: 0;
    }

    .invoice-brand span { color: var(--titanium-orange); }

    .status-badge-titanium {
        padding: 10px 24px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: var(--charcoal);
        color: white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    /* 3. DASHED DIVIDER */
    .receipt-divider {
        margin: 0 30px;
        border-top: 2px dashed #f0f0f2;
        position: relative;
    }

    /* 4. TABLE SECTION */
    .table-wrapper { padding: 40px 50px; }
    
    table { width: 100%; border-collapse: collapse; }
    
    th {
        text-align: left;
        padding-bottom: 20px;
        font-size: 0.75rem;
        color: #aeaeae;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 800;
    }

    td {
        padding: 25px 0;
        border-bottom: 1px solid #f5f5f7;
        color: var(--charcoal);
        font-size: 1rem;
    }

    .item-info h4 { margin: 0; font-weight: 800; font-size: 1.1rem; }
    .item-info span { font-size: 0.85rem; color: #86868b; font-weight: 600; }

    .price-col { font-weight: 800; text-align: right; }

    /* 5. SUMMARY FOOTER */
    .order-footer {
        padding: 40px 50px 60px;
        background: #fbfbfd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .summary-box { text-align: left; }
    .summary-label { font-size: 0.9rem; color: #86868b; font-weight: 600; display: block; }
    .total-value { font-size: 2.5rem; font-weight: 900; color: var(--charcoal); letter-spacing: -2px; }
    .total-value span { font-size: 1.2rem; color: #aeaeae; margin-right: 5px; }

    /* 6. BUTTON ACTION */
    .btn-confirm-titanium {
        background: var(--titanium-orange);
        color: white;
        border: none;
        padding: 20px 35px;
        border-radius: 20px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 15px 30px rgba(255, 107, 53, 0.25);
    }

    .btn-confirm-titanium:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 20px 40px rgba(255, 107, 53, 0.4);
        filter: brightness(1.1);
    }

    /* Animations */
    @keyframes slideUpFade {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 640px) {
        .order-header { flex-direction: column; gap: 20px; padding: 30px; }
        .order-footer { flex-direction: column; gap: 30px; text-align: center; }
        .total-value { font-size: 2rem; }
    }
</style>

<div class="order-detail-container">
    <div class="receipt-paper">
        
        <div class="order-header">
            <div class="invoice-brand">
                <p style="font-weight: 800; color: var(--titanium-orange); font-size: 0.75rem; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">Hardware Shipment</p>
                <h1>INV<span>.</span>#{{ $order->invoice }}</h1>
                <p style="color: #86868b; font-size: 0.9rem; font-weight: 600; margin-top: 5px;">Issued on {{ $order->created_at->format('d M Y') }}</p>
            </div>
            <div class="status-badge-titanium">
                {{ $order->status }}
            </div>
        </div>

        <div class="receipt-divider"></div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Hardware Unit</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="item-info">
                                    <h4>{{ $item->product->name }}</h4>
                                    <span>Base Price: Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td style="text-align: center; font-weight: 800; color: #86868b;">
                                {{ $item->quantity }}
                            </td>
                            <td class="price-col">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="order-footer">
            <div class="summary-box">
                <span class="summary-label">Total Investment</span>
                <div class="total-value">
                    <span>IDR</span>{{ number_format($order->total_price, 0, ',', '.') }}
                </div>
                <p style="font-size: 0.75rem; color: #aeaeae; font-weight: 700; margin-top: 5px;">
                    *Includes logistic tax & titanium protection
                </p>
            </div>

            @if($order->status === 'shipped')
                <form action="{{ route('user.orders.complete', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-confirm-titanium">
                        Verify Delivery
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('user.orders.index') }}" style="text-decoration: none; color: #aeaeae; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s;">
            ← Return to Fleet Logs
        </a>
    </div>
</div>

@endsection