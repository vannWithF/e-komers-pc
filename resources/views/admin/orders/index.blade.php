@extends('layouts.admin')

@section('content')

<style>
    :root {
        --primary: #4f46e5;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --bg-body: #f8fafc;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.5px;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: slideUp 0.5s ease;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    thead th {
        background: #f8fafc;
        padding: 16px 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
    }

    tbody td {
        padding: 18px 20px;
        font-size: 0.9rem;
        color: var(--text-main);
        border-bottom: 1px solid #f1f5f9;
        transition: 0.2s;
    }

    tbody tr:hover td {
        background-color: #fcfcfd;
    }

    /* Badge System */
    .badge-pill {
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Payment Status */
    .pay-pending { background: #fffbeb; color: #b45309; }
    .pay-paid { background: #f0fdf4; color: #15803d; }
    .pay-shipped { background: #eff6ff; color: #1d4ed8; }

    /* Logistic Status */
    .log-processing { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .log-shipped { background: #e0e7ff; color: #4338ca; }
    .log-delivered { background: #dcfce7; color: #166534; }
    .log-completed { background: #059669; color: #ffffff; }

    /* Action Button */
    .btn-action {
        text-decoration: none;
        background: white;
        color: var(--text-main);
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
    }

    .btn-action:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .pagination-container {
        margin-top: 25px;
    }
</style>

<div class="page-header">
    <h2 class="page-title">Order Management</h2>
    <div style="font-size: 0.85rem; color: var(--text-muted);">
        Total: <strong>{{ $orders->total() }} Orders</strong>
    </div>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Total Price</th>
                <th>Payment</th>
                <th>Logistics</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>
                        <span style="font-weight: 800; color: var(--primary);">#{{ $order->invoice }}</span>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">
                            {{ $order->created_at->format('d M Y') }}
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 700;">{{ $order->user->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">ID: {{ $order->user_id }}</div>
                    </td>
                    <td>
                        <span style="font-weight: 800;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <span class="badge-pill {{ $order->status == 'paid' ? 'pay-paid' : ($order->status == 'shipped' ? 'pay-shipped' : 'pay-pending') }}">
                            ● {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        @php
                            $logClass = 'log-processing';
                            if($order->logistic_status == 'shipped') $logClass = 'log-shipped';
                            if($order->logistic_status == 'delivered') $logClass = 'log-delivered';
                            if($order->logistic_status == 'completed') $logClass = 'log-completed';
                        @endphp
                        <span class="badge-pill {{ $logClass }}">
                            {{ ucfirst($order->logistic_status ?? 'Processing') }}
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-action">
                            Manage Detail
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination-container">
    {{ $orders->links() }}
</div>

@endsection