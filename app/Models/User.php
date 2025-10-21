<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['uuid', 'nama', 'email', 'password'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->uuid = (string) Str::uuid();
        });
    }

    protected $hidden = ['password'];
}
