@extends('admin.layouts.app')

@section('title', 'Kelola Laporan Penjual')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">📋 Kelola Laporan Penjual</h1>
            <p class="text-gray-600">Monitor dan tinjau laporan yang masuk dari pembeli</p>
        </div>

    </div>

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

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Laporan</p>
                    <h3 class="text-3xl font-bold">{{ $stats['total'] }}</h3>
                </div>
                <i class='bx bx-file text-4xl opacity-50'></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium mb-1">Pending</p>
                    <h3 class="text-3xl font-bold">{{ $stats['pending'] }}</h3>
                </div>
                <i class='bx bx-time-five text-4xl opacity-50'></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Ditinjau</p>
                    <h3 class="text-3xl font-bold">{{ $stats['ditinjau'] }}</h3>
                </div>
                <i class='bx bx-search text-4xl opacity-50'></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Selesai</p>
                    <h3 class="text-3xl font-bold">{{ $stats['selesai'] }}</h3>
                </div>
                <i class='bx bx-check-circle text-4xl opacity-50'></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Ditolak</p>
                    <h3 class="text-3xl font-bold">{{ $stats['ditolak'] }}</h3>
                </div>
                <i class='bx bx-x-circle text-4xl opacity-50'></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Laporan</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}"
                    placeholder="Nama pelapor, email, atau deskripsi..."
                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none"
                >
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select 
                    name="status" 
                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none"
                >
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ditinjau" {{ $status === 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                    <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Filter Kategori -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                <select 
                    name="kategori" 
                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none"
                >
                    <option value="">Semua Kategori</option>
                    <option value="penipuan" {{ $kategori === 'penipuan' ? 'selected' : '' }}>Penipuan</option>
                    <option value="produk_palsu" {{ $kategori === 'produk_palsu' ? 'selected' : '' }}>Produk Palsu</option>
                    <option value="pelayanan_buruk" {{ $kategori === 'pelayanan_buruk' ? 'selected' : '' }}>Pelayanan Buruk</option>
                    <option value="pengiriman_bermasalah" {{ $kategori === 'pengiriman_bermasalah' ? 'selected' : '' }}>Pengiriman Bermasalah</option>
                    <option value="lainnya" {{ $kategori === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all">
                    <i class='bx bx-search mr-2'></i>Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all">
                    <i class='bx bx-refresh mr-2'></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <form method="POST" action="{{ route('admin.laporan.bulkAction') }}" id="bulkForm">
        @csrf
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 flex items-center gap-4">
            <input type="checkbox" id="selectAll" class="w-5 h-5 rounded border-gray-300 text-blue-600">
            <label for="selectAll" class="text-sm font-semibold text-gray-700">Pilih Semua</label>
            
            <select name="action" class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 outline-none" required>
                <option value="">-- Pilih Aksi --</option>
                <option value="ditinjau">Tandai Ditinjau</option>
                <option value="selesai">Tandai Selesai</option>
                <option value="ditolak">Tandai Ditolak</option>
                <option value="delete">Hapus</option>
            </select>

            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all">
                Terapkan
            </button>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">#</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Penjual</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Pelapor</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Kategori</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Status</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal</span>
                            </th>
                            <th class="px-6 py-4 text-center">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($laporan as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="laporan_ids[]" value="{{ $item->id }}" class="laporan-checkbox w-5 h-5 rounded border-gray-300 text-blue-600">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold">
                                        {{ substr($item->penjual->display_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->penjual->display_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $item->penjual->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $item->nama_pelapor }}</p>
                                <p class="text-sm text-gray-500">{{ $item->email_pelapor }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($item->kategori === 'penipuan') bg-red-100 text-red-800
                                    @elseif($item->kategori === 'produk_palsu') bg-orange-100 text-orange-800
                                    @elseif($item->kategori === 'pelayanan_buruk') bg-yellow-100 text-yellow-800
                                    @elseif($item->kategori === 'pengiriman_bermasalah') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $item->kategori_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($item->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($item->status === 'ditinjau') bg-blue-100 text-blue-800
                                    @elseif($item->status === 'selesai') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $item->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900">{{ $item->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $item->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.laporan.show', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all">
                                    <i class='bx bx-show mr-2'></i>Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class='bx bx-search-alt text-6xl text-gray-300 mb-4'></i>
                                    <p class="text-gray-500 text-lg font-medium">Tidak ada laporan ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($laporan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $laporan->links() }}
            </div>
            @endif
        </div>
    </form>
</div>

<script>
// Select All Checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.laporan-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Bulk Form Confirmation
document.getElementById('bulkForm').addEventListener('submit', function(e) {
    const checkedBoxes = document.querySelectorAll('.laporan-checkbox:checked');
    if (checkedBoxes.length === 0) {
        e.preventDefault();
        alert('Pilih minimal satu laporan terlebih dahulu!');
        return false;
    }
    
    const action = this.querySelector('select[name="action"]').value;
    if (!action) {
        e.preventDefault();
        alert('Pilih aksi yang ingin dilakukan!');
        return false;
    }
    
    if (action === 'delete') {
        if (!confirm('Apakah Anda yakin ingin menghapus laporan yang dipilih?')) {
            e.preventDefault();
            return false;
        }
    }
});
</script>

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