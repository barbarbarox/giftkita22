<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['uuid', 'nama', 'username', 'password'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($admin) {
            $admin->uuid = (string) Str::uuid();
        });
    }

    protected $hidden = ['password'];
}
