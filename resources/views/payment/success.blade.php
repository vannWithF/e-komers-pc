@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.5);
        --text-dark: #1a1a1a;
        --success-green: #34c759; /* Apple Success Green */
    }

    .success-wrapper {
        max-width: 600px;
        margin: 80px auto;
        padding: 0 25px;
        perspective: 1000px;
    }

    .success-card {
        background: var(--glass-bg);
        backdrop-filter: blur(30px) saturate(180%);
        -webkit-backdrop-filter: blur(30px) saturate(180%);
        padding: 60px 40px;
        border-radius: 50px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 40px 100px rgba(255, 107, 53, 0.1);
        text-align: center;
        animation: cardEntrance 1s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Animated Icon Section */
    .icon-box {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 35px;
    }

    .icon-circle {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-titanium));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 45px;
        color: white;
        box-shadow: 0 20px 40px rgba(232, 90, 36, 0.3);
        animation: bounceIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Success Header */
    h2 {
        font-size: 2.8rem;
        font-weight: 900;
        letter-spacing: -2px;
        color: var(--text-dark);
        margin: 0 0 15px 0;
        line-height: 1;
    }

    .message {
        color: #86868b;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    /* Minimalist Order Info */
    .order-status-panel {
        background: rgba(0, 0, 0, 0.03);
        border-radius: 30px;
        padding: 25px;
        margin-bottom: 40px;
        border: 1px solid rgba(0, 0, 0, 0.02);
    }

    .status-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .status-row:last-child { margin-bottom: 0; }

    .status-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #a1a1a6;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .status-value {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .badge-paid {
        background: var(--success-green);
        color: white;
        padding: 5px 15px;
        border-radius: 12px;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    /* Buttons Group */
    .action-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .btn-track {
        background: var(--text-dark);
        color: white;
        text-decoration: none;
        padding: 22px;
        border-radius: 22px;
        font-weight: 800;
        font-size: 1rem;
        transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .btn-track:hover {
        transform: translateY(-5px);
        background: #000;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .btn-continue {
        color: var(--deep-titanium);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 700;
        padding: 10px;
        transition: 0.3s;
    }

    .btn-continue:hover {
        opacity: 0.7;
    }

    /* Animations */
    @keyframes cardEntrance {
        from { opacity: 0; transform: translateY(60px) rotateX(-10deg); }
        to { opacity: 1; transform: translateY(0) rotateX(0); }
    }

    @keyframes bounceIn {
        0% { transform: scale(0); opacity: 0; }
        60% { transform: scale(1.15); opacity: 1; }
        100% { transform: scale(1); }
    }
</style>

<div class="success-wrapper">
    <div class="success-card">
        <div class="icon-box">
            <div class="icon-circle">
                ✓
            </div>
        </div>

        <h2>Confirmed.</h2>
        <p class="message">
            Your hardware journey begins now. We've received your payment and our technicians are preparing your setup.
        </p>

        <div class="order-status-panel">
            <div class="status-row">
                <span class="status-label">Reference</span>
                <span class="status-value">#{{ $order->invoice }}</span>
            </div>
            <div class="status-row">
                <span class="status-label">Payment Status</span>
                <span class="status-value">
                    <span class="badge-paid">SECURED</span>
                </span>
            </div>
            <div class="status-row">
                <span class="status-label">Order Status</span>
                <span class="status-value" style="color: var(--titanium-orange);">{{ strtoupper($order->status) }}</span>
            </div>
        </div>

        <div class="action-group">
            <a href="{{ route('user.orders.index') }}" class="btn-track">
                Track My Order
            </a>
            <a href="{{ route('shop.index') }}" class="btn-continue">
                Continue Shopping &rarr;
            </a>
        </div>

        <p style="margin-top: 40px; font-size: 0.75rem; color: #c1c1c6; font-weight: 600;">
            A confirmation email has been sent to your registered account.
        </p>
    </div>
</div>

@endsection