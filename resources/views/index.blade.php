@extends('layouts.style')

@section('title', 'Kantin')

@section('content')
<head>
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
    <div class="container">
        <div class="main-content">
            @foreach($products as $product)
                <div class="card">
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="product-image">
                    <div class="product-info">
                        <h3>{{ $product->nama }}</h3>
                        <p>Rp. {{ number_format($product->harga, 0, ',', '.') }}</p>
                    </div>
                    <button class="btn-tambah" onclick="openModal({{ $product->id }})">Tambah ke Keranjang</button>
                    <a href="{{ route('products.show', $product->id) }}" class="btn-show">Tampilkan Produk</a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Modal -->
    @foreach($products as $product)
        <div id="modal-{{ $product->id }}" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal({{ $product->id }})">&times;</span>
                <h2>{{ $product->nama }}</h2>
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="modal-product-image">
                <form action="{{ route('cart.add') }}" method="post" onsubmit="showNotification(event)">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <label for="quantity-{{ $product->id }}">Jumlah:</label>
                    <input type="number" id="quantity-{{ $product->id }}" name="quantity" value="1" min="1">
                    <button type="submit">Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Notification -->
    <div id="notification" class="notification">
        <p>Produk telah ditambahkan ke keranjang!</p>
    </div>
@endsection

<script>
    function openModal(productId) {
        document.getElementById('modal-' + productId).style.display = 'block';
    }

    function closeModal(productId) {
        document.getElementById('modal-' + productId).style.display = 'none';
    }

    function showNotification(event) {
        event.preventDefault();
        const notification = document.getElementById('notification');
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
        
        const form = event.target;
        const formData = new FormData(form);
        const productId = formData.get('product_id');
        const quantity = formData.get('quantity');
        
        // Kirim permintaan AJAX untuk menambahkan produk ke keranjang
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': formData.get('_token')
            }
        }).then(response => {
            if (response.ok) {
                closeModal(productId);
            }
        });
    }
</script>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #FFFFFF;
        margin: 0;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }

    .main-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .card {
        background-color: #FFFFFF;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative; /* Tambahkan posisi relatif */
        z-index: 1; /* Atur z-index agar lebih tinggi dari notifikasi */
    }

    .product-image {
        max-width: 100px;
        max-height: 100px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .product-info {
        margin-bottom: 10px;
    }

    .btn-tambah, .btn-show {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
        width: 100%;
        text-align: center;
    }

    .btn-show {
        background-color: #007bff;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 2; /* Atur z-index lebih tinggi dari card */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
        text-align: center;
    }

    .modal-product-image {
        max-width: 100px;
        max-height: 100px;
        border-radius: 10px;
        margin: 10px 0;
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

    .notification {
        display: none;
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        z-index: 3; /* Atur z-index lebih tinggi dari card dan modal */
        text-align: center;
        font-size: 14px;
        width: auto;
    }
</style>
