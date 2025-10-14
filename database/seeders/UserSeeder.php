<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'google_id' => null,
                'password' => Hash::make('123456'),
                'kode_prodi' => null,
                'role' => 'admin',
                'nama' => 'Admin',
                'email' => 'admin@politala.ac.id',
                'foto' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'google_id' => null,
                'password' => Hash::make('123456'),
                'kode_prodi' => null,
                'role' => 'dosen',
                'nama' => 'Dosen',
                'email' => 'dosen@politala.ac.id',
                'foto' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'google_id' => null,
                'password' => Hash::make('123456'),
                'kode_prodi' => 'TI',
                'role' => 'akademik',
                'nama' => 'Akademik',
                'email' => 'akademik@politala.ac.id',
                'foto' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
