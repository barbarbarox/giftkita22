<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'id_toko', 'id_kategori', 'nama_produk', 'deskripsi', 'harga'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($produk) {
            $produk->uuid = (string) Str::uuid();
        });
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_produk');
    }
}
