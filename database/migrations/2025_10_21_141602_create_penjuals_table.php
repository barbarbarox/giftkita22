<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penjuals', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('status_verifikasi')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('penjuals');
    }
};
