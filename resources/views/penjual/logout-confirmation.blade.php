<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            max-width: 400px;
            text-align: center;
        }
        h1 { color: #333; margin-bottom: 1rem; }
        p { color: #666; margin-bottom: 2rem; }
        form { display: inline; }
        button {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover { background: #5568d3; }
        .cancel {
            display: inline-block;
            margin-left: 10px;
            color: #667eea;
            text-decoration: none;
            padding: 12px 30px;
        }
        .cancel:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚠️ Konfirmasi Logout</h1>
        <p>Apakah Anda yakin ingin keluar dari akun Anda?</p>
        
        <form action="{{ route('penjual.logout') }}" method="POST">
            @csrf
            <button type="submit">Ya, Logout</button>
        </form>
        
        <a href="{{ route('penjual.dashboard') }}" class="cancel">Batal</a>
    </div>
</body>
</html>