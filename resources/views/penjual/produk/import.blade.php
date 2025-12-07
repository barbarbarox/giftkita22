@extends('layouts.penjual')

@section('title', 'Import Produk dari Excel | GiftKita Seller')
<!-- penjual/produk/import.blade.php -->
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] rounded-2xl shadow-2xl p-6 sm:p-8 mb-8">
        <div class="flex items-start justify-between">
            <div class="text-white">
                <h1 class="text-3xl sm:text-4xl font-bold mb-2">📊 Import Produk</h1>
                <p class="text-white/90">Import produk dalam jumlah banyak menggunakan file Excel atau CSV</p>
            </div>
            <a href="{{ route('penjual.produk.index') }}"
                class="bg-white text-[#007daf] px-4 py-2 rounded-lg font-semibold hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-md animate-fade-in flex items-center gap-3">
        <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Warning Message --}}
    @if(session('warning'))
    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-lg mb-6 shadow-md animate-fade-in">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="flex-1">
                <span class="font-medium">{{ session('warning') }}</span>

                @if(session('errors'))
                <div class="mt-3 bg-white/50 rounded-lg p-3 max-h-60 overflow-y-auto">
                    <p class="font-semibold mb-2 text-sm">Detail Error:</p>
                    @foreach(session('errors') as $error)
                    <div class="text-xs mb-2 pb-2 border-b border-yellow-200 last:border-0">
                        <p><strong>Baris {{ $error['row'] }}:</strong> {{ $error['error'] }}</p>
                        <p class="text-gray-600 mt-1">Data: {{ json_encode($error['data']) }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg mb-6 shadow-md animate-fade-in flex items-center gap-3">
        <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Validation Errors --}}
    @if(session('validation_errors'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg mb-6 shadow-md animate-fade-in">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <p class="font-semibold mb-2">Terjadi Kesalahan Validasi:</p>
                <div class="bg-white/50 rounded-lg p-3 max-h-60 overflow-y-auto">
                    @foreach(session('validation_errors') as $error)
                    <div class="text-sm mb-2 pb-2 border-b border-red-200 last:border-0">
                        <p><strong>Baris {{ $error['row'] }}:</strong></p>
                        <ul class="list-disc ml-5 mt-1">
                            @foreach($error['errors'] as $err)
                            <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Download Template Section --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">1. Download Template</h3>
                <p class="text-gray-600 mb-6 text-sm">
                    Download template Excel untuk memudahkan pengisian data produk
                </p>
                <a href="{{ route('penjual.produk.import.template') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 hover:scale-105 transform transition-all duration-300 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Template
                </a>
            </div>
        </div>

        {{-- Upload File Section --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">2. Upload File</h3>
                <p class="text-gray-600 mb-6 text-sm">
                    Upload file Excel yang sudah diisi dengan data produk
                </p>

                <form action="{{ route('penjual.produk.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="mb-4">
                        <label for="file" class="cursor-pointer">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-500 transition-colors duration-300" id="dropZone">
                                <input type="file" name="file" id="file" class="hidden" accept=".xlsx,.xls,.csv" required>
                                <div id="filePreview" class="hidden">
                                    <div class="flex items-center justify-center gap-3">
                                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div class="text-left">
                                            <p class="font-medium text-gray-800" id="fileName"></p>
                                            <p class="text-sm text-gray-500" id="fileSize"></p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="clearFile()" class="mt-3 text-sm text-red-600 hover:text-red-700">
                                        Hapus file
                                    </button>
                                </div>
                                <div id="uploadPrompt">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-gray-600 font-medium">Klik untuk memilih file</p>
                                    <p class="text-gray-400 text-sm mt-1">atau drag & drop file di sini</p>
                                    <p class="text-gray-400 text-xs mt-2">Format: .xlsx, .xls, .csv (max 2MB)</p>
                                </div>
                            </div>
                        </label>
                        @error('file')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-bold py-3 rounded-lg hover:scale-105 transform transition-all duration-300 shadow-md">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Import Produk
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Instructions --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mt-6 border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-lin
                    ecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Petunjuk Penggunaan
        </h3>
        <div class="space-y-3 text-gray-600">
            <div class="flex items-start gap-3">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">1</span>
                <p><strong>Download template Excel</strong> dengan klik tombol "Download Template"</p>
            </div>
            <div class="flex items-start gap-3">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">2</span>
                <p><strong>Isi data produk</strong> sesuai format yang tersedia di template. Perhatikan contoh yang sudah disediakan</p>
            </div>
            <div class="flex items-start gap-3">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">3</span>
                <p><strong>Pastikan kategori dan nama toko</strong> sesuai dengan yang tersedia di sistem</p>
            </div>
            <div class="flex items-start gap-3">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">4</span>
                <p><strong>Upload file</strong> yang sudah diisi melalui form di atas</p>
            </div>
            <div class="flex items-start gap-3">
                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">5</span>
                <p><strong>Klik "Import Produk"</strong> dan tunggu proses selesai</p>
            </div>
        </div>
        <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
            <p class="text-sm text-yellow-800">
                <strong>⚠️ Catatan Penting:</strong> Fitur import ini tidak dapat mengunggah foto/video produk. Anda perlu menambahkan foto/video secara manual melalui fitur edit produk setelah import selesai.
            </p>
        </div>
    </div>
</div>
<script>
    const fileInput = document.getElementById('file');
    const filePreview = document.getElementById('filePreview');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const dropZone = document.getElementById('dropZone');

    // File input change
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            displayFile(this.files[0]);
        }
    });

    // Drag and drop
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-500', 'bg-blue-50');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            displayFile(files[0]);
        }
    });

    function displayFile(file) {
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        uploadPrompt.classList.add('hidden');
        filePreview.classList.remove('hidden');
    }

    function clearFile() {
        fileInput.value = '';
        uploadPrompt.classList.remove('hidden');
        filePreview.classList.add('hidden');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
</script>
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
</style>
@endsection