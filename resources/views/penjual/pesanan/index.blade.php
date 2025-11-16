@extends('layouts.penjual')

@section('title', 'Pesanan Masuk | GiftKita Seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <span class="text-4xl">📦</span>
            <h1 class="text-3xl font-bold text-gray-800">Pesanan Masuk</h1>
        </div>
        <p class="text-gray-600">Kelola semua pesanan dari pelanggan Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        @php
            $statusCounts = [
                'pending' => $pesanans->where('status', 'pending')->count(),
                'dikonfirmasi' => $pesanans->where('status', 'dikonfirmasi')->count(),
                'diproses' => $pesanans->where('status', 'diproses')->count(),
                'dikirim' => $pesanans->where('status', 'dikirim')->count(),
                'selesai' => $pesanans->where('status', 'selesai')->count(),
                'dibatalkan' => $pesanans->where('status', 'dibatalkan')->count(),
            ];
        @endphp

        <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl p-4 text-white shadow-lg transform hover:scale-105 transition-all">
            <div class="text-2xl font-bold">{{ $statusCounts['pending'] }}</div>
            <div class="text-sm opacity-90">Pending</div>
        </div>
        <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl p-4 text-white shadow-lg transform hover:scale-105 transition-all">
            <div class="text-2xl font-bold">{{ $statusCounts['dikonfirmasi'] }}</div>
            <div class="text-sm opacity-90">Dikonfirmasi</div>
        </div>
        <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl p-4 text-white shadow-lg transform hover:scale-105 transition-all">
            <div class="text-2xl font-bold">{{ $statusCounts['diproses'] }}</div>
            <div class="text-sm opacity-90">Diproses</div>
        </div>
        <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl p-4 text-white shadow-lg transform hover:scale-105 transition-all">
            <div class="text-2xl font-bold">{{ $statusCounts['selesai'] }}</div>
            <div class="text-sm opacity-90">Selesai</div>
        </div>
        <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-xl p-4 text-white shadow-lg transform hover:scale-105 transition-all">
            <div class="text-2xl font-bold">{{ $statusCounts['dibatalkan'] }}</div>
            <div class="text-sm opacity-90">Dibatalkan</div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-xl shadow-lg p-2 mb-6">
        <div class="flex flex-wrap gap-2">
            <button class="tab-btn flex-1 min-w-[120px] px-4 py-3 rounded-lg font-semibold transition-all duration-300 bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-md active" data-status="pending">
                <i class="fas fa-clock mr-2"></i>Pending
            </button>
            <button class="tab-btn flex-1 min-w-[120px] px-4 py-3 rounded-lg font-semibold transition-all duration-300 hover:bg-gray-100" data-status="dikonfirmasi">
                <i class="fas fa-check mr-2"></i>Dikonfirmasi
            </button>
            <button class="tab-btn flex-1 min-w-[120px] px-4 py-3 rounded-lg font-semibold transition-all duration-300 hover:bg-gray-100" data-status="diproses">
                <i class="fas fa-cog mr-2"></i>Diproses
            </button>

            <button class="tab-btn flex-1 min-w-[120px] px-4 py-3 rounded-lg font-semibold transition-all duration-300 hover:bg-gray-100" data-status="selesai">
                <i class="fas fa-check-circle mr-2"></i>Selesai
            </button>
            <button class="tab-btn flex-1 min-w-[120px] px-4 py-3 rounded-lg font-semibold transition-all duration-300 hover:bg-gray-100" data-status="dibatalkan">
                <i class="fas fa-times-circle mr-2"></i>Dibatalkan
            </button>
        </div>
    </div>

    <!-- Tab Contents -->
    @foreach (['pending', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'] as $status)
        <div class="tab-content {{ $status === 'pending' ? '' : 'hidden' }}" id="tab-{{ $status }}">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">#</th>
                                <th class="px-6 py-4 text-left font-semibold">Produk & Toko</th>
                                <th class="px-6 py-4 text-left font-semibold">Pembeli</th>
                                <th class="px-6 py-4 text-left font-semibold">Jumlah & Harga</th>
                                <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                                <th class="px-6 py-4 text-left font-semibold">Status</th>
                                <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $filtered = $pesanans->where('status', $status);
                                $no = 1;
                            @endphp

                            @forelse ($filtered as $pesanan)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold text-sm">
                                            {{ $no++ }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-3">
                                            <div class="bg-gradient-to-br from-blue-500 to-purple-500 w-12 h-12 rounded-lg flex items-center justify-center text-white text-xl">
                                                <i class="fas fa-gift"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">{{ $pesanan->produk->nama ?? '-' }}</p>
                                                <p class="text-xs text-gray-500">
                                                    <i class="fas fa-store mr-1"></i>{{ $pesanan->produk->toko->nama_toko ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $pesanan->nama_pembeli }}</p>
                                            <p class="text-xs text-gray-500">
                                                <i class="fas fa-phone mr-1"></i>{{ $pesanan->no_hp_pembeli ?? '-' }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                <i class="fas fa-envelope mr-1"></i>{{ $pesanan->email_pembeli ?? '-' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-blue-600">{{ $pesanan->jumlah }} pcs</p>
                                            <p class="text-sm text-green-600 font-bold">
                                                Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <p class="font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y') }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('H:i') }} WIB
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <select data-id="{{ $pesanan->id }}" 
                                                class="status-select border-2 border-gray-300 rounded-lg px-3 py-2 text-sm font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all cursor-pointer
                                                {{ $pesanan->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-300' : '' }}
                                                {{ $pesanan->status === 'dikonfirmasi' ? 'bg-blue-50 text-blue-700 border-blue-300' : '' }}
                                                {{ $pesanan->status === 'diproses' ? 'bg-indigo-50 text-indigo-700 border-indigo-300' : '' }}
                                                {{ $pesanan->status === 'selesai' ? 'bg-green-50 text-green-700 border-green-300' : '' }}
                                                {{ $pesanan->status === 'dibatalkan' ? 'bg-red-50 text-red-700 border-red-300' : '' }}">
                                            <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="dikonfirmasi" {{ $pesanan->status == 'dikonfirmasi' ? 'selected' : '' }}>✅ Dikonfirmasi</option>
                                            <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                                            <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>✔️ Selesai</option>
                                            <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            <a href="{{ route('penjual.pesanan.show', $pesanan->id) }}" 
                                               class="inline-flex items-center justify-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 transition-all duration-300 hover:shadow-lg text-sm">
                                                <i class="fas fa-eye"></i>
                                                <span>Detail</span>
                                            </a>
                                            @if($pesanan->no_hp_pembeli)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanan->no_hp_pembeli) }}?text={{ urlencode('Halo ' . $pesanan->nama_pembeli . ', pesanan Anda untuk produk ' . ($pesanan->produk->nama ?? '-') . ' telah kami terima.') }}" 
                                               target="_blank" 
                                               class="inline-flex items-center justify-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-600 transition-all duration-300 hover:shadow-lg text-sm">
                                                <i class="fab fa-whatsapp"></i>
                                                <span>WhatsApp</span>
                                            </a>
                                            @endif
                                            @if($pesanan->hasLocation())
                                            <a href="{{ $pesanan->map_link }}" 
                                               target="_blank" 
                                               class="inline-flex items-center justify-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-orange-600 transition-all duration-300 hover:shadow-lg text-sm">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>Lokasi</span>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-inbox text-6xl mb-4"></i>
                                            <p class="text-lg font-semibold">Belum ada pesanan {{ $status }}</p>
                                            <p class="text-sm">Pesanan dengan status {{ $status }} akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    // Define color schemes for each status
    const statusColors = {
        'pending': 'from-yellow-500 to-orange-500',
        'dikonfirmasi': 'from-blue-400 to-blue-600',
        'diproses': 'from-indigo-400 to-indigo-600',
        'selesai': 'from-green-400 to-green-600',
        'dibatalkan': 'from-red-400 to-red-600'
    };

    // Tab handler with color change
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const status = tab.dataset.status;
            
            // Remove active styles from all tabs
            tabs.forEach(t => {
                t.classList.remove('active', 'scale-105', 'shadow-xl', 'text-white');
                t.classList.remove(...Object.values(statusColors).flatMap(c => c.split(' ')));
                t.classList.add('hover:bg-gray-100');
            });
            
            // Add active styles to clicked tab
            tab.classList.remove('hover:bg-gray-100');
            tab.classList.add('active', 'scale-105', 'shadow-xl', 'text-white', 'bg-gradient-to-r');
            tab.classList.add(...statusColors[status].split(' '));
            
            // Show corresponding content
            contents.forEach(c => c.classList.add('hidden'));
            document.getElementById(`tab-${status}`).classList.remove('hidden');
        });
    });

    // Update status AJAX
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', async (e) => {
            const id = e.target.dataset.id;
            const status = e.target.value;
            const oldStatus = e.target.getAttribute('data-old-status') || e.target.value;

            // Confirmation dialog
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
                e.target.value = oldStatus; // Revert to old status
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Memperbarui...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
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
                    e.target.value = oldStatus; // Revert
                    Swal.fire({
                        title: '⚠️ Gagal!',
                        text: result.message || 'Terjadi kesalahan saat memperbarui status.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            } catch (error) {
                e.target.value = oldStatus; // Revert
                Swal.fire({
                    title: '❌ Error!',
                    text: 'Tidak dapat terhubung ke server.',
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});
</script>

<style>
    .tab-btn.active {
        transform: scale(1.05);
    }
    
    .tab-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .status-select {
        min-width: 150px;
    }
    
    .status-select:hover {
        transform: scale(1.02);
    }
</style>
@endsection