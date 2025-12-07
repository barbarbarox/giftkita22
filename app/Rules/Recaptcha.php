<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Jika tidak ada value, return false
        if (empty($value)) {
            return false;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $value,
                'remoteip' => request()->ip()
            ]);

            $result = $response->json();

            // Cek apakah verifikasi berhasil
            return isset($result['success']) && $result['success'] === true;
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('reCAPTCHA verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.';
    }
}