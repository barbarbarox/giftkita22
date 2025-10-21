<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Penjual extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['uuid', 'nama', 'username', 'password', 'status_verifikasi'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($penjual) {
            $penjual->uuid = (string) Str::uuid();
        });
    }

    protected $hidden = ['password'];

    public function toko()
    {
        return $this->hasOne(Toko::class, 'id_penjual');
    }
}
