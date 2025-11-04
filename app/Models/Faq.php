<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Faq extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'faqs';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
    ];
}
