@extends('layouts.app')

@section('content')

<style>
    .order-detail-wrapper {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .order-id-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a202c;
    }

    /* Info Card */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-box {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
    }

    /* Table Styling */
    .receipt-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f8fafc;
        padding: 15px 20px;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        border-bottom: 2px solid #f1f5f9;
    }

    td {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .product-cell {
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-weight: 700;
        color: #1a202c;
    }

    /* Totals Section */
    .receipt-footer {
        padding: 30px;
        background: #f8fafc;
        display: flex;
        justify-content: flex-end;
    }

    .total-table {
        width: 300px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .grand-total {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #e2e8f0;
        font-size: 1.25rem;
        font-weight: 800;
        color: #4f46e5;
    }

    /* Badge Color */
    .badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        background: #e0f2fe;
        color: #0369a1;
    }

    .btn-back {
        text-decoration: none;
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
        transition: color 0.2s;
    }

    .btn-back:hover { color: #1a202c; }

    @media (max-width: 640px) {
        .summary-grid { grid-template-columns: 1fr; }
        .receipt-footer { justify-content: center; }
        .total-table { width: 100%; }
    }
</style>

<div class="order-detail-wrapper">
    
    <div class="header-row">
        <h2 class="order-id-title">Detail Pesanan #{{ $order->invoice ?? $order->id }}</h2>
        <a href="{{ route('user.orders.index') }}" class="btn-back">← Kembali</a>
    </div>

    <div class="summary-grid">
        <div class="info-box">
            <div class="info-label">Status Pesanan</div>
            <div class="info-value">
                <span class="badge">{{ ucfirst($order->status) }}</span>
            </div>
        </div>
        <div class="info-box">
            <div class="info-label">Tanggal Transaksi</div>
            <div class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Metode Pembayaran</div>
            <div class="info-value">Transfer Bank</div>
        </div>
    </div>

    <div class="receipt-card">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="product-cell">
                            <span class="product-name">{{ $item->product->name ?? 'Produk Tidak Tersedia' }}</span>
                        </td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right; font-weight: 600;">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="receipt-footer">
            <div class="total-table">
                <div class="total-row">
                    <span style="color: #64748b;">Subtotal Produk</span>
                    <span style="font-weight: 600;">Rp {{ number_format($order->total_price - 20000, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span style="color: #64748b;">Ongkos Kirim</span>
                    <span style="font-weight: 600;">Rp 20.000</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection