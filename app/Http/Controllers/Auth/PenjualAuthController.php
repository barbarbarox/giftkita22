<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Penjual;

class PenjualAuthController extends Controller
{
    /**
     * 🧭 Tampilkan form login penjual.
     */
    public function showLoginForm()
    {
        return view('penjual.auth.login');
    }

    /**
     * 🔐 Proses login penjual manual.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $penjual = Penjual::where('email', $credentials['email'])->first();

        if (!$penjual) {
            return back()->withErrors(['email' => 'Email tidak ditemukan di sistem.'])->withInput();
        }

        if (!Hash::check($credentials['password'], $penjual->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        // ⚠️ VALIDASI STATUS AKUN - Cek apakah akun aktif
        if ($penjual->isInactive()) {
            return back()->withErrors([
                'status' => 'Akun Anda telah dinonaktifkan oleh admin.',
                'reason' => $penjual->deactivation_reason ?? 'Tidak ada alasan yang diberikan.',
                'date' => $penjual->deactivated_at ? $penjual->deactivated_at->format('d M Y H:i') : null
            ])->withInput($request->only('email'));
        }

        Auth::guard('penjual')->login($penjual, $request->filled('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('penjual.dashboard'))
            ->with('success', 'Selamat datang kembali, ' . $penjual->username . '!');
    }

    /**
     * 🚪 Logout penjual.
     */
    public function logout(Request $request)
    {
        Auth::guard('penjual')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('penjual.login'))
            ->with('status', 'Anda telah berhasil logout.');
    }

    /**
     * 🌐 Arahkan pengguna ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * 🎯 Tangani callback dari Google setelah login.
     */
    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google (gunakan stateless agar tidak tergantung session)
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cek apakah penjual sudah terdaftar
            $penjual = Penjual::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            // Jika belum terdaftar, buat akun baru
            if (!$penjual) {
                $penjual = Penjual::create([
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(str()->random(16)), // buat password acak
                    'no_hp' => '-', // opsional, bisa diganti nanti
                    'status' => 'active', // Default aktif untuk pendaftaran baru
                ]);
            } else {
                // Update google_id jika belum diset
                if (empty($penjual->google_id)) {
                    $penjual->update(['google_id' => $googleUser->getId()]);
                }
                
                // ⚠️ VALIDASI STATUS AKUN untuk login Google
                if ($penjual->isInactive()) {
                    return redirect()->route('penjual.login')->withErrors([
                        'status' => 'Akun Anda telah dinonaktifkan oleh admin.',
                        'reason' => $penjual->deactivation_reason ?? 'Tidak ada alasan yang diberikan.',
                        'date' => $penjual->deactivated_at ? $penjual->deactivated_at->format('d M Y H:i') : null
                    ]);
                }
            }

            // Login menggunakan guard penjual
            Auth::guard('penjual')->login($penjual, true);
            session()->regenerate();

            return redirect()->route('penjual.dashboard')
                ->with('success', 'Selamat datang, ' . $penjual->username . '!');
        } catch (\Throwable $e) {
            // Hindari menampilkan error internal Google ke user
            return redirect()->route('penjual.login')
                ->withErrors(['login' => 'Login Google gagal. Pastikan Anda mengizinkan akses akun Google.']);
        }
    }

    /**
     * 🧾 Form registrasi penjual.
     */
    public function showRegisterForm()
    {
        return view('penjual.auth.register');
    }

    /**
     * ✍️ Proses registrasi penjual manual.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:penjuals,email',
            'password' => 'required|string|min:6|confirmed',
            'no_hp' => 'required|string|max:20',
        ]);

        $penjual = Penjual::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'no_hp' => $validated['no_hp'],
            'status' => 'active', // Default aktif untuk pendaftaran baru
        ]);

        Auth::guard('penjual')->login($penjual);
        $request->session()->regenerate();

        return redirect()->route('penjual.dashboard')
            ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $penjual->username . '!');
    }
}