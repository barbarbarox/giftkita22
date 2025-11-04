<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tokos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('penjual_id');
            $table->string('nama_toko');
            $table->text('alamat_toko')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('sosial_media')->nullable(); // atau nanti bisa jadi tabel terpisah
            $table->timestamps();

            $table->foreign('penjual_id')->references('id')->on('penjuals')->onDelete('cascade');

        });
    }

    public function down(): void {
        Schema::dropIfExists('toko');
    }
};
