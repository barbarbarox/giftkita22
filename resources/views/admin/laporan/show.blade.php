@extends('admin.layouts.app')

@section('title', 'Detail Laporan #' . $laporan->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Back Button -->
    <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6 transition-colors">
        <i class='bx bx-arrow-back mr-2 text-xl'></i>
        Kembali ke Daftar Laporan
    </a>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 flex items-center gap-3 animate-fade-in">
        <i class='bx bx-check-circle text-green-500 text-2xl'></i>
        <p class="text-green-800 font-medium">{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
            <i class='bx bx-x text-2xl'></i>
        </button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Detail Laporan -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Detail Laporan #{{ $laporan->id }}</h2>
                        <p class="text-gray-500">Dilaporkan pada {{ $laporan->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold
                        @if($laporan->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($laporan->status === 'ditinjau') bg-blue-100 text-blue-800
                        @elseif($laporan->status === 'selesai') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ $laporan->status_label }}
                    </span>
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-600 mb-2 block">Kategori Masalah</label>
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium
                        @if($laporan->kategori === 'penipuan') bg-red-100 text-red-800
                        @elseif($laporan->kategori === 'produk_palsu') bg-orange-100 text-orange-800
                        @elseif($laporan->kategori === 'pelayanan_buruk') bg-yellow-100 text-yellow-800
                        @elseif($laporan->kategori === 'pengiriman_bermasalah') bg-purple-100 text-purple-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        @if($laporan->kategori === 'penipuan') 🚨
                        @elseif($laporan->kategori === 'produk_palsu') 🎭
                        @elseif($laporan->kategori === 'pelayanan_buruk') 😡
                        @elseif($laporan->kategori === 'pengiriman_bermasalah') 📦
                        @else 📝
                        @endif
                        {{ $laporan->kategori_label }}
                    </span>
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-600 mb-2 block">Deskripsi Masalah</label>
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $laporan->deskripsi }}</p>
                    </div>
                </div>

                <!-- Bukti File -->
                @if($laporan->bukti_file)
                <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-600 mb-2 block">Bukti Pendukung</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <a href="{{ asset('storage/' . $laporan->bukti_file) }}" target="_blank" class="block">
                            <img src="{{ asset('storage/' . $laporan->bukti_file) }}" alt="Bukti Laporan" class="max-w-full h-auto rounded-lg shadow-md hover:shadow-xl transition-shadow">
                        </a>
                        <a href="{{ asset('storage/' . $laporan->bukti_file) }}" download class="mt-3 inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            <i class='bx bx-download mr-2'></i>
                            Download Bukti
                        </a>
                    </div>
                </div>
                @endif

                <!-- Catatan Admin -->
                @if($laporan->catatan_admin)
                <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-600 mb-2 block">Catatan Admin</label>
                    <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                        <p class="text-gray-800 leading-relaxed">{{ $laporan->catatan_admin }}</p>
                        @if($laporan->ditinjau_at)
                        <p class="text-sm text-gray-500 mt-2">Ditinjau pada: {{ $laporan->ditinjau_at->format('d F Y, H:i') }} WIB</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Update Status Form -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Update Status Laporan</h3>
                <form action="{{ route('admin.laporan.updateStatus', $laporan->id) }}" method="POST">
                    @csrf
                    
                    <!-- Status -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Laporan</label>
                        <select name="status" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                            <option value="pending" {{ $laporan->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="ditinjau" {{ $laporan->status === 'ditinjau' ? 'selected' : '' }}>🔍 Sedang Ditinjau</option>
                            <option value="selesai" {{ $laporan->status === 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                            <option value="ditolak" {{ $laporan->status === 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Admin (Opsional)</label>
                        <textarea 
                            name="catatan_admin" 
                            rows="4"
                            placeholder="Tambahkan catatan atau penjelasan terkait status laporan..."
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none resize-none"
                        >{{ $laporan->catatan_admin }}</textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all">
                            <i class='bx bx-save mr-2'></i>
                            Update Status
                        </button>
                        <button type="button" onclick="if(confirm('Hapus laporan ini?')) document.getElementById('deleteForm').submit();" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all">
                            <i class='bx bx-trash mr-2'></i>
                            Hapus
                        </button>
                    </div>
                </form>

                <!-- Delete Form -->
                <form id="deleteForm" action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Info Pelapor -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class='bx bx-user text-blue-600'></i>
                    Data Pelapor
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-gray-900">{{ $laporan->nama_pelapor }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <a href="mailto:{{ $laporan->email_pelapor }}" class="font-medium text-blue-600 hover:text-blue-800">{{ $laporan->email_pelapor }}</a>
                    </div>
                    @if($laporan->no_telp_pelapor)
                    <div>
                        <p class="text-sm text-gray-600 mb-1">No. Telepon</p>
                        <a href="tel:{{ $laporan->no_telp_pelapor }}" class="font-medium text-blue-600 hover:text-blue-800">{{ $laporan->no_telp_pelapor }}</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Info Penjual -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class='bx bx-store text-red-600'></i>
                    Penjual yang Dilaporkan
                </h3>
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        {{ substr($laporan->penjual->display_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $laporan->penjual->display_name }}</p>
                        <p class="text-sm text-gray-600">{{ $laporan->penjual->email }}</p>
                        <p class="text-sm text-gray-600">{{ $laporan->penjual->no_hp }}</p>
                    </div>
                </div>
                
                <!-- Status Penjual -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Status Penjual</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $laporan->penjual->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $laporan->penjual->status === 'active' ? '✅ Aktif' : '❌ Nonaktif' }}
                    </span>
                </div>

                <!-- Total Laporan -->
                <div class="bg-red-50 rounded-lg p-3">
                    <p class="text-sm text-gray-600 mb-1">Total Laporan Diterima</p>
                    <p class="text-2xl font-bold text-red-600">{{ $laporan->penjual->jumlah_laporan }} Laporan</p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 space-y-2">
                    <a href="{{ route('admin.penjual.monitoring', $laporan->penjual->id) }}" class="block w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center font-semibold rounded-lg transition-all">
                        <i class='bx bx-show mr-2'></i>
                        Lihat Monitoring Penjual
                    </a>
                    @if($laporan->penjual->isActive())
                    <form action="{{ route('admin.penjual.deactivate', $laporan->penjual->id) }}" method="POST" onsubmit="return confirm('Nonaktifkan penjual ini?')">
                        @csrf
                        <input type="hidden" name="reason" value="Terlalu banyak laporan dari pembeli">
                        <button type="submit" class="block w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-center font-semibold rounded-lg transition-all">
                            <i class='bx bx-block mr-2'></i>
                            Nonaktifkan Penjual
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.penjual.activate', $laporan->penjual->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-center font-semibold rounded-lg transition-all">
                            <i class='bx bx-check mr-2'></i>
                            Aktifkan Penjual
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Riwayat Laporan -->
            @if($riwayatLaporan->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class='bx bx-history text-purple-600'></i>
                    Riwayat Laporan Penjual
                </h3>
                <div class="space-y-3">
                    @foreach($riwayatLaporan as $riwayat)
                    <div class="border-l-4 border-gray-300 pl-3 py-2 hover:border-blue-500 transition-colors">
                        <a href="{{ route('admin.laporan.show', $riwayat->id) }}" class="block">
                            <p class="text-sm font-semibold text-gray-900">{{ $riwayat->kategori_label }}</p>
                            <p class="text-xs text-gray-500">{{ $riwayat->created_at->format('d M Y') }}</p>
                            <span class="inline-block mt-1 px-2 py-1 rounded text-xs font-medium
                                @if($riwayat->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($riwayat->status === 'ditinjau') bg-blue-100 text-blue-800
                                @elseif($riwayat->status === 'selesai') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $riwayat->status_label }}
                            </span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection