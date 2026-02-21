@extends('layouts.app')

@section('content')

<style>
    .detail-container {
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        max-width: 900px;
        margin: 20px auto;
        color: #333;
        line-height: 1.6;
    }

    /* Header & Card Style */
    .card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        padding: 25px;
        margin-bottom: 25px;
        border: 1px solid #eee;
    }

    h2, h3 {
        margin-top: 0;
        color: #2c3e50;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }

    /* Info Order Section */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 10px;
    }

    .info-item label {
        display: block;
        font-size: 0.85rem;
        color: #888;
        text-transform: uppercase;
        font-weight: bold;
    }

    .info-item p {
        margin: 5px 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
    }

    th {
        background-color: #f8f9fa;
        text-align: left;
        padding: 12px;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

    .text-right { text-align: right; }

    /* Form & Button Styling */
    .form-group {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 15px;
    }

    select {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        flex-grow: 1;
        font-size: 1rem;
        outline: none;
    }

    select:focus { border-color: #4A90E2; }

    button {
        background-color: #27ae60;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.3s;
    }

    button:hover { background-color: #219150; }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.9rem;
        background: #e1f5fe;
        color: #0288d1;
    }
</style>

<div class="detail-container">
    <div class="card">
        <h2>Detail Order</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Invoice</label>
                <p style="color: #4A90E2;">#{{ $order->invoice }}</p>
            </div>
            <div class="info-item">
                <label>Pelanggan</label>
                <p>{{ $order->user->name }}</p>
            </div>
            <div class="info-item">
                <label>Status Saat Ini</label>
                <p><span class="status-badge">{{ ucfirst($order->status) }}</span></p>
            </div>
        </div>
    </div>

    <div class="card">
        <h3>Item Pesanan</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th style="text-align: center;">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td style="font-weight: 500;">{{ $item->product->name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td class="text-right" style="font-weight: bold;">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right" style="padding-top: 20px; font-weight: bold;">Total Pembayaran:</td>
                        <td class="text-right" style="padding-top: 20px; font-size: 1.2rem; color: #e74c3c; font-weight: 800;">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card">
        <h3>Ubah Status Pesanan</h3>
        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <select name="status">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                </select>
                <button type="submit">Update Status</button>
            </div>
        </form>
    </div>
</div>

@endsection