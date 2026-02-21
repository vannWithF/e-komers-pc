@extends('layouts.app')

@section('content')

<style>
    .success-wrapper {
        max-width: 500px;
        margin: 60px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        text-align: center;
    }

    .success-card {
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        border: 1px solid #eef2f7;
    }

    /* Icon Checkmark */
    .icon-circle {
        width: 80px;
        height: 80px;
        background-color: #dcfce7;
        color: #166534;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 25px;
        animation: scaleIn 0.5s ease-out;
    }

    @keyframes scaleIn {
        0% { transform: scale(0); }
        80% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    h2 {
        color: #1a202c;
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .message {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    /* Order Details Box */
    .order-info {
        background-color: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .info-label { color: #94a3b8; }
    .info-value { color: #1e293b; font-weight: 600; }

    .status-badge {
        background: #4f46e5;
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    /* Buttons */
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-primary {
        background: #4f46e5;
        color: white;
        text-decoration: none;
        padding: 14px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #4338ca;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-secondary {
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .btn-secondary:hover {
        color: #1e293b;
    }
</style>

<div class="success-wrapper">
    <div class="success-card">
        <div class="icon-circle">
            ✓
        </div>

        <h2>Pembayaran Berhasil!</h2>
        <p class="message">
            Pesanan Anda telah kami terima dan akan segera diproses. 
            Terima kasih telah mempercayai layanan kami.
        </p>

        <div class="order-info">
            <div class="info-row">
                <span class="info-label">No. Invoice</span>
                <span class="info-value">#{{ $order->invoice }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Pesanan</span>
                <span class="info-value">
                    <span class="status-badge">{{ $order->status }}</span>
                </span>
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('user.orders.index') }}" class="btn-primary">
                Cek Status Pesanan
            </a>
            <a href="{{ route('shop.index') }}" class="btn-secondary">
                Kembali Belanja
            </a>
        </div>
    </div>
</div>

@endsection@extends('layouts.app')

@section('content')

<style>
    .success-wrapper {
        max-width: 500px;
        margin: 60px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        text-align: center;
    }

    .success-card {
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        border: 1px solid #eef2f7;
    }

    /* Icon Checkmark */
    .icon-circle {
        width: 80px;
        height: 80px;
        background-color: #dcfce7;
        color: #166534;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 25px;
        animation: scaleIn 0.5s ease-out;
    }

    @keyframes scaleIn {
        0% { transform: scale(0); }
        80% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    h2 {
        color: #1a202c;
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .message {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    /* Order Details Box */
    .order-info {
        background-color: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .info-label { color: #94a3b8; }
    .info-value { color: #1e293b; font-weight: 600; }

    .status-badge {
        background: #4f46e5;
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    /* Buttons */
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-primary {
        background: #4f46e5;
        color: white;
        text-decoration: none;
        padding: 14px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #4338ca;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-secondary {
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .btn-secondary:hover {
        color: #1e293b;
    }
</style>

<div class="success-wrapper">
    <div class="success-card">
        <div class="icon-circle">
            ✓
        </div>

        <h2>Pembayaran Berhasil!</h2>
        <p class="message">
            Pesanan Anda telah kami terima dan akan segera diproses. 
            Terima kasih telah mempercayai layanan kami.
        </p>

        <div class="order-info">
            <div class="info-row">
                <span class="info-label">No. Invoice</span>
                <span class="info-value">#{{ $order->invoice }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Pesanan</span>
                <span class="info-value">
                    <span class="status-badge">{{ $order->status }}</span>
                </span>
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('user.orders.index') }}" class="btn-primary">
                Cek Status Pesanan
            </a>
            <a href="{{ route('shop.index') }}" class="btn-secondary">
                Kembali Belanja
            </a>
        </div>
    </div>
</div>

@endsection