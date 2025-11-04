<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Kategori extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'kategoris';

    // Karena pakai UUID sebagai primary key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Relasi ke produk (1 kategori punya banyak produk)
     */
    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id', 'id');
    }
}
