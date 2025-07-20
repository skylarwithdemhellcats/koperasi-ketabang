<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('saldo_awal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('accounts')->onDelete('cascade');
            $table->integer('bulan'); // 1 - 12
            $table->integer('tahun');
            $table->decimal('jumlah', 20, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saldo_awal');
    }
};
