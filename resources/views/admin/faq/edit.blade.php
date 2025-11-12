@extends('admin.layouts.app')

@section('title', 'Edit FAQ | GiftKita Admin')

@section('content')
<div class="max-w-5xl mx-auto p-8">
    <h1 class="text-2xl font-bold text-[#007daf] mb-6 flex items-center gap-2">
        ✏️ Edit FAQ
    </h1>

    {{-- ✅ Notifikasi error validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-5">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ Form Edit FAQ --}}
    <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST" enctype="multipart/form-data"
          class="space-y-6 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        @csrf
        @method('PUT')

        {{-- Pertanyaan --}}
        <div>
            <label for="pertanyaan" class="block text-gray-700 font-semibold mb-2">
                Pertanyaan
            </label>
            <input type="text" id="pertanyaan" name="pertanyaan" value="{{ old('pertanyaan', $faq->pertanyaan) }}"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#007daf] focus:outline-none"
                   placeholder="Masukkan pertanyaan FAQ..." required>
        </div>

        {{-- Jawaban (pakai CKEditor) --}}
        <div>
            <label for="jawaban" class="block text-gray-700 font-semibold mb-2">
                Jawaban
            </label>
            <textarea id="editor" name="jawaban" rows="8"
                      class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#007daf] focus:outline-none"
                      placeholder="Tulis jawaban FAQ dengan format lengkap...">{{ old('jawaban', $faq->jawaban) }}</textarea>
        </div>

        {{-- Role (Kategori FAQ) --}}
        <div>
            <label for="role" class="block text-gray-700 font-semibold mb-2">
                Untuk Pengguna
            </label>
            <select id="role" name="role"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#007daf] focus:outline-none" required>
                <option value="" disabled>Pilih kategori pengguna...</option>
                <option value="pembeli" {{ old('role', $faq->role) == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                <option value="penjual" {{ old('role', $faq->role) == 'penjual' ? 'selected' : '' }}>Penjual</option>
                <option value="semua" {{ old('role', $faq->role) == 'semua' ? 'selected' : '' }}>Semua</option>
            </select>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.faq.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold hover:scale-105 transition">
                Perbarui FAQ
            </button>
        </div>
    </form>
</div>

{{-- ✅ CKEditor CDN + konfigurasi upload gambar --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: '{{ route("admin.faq.uploadImage") }}?_token={{ csrf_token() }}'
            },
            toolbar: {
                items: [
                    'heading', '|', 'bold', 'italic', 'link', 'blockQuote', 'numberedList', 'bulletedList',
                    '|', 'insertTable', 'undo', 'redo', '|', 'imageUpload'
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
