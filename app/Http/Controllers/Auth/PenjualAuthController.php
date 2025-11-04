<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Penjual;

class PenjualAuthController extends Controller
{
    /**
     * Tampilkan form login penjual
     */
    public function showLoginForm()
    {
        return view('penjual.auth.login');
    }

    /**
     * Proses login penjual
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $penjual = Penjual::where('email', $credentials['email'])->first();

        if (!$penjual) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan di sistem.'
            ]);
        }

        // Periksa password manual
        if (!Hash::check($credentials['password'], $penjual->password)) {
            return back()->withErrors([
                'password' => 'Password salah.'
            ]);
        }

        // Login manual ke guard penjual
        Auth::guard('penjual')->login($penjual);

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        return redirect()->intended(route('penjual.dashboard'))
            ->with('success', 'Selamat datang kembali, ' . $penjual->username . '!');
    }

    /**
     * Logout penjual
     */
    public function logout(Request $request)
    {
        Auth::guard('penjual')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('penjual.login'))
            ->with('status', 'Anda telah berhasil logout.');
    }
}
