<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\Eduwisata;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some products and eduwisatas for orders
        $products = Product::all();
        $eduwisatas = Eduwisata::all();
        
        if ($products->isEmpty() && $eduwisatas->isEmpty()) {
            $this->command->info('No products or eduwisatas found. Please run ProductSeeder and EduwisataSeeder first.');
            return;
        }

        $orders = [
            [
                'nama_pemesan' => 'Budi Santoso',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'jumlah_orang' => 3,
                'tanggal_kunjungan' => '2024-01-20',
                'produk_id' => $products->isNotEmpty() ? $products->random()->id : null,
                'eduwisata_id' => $eduwisatas->isNotEmpty() ? $eduwisatas->random()->id : null,
                'jumlah' => 5,
                'total_harga' => 85000,
                'status' => 'selesai',
                'keterangan' => 'Pesanan produk pertanian organik'
            ],
            [
                'nama_pemesan' => 'Siti Nurhaliza',
                'telepon' => '081876543210',
                'alamat' => 'Jl. Malioboro No. 45, Yogyakarta',
                'jumlah_orang' => 2,
                'tanggal_kunjungan' => '2024-01-25',
                'produk_id' => null,
                'eduwisata_id' => $eduwisatas->isNotEmpty() ? $eduwisatas->random()->id : null,
                'jumlah' => null,
                'total_harga' => 120000,
                'status' => 'menunggu',
                'keterangan' => 'Paket eduwisata pertanian'
            ],
            [
                'nama_pemesan' => 'Ahmad Fauzi',
                'telepon' => '081112223334',
                'alamat' => 'Jl. Ahmad Yani No. 67, Semarang',
                'jumlah_orang' => 4,
                'tanggal_kunjungan' => '2024-01-22',
                'produk_id' => $products->isNotEmpty() ? $products->random()->id : null,
                'eduwisata_id' => null,
                'jumlah' => 10,
                'total_harga' => 95000,
                'status' => 'disetujui',
                'keterangan' => 'Pesanan sayuran segar'
            ],
            [
                'nama_pemesan' => 'Dewi Sartika',
                'telepon' => '081445556667',
                'alamat' => 'Jl. Solo No. 89, Solo',
                'jumlah_orang' => 1,
                'tanggal_kunjungan' => '2024-01-18',
                'produk_id' => null,
                'eduwisata_id' => $eduwisatas->isNotEmpty() ? $eduwisatas->random()->id : null,
                'jumlah' => null,
                'total_harga' => 150000,
                'status' => 'selesai',
                'keterangan' => 'Paket wisata keluarga'
            ],
            [
                'nama_pemesan' => 'Rudi Hartono',
                'telepon' => '081778889990',
                'alamat' => 'Jl. Magelang No. 12, Magelang',
                'jumlah_orang' => 2,
                'tanggal_kunjungan' => '2024-01-19',
                'produk_id' => $products->isNotEmpty() ? $products->random()->id : null,
                'eduwisata_id' => null,
                'jumlah' => 3,
                'total_harga' => 75000,
                'status' => 'ditolak',
                'keterangan' => 'Pesanan beras organik'
            ],
            [
                'nama_pemesan' => 'Nina Safitri',
                'telepon' => '081223334445',
                'alamat' => 'Jl. Veteran No. 34, Bandung',
                'jumlah_orang' => 3,
                'tanggal_kunjungan' => '2024-01-21',
                'produk_id' => $products->isNotEmpty() ? $products->random()->id : null,
                'eduwisata_id' => null,
                'jumlah' => 8,
                'total_harga' => 180000,
                'status' => 'selesai',
                'keterangan' => 'Pesanan sayuran organik'
            ],
            [
                'nama_pemesan' => 'Joko Widodo',
                'telepon' => '081556667778',
                'alamat' => 'Jl. Diponegoro No. 56, Surabaya',
                'jumlah_orang' => 2,
                'tanggal_kunjungan' => '2024-01-23',
                'produk_id' => null,
                'eduwisata_id' => $eduwisatas->isNotEmpty() ? $eduwisatas->random()->id : null,
                'jumlah' => null,
                'total_harga' => 110000,
                'status' => 'menunggu',
                'keterangan' => 'Paket edukasi hidroponik'
            ],
            [
                'nama_pemesan' => 'Maya Indah',
                'telepon' => '081889990001',
                'alamat' => 'Jl. Gajah Mada No. 78, Malang',
                'jumlah_orang' => 1,
                'tanggal_kunjungan' => '2024-01-24',
                'produk_id' => $products->isNotEmpty() ? $products->random()->id : null,
                'eduwisata_id' => null,
                'jumlah' => 6,
                'total_harga' => 130000,
                'status' => 'disetujui',
                'keterangan' => 'Pesanan cabai merah'
            ],
            [
                'nama_pemesan' => 'Bambang Sutejo',
                'telepon' => '081112223334',
                'alamat' => 'Jl. Merdeka No. 90, Medan',
                'jumlah_orang' => 4,
                'tanggal_kunjungan' => '2024-01-26',
                'produk_id' => $products->isNotEmpty() ? $products->random()->id : null,
                'eduwisata_id' => null,
                'jumlah' => 12,
                'total_harga' => 90000,
                'status' => 'selesai',
                'keterangan' => 'Pesanan tomat cherry'
            ],
            [
                'nama_pemesan' => 'Sri Wahyuni',
                'telepon' => '081445556667',
                'alamat' => 'Jl. Asia Afrika No. 23, Bandung',
                'jumlah_orang' => 2,
                'tanggal_kunjungan' => '2024-01-27',
                'produk_id' => null,
                'eduwisata_id' => $eduwisatas->isNotEmpty() ? $eduwisatas->random()->id : null,
                'jumlah' => null,
                'total_harga' => 160000,
                'status' => 'menunggu',
                'keterangan' => 'Paket camping di kebun'
            ]
        ];

        foreach ($orders as $orderData) {
            Order::create($orderData);
        }

        $this->command->info('Orders seeded successfully!');
    }
} 