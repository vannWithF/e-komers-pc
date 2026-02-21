@extends('layouts.app')

@section('content')

<style>
    .orders-wrapper {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .header-section {
        margin-bottom: 30px;
    }

    .header-section h2 {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1a202c;
    }

    /* Table Container */
    .table-responsive {
        background: #ffffff;
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
        padding: 15px 20px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        border-bottom: 2px solid #f1f5f9;
    }

    td {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.95rem;
        vertical-align: middle;
    }

    /* Status Badge Styling */
    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: capitalize;
    }

    .status-pending { background-color: #fef3c7; color: #92400e; }
    .status-paid { background-color: #dcfce7; color: #166534; }
    .status-shipped { background-color: #e0e7ff; color: #3730a3; }
    .status-completed { background-color: #d1fae5; color: #065f46; }

    /* Action Button */
    .btn-detail {
        text-decoration: none;
        color: #4f46e5;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 8px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background-color: #4f46e5;
        color: #ffffff;
        border-color: #4f46e5;
    }

    /* Pagination Styling Custom */
    .pagination-container {
        margin-top: 25px;
        display: flex;
        justify-content: center;
    }

    /* Alert Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #f8fafc;
        border-radius: 16px;
        border: 2px dashed #cbd5e0;
    }

    .empty-state p {
        color: #718096;
        margin-bottom: 20px;
    }

    @media (max-width: 640px) {
        .hidden-mobile { display: none; }
    }
</style>

<div class="orders-wrapper">
    <div class="header-section">
        <h2>📦 My Orders</h2>
    </div>

    @if($orders->count())
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="hidden-mobile">Date</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td style="font-weight: 600; color: #1a202c;">
                                #{{ $order->invoice ?? $order->id }}
                            </td>
                            <td style="font-weight: 700;">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td>
                                @php
                                    $status = strtolower($order->status);
                                    $badgeClass = match($status) {
                                        'pending' => 'status-pending',
                                        'paid' => 'status-paid',
                                        'shipped' => 'status-shipped',
                                        'completed' => 'status-completed',
                                        default => 'status-pending'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="hidden-mobile" style="color: #94a3b8;">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('user.orders.show', $order) }}" class="btn-detail">
                                    Lihat Detail
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
    @else
        <div class="empty-state">
            <p>Wah, sepertinya kamu belum pernah melakukan pemesanan.</p>
            <a href="{{ route('shop.index') }}" class="btn-detail" style="background: #4f46e5; color: white;">
                Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>

@endsection