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
        Schema::table('penjuals', function (Blueprint $table) {
            // Status akun penjual
            $table->enum('status', ['active', 'inactive'])
                  ->default('active')
                  ->after('no_hp');
            
            // Timestamp kapan di-nonaktifkan
            $table->timestamp('deactivated_at')->nullable()->after('status');
            
            // Alasan deaktivasi (opsional)
            $table->text('deactivation_reason')->nullable()->after('deactivated_at');
            
            // Admin yang melakukan deaktivasi
            $table->unsignedBigInteger('deactivated_by')->nullable()->after('deactivation_reason');
            
            // Index untuk performa query
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjuals', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn([
                'status',
                'deactivated_at',
                'deactivation_reason',
                'deactivated_by'
            ]);
        });
    }
};