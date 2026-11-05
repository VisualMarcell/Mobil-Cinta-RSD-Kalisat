<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobil_cinta_perjalanan', function (Blueprint $table) {
            $table->id();

            // Identitas perjalanan
            $table->string('nomor_perjalanan')
                ->unique('mc_perjalanan_nomor_uq');

            // Data pengajuan
            $table->foreignId('diajukan_oleh_id')
                ->constrained('mobil_cinta_akun')
                ->restrictOnDelete();

            $table->foreignId('ruangan_id')
                ->nullable()
                ->constrained('ruangans')
                ->nullOnDelete();

            $table->string('nama_pasien');
            $table->string('nomor_rekam_medis');
            $table->string('jenis_kelamin_pasien')->nullable();
            $table->string('penjamin');
            $table->string('tujuan');
            $table->text('catatan')->nullable();

            // Status pengajuan
            $table->string('status')->default('diajukan');
            $table->timestamp('diajukan_pada')->nullable();

            // Penugasan sopir dan kendaraan
            $table->foreignId('sopir_id')
                ->nullable()
                ->constrained('mobil_cinta_akun')
                ->restrictOnDelete();

            $table->string('nama_sopir')->nullable();

            $table->foreignId('kendaraan_id')
                ->nullable()
                ->constrained('mobil_cinta_kendaraan')
                ->restrictOnDelete();

            $table->foreignId('ditugaskan_oleh_id')
                ->nullable()
                ->constrained('mobil_cinta_akun')
                ->restrictOnDelete();

            $table->timestamp('ditugaskan_pada')->nullable();

            // Dokumentasi keberangkatan
            $table->decimal('kilometer_berangkat', 10, 2)->nullable();
            $table->decimal('latitude_berangkat', 10, 7)->nullable();
            $table->decimal('longitude_berangkat', 11, 7)->nullable();
            $table->string('foto_berangkat')->nullable();
            $table->timestamp('waktu_berangkat')->nullable();

            // Dokumentasi kedatangan
            $table->decimal('kilometer_sampai', 10, 2)->nullable();
            $table->decimal('latitude_sampai', 10, 7)->nullable();
            $table->decimal('longitude_sampai', 11, 7)->nullable();
            $table->string('foto_sampai')->nullable();
            $table->timestamp('waktu_sampai')->nullable();

            // Catatan dan penolakan
            $table->text('catatan_sopir')->nullable();
            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();

            $table->index(
                ['status', 'diajukan_pada'],
                'mc_perjalanan_status_waktu_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobil_cinta_perjalanan');
    }
};