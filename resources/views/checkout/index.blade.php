@extends('layouts.app')

@section('content')

<style>
    .checkout-wrapper {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .checkout-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        padding: 30px;
        border: 1px solid #f0f0f0;
    }

    h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 25px;
        text-align: center;
    }

    /* Order Items List */
    .order-summary {
        margin-bottom: 25px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #edf2f7;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .item-row:last-child {
        border-bottom: none;
    }

    .item-name {
        font-weight: 500;
    }

    /* Price Breakdown Section */
    .price-breakdown {
        background-color: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        margin-top: 20px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        color: #718096;
        font-size: 0.9rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #e2e8f0;
        color: #1a202c;
    }

    .total-row strong {
        font-size: 1.3rem;
        color: #2d3748;
    }

    /* Checkout Button */
    .btn-order {
        width: 100%;
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        color: white;
        border: none;
        padding: 16px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        margin-top: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }

    .btn-order:active {
        transform: scale(0.98);
    }

    /* Security Note */
    .security-note {
        display: block;
        text-align: center;
        font-size: 0.8rem;
        color: #a0aec0;
        margin-top: 15px;
    }
</style>

<div class="checkout-wrapper">
    <div class="checkout-card">
        <h2>Konfirmasi Pesanan</h2>

        <div class="order-summary">
            @php $total = 0; @endphp
            @foreach($cart as $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp
                <div class="item-row">
                    <span class="item-name">{{ $item['name'] }} <small>x{{ $item['quantity'] }}</small></span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="price-breakdown">
            <div class="price-row">
                <span>Subtotal Produk</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="price-row">
                <span>Ongkos Kirim</span>
                <span>Rp 20.000</span>
            </div>
            <div class="total-row">
                <strong>Total Bayar</strong>
                <strong>Rp {{ number_format($total + 20000, 0, ',', '.') }}</strong>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <button type="submit" class="btn-order">
                Buat Pesanan Sekarang
            </button>
        </form>

        <span class="security-note">🔒 Transaksi Anda dijamin aman & terenkripsi</span>
    </div>
</div>

@endsection