<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasUuid;

class Penjual extends Authenticatable
{
    use HasFactory, HasUuid;

    protected $table = 'penjuals';

    /**
     * Karena memakai UUID sebagai primary key,
     * kita pastikan Laravel tahu bahwa ID-nya bukan auto-increment.
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_hp',
    ];

    protected $hidden = ['password'];

    /**
     * Relasi: satu penjual memiliki banyak toko.
     */
    public function tokos()
    {
        return $this->hasMany(Toko::class, 'penjual_id');
    }

    /**
     * Relasi: jika penjual punya file (foto profil, dll)
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
