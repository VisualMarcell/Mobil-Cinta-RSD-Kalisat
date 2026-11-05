<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobil_cinta_peran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peran')->unique('mc_peran_nama_uq');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobil_cinta_peran');
    }
};