<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Eduwisata;

class EduwisataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eduwisatas = [
            [
                'name' => 'Paket Wisata Pertanian Organik',
                'description' => 'Nikmati pengalaman belajar pertanian organik langsung di lahan kami. Paket ini mencakup tour kebun organik, workshop pembuatan pupuk kompos, dan panen sayuran segar. Cocok untuk keluarga dan kelompok sekolah.',
                'harga' => 75000.00,
                'image' => 'eduwisata_images/paket-pertanian-organik.jpg'
            ],
            [
                'name' => 'Paket Edukasi Hidroponik',
                'description' => 'Pelajari teknik hidroponik modern untuk menanam sayuran tanpa tanah. Paket ini meliputi penjelasan sistem hidroponik, praktik menanam, dan perawatan tanaman. Ideal untuk mahasiswa dan pengusaha pertanian.',
                'harga' => 100000.00,
                'image' => 'eduwisata_images/paket-hidroponik.jpg'
            ],
            [
                'name' => 'Paket Panen Raya',
                'description' => 'Rasakan sensasi panen langsung di kebun kami. Paket ini memungkinkan pengunjung memanen berbagai jenis sayuran dan buah-buahan segar. Hasil panen bisa dibawa pulang sebagai oleh-oleh.',
                'harga' => 50000.00,
                'image' => 'eduwisata_images/paket-panen-raya.jpg'
            ],
            [
                'name' => 'Paket Workshop Pengolahan Hasil Pertanian',
                'description' => 'Belajar mengolah hasil pertanian menjadi produk bernilai tambah. Workshop ini mencakup pembuatan selai, keripik sayuran, dan produk olahan lainnya. Cocok untuk ibu rumah tangga dan pengusaha.',
                'harga' => 120000.00,
                'image' => 'eduwisata_images/paket-workshop-pengolahan.jpg'
            ],
            [
                'name' => 'Paket Wisata Keluarga Tani',
                'description' => 'Pengalaman lengkap menjadi petani sehari. Paket ini meliputi aktivitas menanam, merawat, dan memanen sayuran. Dilengkapi dengan makan siang tradisional dan foto kenangan.',
                'harga' => 150000.00,
                'image' => 'eduwisata_images/paket-keluarga-tani.jpg'
            ],
            [
                'name' => 'Paket Edukasi Pengendalian Hama Terpadu',
                'description' => 'Pelajari teknik pengendalian hama yang ramah lingkungan. Paket ini mencakup identifikasi hama, pembuatan pestisida alami, dan monitoring hama. Cocok untuk petani dan penyuluh pertanian.',
                'harga' => 80000.00,
                'image' => 'eduwisata_images/paket-pengendalian-hama.jpg'
            ],
            [
                'name' => 'Paket Wisata Sekolah',
                'description' => 'Program edukasi pertanian khusus untuk siswa sekolah. Paket ini dirancang sesuai kurikulum pendidikan dengan aktivitas yang menyenangkan dan edukatif.',
                'harga' => 60000.00,
                'image' => 'eduwisata_images/paket-wisata-sekolah.jpg'
            ],
            [
                'name' => 'Paket Fotografi Pertanian',
                'description' => 'Nikmati keindahan alam pertanian sambil berfoto. Paket ini menyediakan spot foto terbaik di kebun kami dengan pemandangan sawah, kebun sayuran, dan aktivitas pertanian.',
                'harga' => 40000.00,
                'image' => 'eduwisata_images/paket-fotografi-pertanian.jpg'
            ],
            [
                'name' => 'Paket Camping di Kebun',
                'description' => 'Pengalaman camping unik di tengah kebun pertanian. Nikmati malam yang tenang dengan suara alam sambil belajar tentang pertanian. Cocok untuk keluarga dan kelompok.',
                'harga' => 200000.00,
                'image' => 'eduwisata_images/paket-camping-kebun.jpg'
            ],
            [
                'name' => 'Paket Corporate Outbound Pertanian',
                'description' => 'Program team building dengan tema pertanian untuk perusahaan. Paket ini menggabungkan aktivitas outdoor dengan pembelajaran pertanian yang menyenangkan.',
                'harga' => 180000.00,
                'image' => 'eduwisata_images/paket-corporate-outbound.jpg'
            ]
        ];

        foreach ($eduwisatas as $eduwisata) {
            Eduwisata::updateOrCreate(
                ['name' => $eduwisata['name']],
                $eduwisata
            );
        }

        $this->command->info('Eduwisatas seeded successfully!');
    }
} 