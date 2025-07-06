<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Panen Cabai Merah',
                'description' => '2024-01-15',
                'image' => 'gallery_images/panen-cabai-merah.jpg'
            ],
            [
                'title' => 'Sawah Beras Organik',
                'description' => '2024-01-20',
                'image' => 'gallery_images/sawah-beras-organik.jpg'
            ],
            [
                'title' => 'Kebun Tomat Cherry',
                'description' => '2024-01-25',
                'image' => 'gallery_images/kebun-tomat-cherry.jpg'
            ],
            [
                'title' => 'Kegiatan Penyuluhan Pertanian',
                'description' => '2024-02-01',
                'image' => 'gallery_images/penyuluhan-pertanian.jpg'
            ],
            [
                'title' => 'Panen Bawang Merah',
                'description' => '2024-02-05',
                'image' => 'gallery_images/panen-bawang-merah.jpg'
            ],
            [
                'title' => 'Lahan Kentang Segar',
                'description' => '2024-02-10',
                'image' => 'gallery_images/lahan-kentang.jpg'
            ],
            [
                'title' => 'Kegiatan Pemupukan Organik',
                'description' => '2024-02-15',
                'image' => 'gallery_images/pemupukan-organik.jpg'
            ],
            [
                'title' => 'Panen Jagung Manis',
                'description' => '2024-02-20',
                'image' => 'gallery_images/panen-jagung-manis.jpg'
            ],
            [
                'title' => 'Kebun Kacang Panjang',
                'description' => '2024-02-25',
                'image' => 'gallery_images/kebun-kacang-panjang.jpg'
            ],
            [
                'title' => 'Panen Terong Ungu',
                'description' => '2024-03-01',
                'image' => 'gallery_images/panen-terong-ungu.jpg'
            ],
            [
                'title' => 'Kebun Timun Segar',
                'description' => '2024-03-05',
                'image' => 'gallery_images/kebun-timun.jpg'
            ],
            [
                'title' => 'Panen Wortel Organik',
                'description' => '2024-03-10',
                'image' => 'gallery_images/panen-wortel-organik.jpg'
            ],
            [
                'title' => 'Kebun Bayam Hijau',
                'description' => '2024-03-15',
                'image' => 'gallery_images/kebun-bayam-hijau.jpg'
            ],
            [
                'title' => 'Panen Kangkung Segar',
                'description' => '2024-03-20',
                'image' => 'gallery_images/panen-kangkung.jpg'
            ],
            [
                'title' => 'Kegiatan Pengendalian Hama',
                'description' => '2024-03-25',
                'image' => 'gallery_images/pengendalian-hama.jpg'
            ],
            [
                'title' => 'Penyortiran Hasil Panen',
                'description' => '2024-03-30',
                'image' => 'gallery_images/penyortiran-panen.jpg'
            ],
            [
                'title' => 'Kebun Sayuran Organik',
                'description' => '2024-04-01',
                'image' => 'gallery_images/kebun-sayuran-organik.jpg'
            ],
            [
                'title' => 'Kegiatan Pelatihan Pertanian',
                'description' => '2024-04-05',
                'image' => 'gallery_images/pelatihan-pertanian.jpg'
            ],
            [
                'title' => 'Panen Sayuran Segar',
                'description' => '2024-04-10',
                'image' => 'gallery_images/panen-sayuran-segar.jpg'
            ],
            [
                'title' => 'Lahan Pertanian Terpadu',
                'description' => '2024-04-15',
                'image' => 'gallery_images/lahan-pertanian-terpadu.jpg'
            ]
        ];

        foreach ($galleries as $gallery) {
            Gallery::updateOrCreate(
                ['title' => $gallery['title']],
                $gallery
            );
        }

        $this->command->info('Galleries seeded successfully!');
    }
} 