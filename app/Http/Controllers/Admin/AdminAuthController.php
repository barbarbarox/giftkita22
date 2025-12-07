<?php
/**
 * app/Http/Controllers/Admin/AdminAuthController.php
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use App\Rules\Recaptcha;

class AdminAuthController extends Controller
{
    /**
     * 🔐 Tampilkan form login admin
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * 🚪 Proses login admin
     */
    public function login(Request $request)
    {
        // ✅ Validasi input + reCAPTCHA
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'g-recaptcha-response' => ['required', new Recaptcha]
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA.',
        ]);

        // ✅ Cek apakah admin terdaftar
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin) {
            Log::warning('Admin login gagal - Email tidak ditemukan', [
                'email' => $credentials['email'],
                'ip' => $request->ip()
            ]);

            return back()->withErrors(['email' => 'Email tidak ditemukan di sistem admin.'])
                ->withInput($request->only('email'));
        }

        // ✅ Cek password
        if (!Hash::check($credentials['password'], $admin->password)) {
            Log::warning('Admin login gagal - Password salah', [
                'email' => $credentials['email'],
                'ip' => $request->ip()
            ]);

            return back()->withErrors(['password' => 'Password salah.'])
                ->withInput($request->only('email'));
        }

        // ✅ Coba login pakai guard admin
        // Hapus g-recaptcha-response dari credentials sebelum attempt
        $loginCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ];

        if (Auth::guard('admin')->attempt($loginCredentials, $request->filled('remember'))) {
            // Regenerate session untuk keamanan CSRF/session fixation
            $request->session()->regenerate();

            Log::info('Admin berhasil login', [
                'admin_id' => $admin->id,
                'email' => $admin->email,
                'ip' => $request->ip()
            ]);

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Berhasil login sebagai admin!');
        }

        // ❌ Jika gagal (guard belum dikonfigurasi dengan benar)
        Log::error('Admin login gagal - Guard configuration error', [
            'email' => $credentials['email']
        ]);

        return back()->withErrors(['email' => 'Login gagal. Periksa konfigurasi guard admin di config/auth.php.'])
            ->withInput($request->only('email'));
    }

    /**
     * 🔓 Logout admin
     */
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        Log::info('Admin logout', [
            'admin_id' => $admin->id ?? null,
            'email' => $admin->email ?? null,
            'ip' => $request->ip()
        ]);

        Auth::guard('admin')->logout();

        // Hapus sesi dan token agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Anda telah logout.');
    }
}