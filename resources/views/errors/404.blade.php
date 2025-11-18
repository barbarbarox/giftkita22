<!DOCTYPE html>
<html>
<head>
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: #f5f5f5;
        }
        .error-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { font-size: 72px; margin: 0; color: #e74c3c; }
        h2 { color: #555; }
        a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Maaf, halaman yang Anda cari tidak dapat ditemukan.</p>
        <a href="{{ url('/') }}">← Kembali ke Beranda</a>
    </div>
</body>
</html>