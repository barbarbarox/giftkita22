<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class BantuanController extends Controller
{
    /**
     * Tampilkan halaman Bantuan & FAQ khusus untuk penjual.
     */
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari query string
        $search = $request->input('q');

        // Query FAQ hanya untuk role 'penjual' dan 'semua'
        $faqs = Faq::query()
            ->where(function ($query) {
                $query->where('role', 'penjual')
                      ->orWhere('role', 'semua');
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('pertanyaan', 'like', "%{$search}%")
                        ->orWhere('jawaban', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Kirim data ke view
        return view('penjual.bantuan', compact('faqs'));
    }
}
