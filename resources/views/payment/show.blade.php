@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --glass-bg: rgba(255, 255, 255, 0.75);
        --glass-border: rgba(255, 255, 255, 0.5);
        --text-dark: #1a1a1a;
        --titanium-gray: #f2f2f7;
    }

    .payment-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 0 25px;
        animation: titaniumSlideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .payment-card {
        background: var(--glass-bg);
        backdrop-filter: blur(30px) saturate(180%);
        -webkit-backdrop-filter: blur(30px) saturate(180%);
        border-radius: 45px;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        box-shadow: 0 40px 100px rgba(0,0,0,0.06);
    }

    /* HEADER */
    .payment-header {
        background: rgba(255, 255, 255, 0.3);
        padding: 40px 30px;
        text-align: center;
        border-bottom: 1px solid rgba(0,0,0,0.03);
    }

    .payment-header h2 {
        margin: 0;
        color: var(--text-dark);
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -1.5px;
    }

    .invoice-badge {
        display: inline-block;
        margin-top: 12px;
        padding: 6px 16px;
        background: var(--text-dark);
        color: white;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1px;
    }

    /* BODY */
    .payment-body {
        padding: 45px;
    }

    .amount-box {
        text-align: center;
        margin-bottom: 40px;
    }

    .amount-box span {
        display: block;
        color: #86868b;
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .amount-box strong {
        font-size: 3rem;
        color: var(--text-dark);
        letter-spacing: -2px;
        font-weight: 900;
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-titanium));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* INSTRUCTION CARD (The Titanium Look) */
    .instruction-card {
        background: var(--titanium-gray);
        padding: 30px;
        border-radius: 35px;
        border: 1px solid rgba(0,0,0,0.03);
        margin-bottom: 40px;
        position: relative;
    }

    .instruction-card h3 {
        margin-top: 0;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--titanium-orange);
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .bank-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .bank-info:last-child { border: none; margin-bottom: 0; padding-bottom: 0; }

    .bank-label { color: #86868b; font-size: 0.9rem; font-weight: 600; }
    .bank-value { font-weight: 800; color: var(--text-dark); font-size: 1rem; }

    .copy-button {
        font-size: 0.7rem;
        color: var(--titanium-orange);
        background: white;
        padding: 4px 10px;
        border-radius: 8px;
        margin-left: 8px;
        border: 1px solid var(--glass-border);
        cursor: pointer;
    }

    /* BUTTONS */
    .btn-confirm-titanium {
        width: 100%;
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-titanium));
        color: white;
        border: none;
        padding: 24px;
        border-radius: 24px;
        font-size: 1.1rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 20px 40px rgba(232, 90, 36, 0.25);
    }

    .btn-confirm-titanium:hover {
        transform: translateY(-5px);
        filter: brightness(1.1);
        box-shadow: 0 25px 50px rgba(232, 90, 36, 0.35);
    }

    .note-footer {
        display: block;
        text-align: center;
        font-size: 0.8rem;
        font-weight: 600;
        color: #c1c1c6;
        margin-top: 25px;
        line-height: 1.5;
    }

    @keyframes titaniumSlideUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="payment-container">
    <div class="payment-card">
        <div class="payment-header">
            <h2>Complete Payment.</h2>
            <span class="invoice-badge">INVOICE #{{ $order->invoice }}</span>
        </div>

        <div class="payment-body">
            <div class="amount-box">
                <span>Total Amount Due</span>
                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
            </div>

            <div class="instruction-card">
                <h3>Bank Transfer Method</h3>
                
                <div class="bank-info">
                    <span class="bank-label">Destination Bank</span>
                    <span class="bank-value">Bank UKK Titanium</span>
                </div>
                
                <div class="bank-info">
                    <span class="bank-label">Account Number</span>
                    <span class="bank-value" style="font-size: 1.2rem; color: var(--titanium-orange);">
                        123456789 <button class="copy-button" onclick="alert('Copied!')">COPY</button>
                    </span>
                </div>
                
                <div class="bank-info">
                    <span class="bank-label">Account Name</span>
                    <span class="bank-value">Warunk PC-Station</span>
                </div>
            </div>

            <form action="{{ route('payment.pay', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-confirm-titanium">
                    Confirm My Payment
                </button>
            </form>

            <span class="note-footer">
                🔒 Your transaction is secured by titanium-grade encryption.<br>
                Verification usually takes less than 5 minutes.
            </span>
        </div>
    </div>
</div>

@endsection