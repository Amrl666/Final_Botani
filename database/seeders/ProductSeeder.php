<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Beras Organik Premium',
                'description' => 'Beras organik berkualitas tinggi hasil panen langsung dari sawah kami. Beras putih pulen dengan aroma yang khas dan rasa yang enak. Cocok untuk konsumsi sehari-hari maupun acara khusus.',
                'price' => 15000,
                'unit' => 'kg',
                'min_increment' => 1,
                'stock' => 500,
                'featured' => true,
                'bundle_quantity' => 5,
                'bundle_price' => 70000,
                'image' => 'product_images/beras-organik.jpg'
            ],
            [
                'name' => 'Cabai Merah Segar',
                'description' => 'Cabai merah segar hasil panen pagi hari. Tingkat kepedasan yang konsisten dan warna merah yang menarik. Cocok untuk bumbu masakan atau dijual kembali.',
                'price' => 25000,
                'unit' => 'kg',
                'min_increment' => 0.5,
                'stock' => 100,
                'featured' => true,
                'bundle_quantity' => 3,
                'bundle_price' => 70000,
                'image' => 'product_images/cabai-merah.jpg'
            ],
            [
                'name' => 'Tomat Cherry',
                'description' => 'Tomat cherry manis dan segar, ukuran kecil dengan rasa yang enak. Cocok untuk salad, jus, atau camilan sehat. Hasil panen organik tanpa pestisida.',
                'price' => 18000,
                'unit' => 'kg',
                'min_increment' => 0.5,
                'stock' => 75,
                'featured' => false,
                'bundle_quantity' => 2,
                'bundle_price' => 32000,
                'image' => 'product_images/tomat-cherry.jpg'
            ],
            [
                'name' => 'Bawang Merah',
                'description' => 'Bawang merah lokal berkualitas tinggi. Ukuran besar dan seragam dengan aroma yang kuat. Cocok untuk bumbu masakan atau dijual kembali.',
                'price' => 22000,
                'unit' => 'kg',
                'min_increment' => 1,
                'stock' => 200,
                'featured' => true,
                'bundle_quantity' => 4,
                'bundle_price' => 80000,
                'image' => 'product_images/bawang-merah.jpg'
            ],
            [
                'name' => 'Kentang Segar',
                'description' => 'Kentang segar hasil panen langsung. Ukuran seragam dan berkualitas tinggi. Cocok untuk berbagai jenis masakan atau dijual kembali.',
                'price' => 12000,
                'unit' => 'kg',
                'min_increment' => 1,
                'stock' => 300,
                'featured' => false,
                'bundle_quantity' => 5,
                'bundle_price' => 55000,
                'image' => 'product_images/kentang-segar.jpg'
            ],
            [
                'name' => 'Jagung Manis',
                'description' => 'Jagung manis segar dengan rasa yang manis dan tekstur yang lembut. Cocok untuk direbus, dibakar, atau diolah menjadi berbagai masakan.',
                'price' => 8000,
                'unit' => 'buah',
                'min_increment' => 1,
                'stock' => 150,
                'featured' => false,
                'bundle_quantity' => 10,
                'bundle_price' => 70000,
                'image' => 'product_images/jagung-manis.jpg'
            ],
            [
                'name' => 'Kacang Panjang',
                'description' => 'Kacang panjang segar dan renyah. Ukuran panjang dan seragam dengan warna hijau yang menarik. Cocok untuk sayur atau lalapan.',
                'price' => 15000,
                'unit' => 'ikat',
                'min_increment' => 1,
                'stock' => 80,
                'featured' => false,
                'bundle_quantity' => 5,
                'bundle_price' => 70000,
                'image' => 'product_images/kacang-panjang.jpg'
            ],
            [
                'name' => 'Terong Ungu',
                'description' => 'Terong ungu segar dengan ukuran besar dan seragam. Tekstur lembut dan rasa yang enak. Cocok untuk berbagai jenis masakan.',
                'price' => 18000,
                'unit' => 'kg',
                'min_increment' => 0.5,
                'stock' => 120,
                'featured' => false,
                'bundle_quantity' => 3,
                'bundle_price' => 50000,
                'image' => 'product_images/terong-ungu.jpg'
            ],
            [
                'name' => 'Timun Segar',
                'description' => 'Timun segar dengan ukuran besar dan renyah. Cocok untuk lalapan, salad, atau jus. Hasil panen pagi hari untuk kesegaran maksimal.',
                'price' => 10000,
                'unit' => 'kg',
                'min_increment' => 0.5,
                'stock' => 90,
                'featured' => false,
                'bundle_quantity' => 2,
                'bundle_price' => 18000,
                'image' => 'product_images/timun-segar.jpg'
            ],
            [
                'name' => 'Wortel Organik',
                'description' => 'Wortel organik dengan warna oranye yang cerah dan rasa yang manis. Ukuran besar dan seragam. Cocok untuk jus, masakan, atau camilan sehat.',
                'price' => 16000,
                'unit' => 'kg',
                'min_increment' => 0.5,
                'stock' => 180,
                'featured' => true,
                'bundle_quantity' => 3,
                'bundle_price' => 45000,
                'image' => 'product_images/wortel-organik.jpg'
            ],
            [
                'name' => 'Bayam Hijau',
                'description' => 'Bayam hijau segar dengan daun yang lebar dan tebal. Kaya akan nutrisi dan cocok untuk sayur bening atau olahan lainnya.',
                'price' => 8000,
                'unit' => 'ikat',
                'min_increment' => 1,
                'stock' => 100,
                'featured' => false,
                'bundle_quantity' => 5,
                'bundle_price' => 35000,
                'image' => 'product_images/bayam-hijau.jpg'
            ],
            [
                'name' => 'Kangkung Segar',
                'description' => 'Kangkung segar dengan batang yang renyah dan daun yang hijau. Cocok untuk tumis atau sayur bening. Hasil panen pagi hari.',
                'price' => 7000,
                'unit' => 'ikat',
                'min_increment' => 1,
                'stock' => 120,
                'featured' => false,
                'bundle_quantity' => 5,
                'bundle_price' => 30000,
                'image' => 'product_images/kangkung-segar.jpg'
            ]
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }

        $this->command->info('Products seeded successfully!');
    }
} 