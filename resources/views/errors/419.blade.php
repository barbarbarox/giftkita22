<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GiftKita — 419 Halaman Kadaluarsa</title>
    <style>
        body, html { margin: 0; padding: 0; background: #fdf7fb; font-family: 'Montserrat', sans-serif;}
        .error-container { min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 2rem;}
        .giftbox { position: relative; width: 320px; height: 320px; margin-bottom: 2rem; animation: floatUpDown 3s ease-in-out infinite;}
        @keyframes floatUpDown { 0%,100% { transform: translateY(0);} 50% { transform: translateY(-28px);}}
        .giftbox-outer { position: absolute; width: 100%; height: 100%; background: #c771d4; border-radius: 45px; box-shadow: 0 12px 36px #c771d444; display: flex; justify-content: center; align-items: center; z-index: 1;}
        .giftbox-inner { position: absolute; top: 40px; left: 40px; width: 240px; height: 190px; background: #fff; border-radius: 32px 32px 20px 20px; box-shadow: 0 4px 32px #c771d444 inset; display: flex; justify-content: center; align-items: center; z-index: 20;}
        .giftbox-label { font-size: 6rem; font-weight: bold; color: #c771d4; margin: 0; padding: 0; font-family: inherit; line-height: 1; letter-spacing: 5px; z-index: 21; position: relative;}
        .ribbon-vert, .ribbon-horiz { position: absolute; background: #1a7695; z-index: 10;}
        .ribbon-vert { left: 50%; top: 0; width: 32px; height: 320px; transform: translateX(-50%); border-radius: 16px;}
        .ribbon-horiz { top: 140px; left: 0; width: 320px; height: 32px; border-radius: 16px;}
        .flower { position: absolute; left: 50%; top: 20px; width: 84px; height: 52px; transform: translateX(-50%); z-index: 30;}
        .petal { position: absolute; background: #1a7695; border-radius: 50%; z-index: 30;}
        .petal.top { width: 42px; height: 38px; left: 21px; top: 0;}
        .petal.left { width: 42px; height: 32px; left: 0; top: 16px;}
        .petal.right { width: 42px; height: 32px; right: 0; top: 16px;}
        .petal.middle { width: 24px; height: 24px; left: 30px; top: 13px; background: #ffb829; border-radius: 50%; z-index: 31;}
        a.btn { background: linear-gradient(90deg,#007daf 0%,#c771d4 50%,#ffb829 100%); color: white; padding: 0.8rem 2rem; font-weight: 600; border-radius: 25px; text-decoration: none; transition: filter 0.3s;}
        a.btn:hover { filter: brightness(1.1);}
        h2 { color: #ffb829;}
        p { color: #007daf; max-width: 400px; margin-bottom: 2rem; font-size: 1.2rem;}
        @media (max-width:500px) {
            .giftbox { width: 200px; height: 200px;}
            .giftbox-inner { top: 26px; left: 26px; width: 148px; height: 116px;}
            .giftbox-label { font-size: 3.2rem;}
            .ribbon-vert { width: 18px; height: 200px;}
            .ribbon-horiz { width: 200px; height: 18px; top: 84px;}
            .flower { width: 50px; height: 32px; top: 8px;}
            .petal.top { width: 24px; height: 17px; left: 13px;}
            .petal.left, .petal.right { width: 22px; height: 15px; top: 10px;}
            .petal.left { left: 0;}
            .petal.right { right: 0;}
            .petal.middle { width: 14px; height: 14px; left: 18px; top: 7px;}
        }
    </style>
</head>
<body>
<div class="error-container">
    <div class="giftbox">
        <div class="giftbox-outer"></div>
        <div class="ribbon-vert"></div>
        <div class="ribbon-horiz"></div>
        <div class="giftbox-inner">
            <span class="giftbox-label">419</span>
        </div>
        <div class="flower">
            <div class="petal top"></div>
            <div class="petal left"></div>
            <div class="petal right"></div>
            <div class="petal middle"></div>
        </div>
    </div>
    <h2>Halaman Kadaluarsa</h2>
    <p>Maaf, token keamanan sudah kadaluarsa. Silakan muat ulang halaman dan coba lagi.</p>
    <a href="{{ url('/') }}" class="btn">Kembali ke Beranda</a>
</div>
</body>
</html>
