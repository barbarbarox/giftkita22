<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class ProdukKategori extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'produk_kategori';

    protected $fillable = [
        'produk_id',
        'kategori_id',
    ];
}
