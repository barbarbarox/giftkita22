<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produks', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('id_toko');
            $table->uuid('id_kategori')->nullable();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->timestamps();

            $table->foreign('id_toko')->references('uuid')->on('tokos')->onDelete('cascade');
            $table->foreign('id_kategori')->references('uuid')->on('kategoris')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('produks');
    }
};
