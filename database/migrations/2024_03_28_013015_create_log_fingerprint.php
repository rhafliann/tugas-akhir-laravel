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
        Schema::create('log_fingerprint', function (Blueprint $table) {
            $table->id('id_log_fingerprint');
            $table->string('cloud_id');
            $table->string('nik');
            $table->string('type');
            $table->timestamp('scan_time');
            $table->text('original_data');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->unique(['nik', 'type', 'scan_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_fingerprint');
    }
};
