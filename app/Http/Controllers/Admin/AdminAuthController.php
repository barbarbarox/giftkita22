<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /**
     * 🔐 Tampilkan form login admin
     */
    public function showLoginForm()
    {
        return view('admin.auth.olgin');
    }

    /**
     * 🚪 Proses login admin
     */
    public function login(Request $request)
    {
        // ✅ Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // ✅ Cek apakah admin terdaftar
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Email tidak ditemukan di sistem admin.']);
        }

        // ✅ Cek password
        if (!Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        // ✅ Coba login pakai guard admin
        if (Auth::guard('admin')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], true)) {
            // Regenerate session untuk keamanan CSRF/session fixation
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Berhasil login sebagai admin!');
        }

        // ❌ Jika gagal (guard belum dikonfigurasi dengan benar)
        return back()->withErrors(['email' => 'Login gagal. Periksa konfigurasi guard admin di config/auth.php.']);
    }

    /**
     * 🔓 Logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        // Hapus sesi dan token agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Anda telah logout.');
    }
}
