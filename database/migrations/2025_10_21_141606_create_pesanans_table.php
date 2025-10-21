<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('id_produk');
            $table->string('nama_pembeli');
            $table->text('alamat');
            $table->string('no_hp', 20);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_produk')->references('uuid')->on('produks')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pesanans');
    }
};
