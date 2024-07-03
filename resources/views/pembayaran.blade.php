<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
</head>
<body>
    <h1>Detail Pembayaran</h1>
    <p><strong>Nama:</strong> {{ $nama }}</p>
    <p><strong>Rombel:</strong> {{ $rombel }}</p>
    <p><strong>Total Item:</strong> {{ $total_item }}</p>
    <p><strong>Total Harga:</strong> Rp. {{ number_format($total_harga, 0, ',', '.') }}</p>
    <p><strong>Jumlah Uang Diberikan:</strong> Rp. {{ number_format($uang, 0, ',', '.') }}</p>
    <p><strong>Kembalian:</strong> Rp. {{ number_format($kembalian, 0, ',', '.') }}</p>
</body>
</html>
