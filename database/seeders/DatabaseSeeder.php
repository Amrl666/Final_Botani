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
        // User Seeder
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        User::factory(5)->create();

        // Product Seeder
        $products = [];
        for ($i = 1; $i <= 10; $i++) {
            $products[] = Product::create([
                'name' => 'Produk ' . $i,
                'description' => 'Deskripsi produk ' . $i,
                'price' => rand(5000, 50000),
                'image' => 'default.png',
                'stock' => rand(10, 100),
                'featured' => $i % 3 === 0,
            ]);
        }

        // Eduwisata Seeder
        $eduwisatas = [];
        for ($i = 1; $i <= 3; $i++) {
            $eduwisatas[] = Eduwisata::create([
                'name' => 'Eduwisata ' . $i,
                'description' => 'Deskripsi eduwisata ' . $i,
                'harga' => rand(10000, 20000),
                'image' => 'default.png',
            ]);
        }

        // Blog Seeder
        for ($i = 1; $i <= 10; $i++) {
            Blog::create([
                'title' => 'Judul Blog ' . $i,
                'image' => 'default.png',
                'content' => 'Isi konten blog ke-' . $i,
            ]);
        }

        // Gallery Seeder (description = tanggal)
        for ($i = 1; $i <= 10; $i++) {
            Gallery::create([
                'title' => 'Galeri ' . $i,
                'image' => 'default.png',
                'description' => Carbon::now()->subDays($i)->format('Y-m-d'),
            ]);
        }

        // Video Seeder
        for ($i = 1; $i <= 5; $i++) {
            Video::create([
                'name' => 'Video ' . $i,
                'title' => 'Judul Video ' . $i,
                'video' => 'https://www.youtube.com/watch?v=video' . $i,
                'description' => 'Deskripsi video ke-' . $i,
            ]);
        }

        // Prestasi Seeder
        for ($i = 1; $i <= 5; $i++) {
            Prestasi::create([
                'title' => 'Prestasi ' . $i,
                'content' => 'Deskripsi prestasi ke-' . $i,
                'image' => 'default.png',
            ]);
        }

        // Order + OrderItem Seeder (produk)
        for ($i = 1; $i <= 10; $i++) {
            $order = Order::create([
                'nama_pemesan' => 'Pemesan ' . $i,
                'telepon' => '0812345678' . $i,
                'alamat' => 'Alamat ke-' . $i,
                'tanggal_kunjungan' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                'keterangan' => 'Catatan pesanan ke-' . $i,
                'total_harga' => 0, // will update after items
                'status' => collect(['menunggu','disetujui','ditolak','selesai'])->random(),
            ]);
            $total = 0;
            $itemCount = rand(1, 3);
            $pickedProducts = collect($products)->random($itemCount);
            foreach ($pickedProducts as $product) {
                $qty = rand(1, 5);
                $subtotal = $qty * $product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price_per_unit' => $product->price,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
            $order->update(['total_harga' => $total]);
        }

        // Order Eduwisata Seeder
        foreach (range(1, 5) as $i) {
            $eduwisata = collect($eduwisatas)->random();
            $jumlah_orang = rand(5, 30);
            Order::create([
                'nama_pemesan' => 'Wisatawan ' . $i,
                'telepon' => '0898765432' . $i,
                'alamat' => 'Alamat Wisatawan ' . $i,
                'jumlah_orang' => $jumlah_orang,
                'eduwisata_id' => $eduwisata->id,
                'tanggal_kunjungan' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                'keterangan' => 'Catatan wisata ke-' . $i,
                'total_harga' => $eduwisata->harga * $jumlah_orang,
                'status' => collect(['menunggu','disetujui','ditolak','selesai'])->random(),
            ]);
        }
    }
}