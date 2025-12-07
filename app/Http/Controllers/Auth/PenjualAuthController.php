<?php

/**
 * /Controller/Auth/PenjualAuthController.php
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Penjual;
use App\Rules\Recaptcha;

class PenjualAuthController extends Controller
{
    /**
     * 🧭 Tampilkan form login penjual.
     * 
     * ⚠️ PENTING: Hapus pengecekan Auth::guard()->check() karena sudah dihandle oleh middleware guest:penjual
     */
    public function showLoginForm()
    {
        return view('penjual.auth.login');
    }

    /**
     * 🔐 Proses login penjual manual dengan rate limiting progresif.
     */
    public function login(Request $request)
    {
        // Cek rate limiting terlebih dahulu
        $this->checkTooManyFailedAttempts($request);

        // ✅ Validasi input + reCAPTCHA
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'g-recaptcha-response' => ['required', new Recaptcha]
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA.',
        ]);

        // ⚠️ PENTING: Cek apakah user ada di database
        $penjual = Penjual::where('email', $credentials['email'])->first();

        if (!$penjual) {
            $this->incrementLoginAttempts($request);

            Log::warning('Login gagal - Email tidak ditemukan', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
                'attempts' => $this->getLoginAttempts($request)
            ]);

            return back()->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        if (!Hash::check($credentials['password'], $penjual->password)) {
            $this->incrementLoginAttempts($request);

            Log::warning('Login gagal - Password salah', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
                'attempts' => $this->getLoginAttempts($request)
            ]);

            return back()->withErrors(['password' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        // ⚠️ VALIDASI STATUS AKUN - Cek apakah akun aktif
        if ($penjual->isInactive()) {
            return back()->withErrors([
                'account_banned' => 'Akun Anda telah dinonaktifkan.',
                'status' => 'Akun Anda telah dinonaktifkan oleh admin.',
                'reason' => $penjual->deactivation_reason ?? 'Tidak ada alasan yang diberikan.',
                'date' => $penjual->deactivated_at ? $penjual->deactivated_at->format('d M Y H:i') : null
            ])->with('ban_info', [
                'banned' => true,
                'reason' => $penjual->deactivation_reason ?? 'Tidak ada alasan yang diberikan.',
                'date' => $penjual->deactivated_at ? $penjual->deactivated_at->format('d M Y H:i') : null,
            ])->withInput($request->only('email'));
        }

        // ✅ Login berhasil - Clear rate limiter
        $this->clearLoginAttempts($request);

        // Login user (hapus g-recaptcha-response dari credentials)
        $loginCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ];

        Auth::guard('penjual')->login($penjual, $request->filled('remember'));
        $request->session()->regenerate();

        Log::info('Penjual berhasil login', [
            'penjual_id' => $penjual->id,
            'email' => $penjual->email,
            'ip' => $request->ip()
        ]);

        return redirect()->intended(route('penjual.dashboard'))
            ->with('success', 'Selamat datang kembali, ' . $penjual->username . '!');
    }

    /**
     * 🚪 Logout penjual.
     */
    public function logout(Request $request)
    {
        $penjual = Auth::guard('penjual')->user();

        Log::info('Penjual logout', [
            'penjual_id' => $penjual->id ?? null,
            'email' => $penjual->email ?? null,
            'ip' => $request->ip()
        ]);

        // 1. Forget remember token
        if ($penjual) {
            $penjual->setRememberToken(null);
            $penjual->save();
        }

        // 2. Logout dari guard
        Auth::guard('penjual')->logout();

        // 3. Invalidate session SEBELUM regenerate
        $request->session()->invalidate();

        // 4. Regenerate token untuk CSRF protection
        $request->session()->regenerateToken();

        return redirect()->route('penjual.login')
            ->with('status', 'Anda telah berhasil logout.');
    }

    /**
     * 🌐 Arahkan pengguna ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        // Validasi konfigurasi sebelum redirect
        if (
            empty(config('services.google.client_id')) ||
            empty(config('services.google.client_secret')) ||
            empty(config('services.google.redirect'))
        ) {

            Log::error('Google OAuth Configuration Missing', [
                'client_id' => config('services.google.client_id') ? 'Set' : 'Missing',
                'client_secret' => config('services.google.client_secret') ? 'Set' : 'Missing',
                'redirect' => config('services.google.redirect') ?? 'Missing'
            ]);

            return redirect()->route('penjual.login')
                ->withErrors(['error' => 'Konfigurasi Google OAuth belum lengkap. Hubungi administrator.']);
        }

        Log::info('Google OAuth Redirect Attempt', [
            'client_id_length' => strlen(config('services.google.client_id')),
            'redirect_uri' => config('services.google.redirect'),
            'environment' => app()->environment()
        ]);

        try {
            return Socialite::driver('google')
                ->scopes(['openid', 'profile', 'email'])
                ->redirect();
        } catch (\Exception $e) {
            Log::error('Google OAuth Redirect Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('penjual.login')
                ->withErrors(['error' => 'Gagal menghubungkan ke Google. Silakan coba lagi.']);
        }
    }

    /**
     * 🎯 Tangani callback dari Google setelah login.
     */
    public function handleGoogleCallback(Request $request)
    {
        // Cek apakah ada error dari Google
        if ($request->has('error')) {
            Log::warning('Google OAuth Callback Error', [
                'error' => $request->get('error'),
                'error_description' => $request->get('error_description')
            ]);

            return redirect()->route('penjual.login')
                ->withErrors(['error' => 'Login Google dibatalkan atau gagal. Silakan coba lagi.']);
        }

        try {
            // Ambil data user dari Google dengan stateless
            $googleUser = Socialite::driver('google')->stateless()->user();

            Log::info('Google Callback Success', [
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
            ]);

            // Cek apakah penjual sudah terdaftar (cek by google_id atau email)
            $penjual = Penjual::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            // Jika belum terdaftar, buat akun baru
            if (!$penjual) {
                $penjual = Penjual::create([
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(str()->random(32)), // password acak untuk keamanan
                    'no_hp' => '-', // opsional, bisa diupdate nanti
                    'status' => 'active', // Default aktif untuk pendaftaran baru
                ]);

                Log::info('Penjual baru registrasi via Google', [
                    'penjual_id' => $penjual->id,
                    'email' => $penjual->email
                ]);

                $welcomeMessage = 'Selamat datang, ' . $penjual->username . '! Akun Anda berhasil dibuat.';
            } else {
                // Update google_id jika belum diset (untuk user yang register manual lalu login via Google)
                if (empty($penjual->google_id)) {
                    $penjual->update(['google_id' => $googleUser->getId()]);
                    Log::info('Google ID updated untuk penjual existing', [
                        'penjual_id' => $penjual->id,
                        'email' => $penjual->email
                    ]);
                }

                // ⚠️ VALIDASI STATUS AKUN untuk login Google
                if ($penjual->isInactive()) {
                    Log::warning('Login Google gagal - Akun tidak aktif', [
                        'penjual_id' => $penjual->id,
                        'email' => $penjual->email
                    ]);

                    return redirect()->route('penjual.login')->withErrors([
                        'account_banned' => 'Akun Anda telah dinonaktifkan.',
                        'status' => 'Akun Anda telah dinonaktifkan oleh admin.',
                        'reason' => $penjual->deactivation_reason ?? 'Tidak ada alasan yang diberikan.',
                        'date' => $penjual->deactivated_at ? $penjual->deactivated_at->format('d M Y H:i') : null
                    ])->with('ban_info', [
                        'banned' => true,
                        'reason' => $penjual->deactivation_reason ?? 'Tidak ada alasan yang diberikan.',
                        'date' => $penjual->deactivated_at ? $penjual->deactivated_at->format('d M Y H:i') : null,
                    ]);
                }

                $welcomeMessage = 'Selamat datang kembali, ' . $penjual->username . '!';
            }

            // Login menggunakan guard penjual
            Auth::guard('penjual')->login($penjual, true);
            $request->session()->regenerate();

            Log::info('Penjual login via Google', [
                'penjual_id' => $penjual->id,
                'email' => $penjual->email
            ]);

            return redirect()->route('penjual.dashboard')
                ->with('success', $welcomeMessage);
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error('Google OAuth Invalid State', [
                'error' => $e->getMessage(),
                'session_state' => session()->get('state'),
                'request_state' => $request->get('state')
            ]);

            return redirect()->route('penjual.login')
                ->withErrors(['error' => 'Sesi Google login telah kedaluwarsa. Silakan coba lagi.']);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Google OAuth Client Error', [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);

            return redirect()->route('penjual.login')
                ->withErrors(['error' => 'Gagal berkomunikasi dengan Google. Pastikan Anda mengizinkan akses.']);
        } catch (\Exception $e) {
            Log::error('Google Callback Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('penjual.login')
                ->withErrors(['error' => 'Login Google gagal. Silakan coba lagi atau gunakan login manual.']);
        }
    }

    /**
     * 🧾 Form registrasi penjual.
     * 
     * ⚠️ PENTING: Hapus pengecekan Auth::guard()->check() karena sudah dihandle oleh middleware guest:penjual
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
        // ✅ Validasi input + reCAPTCHA
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:penjuals,email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'no_hp' => 'required|string|max:20',
            'g-recaptcha-response' => ['required', new Recaptcha]
        ], [
            'username.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain atau login.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA.',
        ]);

        $penjual = Penjual::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_hp' => $validated['no_hp'],
            'status' => 'active', // Default aktif untuk pendaftaran baru
        ]);

        Auth::guard('penjual')->login($penjual);
        $request->session()->regenerate();

        Log::info('Penjual baru registrasi manual', [
            'penjual_id' => $penjual->id,
            'email' => $penjual->email
        ]);

        return redirect()->route('penjual.dashboard')
            ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $penjual->username . '!');
    }

    // ═══════════════════════════════════════════════════════════════
    // 🔍 CHECK BAN STATUS (AJAX)
    // ═══════════════════════════════════════════════════════════════

    /**
     * Check ban status via AJAX - untuk real-time countdown
     */
    public function checkBanStatus(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $key = 'login-penjual:' . strtolower($request->email) . '|' . $request->ip();
        $attempts = RateLimiter::attempts($key);

        // Cek apakah user sedang di-ban
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'banned' => true,
                'seconds' => $seconds,
                'attempts' => $attempts,
                'message' => 'Terlalu banyak percobaan login gagal.'
            ]);
        }

        // Tidak banned, tapi return jumlah attempts
        return response()->json([
            'banned' => false,
            'attempts' => $attempts
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    // 🛡️ RATE LIMITING METHODS - Progresif dengan Peningkatan 2x Lipat
    // ═══════════════════════════════════════════════════════════════

    /**
     * Cek apakah user sudah terlalu banyak mencoba login
     */
    protected function checkTooManyFailedAttempts(Request $request)
    {
        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);

            Log::warning('Login diblokir - Rate limit exceeded', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'attempts' => RateLimiter::attempts($key),
                'wait_seconds' => $seconds
            ]);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login gagal. Silakan coba lagi dalam {$minutes} menit.",
            ]);
        }
    }

    /**
     * Increment percobaan login yang gagal dengan waktu tunggu progresif
     */
    protected function incrementLoginAttempts(Request $request)
    {
        $key = $this->throttleKey($request);
        $attempts = RateLimiter::attempts($key);

        // Hitung decay time: 1 menit untuk 5 percobaan pertama, lalu 2x lipat
        $decayMinutes = $this->calculateDecayMinutes($attempts + 1);

        // Hit rate limiter dengan decay time yang sesuai
        RateLimiter::hit($key, $decayMinutes * 60); // konversi ke detik
    }

    /**
     * Hitung waktu tunggu berdasarkan jumlah percobaan (progresif 2x lipat)
     */
    protected function calculateDecayMinutes(int $attempts): int
    {
        if ($attempts <= 5) {
            return 1; // 1 menit untuk 5 percobaan pertama
        }

        // Setelah 5 percobaan, hitung berapa kali kelipatan 5
        $multiplier = ceil(($attempts - 5) / 5);

        // 2^multiplier = waktu tunggu meningkat eksponensial
        // Percobaan 6-10: 2 menit
        // Percobaan 11-15: 4 menit
        // Percobaan 16-20: 8 menit, dst
        return pow(2, $multiplier);
    }

    /**
     * Dapatkan jumlah percobaan login saat ini
     */
    protected function getLoginAttempts(Request $request): int
    {
        return RateLimiter::attempts($this->throttleKey($request));
    }

    /**
     * Clear percobaan login setelah login berhasil
     */
    protected function clearLoginAttempts(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    /**
     * Generate throttle key berdasarkan email + IP
     */
    protected function throttleKey(Request $request): string
    {
        return 'login-penjual:' . strtolower($request->input('email')) . '|' . $request->ip();
    }
}