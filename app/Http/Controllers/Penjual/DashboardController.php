<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('penjual.dashboard');
    }
}
