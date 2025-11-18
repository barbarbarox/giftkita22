<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasUuid;

class Penjual extends Authenticatable
{
    use HasFactory, HasUuid;

    protected $table = 'penjuals';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_hp',
        'google_id',
        'status',
        'deactivated_at',
        'deactivation_reason',
        'deactivated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deactivated_at' => 'datetime',
    ];

    /**
     * Relasi: satu penjual memiliki banyak toko.
     */
    public function tokos()
    {
        return $this->hasMany(Toko::class, 'penjual_id');
    }

    /**
     * Relasi: get toko utama/pertama (untuk kemudahan akses)
     */
    public function toko()
    {
        return $this->hasOne(Toko::class, 'penjual_id')->oldest();
    }

    /**
     * Relasi: jika penjual punya file (foto profil, dll)
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Relasi: admin yang melakukan deaktivasi
     */
    public function deactivatedBy()
    {
        return $this->belongsTo(Admin::class, 'deactivated_by');
    }

    /**
     * Relasi: laporan-laporan yang diterima penjual ini
     */
    public function laporanPenjuals()
    {
        return $this->hasMany(LaporanPenjual::class, 'penjual_id');
    }

    /**
     * Relasi: laporan yang masih pending
     */
    public function laporanPending()
    {
        return $this->hasMany(LaporanPenjual::class, 'penjual_id')
            ->where('status', 'pending');
    }

    /**
     * Accessor: Get nama toko (dari toko pertama)
     */
    public function getNamaTokoAttribute()
    {
        return $this->toko->nama_toko ?? $this->username;
    }

    /**
     * Accessor: Get jumlah laporan
     */
    public function getJumlahLaporanAttribute()
    {
        return $this->laporanPenjuals()->count();
    }

    /**
     * Accessor: Get jumlah laporan pending
     */
    public function getJumlahLaporanPendingAttribute()
    {
        return $this->laporanPending()->count();
    }

    /**
     * Scope: Hanya penjual aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Hanya penjual tidak aktif
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope: Penjual dengan laporan
     */
    public function scopeWithLaporan($query)
    {
        return $query->withCount('laporanPenjuals');
    }

    /**
     * Scope: Penjual yang punya banyak laporan (bermasalah)
     */
    public function scopeBermasalah($query, $minLaporan = 3)
    {
        return $query->withCount('laporanPenjuals')
            ->having('laporan_penjuals_count', '>=', $minLaporan);
    }

    /**
     * Check apakah penjual aktif
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check apakah penjual tidak aktif
     */
    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    /**
     * Check apakah penjual bermasalah (punya banyak laporan)
     */
    public function isBermasalah($minLaporan = 3)
    {
        return $this->laporanPenjuals()->count() >= $minLaporan;
    }

    /**
     * Nonaktifkan penjual
     */
    public function deactivate($reason = null, $adminId = null)
    {
        $this->update([
            'status' => 'inactive',
            'deactivated_at' => now(),
            'deactivation_reason' => $reason,
            'deactivated_by' => $adminId,
        ]);
    }

    /**
     * Aktifkan kembali penjual
     */
    public function activate()
    {
        $this->update([
            'status' => 'active',
            'deactivated_at' => null,
            'deactivation_reason' => null,
            'deactivated_by' => null,
        ]);
    }

    /**
     * Get display name (untuk dropdown, notifikasi, dll)
     */
    public function getDisplayNameAttribute()
    {
        if ($this->tokos()->exists()) {
            return $this->toko->nama_toko ?? $this->username;
        }
        return $this->username;
    }

    /**
     * Get identitas lengkap (untuk laporan, admin panel)
     */
    public function getIdentitasLengkapAttribute()
    {
        $nama = $this->display_name;
        return "{$nama} ({$this->email})";
    }
}