<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            if (!Schema::hasColumn('files', 'fileable_id')) {
                $table->uuid('fileable_id')->nullable()->after('filepath');
            }
            if (!Schema::hasColumn('files', 'fileable_type')) {
                $table->string('fileable_type')->nullable()->after('fileable_id');
            }

            // Jika masih ada produk_id lama, hapus
            if (Schema::hasColumn('files', 'produk_id')) {
                $table->dropColumn('produk_id');
            }
        });
    }

};
