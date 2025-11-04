<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class File extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'files';

    /**
     * Karena memakai UUID sebagai primary key.
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'filepath',
        'fileable_id',
        'fileable_type',
    ];

    /**
     * Relasi ke model yang memiliki file (produk, toko, dll)
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    /**
     * Akses URL lengkap file dari storage publik.
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->filepath);
    }

    /**
     * Deteksi apakah file berupa video atau gambar.
     */
    public function getTypeAttribute()
    {
        $ext = strtolower(pathinfo($this->filepath, PATHINFO_EXTENSION));
        return in_array($ext, ['mp4', 'mov', 'avi', 'webm']) ? 'video' : 'image';
    }
}
