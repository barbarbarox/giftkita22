<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * 🔹 Secara otomatis buat UUID setiap kali record baru dibuat
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($toko) {
            // Isi kolom UUID jika belum ada
            if (empty($toko->uuid)) {
                $toko->uuid = (string) Str::uuid();
            }

            // Jika kolom ID juga UUID (bukan auto increment)
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
}
