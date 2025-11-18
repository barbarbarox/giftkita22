<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenjual extends Model
{
    use HasFactory;

    protected $table = 'laporan_penjuals';

    protected $fillable = [
        'penjual_id',
        'nama_pelapor',
        'email_pelapor',
        'no_telp_pelapor',
        'kategori',
        'deskripsi',
        'bukti_file',
        'status',
        'catatan_admin',
        'ditinjau_at',
    ];

    protected $casts = [
        'ditinjau_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Penjual (tabel penjuals)
    public function penjual()
    {
        return $this->belongsTo(Penjual::class, 'penjual_id');
    }

    // Accessor untuk label kategori
    public function getKategoriLabelAttribute()
    {
        $labels = [
            'penipuan' => 'Penipuan',
            'produk_palsu' => 'Produk Palsu',
            'pelayanan_buruk' => 'Pelayanan Buruk',
            'pengiriman_bermasalah' => 'Pengiriman Bermasalah',
            'lainnya' => 'Lainnya',
        ];

        return $labels[$this->kategori] ?? $this->kategori;
    }

    // Accessor untuk label status
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'ditinjau' => 'Sedang Ditinjau',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    // Accessor untuk warna badge status
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'ditinjau' => 'blue',
            'selesai' => 'green',
            'ditolak' => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }
}