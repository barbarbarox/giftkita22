<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            // Tambahkan kolom role untuk membedakan FAQ pembeli, penjual, atau umum
            $table->enum('role', ['pembeli', 'penjual', 'semua'])
                  ->default('semua')
                  ->after('jawaban');
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
