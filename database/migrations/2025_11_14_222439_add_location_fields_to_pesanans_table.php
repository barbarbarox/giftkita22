<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Tambah kolom untuk lokasi Google Maps
            $table->text('google_map_link')->nullable()->after('alamat_pembeli');
            $table->string('latitude', 20)->nullable()->after('google_map_link');
            $table->string('longitude', 20)->nullable()->after('latitude');
            
            // Hapus kolom jumlah (tidak diperlukan lagi)
            // HATI-HATI: Jika sudah ada data, backup dulu!
            // $table->dropColumn('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['google_map_link', 'latitude', 'longitude']);
            // $table->integer('jumlah')->default(1);
        });
    }
};