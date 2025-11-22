<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    /**
     * 📱 Halaman setting 2FA
     */
    public function index()
    {
        $penjual = Auth::guard('penjual')->user();
        
        return view('penjual.two-factor.index', [
            'twoFactorEnabled' => $penjual->hasTwoFactorEnabled(),
            'recoveryCodes' => $penjual->hasTwoFactorEnabled() ? $penjual->getRecoveryCodes() : [],
        ]);
    }

    /**
     * ✅ Enable 2FA
     */
    public function enable(Request $request)
    {
        $penjual = Auth::guard('penjual')->user();

        if ($penjual->hasTwoFactorEnabled()) {
            return back()->with('error', '2FA sudah aktif.');
        }

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        // Generate recovery codes
        $recoveryCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $recoveryCodes[] = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10));
        }

        $penjual->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ]);

        return back()->with('success', 'Silakan scan QR Code dengan aplikasi authenticator Anda.');
    }

    /**
     * ✔️ Konfirmasi 2FA dengan kode
     */
    public function confirm(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $penjual = Auth::guard('penjual')->user();

        if ($penjual->hasTwoFactorEnabled()) {
            return back()->with('error', '2FA sudah dikonfirmasi sebelumnya.');
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey(
            decrypt($penjual->two_factor_secret),
            $request->code
        );

        if (!$valid) {
            return back()->withErrors(['code' => 'Kode 2FA tidak valid. Coba lagi.']);
        }

        $penjual->update(['two_factor_confirmed_at' => now()]);

        return back()->with('success', '2FA berhasil diaktifkan! Simpan recovery codes Anda di tempat yang aman.');
    }

    /**
     * ❌ Disable 2FA
     */
    public function disable(Request $request)
    {
        $request->validate(['password' => 'required']);

        $penjual = Auth::guard('penjual')->user();

        if (!Hash::check($request->password, $penjual->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        $penjual->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        return back()->with('success', '2FA berhasil dinonaktifkan.');
    }

    /**
     * 🔄 Regenerate recovery codes
     */
    public function regenerateRecoveryCodes()
    {
        $penjual = Auth::guard('penjual')->user();

        if (!$penjual->hasTwoFactorEnabled()) {
            return back()->with('error', 'Aktifkan 2FA terlebih dahulu.');
        }

        $recoveryCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $recoveryCodes[] = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10));
        }

        $penjual->update([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes))
        ]);

        return back()->with('success', 'Recovery codes berhasil di-regenerate. Simpan kode baru Anda!');
    }
}