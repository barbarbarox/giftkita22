<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjual;
use App\Models\Kategori;
use App\Models\Faq;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $total_penjual = Penjual::count();
        $total_kategori = Kategori::count();
        $total_faq = Faq::count();

        return view('admin.dashboard', compact('total_penjual', 'total_kategori', 'total_faq'));
    }
}
