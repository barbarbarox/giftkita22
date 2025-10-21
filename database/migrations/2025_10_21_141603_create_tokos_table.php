<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tokos', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('id_penjual');
            $table->string('nama_toko');
            $table->text('deskripsi')->nullable();
            $table->string('kontak')->nullable();
            $table->timestamps();

            $table->foreign('id_penjual')->references('uuid')->on('penjuals')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tokos');
    }
};
