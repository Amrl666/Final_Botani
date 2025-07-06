<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            ProductSeeder::class,
            BlogSeeder::class,
            GallerySeeder::class,
            PrestasiSeeder::class,
            VideoSeeder::class,
            EduwisataSeeder::class,
            ContactSeeder::class,
            OrderSeeder::class,
        ]);
    }
} 