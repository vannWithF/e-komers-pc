@extends('layouts.app')

@section('content')

<style>
    .payment-container {
        max-width: 550px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .payment-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #eef2f7;
    }

    .payment-header {
        background: #f8fafc;
        padding: 30px;
        text-align: center;
        border-bottom: 1px solid #edf2f7;
    }

    .payment-header h2 {
        margin: 0;
        color: #1a202c;
        font-size: 1.5rem;
    }

    .invoice-badge {
        display: inline-block;
        margin-top: 10px;
        padding: 4px 12px;
        background: #e2e8f0;
        color: #475569;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .payment-body {
        padding: 30px;
    }

    .amount-box {
        text-align: center;
        margin-bottom: 30px;
    }

    .amount-box span {
        display: block;
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .amount-box strong {
        font-size: 2rem;
        color: #4f46e5;
        letter-spacing: -1px;
    }

    /* Instruction Box */
    .instruction-card {
        background: #f1f5f9;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #4f46e5;
        margin-bottom: 30px;
    }

    .instruction-card h3 {
        margin-top: 0;
        font-size: 1rem;
        color: #334155;
        margin-bottom: 15px;
    }

    .bank-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .bank-info:last-child { border: none; }

    .bank-label { color: #64748b; font-size: 0.85rem; }
    .bank-value { font-weight: 700; color: #1e293b; }

    /* Button */
    .btn-confirm {
        width: 100%;
        background-color: #10b981;
        color: white;
        border: none;
        padding: 16px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-confirm:hover {
        background-color: #059669;
        transform: translateY(-2px);
    }

    .note {
        display: block;
        text-align: center;
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 20px;
    }
</style>

<div class="payment-container">
    <div class="payment-card">
        <div class="payment-header">
            <h2>Selesaikan Pembayaran</h2>
            <span class="invoice-badge">#{{ $order->invoice }}</span>
        </div>

        <div class="payment-body">
            <div class="amount-box">
                <span>Total yang harus dibayar:</span>
                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
            </div>

            <div class="instruction-card">
                <h3>Metode Transfer Bank</h3>
                
                <div class="bank-info">
                    <span class="bank-label">Nama Bank</span>
                    <span class="bank-value">Bank UKK</span>
                </div>
                
                <div class="bank-info">
                    <span class="bank-label">Nomor Rekening</span>
                    <span class="bank-value" style="color: #4f46e5; font-size: 1.1rem;">123456789</span>
                </div>
                
                <div class="bank-info">
                    <span class="bank-label">Atas Nama</span>
                    <span class="bank-value">E-Commerce Store</span>
                </div>
            </div>

            <form action="{{ route('payment.pay', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-confirm">
                    Saya Sudah Membayar
                </button>
            </form>

            <span class="note">
                Pesanan akan diverifikasi otomatis setelah Anda menekan tombol di atas.
            </span>
        </div>
    </div>
</div>

@endsection