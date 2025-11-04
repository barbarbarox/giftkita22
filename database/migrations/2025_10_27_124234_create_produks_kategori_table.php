<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produk_kategori', function (Blueprint $table) {
            $table->uuid('produk_id');
            $table->uuid('kategori_id');
            $table->timestamps();

            $table->primary(['produk_id', 'kategori_id']);

            $table->foreign('produk_id')
                ->references('id')
                ->on('produks')
                ->onDelete('cascade');

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategoris')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('produk_kategori');
    }
};
