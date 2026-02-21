@extends('layouts.app')

@section('content')

<style>
    .cart-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cart-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Table Styling */
    .cart-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th {
        background-color: #f8fafc;
        padding: 15px 20px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        border-bottom: 2px solid #edf2f7;
    }

    td {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    /* Product Column */
    .product-name {
        font-weight: 600;
        color: #1e293b;
    }

    /* Button Hapus */
    .btn-remove {
        background: none;
        border: none;
        color: #ef4444;
        font-weight: 600;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 6px;
        transition: background 0.2s;
        font-size: 0.85rem;
    }

    .btn-remove:hover {
        background-color: #fef2f2;
    }

    /* Footer & Total Section */
    .cart-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 40px;
        padding: 10px 0;
    }

    .total-price {
        text-align: right;
    }

    .total-price span {
        display: block;
        font-size: 0.9rem;
        color: #64748b;
    }

    .total-price strong {
        font-size: 1.5rem;
        color: #1a202c;
    }

    /* Checkout Button */
    .btn-checkout {
        display: inline-block;
        background-color: #4f46e5;
        color: white;
        text-decoration: none;
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
    }

    .btn-checkout:hover {
        background-color: #4338ca;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        background: #f8fafc;
        border-radius: 15px;
        border: 2px dashed #e2e8f0;
    }

    .empty-cart p {
        color: #64748b;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    @media (max-width: 640px) {
        .cart-footer {
            flex-direction: column;
            align-items: flex-end;
        }
    }
</style>

<div class="cart-container">
    <h2 class="cart-title">🛒 Keranjang Belanja</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="cart-card">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th style="text-align: center;">Jumlah</th>
                        <th>Total</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td class="product-name">{{ $item['name'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td style="text-align: center;">{{ $item['quantity'] }}</td>
                            <td style="font-weight: 700;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td style="text-align: center;">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-remove">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart-footer">
            <div class="total-price">
                <span>Total Pembayaran</span>
                <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn-checkout">
                Lanjut ke Checkout &rarr;
            </a>
        </div>

    @else
        <div class="empty-cart">
            <p>Wah, keranjang belanjamu masih kosong nih.</p>
            <a href="/" class="btn-checkout" style="background-color: #64748b;">Mulai Belanja</a>
        </div>
    @endif
</div>

@endsection