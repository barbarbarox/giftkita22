@extends('layouts.app')

@section('title', $toko->nama_toko . ' | GiftKita')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12">

    {{-- 🔹 Header Toko + Peta --}}
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 mb-12 grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

        {{-- Kiri: Info Toko --}}
        <div>
            @php
                $foto = $toko->foto_profil
                    ? (str_starts_with($toko->foto_profil, 'storage/') ? asset($toko->foto_profil) : asset('storage/'.$toko->foto_profil))
                    : asset('images/no-image.jpg');

                $nomorWa = $toko->whatsapp ? preg_replace('/\D/', '', $toko->whatsapp) : null;
                $pesan = urlencode("Halo, saya tertarik dengan produk dari *{$toko->nama_toko}* di GiftKita!");
                $linkWA = $nomorWa ? "https://wa.me/{$nomorWa}?text={$pesan}" : null;
            @endphp

            {{-- Foto + Nama --}}
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                <img src="{{ $foto }}" alt="{{ $toko->nama_toko }}"
                     style="width: 100px; height: 100px; border-radius: 16px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 3px solid #fff;">
                <div>
                    <h1 style="font-size: 1.6rem; font-weight: 800; color: #007daf; margin: 0;">{{ $toko->nama_toko }}</h1>
                    <p style="color: gray; font-size: 0.9rem;">👤 {{ $toko->penjual->nama ?? 'Pemilik tidak diketahui' }}</p>
                </div>
            </div>

            {{-- Deskripsi --}}
            <p style="color: #444; line-height: 1.6; margin-bottom: 10px;">
                {{ $toko->deskripsi ?? 'Belum ada deskripsi toko.' }}
            </p>

            {{-- Alamat --}}
            @if ($toko->alamat_toko)
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 15px;">
                    <strong>📍 Alamat:</strong> {{ $toko->alamat_toko }}
                </p>
            @endif

            {{-- 🔘 Tombol Media Sosial (warna seragam + animasi) --}}
            <div class="social-buttons" style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">
                @if ($linkWA)
                    <a href="{{ $linkWA }}" target="_blank" class="btn-social">
                        <img src="{{ asset('icons/whatsapp.png') }}" alt="WhatsApp"> Hubungi via WhatsApp
                    </a>
                @endif

                @if ($toko->instagram)
                    <a href="{{ $toko->instagram }}" target="_blank" class="btn-social">
                        <img src="{{ asset('icons/instagram.png') }}" alt="Instagram"> Kunjungi Instagram
                    </a>
                @endif

                @if ($toko->facebook)
                    <a href="{{ $toko->facebook }}" target="_blank" class="btn-social">
                        <img src="{{ asset('icons/facebook.png') }}" alt="Facebook"> Kunjungi Facebook
                    </a>
                @endif
            </div>
        </div>

        {{-- Kanan: Google Maps --}}
        @if ($toko->embed_map_link)
            <div class="w-full">
                <div style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid #ddd;">
                    <iframe
                        src="{{ $toko->embed_map_link }}"
                        width="100%"
                        height="350"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    {{-- Tombol Salin Link --}}
                    <button id="copyMapLink"
                            data-link="{{ $toko->google_map_link }}"
                            style="position: absolute; bottom: 15px; right: 15px; background: rgba(255,255,255,0.95); border: 1px solid #ccc; border-radius: 8px; padding: 8px 14px; font-weight: 600; color: #007daf; cursor: pointer;">
                        🔗 Salin Link Maps
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- 🔹 Produk Toko --}}
    <h2 style="font-size: 1.6rem; font-weight: 700; color: #007daf; text-align: center; margin-bottom: 25px;">
        Produk dari {{ $toko->nama_toko }}
    </h2>

    @if ($toko->produks->isEmpty())
        <p style="text-align: center; color: gray;">Belum ada produk di toko ini.</p>
    @else
        <div class="produk-grid">
            @foreach ($toko->produks as $produk)
                @php
                    $thumbnail = $produk->files->first();
                    $imagePath = $thumbnail
                        ? (str_starts_with($thumbnail->filepath, 'storage/') ? asset($thumbnail->filepath) : asset('storage/'.$thumbnail->filepath))
                        : asset('images/no-image.jpg');
                @endphp

                <a href="{{ route('produk.show', $produk->id) }}" class="produk-card">
                    <div class="produk-img">
                        <img src="{{ $imagePath }}" alt="{{ $produk->nama }}">
                    </div>
                    <div class="produk-info">
                        <h3>{{ $produk->nama }}</h3>
                        <p>{{ Str::limit($produk->deskripsi, 40) }}</p>
                        <span>Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>

{{-- Style Animasi --}}
<style>
/* 🔘 Tombol sosial media */
.btn-social {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #007daf;
    color: white;
    padding: 10px 18px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}
.btn-social img {
    width: 20px;
    height: 20px;
    transition: transform 0.25s ease;
}
.btn-social:hover {
    background-color: #005c86;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}
.btn-social:hover img {
    transform: scale(1.1) rotate(5deg);
}
.btn-social:active {
    transform: scale(0.97);
}

/* 🛍️ Produk Grid */
.produk-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 18px;
    justify-items: center;
}
.produk-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 200px;
    aspect-ratio: 1/1.2;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #eee;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}
.produk-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}
.produk-img {
    flex: 1;
    overflow: hidden;
}
.produk-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.produk-card:hover .produk-img img {
    transform: scale(1.08);
}
.produk-info {
    padding: 10px;
    text-align: center;
}
.produk-info h3 {
    font-weight: 600;
    color: #007daf;
    font-size: 1rem;
    margin: 4px 0;
}
.produk-info p {
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 4px;
}
.produk-info span {
    font-weight: bold;
    color: #ffb829;
}
</style>

{{-- Script tombol salin --}}
<script>
document.getElementById('copyMapLink')?.addEventListener('click', function() {
    const link = this.dataset.link;
    navigator.clipboard.writeText(link);
    this.textContent = '✅ Link Disalin';
    setTimeout(() => this.textContent = '🔗 Salin Link Maps', 2000);
});
</script>
@endsection
