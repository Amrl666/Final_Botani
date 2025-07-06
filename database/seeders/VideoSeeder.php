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
                'name' => 'Cara Menanam Cabai Merah',
                'title' => 'Cara Menanam Cabai Merah yang Benar',
                'video' => 'https://www.youtube.com/embed/abc123',
                'description' => 'Video tutorial lengkap cara menanam cabai merah dari persiapan lahan hingga panen. Tips dan trik untuk mendapatkan hasil panen yang berkualitas tinggi.'
            ],
            [
                'name' => 'Teknik Pemupukan Organik',
                'title' => 'Teknik Pemupukan Organik untuk Sayuran',
                'video' => 'https://www.youtube.com/embed/def456',
                'description' => 'Video panduan teknik pemupukan organik yang benar untuk berbagai jenis sayuran. Menggunakan pupuk alami untuk hasil yang sehat dan berkualitas.'
            ],
            [
                'name' => 'Pengendalian Hama Terpadu',
                'title' => 'Pengendalian Hama Terpadu Ramah Lingkungan',
                'video' => 'https://www.youtube.com/embed/ghi789',
                'description' => 'Video tutorial pengendalian hama terpadu menggunakan metode ramah lingkungan. Teknik yang efektif tanpa merusak ekosistem.'
            ],
            [
                'name' => 'Budidaya Tomat Cherry',
                'title' => 'Budidaya Tomat Cherry di Lahan Terbatas',
                'video' => 'https://www.youtube.com/embed/jkl012',
                'description' => 'Video panduan lengkap budidaya tomat cherry di pekarangan rumah atau lahan terbatas. Cocok untuk pemula yang ingin berkebun.'
            ],
            [
                'name' => 'Cara Panen dan Pasca Panen',
                'title' => 'Cara Panen dan Pasca Panen yang Benar',
                'video' => 'https://www.youtube.com/embed/mno345',
                'description' => 'Video tutorial cara panen dan pasca panen yang benar untuk berbagai jenis sayuran. Teknik yang tepat untuk menjaga kualitas produk.'
            ],
            [
                'name' => 'Sistem Irigasi Tetes',
                'title' => 'Sistem Irigasi Tetes untuk Pertanian',
                'video' => 'https://www.youtube.com/embed/pqr678',
                'description' => 'Video penjelasan sistem irigasi tetes untuk pertanian yang efisien. Menghemat air dan tenaga kerja dalam perawatan tanaman.'
            ],
            [
                'name' => 'Pembuatan Pupuk Kompos',
                'title' => 'Pembuatan Pupuk Kompos dari Limbah Dapur',
                'video' => 'https://www.youtube.com/embed/stu901',
                'description' => 'Video tutorial pembuatan pupuk kompos dari limbah dapur. Cara mudah mengolah sampah organik menjadi pupuk berkualitas.'
            ],
            [
                'name' => 'Teknik Rotasi Tanaman',
                'title' => 'Teknik Rotasi Tanaman untuk Kesuburan Lahan',
                'video' => 'https://www.youtube.com/embed/vwx234',
                'description' => 'Video penjelasan teknik rotasi tanaman untuk menjaga kesuburan lahan. Sistem pertanian berkelanjutan yang menguntungkan.'
            ],
            [
                'name' => 'Cara Menanam Beras Organik',
                'title' => 'Cara Menanam Beras Organik',
                'video' => 'https://www.youtube.com/embed/yzab567',
                'description' => 'Video panduan lengkap cara menanam beras organik dari persiapan benih hingga panen. Teknik pertanian organik yang ramah lingkungan.'
            ],
            [
                'name' => 'Pengolahan Hasil Pertanian',
                'title' => 'Pengolahan Hasil Pertanian Menjadi Produk Olahan',
                'video' => 'https://www.youtube.com/embed/cdef890',
                'description' => 'Video tutorial pengolahan hasil pertanian menjadi produk olahan yang bernilai tambah. Menambah penghasilan petani.'
            ],
            [
                'name' => 'Teknik Hidroponik',
                'title' => 'Teknik Hidroponik untuk Pemula',
                'video' => 'https://www.youtube.com/embed/fghi123',
                'description' => 'Video panduan teknik hidroponik untuk pemula. Cara menanam sayuran tanpa tanah yang mudah dan praktis.'
            ],
            [
                'name' => 'Pemilihan Benih',
                'title' => 'Pemilihan Benih Berkualitas untuk Pertanian',
                'video' => 'https://www.youtube.com/embed/jklm456',
                'description' => 'Video penjelasan cara memilih benih berkualitas untuk pertanian. Tips memilih benih yang tepat untuk hasil panen optimal.'
            ],
            [
                'name' => 'Cara Menanam Sayuran di Polybag',
                'title' => 'Cara Menanam Sayuran di Polybag',
                'video' => 'https://www.youtube.com/embed/nopq789',
                'description' => 'Video tutorial cara menanam sayuran di polybag. Solusi berkebun di lahan terbatas dengan hasil yang memuaskan.'
            ],
            [
                'name' => 'Teknik Perbanyakan Tanaman',
                'title' => 'Teknik Perbanyakan Tanaman Secara Vegetatif',
                'video' => 'https://www.youtube.com/embed/rstu012',
                'description' => 'Video panduan teknik perbanyakan tanaman secara vegetatif. Cara mudah memperbanyak tanaman tanpa biji.'
            ],
            [
                'name' => 'Pemeliharaan Tanaman Sayuran',
                'title' => 'Pemeliharaan Tanaman Sayuran',
                'video' => 'https://www.youtube.com/embed/vwxy345',
                'description' => 'Video tutorial pemeliharaan tanaman sayuran yang benar. Perawatan rutin untuk hasil panen yang berkualitas.'
            ]
        ];

        foreach ($videos as $video) {
            Video::updateOrCreate(
                ['title' => $video['title']],
                $video
            );
        }

        $this->command->info('Videos seeded successfully!');
    }
} 