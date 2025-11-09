<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Traits\HasUuid;

class Admin extends Authenticatable
{
    use HasFactory, HasUuid, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 🔐 Setter otomatis untuk mengenkripsi password saat disimpan
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value) && strlen($value) < 60) { // hindari re-hash
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * 📂 Relasi opsional ke File (jika admin bisa upload sesuatu)
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
