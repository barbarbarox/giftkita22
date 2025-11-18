<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan_penjuals', function (Blueprint $table) {
            $table->id();
            $table->char('penjual_id', 36); // UUID format char(36)
            $table->string('nama_pelapor');
            $table->string('email_pelapor');
            $table->string('no_telp_pelapor')->nullable();
            $table->string('kategori'); // penipuan, produk_palsu, pelayanan_buruk, pengiriman_bermasalah, lainnya
            $table->text('deskripsi');
            $table->string('bukti_file')->nullable(); // screenshot/foto bukti
            $table->enum('status', ['pending', 'ditinjau', 'selesai', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('ditinjau_at')->nullable();
            $table->timestamps();

            // Foreign key dengan tipe data yang sama (char 36)
            $table->foreign('penjual_id')->references('id')->on('penjuals')->onDelete('cascade');
            $table->index('penjual_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_penjuals');
    }
};