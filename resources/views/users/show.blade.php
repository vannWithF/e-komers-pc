@extends('layouts.app')

@section('content')

<style>
    .order-detail-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .order-header {
        background: #ffffff;
        padding: 30px;
        border-radius: 16px 16px 0 0;
        border: 1px solid #edf2f7;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-header h2 {
        margin: 0;
        font-size: 1.25rem;
        color: #1a202c;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        background: #ebf8ff;
        color: #2b6cb0;
    }

    /* Table Section */
    .table-wrapper {
        background: white;
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f8fafc;
        text-align: left;
        padding: 15px 20px;
        font-size: 0.8rem;
        color: #718096;
        text-transform: uppercase;
    }

    td {
        padding: 20px;
        border-top: 1px solid #f1f5f9;
        color: #2d3748;
    }

    .subtotal-text {
        font-weight: 700;
        color: #1a202c;
    }

    /* Footer & Action */
    .order-footer {
        background: #ffffff;
        padding: 30px;
        border-radius: 0 0 16px 16px;
        border: 1px solid #edf2f7;
        border-top: none;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .total-summary {
        margin-bottom: 20px;
        text-align: right;
    }

    .total-summary p {
        margin: 5px 0;
        color: #718096;
    }

    .total-summary h3 {
        margin: 10px 0;
        font-size: 1.5rem;
        color: #4f46e5;
    }

    .btn-complete {
        background: #10b981;
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-complete:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    @media (max-width: 640px) {
        .order-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .order-footer { align-items: center; }
    }
</style>

<div class="order-detail-container">
    <div class="order-header">
        <div>
            <p style="color: #718096; margin-bottom: 5px; font-size: 0.9rem;">Invoice</p>
            <h2>#{{ $order->invoice }}</h2>
        </div>
        <span class="status-badge">
            {{ $order->status }}
        </span>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td style="font-weight: 600;">{{ $item->product->name }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align: right;" class="subtotal-text">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="order-footer">
        <div class="total-summary">
            <p>Ongkos Kirim: <strong>Rp 20.000</strong></p>
            <h3>Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h3>
        </div>

        @if($order->status === 'shipped')
            <form action="{{ route('user.orders.complete', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-complete">
                    Konfirmasi Barang Diterima
                </button>
            </form>
        @endif
    </div>
</div>

@endsection