<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    /**
     * Tampilkan daftar semua FAQ
     */
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * Form tambah FAQ
     */
    public function create()
    {
        return view('admin.faq.create');
    }

    /**
     * Simpan FAQ baru
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
            ->with('success', 'FAQ berhasil ditambahkan!');
    }

    /**
     * Form edit FAQ
     */
    public function edit($uuid)
    {
        $faq = Faq::where('id', $uuid)->firstOrFail();
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update FAQ
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
            ->with('success', 'FAQ berhasil diperbarui!');
    }

    /**
     * Hapus FAQ
     */
    public function destroy($uuid)
    {
        $faq = Faq::where('id', $uuid)->firstOrFail();
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }
}
