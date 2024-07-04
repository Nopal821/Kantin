@extends('layouts.style')

@section('title', 'Terima Pesanan')

@section('content')
    <div class="container">
        <h1>Terima Pesanan</h1>

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
        </div>

        <div class="payment-form">
        <form id="paymentForm" action="{{ route('orders.process', $order->id) }}" method="post">
    @csrf
    <label for="student_name">Nama Siswa:</label>
    <input type="text" id="student_name" name="student_name" required>
    <label for="amount_given">Uang yang Diberikan:</label>
    <input type="number" id="amount_given" name="amount_given" min="0" required>
    @error('amount_given')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <button type="submit">Proses</button>
</form>

        </div>
    </div>

    <!-- Card Pop-Up -->
    <div id="payment-info" class="payment-info">
        <div class="payment-info-content">
            <span class="close">&times;</span>
            <h2>Informasi Pembayaran</h2>
            <p class="change-info"></p>
        </div>
    </div>
@endsection

<style>
    /* Gaya untuk card pop-up */
    .payment-info {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .payment-info-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
