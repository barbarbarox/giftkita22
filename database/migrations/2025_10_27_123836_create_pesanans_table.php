<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pesanans', function (Blueprint $table) {
            // Pastikan engine pakai InnoDB agar mendukung foreign key
            $table->engine = 'InnoDB';

            $table->uuid('id')->primary();

            // Relasi ke produk (UUID)
            $table->uuid('produk_id');
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');

            // Data pembeli
            $table->string('nama_pembeli');
            $table->string('email_pembeli')->nullable();
            $table->string('no_hp_pembeli')->nullable();
            $table->text('alamat_pembeli')->nullable();

            // Data pesanan
            $table->integer('jumlah');
            $table->dateTime('tanggal_pemesanan')->useCurrent();
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pesanans');
    }
};
