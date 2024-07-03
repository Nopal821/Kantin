@extends('layouts.style')

@section('title', 'Receipt')

@section('content')
    <div class="container">
        <h1>Receipt</h1>

        <div class="order-details">
            <h2>Detail Pesanan</h2>
            <p>ID Pesanan: {{ $order->id }}</p>
            <p>Nama Pengguna: {{ $order->username }}</p>
            <ul>
                @foreach($order->items as $item)
                    <li>{{ $item['name'] }} ({{ $item['quantity'] }}) - Rp. {{ number_format($item['price'], 0, ',', '.') }}</li>
                @endforeach
            </ul>
            <p>Total: Rp. {{ number_format($order->total, 0, ',', '.') }}</p>
            <p>Nama Siswa: {{ $order->student_name }}</p>
            <p>Uang yang Diberikan: Rp. {{ $order->amount_given }}</p>
            <p>Kembalian: Rp. {{ $order->change }}</p>
        </div>

        <div>
            <!-- Tambahkan tombol "Pesanan Selesai" -->
            <a href="{{ route('orders.complete', $order->id) }}" class="btn">Pesanan Selesai</a>
        </div>
    </div>
@endsection
