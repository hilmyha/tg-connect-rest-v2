<?php

namespace Database\Seeders;

use App\Models\Informasi;
use App\Models\Panic;
use App\Models\User;
use App\Models\Warga;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@tgconnect.com',
            'is_admin' => 1,
            'password' => bcrypt('admin123')
        ]);

        User::factory()->create([
            'name' => 'Hilmy Ahmad Haidar',
            'username' => 'haidar',
            'email' => 'haidar@tgconnect.com',
            'is_admin' => 1,
            'password' => bcrypt('haidar123')
        ]);

        Warga::factory()->create([
            'nama_kk' => 'Hilmy Ahmad Haidar',
            'blok' => 'D12',
            'jalan' => 'Pajajaran',
            'jumlah_keluarga' => 4,
            'status_kependudukan' => 1,
            'nomor_hp' => '81234567890',
            'user_id' => 2
        ]);

        Panic::factory()->create([
            'latitude' => '-7.713114560386173',
            'longitude' => '109.02961871663125',
            'user_id' => 1
        ]);


    }
}
