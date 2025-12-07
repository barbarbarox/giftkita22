<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PesananPublikController extends Controller
{
    /**
     * Simpan pesanan dari pembeli publik (tanpa login)
     */
    public function store(Request $request)
    {
        try {
            // ✅ 1. Validasi input dari form
            $validated = $request->validate([
                'produk_id' => 'required|exists:produks,id',
                'nama_pembeli' => 'required|string|max:255',
                'email_pembeli' => 'nullable|email|max:255',
                'no_hp_pembeli' => 'required|string|max:20',
                'alamat_pembeli' => 'required|string',
                'google_map_link' => 'nullable|url|max:2000',
                'latitude' => 'nullable|string|max:20',
                'longitude' => 'nullable|string|max:20',
            ]);

            // 🔍 DEBUG: Log data yang diterima
            Log::info('Data pesanan diterima:', [
                'latitude' => $validated['latitude'] ?? 'null',
                'longitude' => $validated['longitude'] ?? 'null',
                'google_map_link' => $validated['google_map_link'] ?? 'null',
            ]);

            // ✅ 2. Ambil data produk untuk generate WhatsApp link
            $produk = Produk::with('toko')->findOrFail($validated['produk_id']);
            $toko = $produk->toko;

            // ✅ 3. Simpan pesanan ke database
            $pesanan = Pesanan::create([
                'id' => (string) Str::uuid(),
                'produk_id' => $validated['produk_id'],
                'nama_pembeli' => $validated['nama_pembeli'],
                'email_pembeli' => $validated['email_pembeli'] ?? null,
                'no_hp_pembeli' => $validated['no_hp_pembeli'],
                'alamat_pembeli' => $validated['alamat_pembeli'],
                'google_map_link' => $validated['google_map_link'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'jumlah' => 1, // Default 1 karena tidak ada input jumlah
                'tanggal_pemesanan' => Carbon::now(),
                'status' => 'pending',
            ]);

            // 🔍 DEBUG: Konfirmasi data tersimpan
            Log::info('Pesanan berhasil disimpan:', [
                'pesanan_id' => $pesanan->id,
                'latitude_saved' => $pesanan->latitude,
                'longitude_saved' => $pesanan->longitude,
                'google_map_link_saved' => $pesanan->google_map_link,
            ]);

            // ✅ 4. Generate WhatsApp link
            $whatsappNumber = $toko->whatsapp ?? '6281234567890'; // Fallback number
            
            // Bersihkan nomor WhatsApp (hapus karakter non-digit)
            $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
            
            // Pastikan format 62xxx
            if (substr($whatsappNumber, 0, 1) === '0') {
                $whatsappNumber = '62' . substr($whatsappNumber, 1);
            } elseif (substr($whatsappNumber, 0, 2) !== '62') {
                $whatsappNumber = '62' . $whatsappNumber;
            }

            // Generate pesan WhatsApp
            $message = $this->generateWhatsAppMessage($pesanan, $produk, $toko);
            
            $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);

            // ✅ 5. Kembalikan respon sukses dengan WhatsApp URL
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikirim!',
                'whatsapp_url' => $whatsappUrl,
                'debug' => config('app.debug') ? [
                    'latitude' => $pesanan->latitude,
                    'longitude' => $pesanan->longitude,
                    'google_map_link' => $pesanan->google_map_link,
                ] : null,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // ⚠️ Error validasi
            Log::warning('Validasi pesanan gagal:', $e->errors());
            
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // ⚠️ Error umum
            Log::error('Gagal menyimpan pesanan: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pesanan.',
                'error_detail' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Generate pesan WhatsApp
     */
    private function generateWhatsAppMessage($pesanan, $produk, $toko)
    {
        $message = "Halo *" . $toko->nama_toko . "*,\n\n";
        $message .= "Saya tertarik nih dengan produk *" . $produk->nama . "*\n\n";
        
        $message .= "📝 *Detail Pembeli:*\n";
        $message .= "Nama: " . $pesanan->nama_pembeli . "\n";
        
        if ($pesanan->no_hp_pembeli) {
            $message .= "HP: " . $pesanan->no_hp_pembeli . "\n";
        }
        
        if ($pesanan->email_pembeli) {
            $message .= "Email: " . $pesanan->email_pembeli . "\n";
        }
        
        $message .= "\n📍 *Alamat Pengiriman:*\n";
        $message .= $pesanan->alamat_pembeli . "\n";
        
        // Tambahkan link Google Maps dengan prioritas:
        // 1. Jika ada google_map_link, gunakan itu
        // 2. Jika ada latitude & longitude, generate link
        if ($pesanan->google_map_link) {
            $message .= "\n🗺️ Lokasi Maps: " . $pesanan->google_map_link . "\n";
        } elseif ($pesanan->latitude && $pesanan->longitude) {
            $message .= "\n🗺️ Lokasi Maps: https://www.google.com/maps?q={$pesanan->latitude},{$pesanan->longitude}\n";
        }
        
        $message .= "\nTerima kasih! 🎁";
        
        return $message;
    }   
}