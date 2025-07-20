<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('_anggota', function (Blueprint $table) {
            if (!Schema::hasColumn('_anggota', 'rt')) {
                $table->string('rt')->nullable()->after('alamat');
            }

            if (!Schema::hasColumn('_anggota', 'rw')) {
                $table->string('rw')->nullable()->after('rt');
            }
        });
    }

    public function down(): void {
        Schema::table('_anggota', function (Blueprint $table) {
            if (Schema::hasColumn('_anggota', 'rt')) {
                $table->dropColumn('rt');
            }

            if (Schema::hasColumn('_anggota', 'rw')) {
                $table->dropColumn('rw');
            }
        });
    }
};

