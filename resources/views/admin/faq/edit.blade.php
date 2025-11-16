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

    {{-- ✅ Form edit --}}
    <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST" id="faqForm"
          class="space-y-6 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        @csrf
        @method('PUT')

        {{-- Pertanyaan --}}
        <div>
            <label for="pertanyaan" class="block text-gray-700 font-semibold mb-2">
                Pertanyaan <span class="text-red-500">*</span>
            </label>
            <input type="text" id="pertanyaan" name="pertanyaan" 
                   value="{{ old('pertanyaan', $faq->pertanyaan) }}"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#007daf] focus:outline-none"
                   placeholder="Masukkan pertanyaan FAQ..." required>
        </div>

        {{-- Jawaban (CKEditor) --}}
        <div>
            <label for="jawaban" class="block text-gray-700 font-semibold mb-2">
                Jawaban <span class="text-red-500">*</span>
            </label>
            <textarea id="editor" name="jawaban" 
                      class="w-full border border-gray-300 rounded-lg">{{ old('jawaban', $faq->jawaban) }}</textarea>
            <p class="text-xs text-gray-500 mt-2">
                💡 Tips: Gunakan heading, bold, list, dan gambar untuk membuat FAQ lebih mudah dibaca
            </p>
        </div>

        {{-- Role (Kategori FAQ) --}}
        <div>
            <label for="role" class="block text-gray-700 font-semibold mb-2">
                Untuk Pengguna <span class="text-red-500">*</span>
            </label>
            <select id="role" name="role"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#007daf] focus:outline-none" required>
                <option value="" disabled>Pilih kategori pengguna...</option>
                <option value="pembeli" {{ old('role', $faq->role) == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                <option value="penjual" {{ old('role', $faq->role) == 'penjual' ? 'selected' : '' }}>Penjual</option>
                <option value="semua" {{ old('role', $faq->role) == 'semua' ? 'selected' : '' }}>Semua Pengguna</option>
            </select>
        </div>

        {{-- Preview Section --}}
        <div class="border-t pt-6">
            <button type="button" onclick="togglePreview()" 
                    class="mb-4 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition">
                👁️ Preview Jawaban
            </button>
            
            <div id="previewSection" class="hidden p-6 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="font-semibold text-lg mb-3">Preview:</h3>
                <div id="previewContent" class="prose max-w-none"></div>
            </div>
        </div>

        {{-- Info Update --}}
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
            <p class="text-sm text-blue-800">
                <i class='bx bx-info-circle'></i> 
                FAQ terakhir diupdate: <strong>{{ $faq->updated_at->format('d M Y, H:i') }}</strong>
            </p>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-between items-center pt-4 border-t">
            <a href="{{ route('admin.faq.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                ← Kembali
            </a>
            
            <div class="flex gap-3">
                <button type="button" onclick="confirmDelete()" 
                        class="px-5 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
                    🗑️ Hapus
                </button>
                <button type="submit" id="submitBtn"
                        class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white font-semibold hover:scale-105 transition">
                    💾 Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    {{-- Hidden form untuk delete --}}
    <form id="deleteForm" action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

{{-- CKEditor 5 CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<style>
/* CKEditor custom styling */
.ck-editor__editable {
    min-height: 400px;
    max-height: 600px;
}

.ck-content {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Preview styling */
.prose {
    color: #374151;
    line-height: 1.75;
}

.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #007daf;
}

.prose h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #007daf;
}

.prose ul, .prose ol {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.prose li {
    margin: 0.5rem 0;
}

.prose blockquote {
    border-left: 4px solid #007daf;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    color: #6b7280;
}

.prose table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
}

.prose table th {
    background-color: #f3f4f6;
    padding: 0.75rem;
    text-align: left;
    font-weight: 600;
    border: 1px solid #d1d5db;
}

.prose table td {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
}
</style>

<script>
let editorInstance;

// Custom Upload Adapter untuk CKEditor
class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file
            .then(file => new Promise((resolve, reject) => {
                this._initRequest();
                this._initListeners(resolve, reject, file);
                this._sendRequest(file);
            }));
    }

    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.faq.uploadImage") }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.responseType = 'json';
    }

    _initListeners(resolve, reject, file) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${file.name}.`;

        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;

            if (!response || response.error) {
                return reject(response && response.error ? response.error.message : genericErrorText);
            }

            resolve({
                default: response.url
            });
        });

        if (xhr.upload) {
            xhr.upload.addEventListener('progress', evt => {
                if (evt.lengthComputable) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            });
        }
    }

    _sendRequest(file) {
        const data = new FormData();
        data.append('upload', file);
        this.xhr.send(data);
    }
}

// Plugin untuk register custom adapter
function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}

// Initialize CKEditor dengan Custom Upload Adapter
ClassicEditor
    .create(document.querySelector('#editor'), {
        // Gunakan custom upload adapter
        extraPlugins: [MyCustomUploadAdapterPlugin],
        
        // Toolbar configuration
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'link', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'uploadImage', 'blockQuote', 'insertTable', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        
        // Image configuration
        image: {
            toolbar: [
                'imageTextAlternative', '|',
                'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
            ]
        },
        
        // Table configuration
        table: {
            contentToolbar: [
                'tableColumn', 'tableRow', 'mergeTableCells'
            ]
        },
        
        // Heading configuration
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
            ]
        }
    })
    .then(editor => {
        editorInstance = editor;
        console.log('✅ CKEditor berhasil dimuat dengan Custom Upload Adapter');
        console.log('📍 Upload URL:', '{{ route("admin.faq.uploadImage") }}');
    })
    .catch(error => {
        console.error('❌ Error loading CKEditor:', error);
        alert('Gagal memuat editor. Silakan refresh halaman.');
    });

// Toggle preview
function togglePreview() {
    const previewSection = document.getElementById('previewSection');
    const previewContent = document.getElementById('previewContent');
    
    if (previewSection.classList.contains('hidden')) {
        // Show preview
        const content = editorInstance.getData();
        previewContent.innerHTML = content;
        previewSection.classList.remove('hidden');
    } else {
        // Hide preview
        previewSection.classList.add('hidden');
    }
}

// Confirm delete
function confirmDelete() {
    if (confirm('⚠️ Yakin ingin menghapus FAQ ini?\n\nSemua gambar terkait juga akan dihapus.')) {
        document.getElementById('deleteForm').submit();
    }
}

// Prevent double submit
document.getElementById('faqForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '⏳ Menyimpan...';
});
</script>
@endsection