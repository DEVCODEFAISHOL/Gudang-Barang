<?php

namespace Database\Seeders;

use App\Models\User;
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


        // Panggil seeder untuk roles dan permissions terlebih dahulu
        $this->call(RolePermissionSeeder::class);

        // Panggil seeder untuk users
        $this->call(UserSeeder::class);
        // Panggil seeder untuk kategori
        $this->call(KategoriSeeder::class);
    }
}
