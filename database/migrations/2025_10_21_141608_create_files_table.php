<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('fileable_id');
            $table->string('fileable_type');
            $table->string('filename');
            $table->string('filepath');
            $table->string('filetype')->nullable();
            $table->timestamps();

            // index untuk polymorphic lookup
            $table->index(['fileable_id', 'fileable_type']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('files');
    }
};
