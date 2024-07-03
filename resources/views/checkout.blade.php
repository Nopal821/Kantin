<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <form action="/checkout" method="post">
        @csrf
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br><br>
        
        <label for="rombel">Rombel:</label>
        <input type="text" id="rombel" name="rombel" required><br><br>
        
        <label for="uang">Jumlah Uang yang Diberikan:</label>
        <input type="number" id="uang" name="uang" required><br><br>
        
        <button type="submit">Checkout</button>
    </form>
</body>
</html>
