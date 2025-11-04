<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot trait untuk mengisi UUID otomatis.
     */
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            // Isi UUID untuk primary key jika kosong
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            // Jika model punya kolom 'uuid' terpisah
            if (isset($model->uuid) && empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Jangan definisikan properti $incrementing & $keyType di sini
     * agar tidak konflik dengan Model bawaan Laravel.
     * Properti tersebut akan didefinisikan di masing-masing model.
     */
}
