<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'nama_kategori'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($kategori) {
            $kategori->uuid = (string) Str::uuid();
        });
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
