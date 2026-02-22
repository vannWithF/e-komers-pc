@extends('layouts.admin') {{-- Pastikan pakai layout admin yang kita buat tadi --}}

@section('content')

<style>
    :root {
        --primary: #4f46e5;
        --success: #22c55e;
        --warning: #f59e0b;
        --danger: #ef4444;
        --text-dark: #1e293b;
        --text-light: #64748b;
    }

    .order-wrapper {
        animation: fadeIn 0.5s ease;
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Grid Layout */
    .order-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
    }

    /* Card Styling */
    .order-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Info Header */
    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .inv-label { font-size: 0.85rem; color: var(--text-light); font-weight: 600; text-transform: uppercase; }
    .inv-number { font-size: 1.5rem; font-weight: 900; color: var(--primary); }

    /* Tables */
    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 12px; font-size: 0.85rem; color: var(--text-light); border-bottom: 2px solid #f1f5f9; }
    td { padding: 15px 12px; font-size: 0.95rem; border-bottom: 1px solid #f1f5f9; }

    /* Form Controls */
    .form-label { display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; color: var(--text-dark); }
    select {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        font-family: inherit;
        font-weight: 600;
        outline: none;
        transition: 0.2s;
        margin-bottom: 15px;
    }
    select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }

    .btn-update {
        width: 100%;
        background: var(--primary);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-update:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); }

    /* Badge */
    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .badge-pending { background: #fffbeb; color: #d97706; }
    .badge-paid { background: #f0fdf4; color: #16a34a; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 768px) { .order-grid { grid-template-columns: 1fr; } }
</style>

<div class="order-wrapper">
    
    <div class="order-card">
        <div class="invoice-header">
            <div>
                <span class="inv-label">Transaction Invoice</span>
                <h1 class="inv-number">#{{ $order->invoice }}</h1>
            </div>
            <div style="text-align: right;">
                <span class="inv-label">Customer</span>
                <p style="font-weight: 700; font-size: 1.1rem;">{{ $order->user->name }}</p>
                <p style="font-size: 0.85rem; color: var(--text-light);">{{ $order->user->email }}</p>
            </div>
        </div>

        <div style="display: flex; gap: 40px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
            <div>
                <span class="inv-label">Payment Status</span> <br>
                <span class="badge {{ $order->status == 'paid' ? 'badge-paid' : 'badge-pending' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div>
                <span class="inv-label">Logistic Status</span> <br>
                <span class="badge" style="background: #eff6ff; color: #2563eb;">
                    {{ ucfirst($order->logistic_status ?? 'Processing') }}
                </span>
            </div>
            <div>
                <span class="inv-label">Order Date</span> <br>
                <p style="font-weight: 700; font-size: 0.9rem; margin-top: 5px;">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="order-grid">
        <div class="left-col">
            <div class="order-card">
                <h3 class="card-title">📦 Items Ordered</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: var(--text-dark);">{{ $item->product->name }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-light);">Rp {{ number_format($item->price, 0, ',', '.') }} / unit</div>
                            </td>
                            <td style="text-align: center; font-weight: 700;">{{ $item->quantity }}</td>
                            <td style="text-align: right; font-weight: 800;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align: right; border: none; padding-top: 30px; font-weight: 700; color: var(--text-light);">Grand Total:</td>
                            <td style="text-align: right; border: none; padding-top: 30px; font-size: 1.4rem; font-weight: 900; color: var(--danger);">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="right-col">
            <div class="order-card">
                <h3 class="card-title">💳 Payment Action</h3>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Set Payment Status</label>
                    <select name="status">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    </select>
                    <button type="submit" class="btn-update">Update Payment</button>
                </form>
            </div>

            <div class="order-card" style="border-top: 4px solid var(--primary);">
                <h3 class="card-title">🚚 Logistic Update</h3>
                <form method="POST" action="{{ route('admin.orders.updateLogistic', $order->id) }}">
                    @csrf
                    @method('PATCH')
                    <label class="form-label">Shipping Progress</label>
                    <select name="logistic_status">
                        <option value="processing" {{ $order->logistic_status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->logistic_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->logistic_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="completed" {{ $order->logistic_status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit" class="btn-update" style="background: var(--text-dark);">Update Logistics</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection