<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Faq extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'faqs';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'role',
    ];

    /**
     * Relasi polymorphic ke tabel files
     * (satu FAQ bisa punya banyak file terkait — gambar, dokumen, dll)
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
