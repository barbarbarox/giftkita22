@extends('layouts.penjual')

@section('title', 'Detail Pesanan | GiftKita Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <a href="{{ route('penjual.pesanan.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 mb-6 font-semibold transition-all hover:gap-3">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Pesanan</span>
    </a>

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-receipt text-blue-500 mr-2"></i>Detail Pesanan
                </h1>
                <p class="text-gray-600">ID Pesanan: <span class="font-mono font-semibold">{{ $pesanan->id }}</span></p>
            </div>
            
            <!-- Status Badge -->
            <div class="flex items-center gap-3">
                @php
                    $statusConfig = [
                        'pending' => ['icon' => 'clock', 'color' => 'yellow', 'text' => 'Pending'],
                        'dikonfirmasi' => ['icon' => 'check', 'color' => 'blue', 'text' => 'Dikonfirmasi'],
                        'diproses' => ['icon' => 'cog', 'color' => 'indigo', 'text' => 'Diproses'],
                        'dikirim' => ['icon' => 'shipping-fast', 'color' => 'purple', 'text' => 'Dikirim'],
                        'selesai' => ['icon' => 'check-circle', 'color' => 'green', 'text' => 'Selesai'],
                        'dibatalkan' => ['icon' => 'times-circle', 'color' => 'red', 'text' => 'Dibatalkan'],
                    ];
                    $status = $statusConfig[$pesanan->status] ?? ['icon' => 'question', 'color' => 'gray', 'text' => 'Unknown'];
                @endphp
                
                <div class="px-6 py-3 rounded-xl bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-700 font-bold text-lg flex items-center gap-2">
                    <i class="fas fa-{{ $status['icon'] }}"></i>
                    <span>{{ $status['text'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Produk -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-gift"></i>
                        <span>Informasi Produk</span>
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Product Image -->
                        <div class="md:w-48 h-48 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border-2 border-gray-200">
                            @php
                                // Cari file pertama dari produk
                                $firstFile = $pesanan->produk->files->first();
                                
                                if ($firstFile) {
                                    // Cek apakah filepath sudah include 'storage/' atau belum
                                    if (str_starts_with($firstFile->filepath, 'storage/')) {
                                        $imageUrl = asset($firstFile->filepath);
                                    } else {
                                        $imageUrl = asset('storage/' . $firstFile->filepath);
                                    }
                                } else {
                                    $imageUrl = null;
                                }
                            @endphp
                            
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $pesanan->produk->nama }}"
                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-gray-400\'><i class=\'fas fa-image text-6xl\'></i></div>';">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-6xl mb-2"></i>
                                    <p class="text-xs">Foto tidak tersedia</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Details -->
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $pesanan->produk->nama }}</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-store text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Toko</p>
                                        <p class="font-semibold text-gray-800">{{ $pesanan->produk->toko->nama_toko }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-tag text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Kategori</p>
                                        <p class="font-semibold text-gray-800">{{ $pesanan->produk->kategori->nama_kategori ?? '-' }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-money-bill-wave text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Harga Satuan</p>
                                        <p class="font-bold text-green-600 text-lg">Rp {{ number_format($pesanan->produk->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($pesanan->produk->deskripsi)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <i class="fas fa-align-left text-blue-500"></i>
                            Deskripsi Produk
                        </h4>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $pesanan->produk->deskripsi }}</p>
                    </div>
                    @endif
                    
                    {{-- Tampilkan semua foto produk jika ada lebih dari 1 --}}
                    @if($pesanan->produk->files && $pesanan->produk->files->count() > 1)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-images text-purple-500"></i>
                            Galeri Foto Produk ({{ $pesanan->produk->files->count() }} foto)
                        </h4>
                        <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
                            @foreach($pesanan->produk->files as $file)
                                @php
                                    if (str_starts_with($file->filepath, 'storage/')) {
                                        $thumbUrl = asset($file->filepath);
                                    } else {
                                        $thumbUrl = asset('storage/' . $file->filepath);
                                    }
                                @endphp
                                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-gray-200 hover:border-blue-400 transition-all cursor-pointer group">
                                    <img src="{{ $thumbUrl }}" 
                                         alt="Foto {{ $loop->iteration }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                         onclick="showImageModal('{{ $thumbUrl }}')"
                                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-gray-400\'><i class=\'fas fa-image\'></i></div>';">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Pembeli -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        <span>Informasi Pembeli</span>
                    </h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-blue-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                            <p class="font-bold text-gray-800 text-lg">{{ $pesanan->nama_pembeli }}</p>
                        </div>
                    </div>
                    
                    @if($pesanan->email_pembeli)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-purple-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-1">Email</p>
                            <a href="mailto:{{ $pesanan->email_pembeli }}" class="font-semibold text-purple-600 hover:underline">
                                {{ $pesanan->email_pembeli }}
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($pesanan->no_hp_pembeli)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-green-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-1">No. Telepon</p>
                            <a href="tel:{{ $pesanan->no_hp_pembeli }}" class="font-semibold text-green-600 hover:underline">
                                {{ $pesanan->no_hp_pembeli }}
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($pesanan->alamat_pembeli)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-orange-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-1">Alamat</p>
                            <p class="font-semibold text-gray-800">{{ $pesanan->alamat_pembeli }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($pesanan->hasLocation())
                    <div class="mt-4">
                        <a href="{{ $pesanan->map_link }}" 
                           target="_blank"
                           class="w-full inline-flex items-center justify-center gap-2 bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition-all duration-300 hover:shadow-lg">
                            <i class="fas fa-map-marked-alt"></i>
                            <span>Lihat Lokasi di Google Maps</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Summary & Actions -->
        <div class="space-y-6">
            <!-- Ringkasan Pesanan -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-pink-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Ringkasan Pesanan</span>
                    </h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Jumlah</span>
                        <span class="font-bold text-gray-800 text-lg">{{ $pesanan->jumlah }} pcs</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Harga Satuan</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($pesanan->produk->harga, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pt-3">
                        <span class="text-gray-700 font-semibold text-lg">Total Harga</span>
                        <span class="font-bold text-green-600 text-2xl">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-history"></i>
                        <span>Timeline</span>
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Tanggal Pemesanan</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d F Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Terakhir Diupdate</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($pesanan->updated_at)->format('d F Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($pesanan->updated_at)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-pink-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        <span>Update Status</span>
                    </h2>
                </div>
                
                <div class="p-6">
                    <select id="statusSelect" data-id="{{ $pesanan->id }}" 
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-sm font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all cursor-pointer">
                        <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="dikonfirmasi" {{ $pesanan->status == 'dikonfirmasi' ? 'selected' : '' }}>✅ Dikonfirmasi</option>
                        <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                        <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>✔️ Selesai</option>
                        <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                    </select>
                    
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pilih status baru untuk memperbarui pesanan
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-bolt"></i>
                        <span>Aksi Cepat</span>
                    </h2>
                </div>
                
                <div class="p-6 space-y-3">
                    @if($pesanan->no_hp_pembeli)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanan->no_hp_pembeli) }}?text={{ urlencode('Halo ' . $pesanan->nama_pembeli . ', mengenai pesanan Anda untuk produk ' . $pesanan->produk->nama . ' dengan total Rp ' . number_format($pesanan->total_harga, 0, ',', '.')) }}" 
                       target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition-all duration-300 hover:shadow-lg">
                        <i class="fab fa-whatsapp text-xl"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                    @endif
                    
                    <button onclick="window.print()" 
                            class="w-full inline-flex items-center justify-center gap-2 bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-print"></i>
                        <span>Cetak Detail Pesanan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk Preview Gambar --}}
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 text-4xl">&times;</button>
        <img id="modalImage" src="" alt="Preview" class="max-w-full max-h-screen rounded-lg shadow-2xl">
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Image Modal Functions
function showImageModal(imageUrl) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageUrl;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const statusSelect = document.getElementById('statusSelect');
    
    statusSelect.addEventListener('change', async (e) => {
        const id = e.target.dataset.id;
        const status = e.target.value;
        const oldStatus = '{{ $pesanan->status }}';
        
        // Confirmation
        const result = await Swal.fire({
            title: '🔄 Ubah Status Pesanan?',
            html: `Apakah Anda yakin ingin mengubah status pesanan ini menjadi <strong>"${status}"</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        });

        if (!result.isConfirmed) {
            e.target.value = oldStatus;
            return;
        }

        // Loading
        Swal.fire({
            title: 'Memperbarui...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => Swal.showLoading()
        });

        try {
            const response = await fetch(`/penjual/pesanan/${id}/status`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ status })
            });

            const result = await response.json();

            if (result.success) {
                await Swal.fire({
                    title: '✅ Berhasil!',
                    html: `Status pesanan telah diubah menjadi <strong>"${status}"</strong>`,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });

                setTimeout(() => location.reload(), 2000);
            } else {
                e.target.value = oldStatus;
                Swal.fire({
                    title: '⚠️ Gagal!',
                    text: result.message || 'Terjadi kesalahan.',
                    icon: 'error'
                });
            }
        } catch (error) {
            e.target.value = oldStatus;
            Swal.fire({
                title: '❌ Error!',
                text: 'Tidak dapat terhubung ke server.',
                icon: 'error'
            });
        }
    });
});
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
}

#imageModal {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
@endsection