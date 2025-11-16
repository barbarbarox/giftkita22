<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\File as FileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminFaqController extends Controller
{
    /**
     * 🧾 Tampilkan daftar semua FAQ
     */
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * 📝 Form tambah FAQ
     */
    public function create()
    {
        return view('admin.faq.create');
    }

    /**
     * 💾 Simpan FAQ baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban'    => 'required|string',
            'role'       => 'required|in:pembeli,penjual,semua',
        ]);

        // Buat FAQ baru
        $faq = Faq::create($validated);

        // Simpan semua gambar yang ter-upload ke database
        $uploadedImages = session('faq_uploaded_images', []);
        if (!empty($uploadedImages)) {
            foreach ($uploadedImages as $path) {
                try {
                    FileModel::create([
                        'id' => (string) Str::uuid(),
                        'filepath' => $path,
                        'fileable_id' => $faq->id,
                        'fileable_type' => Faq::class,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to save file record', [
                        'path' => $path,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Clear session
            session()->forget('faq_uploaded_images');
        }

        // Process gambar yang ada di konten
        $this->processImagesInContent($faq);

        return redirect()->route('admin.faq.index')
            ->with('success', '✅ FAQ berhasil ditambahkan!');
    }

    /**
     * ✏️ Form edit FAQ
     */
    public function edit($uuid)
    {
        $faq = Faq::where('id', $uuid)->firstOrFail();
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * 🔄 Update FAQ
     */
    public function update(Request $request, $uuid)
    {
        $faq = Faq::where('id', $uuid)->firstOrFail();

        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban'    => 'required|string',
            'role'       => 'required|in:pembeli,penjual,semua',
        ]);

        $faq->update($validated);

        // Update relasi gambar
        $this->processImagesInContent($faq);

        return redirect()->route('admin.faq.index')
            ->with('success', '✅ FAQ berhasil diperbarui!');
    }

    /**
     * 🗑️ Hapus FAQ
     */
    public function destroy($uuid)
    {
        $faq = Faq::where('id', $uuid)->firstOrFail();
        
        // Hapus semua file terkait
        foreach ($faq->files as $file) {
            // Hapus file fisik
            $filePath = str_replace('storage/', '', $file->filepath);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
            // Hapus record dari database
            $file->delete();
        }
        
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', '🗑️ FAQ berhasil dihapus!');
    }

    /**
     * 🖼️ Upload gambar dari CKEditor
     */
    public function uploadImage(Request $request)
    {
        // Log untuk debugging
        \Log::info('Upload Image Request', [
            'has_file' => $request->hasFile('upload'),
            'all_files' => $request->allFiles(),
        ]);

        try {
            // Validasi
            $request->validate([
                'upload' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
            ]);

            if (!$request->hasFile('upload')) {
                \Log::error('No file in request');
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Tidak ada file yang diupload.'
                    ]
                ], 400);
            }

            $file = $request->file('upload');

            // Validasi file valid
            if (!$file->isValid()) {
                \Log::error('Invalid file', ['error' => $file->getError()]);
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'File tidak valid: ' . $file->getErrorMessage()
                    ]
                ], 400);
            }

            // Buat nama file unik
            $filename = uniqid('faq_') . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            \Log::info('Uploading file', [
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType()
            ]);

            // Pastikan direktori exists
            $directory = storage_path('app/public/uploads/faq');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
                \Log::info('Created directory: ' . $directory);
            }

            // Simpan ke storage/app/public/uploads/faq
            $path = $file->storeAs('uploads/faq', $filename, 'public');

            if (!$path) {
                \Log::error('Failed to store file');
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Gagal menyimpan file ke storage.'
                    ]
                ], 500);
            }

            // URL untuk akses file
            $url = asset('storage/' . $path);

            \Log::info('File uploaded successfully', [
                'path' => $path,
                'url' => $url
            ]);

            // ✅ JANGAN simpan ke database dulu
            // File akan di-link ke FAQ saat FAQ disimpan
            // Simpan path ke session untuk tracking
            $uploadedImages = session('faq_uploaded_images', []);
            $uploadedImages[] = $path;
            session(['faq_uploaded_images' => $uploadedImages]);

            // Response untuk CKEditor
            return response()->json([
                'uploaded' => 1,
                'url' => $url
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Validasi gagal: ' . implode(', ', $e->errors()['upload'] ?? ['Unknown error'])
                ]
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Upload gagal: ' . $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * 🔗 Process dan link gambar yang ada di konten ke FAQ
     */
    private function processImagesInContent(Faq $faq)
    {
        // Extract semua URL gambar dari konten HTML
        preg_match_all('/<img[^>]+src="([^">]+)"/', $faq->jawaban, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                // Extract path dari URL
                $path = str_replace(asset('storage/'), '', $imageUrl);
                
                // Cari file di database dan update fileable_id
                FileModel::where('filepath', $path)
                    ->where('fileable_type', Faq::class)
                    ->whereNull('fileable_id')
                    ->update([
                        'fileable_id' => $faq->id
                    ]);
            }
        }
    }
}