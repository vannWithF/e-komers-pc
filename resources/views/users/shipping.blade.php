@extends('layouts.app')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #121212;
        --input-bg: #f5f5f7;
    }

    .shipping-wrapper {
        max-width: 700px;
        margin: 60px auto;
        padding: 0 25px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 1. HEADER SECTION - Precise & Clear */
    .form-header {
        text-align: center;
        margin-bottom: 50px;
        animation: fadeIn 0.8s ease;
    }

    .protocol-badge {
        font-size: 0.75rem;
        font-weight: 900;
        color: var(--titanium-orange);
        text-transform: uppercase;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 10px;
    }

    .form-header h1 {
        font-size: 2.8rem;
        font-weight: 900;
        letter-spacing: -2px;
        color: var(--charcoal);
        margin: 0;
    }

    /* 2. SHIPPING CARD - Premium White */
    .shipping-card {
        background: white;
        border-radius: 40px;
        padding: 50px;
        border: 1px solid #f0f0f2;
        box-shadow: 0 30px 60px rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
    }

    .shipping-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, var(--titanium-orange), var(--deep-titanium));
    }

    /* 3. FORM GROUP - Titanium Style */
    .form-group {
        margin-bottom: 30px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        font-weight: 800;
        color: #86868b;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }

    .label-icon {
        font-size: 1rem;
        color: var(--titanium-orange);
    }

    .input-titanium {
        width: 100%;
        background: var(--input-bg);
        border: 2px solid transparent;
        padding: 18px 25px;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 700;
        color: var(--charcoal);
        transition: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-sizing: border-box;
    }

    .input-titanium:focus {
        outline: none;
        background: white;
        border-color: var(--titanium-orange);
        box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
    }

    textarea.input-titanium {
        resize: none;
        min-height: 120px;
        line-height: 1.6;
    }

    /* Grid for City and Postal Code */
    .form-row {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 25px;
    }

    /* 4. SUBMIT BUTTON - High Impact */
    .btn-protocol {
        width: 100%;
        background: var(--charcoal);
        color: white;
        border: none;
        padding: 24px;
        border-radius: 24px;
        font-size: 1rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        margin-top: 20px;
        transition: 0.4s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .btn-protocol:hover {
        background: var(--titanium-orange);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
    }

    .btn-protocol svg {
        transition: transform 0.3s ease;
    }

    .btn-protocol:hover svg {
        transform: translateX(5px);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 640px) {
        .form-row { grid-template-columns: 1fr; }
        .shipping-card { padding: 30px 20px; }
        .form-header h1 { font-size: 2rem; }
    }
</style>

<div class="shipping-wrapper">
    <div class="form-header">
        <span class="protocol-badge">Logistic Intelligence</span>
        <h1>Shipping <span>Destination.</span></h1>
    </div>

    <div class="shipping-card">
        <form action="{{ route('shipping.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>
                    <span class="label-icon">📱</span> Contact Number
                </label>
                <input type="text" name="phone"
                       placeholder="e.g., 08123456789"
                       value="{{ auth()->user()->phone }}"
                       class="input-titanium">
            </div>

            <div class="form-group">
                <label>
                    <span class="label-icon">🏠</span> Full Street Address
                </label>
                <textarea name="address"
                    placeholder="Street name, house number, apartment, etc."
                    class="input-titanium">{{ auth()->user()->address }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>
                        <span class="label-icon">🏙️</span> City / Region
                    </label>
                    <input type="text" name="city"
                           placeholder="Jakarta Selatan"
                           value="{{ auth()->user()->city }}"
                           class="input-titanium">
                </div>

                <div class="form-group">
                    <label>
                        <span class="label-icon">📮</span> Zip Code
                    </label>
                    <input type="text" name="postal_code"
                           placeholder="12345"
                           value="{{ auth()->user()->postal_code }}"
                           class="input-titanium">
                </div>
            </div>

            <button type="submit" class="btn-protocol">
                Confirm & Initialize Shipment
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </button>
        </form>
    </div>

    <p style="text-align: center; margin-top: 30px; font-size: 0.8rem; color: #aeaeae; font-weight: 600;">
        🔒 All data is encrypted and handled under Titanium Security Protocol.
    </p>
</div>

@endsection