@extends('layouts.app')

@section('content')

<style>
    .shipping-wrapper {
        max-width: 650px;
        margin: 50px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .shipping-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid #edf2f7;
        padding: 40px;
    }

    .form-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .form-header h1 {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 8px;
    }

    .form-header p {
        color: #718096;
        font-size: 0.95rem;
    }

    /* Form Group Styling */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        color: #2d3748;
        transition: all 0.3s ease;
        box-sizing: border-box; /* Pastikan padding tidak merusak lebar */
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Grid for City and Postal Code */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* Submit Button */
    .btn-save {
        width: 100%;
        background: #4f46e5;
        color: white;
        border: none;
        padding: 16px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        margin-top: 20px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    .btn-save:hover {
        background: #4338ca;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
    }

    @media (max-width: 640px) {
        .form-row { grid-template-columns: 1fr; }
        .shipping-card { padding: 25px; }
    }
</style>

<div class="shipping-wrapper">
    <div class="shipping-card">
        <div class="form-header">
            <h1>📍 Data Pengiriman</h1>
            <p>Lengkapi detail tujuan agar paketmu sampai dengan selamat.</p>
        </div>

        <form action="{{ route('shipping.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="phone"
                       placeholder="Contoh: 08123456789"
                       value="{{ auth()->user()->phone }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="address"
                    placeholder="Nama jalan, nomor rumah, RT/RW, Kecamatan"
                    class="form-control">{{ auth()->user()->address }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kota / Kabupaten</label>
                    <input type="text" name="city"
                           placeholder="Jakarta Selatan"
                           value="{{ auth()->user()->city }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" name="postal_code"
                           placeholder="12345"
                           value="{{ auth()->user()->postal_code }}"
                           class="form-control">
                </div>
            </div>

            <button type="submit" class="btn-save">
                Simpan & Lanjutkan
            </button>
        </form>
    </div>
</div>

@endsection