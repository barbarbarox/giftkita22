<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Produk extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'produks';

    protected $fillable = [
        'toko_id',
        'kategori_id',
        'nama',
        'deskripsi',
        'stok',
        'harga',
    ];

    protected $keyType = 'string';

    public $incrementing = false;
    

    // 🔹 Relasi ke Kategori (setiap produk punya satu kategori)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // 🔹 Relasi ke Toko (setiap produk milik satu toko)
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    // 🔹 Relasi ke Pesanan (produk bisa muncul di banyak pesanan)
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'produk_id');
    }

    // 🔹 Relasi ke File (setiap produk bisa punya banyak file foto/video)
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
