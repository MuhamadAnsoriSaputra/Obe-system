<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProdiSeeder::class,
            KurikulumSeeder::class,
            AngkatanSeeder::class,
        ]);
        // User::updateOrCreate(
        //     ['email' => 'muhamad.ansori@mhs.politala.ac.id'], // 👉 ubah dengan emailmu
        //     [
        //         'id_akun' => 'admin001',
        //         'google_id' => null,
        //         'nama' => 'Saviorr',
        //         'password' => Hash::make('Saviorr2R'),
        //         'role' => 'admin',
        //         'foto' => null,
        //     ]
        // );
    }
}
