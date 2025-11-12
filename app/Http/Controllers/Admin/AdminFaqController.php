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

        Faq::create($validated);

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

        return redirect()->route('admin.faq.index')
            ->with('success', '✅ FAQ berhasil diperbarui!');
    }

    /**
     * 🗑️ Hapus FAQ
     */
    public function destroy($uuid)
    {
        $faq = Faq::where('id', $uuid)->firstOrFail();
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', '🗑️ FAQ berhasil dihapus!');
    }

    /**
     * 🖼️ Upload gambar dari CKEditor + simpan di tabel files
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // Buat nama file unik
            $filename = uniqid('faq_') . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            
            // Simpan ke storage publik
            $path = $file->storeAs('uploads/faq', $filename, 'public');

            // Simpan ke tabel files
            FileModel::create([
                'id' => (string) Str::uuid(),
                'filepath' => 'storage/app/public/faq' . $path,
                'fileable_id' => null, // bisa dikaitkan ke FAQ tertentu nanti
                'fileable_type' => Faq::class,
            ]);

            // Kembalikan respons JSON untuk CKEditor
            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Tidak ada file yang diupload.'], 400);
    }
}
