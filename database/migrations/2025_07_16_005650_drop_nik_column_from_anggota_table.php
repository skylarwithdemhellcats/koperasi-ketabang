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
        Schema::table('_anggota', function (Blueprint $table) {
        if (Schema::hasColumn('_anggota', 'nik')) {
            $table->dropColumn('nik');
        }
    });

    }

    public function down(): void
    {
        Schema::table('_anggota', function (Blueprint $table) {
            $table->string('nik')->nullable(); // Bisa dikembalikan jika perlu
        });
    }
};
