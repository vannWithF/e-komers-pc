@extends('layouts.app')

@section('content')

<style>
    .container {
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    .table-container {
        overflow-x: auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        text-align: left;
    }

    th {
        background-color: #4A90E2;
        color: white;
        font-weight: 600;
        padding: 15px;
    }

    td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        color: #555;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    /* Styling Badge Status */
    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-success { background: #d4edda; color: #155724; }

    /* Styling Tombol Aksi */
    .btn-detail {
        text-decoration: none;
        background-color: #4A90E2;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        transition: background 0.3s;
    }

    .btn-detail:hover {
        background-color: #357ABD;
    }

    /* Pagination Styling */
    .pagination-wrapper {
        margin-top: 20px;
    }
</style>

<div class="container">
    <h2>Data Order</h2>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td style="font-weight: bold;">#{{ $order->invoice }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $order->status == 'success' ? 'status-success' : 'status-pending' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn-detail">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $orders->links() }}
    </div>
</div>

@endsection