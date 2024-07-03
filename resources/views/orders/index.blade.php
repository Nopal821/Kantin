@extends('layouts.style')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="container">
        <h1>Daftar Pesanan</h1>
        @if($orders->count() > 0)
            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Pengguna</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->username }}</td>
                                <td>
                                    <ul>
                                        @foreach($order->items as $item)
                                            <li>{{ $item['name'] }} ({{ $item['quantity'] }}) - Rp. {{ number_format($item['price'], 0, ',', '.') }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>Rp. {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ route('orders.accept', $order->id) }}" class="btn-accept">Terima Pesanan</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Tidak ada pesanan yang ditemukan.</p>
        @endif
    </div>
@endsection

<style>
    .container {
        padding: 20px;
    }

    .orders-table {
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 5px;
    }

    .btn-accept {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
    }
</style>
