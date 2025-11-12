<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Helpers\GoogleMapsHelper;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'tokos';

    protected $fillable = [
        'uuid',
        'penjual_id',
        'nama_toko',
        'alamat_toko',
        'deskripsi',
        'foto_profil',
        'instagram',
        'facebook',
        'whatsapp',

        // 🌍 Kolom lokasi
        'google_map_link',
        'embed_map_link',    // ← TAMBAHAN BARU
        'latitude',
        'longitude',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * 🔹 Otomatis buat UUID saat record baru dibuat
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($toko) {
            // Isi kolom UUID jika belum ada
            if (empty($toko->uuid)) {
                $toko->uuid = (string) Str::uuid();
            }

            // Jika kolom ID juga menggunakan UUID
            if (empty($toko->id)) {
                $toko->id = (string) Str::uuid();
            }
        });
    }

    /**
     * 🔹 Relasi ke Penjual (satu toko dimiliki satu penjual)
     */
    public function penjual()
    {
        return $this->belongsTo(Penjual::class, 'penjual_id');
    }

    /**
     * 🔹 Relasi ke Produk (satu toko punya banyak produk)
     */
    public function produks()
    {
        return $this->hasMany(Produk::class, 'toko_id', 'id');
    }

    /**
     * 🗺️ Accessor: Dapatkan embed URL yang siap pakai
     * Prioritas menggunakan embed_map_link dari database
     */
    public function getEmbedUrlAttribute()
    {
        // PRIORITAS 1: Gunakan embed_map_link jika sudah ada (sudah diproses oleh Controller)
        if (!empty($this->embed_map_link)) {
            return $this->embed_map_link;
        }

        // PRIORITAS 2: Jika ada latitude & longitude, buat embed URL dari koordinat
        if (!empty($this->latitude) && !empty($this->longitude)) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}&hl=id&z=15&output=embed";
        }

        // PRIORITAS 3 (Fallback): Convert real-time dari google_map_link
        // Ini hanya digunakan jika embed_map_link dan koordinat belum ada
        if (!empty($this->google_map_link)) {
            return GoogleMapsHelper::convertToEmbed($this->google_map_link);
        }

        return null;
    }

    /**
     * 🗺️ Accessor: Dapatkan koordinat dalam format array
     */
    public function getCoordinatesAttribute()
    {
        if (!empty($this->latitude) && !empty($this->longitude)) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }

        return null;
    }

    /**
     * 🗺️ Helper: Cek apakah toko punya lokasi map yang valid
     */
    public function hasMapLocation()
    {
        return !empty($this->google_map_link) || 
               (!empty($this->latitude) && !empty($this->longitude));
    }

    /**
     * 📍 Helper: Generate link Google Maps untuk dibuka di app
     */
    public function getMapLinkAttribute()
    {
        // Jika ada google_map_link, gunakan itu
        if (!empty($this->google_map_link)) {
            return $this->google_map_link;
        }

        // Fallback: buat link dari koordinat
        if (!empty($this->latitude) && !empty($this->longitude)) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }

        return null;
    }
}