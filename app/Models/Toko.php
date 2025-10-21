<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'id_penjual', 'nama_toko', 'deskripsi', 'kontak'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($toko) {
            $toko->uuid = (string) Str::uuid();
        });
    }

    public function penjual()
    {
        return $this->belongsTo(Penjual::class, 'id_penjual');
    }

    public function files()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_toko');
    }
}
