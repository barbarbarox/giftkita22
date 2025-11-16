<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung Total Penjual
        $totalPenjual = DB::table('penjuals')->count();

        // Hitung Total Kategori
        $totalKategori = DB::table('kategoris')->count();

        // Hitung Total FAQ
        $totalFaq = DB::table('faqs')->count();

        return view('admin.dashboard', compact(
            'totalPenjual',
            'totalKategori',
            'totalFaq'
        ));
    }
}