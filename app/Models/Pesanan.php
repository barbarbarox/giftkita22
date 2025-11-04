<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'produk_id',
        'nama_pembeli',
        'email_pembeli',
        'no_hp_pembeli',
        'alamat_pembeli',
        'jumlah',
        'tanggal_pemesanan',
        'status',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'datetime',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
