@extends('layouts.admin')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-orange: #e85a24;
        --glass-bg: rgba(255, 255, 255, 0.25);
        --glass-border: rgba(255, 255, 255, 0.5);
        --text-main: #2d1a12;
        --text-muted: #8a7b75;
    }

    /* Layout Header yang lebih lega */
    .page-header {
        margin-bottom: 40px;
        padding: 0 10px;
    }

    .page-title {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--text-main);
        letter-spacing: -1.5px;
        background: linear-gradient(to right, var(--text-main), var(--titanium-orange));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* STRUKTUR BARU: Grid Card Flow (Bukan Tabel Baris) */
    .order-grid {
        display: grid;
        grid-template-columns: 1fr; /* List view tapi berbentuk Card */
        gap: 20px;
        animation: liquidAppear 1s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .order-item-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px) saturate(160%);
        -webkit-backdrop-filter: blur(25px) saturate(160%);
        border: 1px solid var(--glass-border);
        border-radius: 35px; /* Lebih bulat */
        padding: 25px 35px;
        display: grid;
        grid-template-columns: 1.2fr 1.5fr 1fr 1fr 0.8fr; /* Pembagian kolom horizontal */
        align-items: center;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        overflow: hidden;
    }

    /* Efek air saat hover */
    .order-item-card:hover {
        transform: translateY(-5px) scale(1.01);
        background: rgba(255, 255, 255, 0.4);
        box-shadow: 0 20px 40px rgba(232, 90, 36, 0.08);
        border-color: var(--titanium-orange);
    }

    /* Desain Informasi Order */
    .info-group { display: flex; flex-direction: column; gap: 4px; }
    .info-label { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; }
    .info-value { font-weight: 700; color: var(--text-main); font-size: 1rem; }
    
    .invoice-tag {
        background: white;
        color: var(--deep-orange);
        padding: 6px 15px;
        border-radius: 15px;
        font-weight: 900;
        font-size: 0.85rem;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(232, 90, 36, 0.1);
    }

    /* Badge & Status Custom */
    .status-pill {
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
        width: fit-content;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .status-paid { background: var(--titanium-orange); color: white; box-shadow: 0 8px 15px rgba(255, 107, 51, 0.3); }
    .status-pending { background: rgba(255,255,255,0.6); color: var(--text-muted); }
    
    /* Tombol Action Modern melayang */
    .manage-btn {
        background: var(--text-main);
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 22px;
        font-size: 0.8rem;
        font-weight: 700;
        text-align: center;
        transition: 0.4s;
        border: 1px solid transparent;
    }

    .manage-btn:hover {
        background: transparent;
        color: var(--text-main);
        border-color: var(--text-main);
    }

    @keyframes liquidAppear {
        from { opacity: 0; transform: translateY(40px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Header Tabel "Palsu" untuk deskripsi kolom */
    .list-header {
        display: grid;
        grid-template-columns: 1.2fr 1.5fr 1fr 1fr 0.8fr;
        padding: 0 35px 15px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 1.5px;
    }

    @media (max-width: 1000px) {
        .order-item-card, .list-header { grid-template-columns: 1fr 1fr; gap: 20px; }
        .list-header { display: none; }
        .manage-btn { grid-column: span 2; }
    }
</style>

<div class="page-header">
    <h2 class="page-title">Order Stream</h2>
    <p style="color: var(--text-muted); font-weight: 600; margin-top: 5px;">Manage your store transactions with liquid flow interface.</p>
</div>

<div class="list-header">
    <div>Identification</div>
    <div>Customer Detail</div>
    <div>Amount</div>
    <div>Status</div>
    <div style="text-align: right;">Action</div>
</div>

<div class="order-grid">
    @foreach($orders as $order)
        <div class="order-item-card">
            <div class="info-group">
                <span class="info-label">Transaction</span>
                <div>
                    <span class="invoice-tag">#{{ $order->invoice }}</span>
                </div>
                <span style="font-size: 0.7rem; color: var(--text-muted); margin-top: 5px;">{{ $order->created_at->format('M d, Y') }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Customer Info</span>
                <span class="info-value">{{ $order->user->name }}</span>
                <span style="font-size: 0.75rem; color: var(--text-muted);">UID: {{ $order->user_id }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Revenue</span>
                <span class="info-value" style="font-size: 1.1rem;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Status Flow</span>
                <div class="status-pill {{ $order->status == 'paid' ? 'status-paid' : 'status-pending' }}">
                    {{ strtoupper($order->status) }}
                </div>
            </div>

            <div style="text-align: right;">
                <a href="{{ route('admin.orders.show', $order->id) }}" class="manage-btn">
                    Manage
                </a>
            </div>
        </div>
    @endforeach
</div>

<div class="pagination-container">
    {{ $orders->links() }}
</div>

@endsection