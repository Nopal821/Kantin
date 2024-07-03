@extends('layouts.style')

@section('title', $product->nama)

@section('content')
    <div class="container">
        <div class="card-detail">
            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}">
            <div class="detail-content">
                <h1>{{ $product->nama }}</h1>
                <p><strong>Harga:</strong> Rp. {{ number_format($product->harga, 0, ',', '.') }}</p>
                <p><strong>:</strong> {{ $product->deskripsi }}</p>
                    <a href="{{ route('index') }}" class="back-link">Kembali ke Daftar Makanan</a>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .card-detail {
        background-color: #FFFFFF;
        padding: 50px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .card-detail img {
        max-width: 300px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .detail-content {
        max-width: 500px;
    }

    .detail-content h1 {
        font-size: 2em;
        margin-bottom: 10px;
    }

    .detail-content p {
        font-size: 1.2em;
        margin-bottom: 10px;
    }

    .detail-content button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }
</style>
