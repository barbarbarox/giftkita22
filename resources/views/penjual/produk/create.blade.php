@extends('layouts.penjual')

@section('title', 'Tambah Produk | GiftKita Seller')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">🛍️ Tambah Produk Baru</h2>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Tambah Produk --}}
        <form action="{{ route('penjual.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Pilih Toko --}}
            <div>
                <label for="toko_id" class="block text-gray-700 font-semibold mb-1">Toko</label>
                <select id="toko_id" name="toko_id"
                    class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf]"
                    required>
                    <option value="">-- Pilih Toko Tempat Produk Ditambahkan --</option>
                    @foreach ($tokos as $toko)
                        <option value="{{ $toko->id }}" {{ old('toko_id') == $toko->id ? 'selected' : '' }}>
                            {{ $toko->nama_toko }}
                        </option>
                    @endforeach
                </select>
                @error('toko_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nama Produk --}}
            <div>
                <label for="nama" class="block text-gray-700 font-semibold mb-1">Nama Produk</label>
                <input type="text" id="nama" name="nama" 
                    value="{{ old('nama') }}" 
                    placeholder="Contoh: Buket Cokelat Valentine"
                    class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf] placeholder-gray-400"
                    required>
                @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori_id" class="block text-gray-700 font-semibold mb-1">Kategori</label>
                <select id="kategori_id" name="kategori_id" 
                    class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf]"
                    required>
                    <option value="">-- Pilih Kategori Produk --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block text-gray-700 font-semibold mb-1">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    placeholder="Tuliskan detail produk, bahan, ukuran, atau keunggulan..."
                    class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf] placeholder-gray-400">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>


            {{-- Harga --}}
            <div>
                <label for="harga" class="block text-gray-700 font-semibold mb-1">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" min="0" 
                    value="{{ old('harga') }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf]"
                    required>
                @error('harga') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Upload Files --}}
            <div>
                <label for="files" class="block text-gray-700 font-semibold mb-1">Upload Foto / Video Produk</label>
                <input type="file" id="files" name="files[]" multiple accept="image/*,video/*"
                    class="w-full border-gray-300 rounded-lg focus:ring-[#007daf] focus:border-[#007daf] bg-white py-2 px-3">
                <small class="text-gray-500">Bisa pilih beberapa file (JPG, PNG, MP4, WebM). Maks 50MB per file.</small>
                @error('files.*') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Preview Area --}}
            <div id="preview-area" class="hidden">
                <label class="block text-gray-700 font-semibold mb-1">Preview File:</label>
                <div id="preview-list" class="flex flex-wrap gap-3"></div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('penjual.produk.index') }}" 
                   class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                    ← Batal
                </a>
                <button type="submit" 
                        class="px-5 py-2 bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold rounded-lg hover:scale-105 transition">
                    💾 Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('files');
    const previewArea = document.getElementById('preview-area');
    const previewList = document.getElementById('preview-list');

    input.addEventListener('change', function () {
        previewList.innerHTML = '';

        const files = Array.from(this.files);
        if (!files.length) {
            previewArea.classList.add('hidden');
            return;
        }

        previewArea.classList.remove('hidden');

        files.forEach(file => {
            const url = URL.createObjectURL(file);
            const ext = file.name.split('.').pop().toLowerCase();

            const wrapper = document.createElement('div');
            wrapper.classList.add('w-36', 'text-center', 'border', 'rounded-lg', 'p-2', 'shadow-sm');

            if (['mp4','mov','webm','avi'].includes(ext)) {
                const video = document.createElement('video');
                video.src = url;
                video.width = 140;
                video.height = 100;
                video.controls = true;
                video.classList.add('rounded-md', 'object-cover');
                wrapper.appendChild(video);
            } else {
                const img = document.createElement('img');
                img.src = url;
                img.width = 140;
                img.height = 100;
                img.classList.add('rounded-md', 'object-cover');
                wrapper.appendChild(img);
            }

            const name = document.createElement('p');
            name.classList.add('text-gray-600', 'text-sm', 'mt-2');
            name.textContent = file.name.length > 20 ? file.name.slice(0,17) + '...' : file.name;
            wrapper.appendChild(name);

            previewList.appendChild(wrapper);
        });
    });
});
</script>
@endpush
