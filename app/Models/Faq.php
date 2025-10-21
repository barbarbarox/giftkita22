<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FAQ extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'pertanyaan', 'jawaban'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($faq) {
            $faq->uuid = (string) Str::uuid();
        });
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
