<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            // Ubah kolom jawaban jadi longText agar bisa menampung HTML panjang dari CKEditor
            $table->longText('jawaban')->change();
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->text('jawaban')->change();
        });
    }
};
