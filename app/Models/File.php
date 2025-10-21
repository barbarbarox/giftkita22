<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'fileable_id', 'fileable_type', 'filename', 'filepath', 'filetype'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($file) {
            $file->uuid = (string) Str::uuid();
        });
    }

    public function fileable()
    {
        return $this->morphTo();
    }
}
