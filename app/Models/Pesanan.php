<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'id_produk', 'nama_pembeli', 'alamat', 'no_hp', 'catatan'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($pesanan) {
            $pesanan->uuid = (string) Str::uuid();
        });
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
    