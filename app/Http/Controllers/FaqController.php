<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $role = $request->input('role');

        $faqs = Faq::query()
            ->when($role && $role !== 'semua', fn($q) => $q->where('role', $role))
            ->when($search, fn($q) => $q->where('pertanyaan', 'like', "%{$search}%")
                                        ->orWhere('jawaban', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('faq.index', compact('faqs', 'search', 'role'));
    }
}
