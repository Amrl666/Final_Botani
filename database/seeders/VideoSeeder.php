<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'name' => 'Tutorial Cabai Organik',
                'title' => 'Cara Menanam Cabai Organik',
                'video' => 'videos/cabai-organik.mp4',
                'description' => 'Video tutorial lengkap cara menanam cabai organik dari persiapan lahan hingga panen. Cocok untuk petani pemula.'
            ],
            [
                'name' => 'Hidroponik Sederhana',
                'title' => 'Teknik Hidroponik Sederhana',
                'video' => 'videos/hidroponik-sederhana.mp4',
                'description' => 'Panduan lengkap membuat sistem hidroponik sederhana untuk menanam sayuran di rumah. Hemat lahan dan efisien.'
            ],
            [
                'name' => 'Pupuk Kompos',
                'title' => 'Pembuatan Pupuk Kompos',
                'video' => 'videos/pupuk-kompos.mp4',
                'description' => 'Tutorial cara membuat pupuk kompos dari limbah dapur dan sisa tanaman. Ramah lingkungan dan ekonomis.'
            ],
            [
                'name' => 'Pengendalian Hama',
                'title' => 'Pengendalian Hama Terpadu',
                'video' => 'videos/pengendalian-hama.mp4',
                'description' => 'Cara mengendalikan hama tanaman secara alami tanpa pestisida kimia. Aman untuk konsumen dan lingkungan.'
            ],
            [
                'name' => 'Panen Pasca Panen',
                'title' => 'Panen dan Pasca Panen',
                'video' => 'videos/panen-pasca-panen.mp4',
                'description' => 'Teknik panen yang benar dan penanganan pasca panen untuk menjaga kualitas produk pertanian.'
            ],
            [
                'name' => 'Tomat Cherry',
                'title' => 'Budidaya Tomat Cherry',
                'video' => 'videos/tomat-cherry.mp4',
                'description' => 'Panduan lengkap budidaya tomat cherry dari pembibitan hingga panen. Hasil panen berkualitas tinggi.'
            ],
            [
                'name' => 'Irigasi Tetes',
                'title' => 'Sistem Irigasi Tetes',
                'video' => 'videos/irigasi-tetes.mp4',
                'description' => 'Cara membuat dan mengatur sistem irigasi tetes untuk efisiensi penggunaan air di lahan pertanian.'
            ],
            [
                'name' => 'Pengolahan Pertanian',
                'title' => 'Pengolahan Hasil Pertanian',
                'video' => 'videos/pengolahan-pertanian.mp4',
                'description' => 'Tutorial mengolah hasil pertanian menjadi produk bernilai tambah seperti selai, keripik, dan produk olahan lainnya.'
            ],
            [
                'name' => 'Bibit Unggul',
                'title' => 'Pemilihan Bibit Unggul',
                'video' => 'videos/bibit-unggul.mp4',
                'description' => 'Cara memilih dan menyiapkan bibit unggul untuk hasil panen yang optimal. Tips dari petani berpengalaman.'
            ],
            [
                'name' => 'Pertanian Vertikal',
                'title' => 'Pertanian Vertikal',
                'video' => 'videos/pertanian-vertikal.mp4',
                'description' => 'Konsep dan implementasi pertanian vertikal untuk memaksimalkan penggunaan lahan terbatas.'
            ]
        ];

        foreach ($videos as $video) {
            Video::updateOrCreate(
                ['name' => $video['name']],
                $video
            );
        }

        $this->command->info('Videos seeded successfully!');
    }
} 