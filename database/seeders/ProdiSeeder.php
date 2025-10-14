<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prodis')->insert([
            [
                'kode_prodi' => 'TI',
                'nama_prodi' => 'Teknologi Informasi',
                'jenjang' => 'D3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_prodi' => 'TM',
                'nama_prodi' => 'Teknik Mesin',
                'jenjang' => 'D3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_prodi' => 'TE',
                'nama_prodi' => 'Teknik Elektro',
                'jenjang' => 'D3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
