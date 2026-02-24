@extends('layouts.app')

@section('content')
<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #121212;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --input-bg: #f5f5f7;
    }

    .orders-container {
        max-width: 1100px;
        margin: 60px auto;
        padding: 0 30px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 1. HEADER SECTION */
    .header-info {
        margin-bottom: 50px;
        animation: fadeIn 0.8s ease;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .header-info h2 {
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -2.5px;
        color: var(--charcoal);
        margin: 0;
    }

    .header-info h2 span { color: var(--titanium-orange); }

    .fleet-badge {
        font-size: 0.75rem;
        font-weight: 900;
        color: var(--titanium-orange);
        text-transform: uppercase;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 8px;
    }

    /* 2. TABLE CARD - THE MODULAR LOOK */
    .table-card-titanium {
        background: white;
        border-radius: 40px;
        border: 1px solid #f0f0f2;
        box-shadow: 0 20px 40px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding: 25px 30px;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 800;
        color: #aeaeae;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        background: #fbfbfd;
        border-bottom: 1px solid #f2f2f7;
    }

    td {
        padding: 30px;
        border-bottom: 1px solid #f8f8fa;
        vertical-align: middle;
    }

    tr:hover td {
        background: #fcfcfd;
    }

    /* 3. INVOICE COLUMN */
    .invoice-id {
        font-size: 1.1rem;
        font-weight: 900;
        color: var(--charcoal);
        letter-spacing: -0.5px;
    }

    .order-date {
        display: block;
        font-size: 0.8rem;
        color: #aeaeae;
        font-weight: 600;
        margin-top: 4px;
    }

    /* 4. PRICE COLUMN */
    .price-value {
        font-size: 1.1rem;
        font-weight: 900;
        color: var(--charcoal);
    }

    /* 5. STATUS PILLS */
    .badge-modern {
        padding: 10px 18px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .status-pending { background: #fff8e1; color: #b78103; }
    .status-paid { background: #e8f5e9; color: #2e7d32; }
    .status-shipped { background: #e3f2fd; color: #1565c0; }
    .status-default { background: #f2f2f7; color: #86868b; }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* 6. ACTION BUTTON - THE CIRCLE LINK */
    .btn-detail-modern {
        width: 50px;
        height: 50px;
        background: var(--charcoal);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        margin: 0 auto;
    }

    .btn-detail-modern:hover {
        background: var(--titanium-orange);
        border-radius: 50%;
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3);
    }

    /* Empty State */
    .empty-hangar {
        padding: 80px 40px;
        text-align: center;
    }

    .empty-hangar h3 { font-size: 1.8rem; font-weight: 900; margin-bottom: 10px; }
    .btn-shopping {
        display: inline-block;
        margin-top: 20px;
        background: var(--charcoal);
        color: white;
        padding: 18px 40px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 800;
        transition: 0.3s;
    }

    .btn-shopping:hover { background: var(--titanium-orange); transform: translateY(-3px); }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        td { padding: 20px; }
        .hidden-mobile { display: none; }
        .header-info h2 { font-size: 2.2rem; }
    }
</style>

<div class="orders-container">
    <div class="header-info">
        <div>
            <span class="fleet-badge">System Logs</span>
            <h2>My <span>Orders.</span></h2>
        </div>
        <div class="hidden-mobile" style="text-align: right;">
            <p style="font-size: 0.8rem; font-weight: 800; color: #aeaeae;">ACTIVE SESSIONS</p>
            <p style="font-size: 1.2rem; font-weight: 900; color: var(--charcoal);">{{ $orders->count() }} Orders</p>
        </div>
    </div>

    <div class="table-card-titanium">
        @if($orders->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Reference / Date</th>
                        <th class="hidden-mobile">Investment</th>
                        <th>Status Protocol</th>
                        <th style="text-align: center;">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <span class="invoice-id">#{{ $order->invoice }}</span>
                                <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="hidden-mobile">
                                <span class="price-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @php
                                    $status = strtolower($order->status);
                                    $statusClass = match($status) {
                                        'pending' => 'status-pending',
                                        'paid'    => 'status-paid',
                                        'shipped' => 'status-shipped',
                                        default   => 'status-default'
                                    };
                                @endphp
                                <div class="badge-modern {{ $statusClass }}">
                                    <span class="status-dot"></span>
                                    {{ $order->status }}
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('user.orders.show', $order->id) }}" class="btn-detail-modern">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-hangar">
                <span style="font-size: 4rem; display: block; margin-bottom: 20px;">🛰️</span>
                <h3>Hangar Empty.</h3>
                <p style="color: #aeaeae; font-weight: 600;">You haven't initialized any hardware deployments yet.</p>
                <a href="{{ route('shop.index') }}" class="btn-shopping">Initialize First Order</a>
            </div>
        @endif
    </div>

    <div style="margin-top: 40px; display: flex; justify-content: center;">
        {{ $orders->links() }}
    </div>
</div>
@endsection