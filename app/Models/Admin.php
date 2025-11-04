<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasUuid;

class Admin extends Authenticatable
{
    use HasFactory, HasUuid;

    protected $table = 'admins';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
