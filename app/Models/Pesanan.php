<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Pesanan extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pesanans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'produk_id',
        'toko_id',
        'nama_pembeli',
        'email_pembeli',
        'no_hp_pembeli',
        'alamat_pembeli',
        'google_map_link',
        'latitude',
        'longitude',
        'jumlah',
        'total_harga',
        'tanggal_pemesanan',
        'status',
        'catatan_penjual',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    /**
     * Boot method untuk auto-fill toko_id dan total_harga
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pesanan) {
            // Auto-fill toko_id dari produk
            if (empty($pesanan->toko_id) && !empty($pesanan->produk_id)) {
                $produk = Produk::find($pesanan->produk_id);
                if ($produk) {
                    $pesanan->toko_id = $produk->toko_id;
                }
            }

            // Auto-calculate total_harga
            if (empty($pesanan->total_harga) && !empty($pesanan->produk_id) && !empty($pesanan->jumlah)) {
                $produk = Produk::find($pesanan->produk_id);
                if ($produk) {
                    $pesanan->total_harga = $produk->harga * $pesanan->jumlah;
                }
            }
        });
    }

    /**
     * Relasi ke produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    /**
     * Relasi ke toko
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    /**
     * Scope: Filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Pesanan dalam periode tertentu
     */
    public function scopePeriode($query, $start, $end)
    {
        return $query->whereBetween('tanggal_pemesanan', [$start, $end]);
    }

    /**
     * Scope: Pesanan hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_pemesanan', today());
    }

    /**
     * Scope: Pesanan minggu ini
     */
    public function scopeMingguIni($query)
    {
        return $query->whereBetween('tanggal_pemesanan', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope: Pesanan bulan ini
     */
    public function scopeBulanIni($query)
    {
        return $query->whereYear('tanggal_pemesanan', now()->year)
                     ->whereMonth('tanggal_pemesanan', now()->month);
    }

    /**
     * Accessor: Cek apakah pesanan punya lokasi
     */
    public function hasLocation()
    {
        return !empty($this->latitude) && !empty($this->longitude);
    }

    /**
     * Accessor: Get koordinat dalam format array
     */
    public function getCoordinatesAttribute()
    {
        if ($this->hasLocation()) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }
        return null;
    }

    /**
     * Accessor: Generate link Google Maps
     */
    public function getMapLinkAttribute()
    {
        if (!empty($this->google_map_link)) {
            return $this->google_map_link;
        }

        if ($this->hasLocation()) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }

        return null;
    }

    /**
     * Accessor: Status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return [
            'pending' => ['text' => 'Pending', 'color' => 'yellow'],
            'dikonfirmasi' => ['text' => 'Dikonfirmasi', 'color' => 'blue'],
            'diproses' => ['text' => 'Diproses', 'color' => 'indigo'],
            'dikirim' => ['text' => 'Dikirim', 'color' => 'purple'],
            'selesai' => ['text' => 'Selesai', 'color' => 'green'],
            'dibatalkan' => ['text' => 'Dibatalkan', 'color' => 'red'],
        ][$this->status] ?? ['text' => 'Unknown', 'color' => 'gray'];
    }
}