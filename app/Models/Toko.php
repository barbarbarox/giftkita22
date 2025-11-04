<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Toko extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'tokos';

    protected $fillable = [
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

    // 🔹 Relasi ke Penjual (setiap toko dimiliki satu penjual)
    public function penjual()
    {
        return $this->belongsTo(Penjual::class, 'penjual_id');
    }

    // 🔹 Relasi ke Produk (satu toko punya banyak produk)
    public function produks()
    {
        return $this->hasMany(Produk::class, 'toko_id', 'id');
    }
}
