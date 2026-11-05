<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobilCintaRuanganSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $ruangans = [
            ['id' => 1,  'nama_ruangan' => 'IT'],
            ['id' => 2,  'nama_ruangan' => 'IGD'],
            ['id' => 3,  'nama_ruangan' => 'LABORATORIUM'],
            ['id' => 4,  'nama_ruangan' => 'RUANG INTENSIF'],
            ['id' => 5,  'nama_ruangan' => 'OK'],
            ['id' => 6,  'nama_ruangan' => 'FARMASI'],
            ['id' => 7,  'nama_ruangan' => 'RM'],
            ['id' => 8,  'nama_ruangan' => 'KANTOR'],
            ['id' => 9,  'nama_ruangan' => 'RADIOLOGI'],
            ['id' => 10, 'nama_ruangan' => 'RAWAT JALAN'],
            ['id' => 11, 'nama_ruangan' => 'RUANG CENDRAWASIH'],
            ['id' => 12, 'nama_ruangan' => 'RUANG NIFAS'],
            ['id' => 13, 'nama_ruangan' => 'RUANG PERINATOLOGI'],
            ['id' => 14, 'nama_ruangan' => 'RUANG MANYAR'],
            ['id' => 15, 'nama_ruangan' => 'RUANG INTERNA'],
            ['id' => 16, 'nama_ruangan' => 'RUANG BANGAU'],
            ['id' => 17, 'nama_ruangan' => 'RUANG VK'],
            ['id' => 18, 'nama_ruangan' => 'RUANG CSSD'],
            ['id' => 19, 'nama_ruangan' => 'RUANG LAUNDRI'],
            ['id' => 20, 'nama_ruangan' => 'IPSRS'],
            ['id' => 21, 'nama_ruangan' => 'OPMI'],
            ['id' => 22, 'nama_ruangan' => 'DRIVER'],
            ['id' => 23, 'nama_ruangan' => 'INSTALASI GIZI'],
            ['id' => 25, 'nama_ruangan' => 'Kepala Bidang Pelayanan Medis dan Keperawatan'],
            ['id' => 26, 'nama_ruangan' => 'Kepala Bidang Penunjang'],
        ];

        $data = array_map(function ($ruangan) use ($now) {
            return [
                'id' => $ruangan['id'],
                'nama_ruangan' => $ruangan['nama_ruangan'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $ruangans);

        DB::table('ruangans')->upsert(
            $data,
            ['id'],
            ['nama_ruangan', 'updated_at']
        );

        $this->command?->info('25 data ruangan Mobil Cinta berhasil disiapkan.');
    }
}