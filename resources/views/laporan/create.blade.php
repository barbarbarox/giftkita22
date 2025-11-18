@extends('layouts.app')

@section('title', 'Laporkan Penjual | GiftKita')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-red-200/30 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-orange-200/30 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="text-center mb-12 animate-fade-in-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-500 to-orange-600 rounded-2xl shadow-xl mb-6">
                <i class='bx bx-error-circle text-white text-4xl'></i>
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4">
                Laporkan <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">Penjual</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Bantu kami menjaga keamanan dan kenyamanan berbelanja di GiftKita dengan melaporkan penjual yang bermasalah.
            </p>
        </div>
    </div>
</div>

<!-- Form Section -->
<div class="bg-white py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Alert Info -->
        <div class="mb-8 bg-blue-50 border-l-4 border-blue-500 rounded-xl p-6 animate-fade-in">
            <div class="flex items-start gap-4">
                <i class='bx bx-info-circle text-blue-500 text-3xl flex-shrink-0'></i>
                <div>
                    <h3 class="text-blue-900 font-bold text-lg mb-2">Penting untuk Diketahui</h3>
                    <ul class="text-blue-800 text-sm space-y-1 list-disc list-inside">
                        <li>Laporan Anda akan ditinjau oleh tim kami dalam 1-3 hari kerja</li>
                        <li>Pastikan informasi yang Anda berikan akurat dan jelas</li>
                        <li>Lampirkan bukti jika memungkinkan untuk mempercepat proses</li>
                        <li>Laporan palsu atau tidak berdasar dapat dikenakan sanksi</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl border-2 border-gray-100 p-8 animate-fade-in-up">
            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" x-data="laporanForm()">
                @csrf

                <!-- Pilih Penjual -->
                <div class="mb-8">
                    <label class="block text-gray-900 font-bold mb-3 flex items-center gap-2">
                        <i class='bx bx-store text-red-500 text-xl'></i>
                        Penjual yang Dilaporkan <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="penjual_id" 
                        required
                        class="w-full px-4 py-4 rounded-xl border-2 border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all outline-none @error('penjual_id') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Penjual --</option>
                        @foreach($penjualList as $penjual)
                            <option value="{{ $penjual->id }}" {{ old('penjual_id') == $penjual->id ? 'selected' : '' }}>
                                {{ $penjual->toko->nama_toko ?? $penjual->username }} ({{ $penjual->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('penjual_id')
                        <p class="mt-2 text-red-600 text-sm flex items-center gap-1">
                            <i class='bx bx-error-circle'></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Data Pelapor -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class='bx bx-user text-gray-700'></i>
                        Data Pelapor
                    </h3>
                    <div class="space-y-4">
                        <!-- Nama -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama_pelapor" 
                                value="{{ old('nama_pelapor') }}"
                                required
                                placeholder="Masukkan nama lengkap Anda"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all outline-none @error('nama_pelapor') border-red-500 @enderror"
                            >
                            @error('nama_pelapor')
                                <p class="mt-2 text-red-600 text-sm flex items-center gap-1">
                                    <i class='bx bx-error-circle'></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email_pelapor" 
                                value="{{ old('email_pelapor') }}"
                                required
                                placeholder="email@contoh.com"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all outline-none @error('email_pelapor') border-red-500 @enderror"
                            >
                            @error('email_pelapor')
                                <p class="mt-2 text-red-600 text-sm flex items-center gap-1">
                                    <i class='bx bx-error-circle'></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                No. Telepon <span class="text-gray-400 text-sm">(Opsional)</span>
                            </label>
                            <input 
                                type="tel" 
                                name="no_telp_pelapor" 
                                value="{{ old('no_telp_pelapor') }}"
                                placeholder="08123456789"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all outline-none @error('no_telp_pelapor') border-red-500 @enderror"
                            >
                            @error('no_telp_pelapor')
                                <p class="mt-2 text-red-600 text-sm flex items-center gap-1">
                                    <i class='bx bx-error-circle'></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Detail Laporan -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class='bx bx-detail text-gray-700'></i>
                        Detail Laporan
                    </h3>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-3">
                            Kategori Masalah <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="relative flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-300 hover:bg-red-50 transition-all group">
                                <input type="radio" name="kategori" value="penipuan" required {{ old('kategori') == 'penipuan' ? 'checked' : '' }} class="w-5 h-5 text-red-500">
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-red-600">🚨 Penipuan</div>
                                    <div class="text-xs text-gray-500">Transaksi tidak jujur</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-300 hover:bg-red-50 transition-all group">
                                <input type="radio" name="kategori" value="produk_palsu" required {{ old('kategori') == 'produk_palsu' ? 'checked' : '' }} class="w-5 h-5 text-red-500">
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-red-600">🎭 Produk Palsu</div>
                                    <div class="text-xs text-gray-500">Barang tidak asli</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-300 hover:bg-red-50 transition-all group">
                                <input type="radio" name="kategori" value="pelayanan_buruk" required {{ old('kategori') == 'pelayanan_buruk' ? 'checked' : '' }} class="w-5 h-5 text-red-500">
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-red-600">😡 Pelayanan Buruk</div>
                                    <div class="text-xs text-gray-500">Sikap tidak profesional</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-300 hover:bg-red-50 transition-all group">
                                <input type="radio" name="kategori" value="pengiriman_bermasalah" required {{ old('kategori') == 'pengiriman_bermasalah' ? 'checked' : '' }} class="w-5 h-5 text-red-500">
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-red-600">📦 Pengiriman Bermasalah</div>
                                    <div class="text-xs text-gray-500">Kirim tidak sesuai</div>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-300 hover:bg-red-50 transition-all group sm:col-span-2">
                                <input type="radio" name="kategori" value="lainnya" required {{ old('kategori') == 'lainnya' ? 'checked' : '' }} class="w-5 h-5 text-red-500">
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-red-600">📝 Lainnya</div>
                                    <div class="text-xs text-gray-500">Masalah lain yang tidak tercantum</div>
                                </div>
                            </label>
                        </div>
                        @error('kategori')
                            <p class="mt-2 text-red-600 text-sm flex items-center gap-1">
                                <i class='bx bx-error-circle'></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">
                            Deskripsi Masalah <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="deskripsi" 
                            required
                            rows="6"
                            placeholder="Jelaskan secara detail masalah yang Anda alami dengan penjual ini. Sertakan kronologi, tanggal kejadian, dan informasi penting lainnya (minimal 20 karakter)..."
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all outline-none resize-none @error('deskripsi') border-red-500 @enderror"
                            x-model="deskripsi"
                        >{{ old('deskripsi') }}</textarea>
                        <div class="mt-2 flex justify-between items-center text-sm">
                            <span :class="deskripsi.length < 20 ? 'text-red-500' : 'text-green-600'" x-text="deskripsi.length + ' karakter'"></span>
                            <span class="text-gray-400">Minimal 20 karakter</span>
                        </div>
                        @error('deskripsi')
                            <p class="mt-2 text-red-600 text-sm flex items-center gap-1">
                                <i class='bx bx-error-circle'></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Upload Bukti -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Bukti Pendukung <span class="text-gray-400 text-sm">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="file" 
                                name="bukti_file" 
                                accept="image/jpeg,image/png,image/jpg"
                                class="hidden"
                                id="bukti_file"
                                @change="handleFileUpload($event)"
                            >
                            <label 
                                for="bukti_file" 
                                class="flex flex-col items-center justify-center w-full px-6 py-8 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-red-400 hover:bg-red-50 transition-all group"
                            >
                                <i class='bx bx-cloud-upload text-5xl text-gray-400 group-hover:text-red-500 mb-3'></i>
                                <span class="text-gray-600 group-hover:text-red-600 font-medium" x-text="fileName || 'Klik untuk upload gambar'"></span>
                                <span class="text-gray-400 text-sm mt-1">JPG, PNG (Maks. 2MB)</span>
                            </label>
                        </div>
                        @error('bukti_file')
                            <p class="mt-2 text-red-600 text-sm flex items-center gap-1">
                                <i class='bx bx-error-circle'></i> {{ $message }}
                            </p>
                        @enderror

                        <!-- Preview Gambar -->
                        <div x-show="previewUrl" class="mt-4">
                            <img :src="previewUrl" alt="Preview" class="max-w-xs rounded-xl shadow-lg">
                        </div>
                    </div>
                </div>

                <!-- Persetujuan -->
                <div class="mb-8">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input 
                            type="checkbox" 
                            required
                            class="mt-1 w-5 h-5 rounded border-gray-300 text-red-500 focus:ring-red-500"
                        >
                        <span class="text-sm text-gray-600 group-hover:text-gray-900">
                            Saya menyatakan bahwa informasi yang saya berikan adalah benar dan dapat dipertanggungjawabkan. Saya memahami bahwa laporan palsu dapat dikenakan sanksi.
                        </span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a 
                        href="{{ route('faq.index') }}"
                        class="flex-1 px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-center transition-all duration-300"
                    >
                        <i class='bx bx-arrow-back mr-2'></i>
                        Kembali
                    </a>
                    <button 
                        type="submit"
                        class="flex-1 px-8 py-4 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300"
                    >
                        <i class='bx bx-send mr-2'></i>
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
function laporanForm() {
    return {
        deskripsi: '{{ old("deskripsi") }}',
        fileName: '',
        previewUrl: '',
        
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
                
                // Preview gambar
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.fileName = '';
                this.previewUrl = '';
            }
        }
    }
}
</script>

<style>
@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

.animate-fade-in-down {
    animation: fade-in-down 0.8s ease-out;
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out;
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

html {
    scroll-behavior: smooth;
}
</style>
@endsection