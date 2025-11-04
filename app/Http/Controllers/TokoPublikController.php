<?php
namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoPublikController extends Controller
{
    public function index()
    {
        $tokos = Toko::withCount('produks')->latest()->get();
        return view('toko.index', compact('tokos'));
    }

    public function show($uuid)
    {
        $toko = Toko::with(['produks.files', 'penjual'])->where('id', $uuid)->firstOrFail();
        return view('toko.show', compact('toko'));
    }
}
