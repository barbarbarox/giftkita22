@extends('layouts.app')

@section('title', 'GiftKita — Hadiah Spesialmu, Dengan Sentuhan Istimewa')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white text-center py-24 px-4 relative overflow-hidden">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-5xl font-bold mb-6 leading-snug">
                Hadiah Istimewa untuk
                <span class="text-rotate inline-block min-h-[1.2em]" data-rotate='["Orang Tersayang", "Momen Bahagia", "Setiap Perayaan", "Kenangan Indah", "Keluarga Tercinta"]'>
                    <span class="text-rotate-sr-only">Orang Tersayang</span>
                </span>
            </h1>

            <p class="text-lg md:text-xl font-light opacity-90 max-w-2xl mx-auto mb-8">
                Setiap hadiah menceritakan kisah, biarkan kami bantu membuatnya istimewa
            </p>

            <div class="flex flex-wrap justify-center gap-4 mt-8">
                <a href="{{ route('katalog.index') }}" class="bg-white text-[#007daf] px-8 py-3 rounded-full font-semibold hover:scale-105 transition shadow-lg">
                    Lihat Katalog
                </a>
                <a href="/about" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-[#007daf] transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Tentang GiftKita Section -->
    <section id="tentang" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#007daf]">Apa itu GiftKita?</h2>
                <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                    <strong class="text-[#c771d4]">GiftKita</strong> adalah platform marketplace terpercaya untuk memesan <strong>hampers, kado, parcel, dan hadiah spesial</strong> untuk berbagai momen berharga dalam hidup Anda.
                </p>
                <p class="text-base text-gray-600 leading-relaxed mb-8">
                    Kami menghubungkan Anda dengan para penjual kreatif yang siap menciptakan hadiah istimewa—mulai dari hampers lebaran, parcel ulang tahun, kado wisuda, hingga gift box pernikahan. Dengan GiftKita, setiap momen spesial Anda akan lebih berkesan dan penuh makna.
                </p>
            </div>
        </div>
    </section>

    <!-- Logo Looping Section -->
    <section class="py-12 bg-gray-50 overflow-hidden">
        <div class="container mx-auto px-4 mb-8 text-center">
            <h3 class="text-2xl font-bold text-[#007daf] mb-2">Kategori Hadiah</h3>
            <p class="text-gray-600">Temukan hadiah sempurna untuk setiap momen spesial</p>
        </div>
        <div class="logoloop logoloop--fade logoloop--scale-hover" data-speed="30">
            <div class="logoloop__track">
                <div class="logoloop__list">
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">🎁</div>
                                <div class="text-sm font-semibold text-gray-700">Hampers Lebaran</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">🎂</div>
                                <div class="text-sm font-semibold text-gray-700">Kado Ulang Tahun</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">🎓</div>
                                <div class="text-sm font-semibold text-gray-700">Gift Wisuda</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">💍</div>
                                <div class="text-sm font-semibold text-gray-700">Parcel Pernikahan</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">👶</div>
                                <div class="text-sm font-semibold text-gray-700">Gift Bayi</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">🎄</div>
                                <div class="text-sm font-semibold text-gray-700">Hampers Natal</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">💼</div>
                                <div class="text-sm font-semibold text-gray-700">Corporate Gift</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">💐</div>
                                <div class="text-sm font-semibold text-gray-700">Gift Anniversary</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Duplicate for seamless loop -->
                <div class="logoloop__list" aria-hidden="true">
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">🎁</div>
                                <div class="text-sm font-semibold text-gray-700">Hampers Lebaran</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">🎂</div>
                                <div class="text-sm font-semibold text-gray-700">Kado Ulang Tahun</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">🎓</div>
                                <div class="text-sm font-semibold text-gray-700">Gift Wisuda</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">💍</div>
                                <div class="text-sm font-semibold text-gray-700">Parcel Pernikahan</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">👶</div>
                                <div class="text-sm font-semibold text-gray-700">Gift Bayi</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">🎄</div>
                                <div class="text-sm font-semibold text-gray-700">Hampers Natal</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">💼</div>
                                <div class="text-sm font-semibold text-gray-700">Corporate Gift</div>
                            </div>
                        </div>
                    </div>
                    <div class="logoloop__item">
                        <div class="logoloop__node">
                            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-sm" style="width: 180px; height: 140px;">
                                <div class="text-4xl mb-2">💐</div>
                                <div class="text-sm font-semibold text-gray-700">Gift Anniversary</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="py-16 bg-white">
        <div class="container mx-auto text-center px-4">
            <h2 class="text-3xl font-bold mb-4 text-[#007daf]">Kenapa Pilih GiftKita?</h2>
            <p class="text-gray-600 mb-12 max-w-2xl mx-auto">
                Platform terbaik untuk menemukan dan memesan hadiah spesial dengan mudah dan aman
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 border rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="text-5xl mb-4">🎯</div>
                    <h3 class="text-xl font-semibold mb-3 text-[#c771d4]">Cocok untuk Semua Acara</h3>
                    <p class="text-gray-600">Dari ulang tahun, wisuda, pernikahan, hingga hampers lebaran—semuanya ada di sini dengan pilihan beragam dan berkualitas.</p>
                </div>
                <div class="p-8 border rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="text-5xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold mb-3 text-[#007daf]">Ga Pake Ribet</h3>
                    <p class="text-gray-600">Pesan hampers mudah dan cepat, tanpa langkah yang bikin pusing. Cukup pilih, pesan, dan hadiah siap diantar!</p>
                </div>
                <div class="p-8 border rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="text-5xl mb-4">💬</div>
                    <h3 class="text-xl font-semibold mb-3 text-[#ffb829]">Komunikasi Oke</h3>
                    <p class="text-gray-600">Toko di sini siap merespons dengan cepat dan ramah di setiap pesanmu. Kepuasan Anda adalah prioritas kami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Pilihan -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4 text-[#007daf]">Produk Pilihan</h2>
            <p class="text-gray-600 mb-12">Koleksi terbaik dari para penjual terpercaya kami</p>

            @if ($produks->isEmpty())
                <div class="py-16">
                    <div class="text-6xl mb-4">🎁</div>
                    <p class="text-gray-600 text-lg">Belum ada produk yang tersedia saat ini.</p>
                    <p class="text-gray-500 text-sm mt-2">Tunggu update produk menarik dari kami!</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach ($produks as $produk)
                        <a href="{{ route('produk.show', $produk->id) }}" 
                           class="group bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden block hover:-translate-y-2">
                            @php
                                $thumbnail = $produk->files->first();
                                $imagePath = $thumbnail ? asset('storage/' . $thumbnail->filepath) : asset('images/no-image.jpg');
                            @endphp

                            {{-- Gambar produk --}}
                            <div class="relative overflow-hidden">
                                <img src="{{ $imagePath }}" 
                                     alt="{{ $produk->nama }}" 
                                     class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-2 right-2 bg-[#ffb829] text-white text-xs px-2 py-1 rounded-full font-semibold">
                                    Populer
                                </div>
                            </div>

                            {{-- Info produk --}}
                            <div class="p-3 text-left">
                                <h3 class="text-sm font-semibold text-[#007daf] mb-1 truncate">{{ $produk->nama }}</h3>
                                <p class="text-xs text-gray-600 mb-2 line-clamp-2">
                                    {{ $produk->deskripsi ?? 'Hadiah spesial untuk momen istimewa Anda.' }}
                                </p>
                                <p class="text-[#ffb829] font-bold text-sm">
                                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Tombol Lihat Semua Produk --}}
                <div class="mt-12">
                    <a href="{{ route('katalog.index') }}" 
                       class="inline-block bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white px-8 py-3 rounded-full font-semibold hover:scale-105 transition shadow-lg">
                        Lihat Semua Produk →
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-[#ffb829] via-[#c771d4] to-[#007daf] text-white text-center py-16 px-4">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ingin Jadi Bagian dari GiftKita?</h2>
            <p class="mb-8 text-lg opacity-90">
                Daftar sebagai penjual dan tunjukkan kreativitasmu dalam membuat hadiah istimewa! 
                Raih peluang bisnis dan tingkatkan pendapatan bersama kami.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/penjual/register" class="bg-white text-[#c771d4] px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition shadow-lg hover:scale-105">
                    Daftar Sebagai Penjual
                </a>
                <a href="#tentang" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-[#c771d4] transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    {{-- Styles --}}
    <style>
        /* Text Rotate Styles */
        .text-rotate {
            display: inline-flex;
            flex-wrap: wrap;
            white-space: pre-wrap;
            position: relative;
            vertical-align: bottom;
        }
        .text-rotate-sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        .text-rotate-word {
            display: inline-flex;
        }
        .text-rotate-element {
            display: inline-block;
            animation: slideUp 0.4s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        .text-rotate-element.out {
            animation: slideDown 0.4s ease forwards;
        }
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideDown {
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        /* Logo Loop Styles */
        .logoloop {
            position: relative;
            --logoloop-gap: 24px;
            --logoloop-fadeColorAuto: #f9fafb;
        }
        @media (prefers-color-scheme: dark) {
            .logoloop {
                --logoloop-fadeColorAuto: #f9fafb;
            }
        }
        .logoloop__track {
            display: flex;
            width: max-content;
            will-change: transform;
            user-select: none;
            position: relative;
            z-index: 0;
        }
        .logoloop__list {
            display: flex;
            align-items: center;
        }
        .logoloop__item {
            flex: 0 0 auto;
            margin-right: var(--logoloop-gap);
        }
        .logoloop__item:last-child {
            margin-right: var(--logoloop-gap);
        }
        .logoloop__node {
            display: inline-flex;
            align-items: center;
        }
        .logoloop--scale-hover .logoloop__item:hover .logoloop__node {
            transform: scale(1.08);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .logoloop--fade::before,
        .logoloop--fade::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: clamp(60px, 10%, 150px);
            pointer-events: none;
            z-index: 10;
        }
        .logoloop--fade::before {
            left: 0;
            background: linear-gradient(
                to right,
                var(--logoloop-fadeColor, var(--logoloop-fadeColorAuto)) 0%,
                rgba(0, 0, 0, 0) 100%
            );
        }
        .logoloop--fade::after {
            right: 0;
            background: linear-gradient(
                to left,
                var(--logoloop-fadeColor, var(--logoloop-fadeColorAuto)) 0%,
                rgba(0, 0, 0, 0) 100%
            );
        }
        @media (prefers-reduced-motion: reduce) {
            .logoloop__track {
                transform: translate3d(0, 0, 0) !important;
            }
            .logoloop__node {
                transition: none !important;
            }
        }
    </style>

    {{-- Scripts --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Text Rotate Animation
            const rotateElements = document.querySelectorAll('.text-rotate');
            
            rotateElements.forEach(element => {
                const words = JSON.parse(element.getAttribute('data-rotate'));
                let currentIndex = 0;
                
                function createWordSpan(word) {
                    const wordSpan = document.createElement('span');
                    wordSpan.className = 'text-rotate-word';
                    
                    word.split('').forEach((char, index) => {
                        const charSpan = document.createElement('span');
                        charSpan.className = 'text-rotate-element';
                        charSpan.textContent = char;
                        charSpan.style.animationDelay = `${index * 0.03}s`;
                        wordSpan.appendChild(charSpan);
                    });
                    
                    return wordSpan;
                }
                
                function rotateText() {
                    const currentWord = element.querySelector('.text-rotate-word');
                    
                    if (currentWord) {
                        const chars = currentWord.querySelectorAll('.text-rotate-element');
                        chars.forEach((char, index) => {
                            setTimeout(() => {
                                char.classList.add('out');
                            }, index * 30);
                        });
                        
                        setTimeout(() => {
                            currentWord.remove();
                            showNextWord();
                        }, chars.length * 30 + 400);
                    } else {
                        showNextWord();
                    }
                }
                
                function showNextWord() {
                    currentIndex = (currentIndex + 1) % words.length;
                    const newWord = createWordSpan(words[currentIndex]);
                    element.appendChild(newWord);
                }
                
                rotateText();
                setInterval(rotateText, 3000);
            });

            // Logo Loop Animation
            const logoLoops = document.querySelectorAll('.logoloop');
            
            logoLoops.forEach(loop => {
                const track = loop.querySelector('.logoloop__track');
                const speed = parseFloat(loop.getAttribute('data-speed')) || 30;
                let position = 0;
                
                function animate() {
                    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                        return;
                    }
                    
                    position -= 0.5;
                    const firstList = track.querySelector('.logoloop__list');
                    const listWidth = firstList.offsetWidth;
                    
                    if (Math.abs(position) >= listWidth) {
                        position = 0;
                    }
                    
                    track.style.transform = `translate3d(${position}px, 0, 0)`;
                    requestAnimationFrame(animate);
                }
                
                animate();
            });
        });
    </script>
@endsection