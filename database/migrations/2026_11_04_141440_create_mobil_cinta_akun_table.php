<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobil_cinta_akun', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peran_id')
                ->constrained('mobil_cinta_peran')
                ->restrictOnDelete();

            $table->string('nama');
            $table->string('nama_pengguna')->unique('mc_akun_pengguna_uq');
            $table->string('kata_sandi');
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('login_terakhir_pada')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobil_cinta_akun');
    }
};