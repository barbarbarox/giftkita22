<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // tambahkan kolom remember_token jika belum ada
            if (!Schema::hasColumn('admins', 'remember_token')) {
                $table->rememberToken()->after('password')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};
