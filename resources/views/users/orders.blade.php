@extends('layouts.app')

@section('content')

<style>
    .orders-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 30px;
    }

    /* Table Styling */
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th {
        background-color: #f8fafc;
        padding: 18px 20px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        border-bottom: 2px solid #f1f5f9;
    }

    td {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.95rem;
        vertical-align: middle;
    }

    tr:last-child td { border-bottom: none; }

    /* Badge Logic */
    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-paid { background: #dcfce7; color: #166534; }
    .status-shipped { background: #e0e7ff; color: #3730a3; }
    .status-default { background: #f1f5f9; color: #475569; }

    /* Action Button */
    .btn-detail {
        text-decoration: none;
        color: #4f46e5;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background-color: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 640px) {
        .hidden-mobile { display: none; }
        td { padding: 15px; }
    }
</style>

<div class="orders-container">
    <h2 class="page-title">📦 Pesanan Saya</h2>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th class="hidden-mobile">Total Pembayaran</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td style="font-weight: 600; color: #1e293b;">
                            #{{ $order->invoice }}
                        </td>
                        <td class="hidden-mobile">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td>
                            @php
                                $statusClass = match(strtolower($order->status)) {
                                    'pending' => 'status-pending',
                                    'paid'    => 'status-paid',
                                    'shipped' => 'status-shipped',
                                    default   => 'status-default'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('user.orders.show', $order->id) }}" class="btn-detail">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 50px; color: #94a3b8;">
                            Belum ada riwayat pesanan. <br>
                            <a href="{{ route('shop.index') }}" style="color: #4f46e5; text-decoration: none; font-weight: 600;">Mulai Belanja &rarr;</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $orders->links() }}
    </div>
</div>

@endsection