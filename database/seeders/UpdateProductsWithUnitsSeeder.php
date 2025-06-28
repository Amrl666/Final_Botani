<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateProductsWithUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing products with default unit and min_increment
        Product::whereNull('unit')->orWhere('unit', '')->update([
            'unit' => 'kg',
            'min_increment' => 0.5
        ]);

        $this->command->info('Products updated with default units successfully!');
    }
}
