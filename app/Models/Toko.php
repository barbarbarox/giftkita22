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
        'google_map_link',
        'embed_map_link',
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
            if (empty($toko->uuid)) {
                $toko->uuid = (string) Str::uuid();
            }

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
     * 🔹 Relasi ke Pesanan (satu toko punya banyak pesanan)
     * ✅ TAMBAHAN BARU untuk fitur statistik
     */
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'toko_id', 'id');
    }

    /**
     * 🗺️ Accessor: Dapatkan embed URL yang siap pakai
     */
    public function getEmbedUrlAttribute()
    {
        if (!empty($this->embed_map_link)) {
            return $this->embed_map_link;
        }

        if (!empty($this->latitude) && !empty($this->longitude)) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}&hl=id&z=15&output=embed";
        }

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
        if (!empty($this->google_map_link)) {
            return $this->google_map_link;
        }

        if (!empty($this->latitude) && !empty($this->longitude)) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }

        return null;
    }
}