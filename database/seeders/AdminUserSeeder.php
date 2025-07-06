<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUsers = [
            [
                'name' => 'Aufa Ajihad',
                'email' => 'aufaajihadan@gmail.com',
                'password' => '2200018304',
            ],
            [
                'name' => 'Rienandini',
                'email' => 'Rienandini@gmail.com',
                'password' => 'Patangpuluhan',
            ],
            [
                'name' => 'Herwulan',
                'email' => 'Herwulan@gmail.com',
                'password' => 'Winongoasri',
            ],
        ];

        foreach ($adminUsers as $adminUser) {
            User::updateOrCreate(
                ['email' => $adminUser['email']],
                [
                    'name' => $adminUser['name'],
                    'email' => $adminUser['email'],
                    'password' => Hash::make($adminUser['password']),
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Admin users created successfully!');
    }
}
