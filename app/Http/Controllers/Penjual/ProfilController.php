<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penjual;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil penjual yang sedang login
     */
    public function index()
    {
        // Ambil user login, atau fallback sementara ke penjual pertama
        $penjual = Auth::user() ?? Penjual::first();

        if (!$penjual) {
            return redirect()->route('penjual.dashboard')->with('warning', 'Belum ada akun penjual terdaftar.');
        }

        // Ambil foto profil jika ada
        $foto = $penjual->files()->latest()->first();

        return view('penjual.profil', compact('penjual', 'foto'));
    }

    /**
     * Update profil penjual
     */
    public function update(Request $request)
    {
        $penjual = Auth::user() ?? Penjual::first();

        if (!$penjual) {
            return redirect()->back()->with('error', 'Tidak ada penjual yang dapat diperbarui.');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $penjual->update($validated);

        // Upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('penjual', 'public');
            $penjual->files()->create(['filepath' => 'storage/' . $path]);
        }

        return redirect()->route('penjual.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
