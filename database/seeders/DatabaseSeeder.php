<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Eduwisata;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Video;
use App\Models\Prestasi;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User Seeder (admin dan pengelola)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'Aufa jihadan',
            'email' => 'aufaajihadan@gmail.com',
            'password' => Hash::make('2200018304'),
        ]);
        User::create([
            'name' => 'Rien Andini',
            'email' => 'rienandini@gmail.com',
            'password' => Hash::make('Patangpuluhan'),
        ]);
        User::create([
            'name' => 'Herwulan',
            'email' => 'herwulan@gmail.com',
            'password' => Hash::make('Winongoasri'),
        ]);

        // Product Seeder (hasil tani realistis)
        $products = [
            ['name' => 'Beras Organik', 'price' => 12000],
            ['name' => 'Cabai Merah', 'price' => 30000],
            ['name' => 'Tomat Segar', 'price' => 8000],
            ['name' => 'Bayam Hijau', 'price' => 5000],
            ['name' => 'Jagung Manis', 'price' => 10000],
            ['name' => 'Mentimun', 'price' => 6000],
            ['name' => 'Terong Ungu', 'price' => 7000],
            ['name' => 'Kacang Panjang', 'price' => 4000],
            ['name' => 'Bawang Merah', 'price' => 25000],
            ['name' => 'Pepaya California', 'price' => 9000],
        ];

        foreach ($products as $item) {
            $productModels[] = Product::create([
                'name' => $item['name'],
                'description' => 'Produk hasil tani unggulan dari kelompok tani Winongo Asri.',
                'price' => $item['price'],
                'stock' => rand(10, 100),
                'image' => 'produk.png',
                'unit' => 'kg',
                'min_increment' => 0.5,
                'featured' => rand(0, 1),
            ]);
        }

        // Eduwisata Seeder
        $eduwisatas = [
            ['name' => 'Kunjungan Kebun Sayur Organik', 'harga' => 15000],
            ['name' => 'Pelatihan Urban Farming', 'harga' => 20000],
            ['name' => 'Wisata Edukasi Kompos', 'harga' => 12000],
        ];

        foreach ($eduwisatas as $item) {
            $eduwisataModels[] = Eduwisata::create([
                'name' => $item['name'],
                'description' => 'Program ' . strtolower($item['name']) . ' untuk pelajar dan umum.',
                'harga' => $item['harga'],
                'image' => 'eduwisata.png',
            ]);
        }

        // Blog Seeder
        for ($i = 1; $i <= 5; $i++) {
            Blog::create([
                'title' => 'Tips Pertanian Ramah Lingkungan ke-' . $i,
                'image' => 'blog.png',
                'content' => 'Artikel edukatif tentang pertanian berkelanjutan dan praktik ramah lingkungan.',
            ]);
        }

        // Gallery Seeder
        for ($i = 1; $i <= 6; $i++) {
            Gallery::create([
                'title' => 'Kegiatan Lapangan ' . $i,
                'image' => 'galeri_' . $i . '.png',
                'description' => Carbon::now()->subDays($i)->format('Y-m-d'),
            ]);
        }

        // Video Seeder
        for ($i = 1; $i <= 3; $i++) {
            Video::create([
                'name' => 'Video Edukasi ' . $i,
                'title' => 'Tutorial Bertani Organik ' . $i,
                'video' => 'https://www.youtube.com/watch?v=dummyvideo' . $i,
                'description' => 'Video panduan untuk praktik pertanian sehat dan berkelanjutan.',
            ]);
        }

        // Prestasi Seeder
        $prestasis = [
            'Juara 1 Lomba Kelompok Tani Nasional',
            'Penghargaan Kelompok Tani Inovatif DIY',
            'Finalis Festival Pertanian Berkelanjutan',
        ];
        foreach ($prestasis as $index => $title) {
            Prestasi::create([
                'title' => $title,
                'content' => 'Penghargaan yang diraih atas kontribusi nyata dalam bidang pertanian.',
                'image' => 'prestasi_' . ($index+1) . '.png',
            ]);
        }

        // Order Produk Seeder
        for ($i = 1; $i <= 5; $i++) {
            $order = Order::create([
                'nama_pemesan' => 'Pemesan Produk ' . $i,
                'telepon' => '0812345678' . $i,
                'alamat' => 'Dusun Winongo No. ' . $i,
                'tanggal_kunjungan' => Carbon::now()->addDays(rand(1, 10))->format('Y-m-d'),
                'keterangan' => 'Pesanan produk pertanian.',
                'total_harga' => 0,
                'status' => collect(['menunggu','disetujui','selesai'])->random(),
            ]);
            $total = 0;
            $items = collect($productModels)->random(rand(2, 4));
            foreach ($items as $item) {
                $qty = rand(1, 3);
                $subtotal = $qty * $item->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $qty,
                    'price_per_unit' => $item->price,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
            $order->update(['total_harga' => $total]);
        }

        // Order Eduwisata Seeder
        foreach (range(1, 3) as $i) {
            $eduwisata = collect($eduwisataModels)->random();
            $jumlah_orang = rand(10, 25);
            Order::create([
                'nama_pemesan' => 'Rombongan ' . $i,
                'telepon' => '0898765432' . $i,
                'alamat' => 'Sekolah/Kelompok ' . $i,
                'jumlah_orang' => $jumlah_orang,
                'eduwisata_id' => $eduwisata->id,
                'tanggal_kunjungan' => Carbon::now()->addDays(rand(5, 15))->format('Y-m-d'),
                'keterangan' => 'Kunjungan edukatif ke lokasi pertanian.',
                'total_harga' => $jumlah_orang * $eduwisata->harga,
                'status' => collect(['menunggu', 'disetujui', 'selesai'])->random(),
            ]);
        }
    }
}
