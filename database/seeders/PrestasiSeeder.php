<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prestasi;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prestasis = [
            [
                'title' => 'Juara 1 Lomba Kelompok Tani Berprestasi Tingkat Kabupaten',
                'content' => 'Kelompok Tani Winongo Asri berhasil meraih juara 1 dalam Lomba Kelompok Tani Berprestasi tingkat Kabupaten Magelang tahun 2023. Prestasi ini diraih berkat inovasi dalam pengembangan pertanian organik dan peningkatan produktivitas lahan.',
                'image' => 'prestasi_images/juara-lomba-kelompok-tani.jpg'
            ],
            [
                'title' => 'Sertifikasi Produk Organik dari BPOM',
                'content' => 'Produk beras organik Kelompok Tani Winongo Asri berhasil mendapatkan sertifikasi organik dari Badan Pengawas Obat dan Makanan (BPOM). Sertifikasi ini membuktikan kualitas dan keamanan produk pertanian kami.',
                'image' => 'prestasi_images/sertifikasi-organik-bpom.jpg'
            ],
            [
                'title' => 'Penghargaan Petani Teladan Tingkat Provinsi',
                'content' => 'Ketua Kelompok Tani Winongo Asri, Bapak Sutrisno, berhasil meraih penghargaan Petani Teladan tingkat Provinsi Jawa Tengah tahun 2023. Penghargaan ini diberikan atas dedikasi dan inovasi dalam pengembangan pertanian.',
                'image' => 'prestasi_images/penghargaan-petani-teladan.jpg'
            ],
            [
                'title' => 'Ekspor Pertama Produk Pertanian ke Singapura',
                'content' => 'Kelompok Tani Winongo Asri berhasil melakukan ekspor pertama produk pertanian organik ke Singapura. Produk yang diekspor meliputi beras organik dan sayuran segar dengan kualitas premium.',
                'image' => 'prestasi_images/ekspor-singapura.jpg'
            ],
            [
                'title' => 'Juara 2 Lomba Inovasi Teknologi Pertanian',
                'content' => 'Tim Kelompok Tani Winongo Asri berhasil meraih juara 2 dalam Lomba Inovasi Teknologi Pertanian tingkat nasional. Inovasi yang dikembangkan adalah sistem pengendalian hama terpadu berbasis teknologi.',
                'image' => 'prestasi_images/inovasi-teknologi-pertanian.jpg'
            ],
            [
                'title' => 'Sertifikasi GAP (Good Agricultural Practice)',
                'content' => 'Kelompok Tani Winongo Asri berhasil mendapatkan sertifikasi GAP (Good Agricultural Practice) dari Kementerian Pertanian. Sertifikasi ini membuktikan penerapan praktik pertanian yang baik dan aman.',
                'image' => 'prestasi_images/sertifikasi-gap.jpg'
            ],
            [
                'title' => 'Penghargaan Kelompok Tani Terbaik Se-Jawa Tengah',
                'content' => 'Kelompok Tani Winongo Asri dinobatkan sebagai Kelompok Tani Terbaik se-Jawa Tengah tahun 2023. Penghargaan ini diberikan atas prestasi dalam pengembangan pertanian berkelanjutan.',
                'image' => 'prestasi_images/kelompok-tani-terbaik.jpg'
            ],
            [
                'title' => 'Juara 1 Lomba Pengolahan Hasil Pertanian',
                'content' => 'Kelompok Tani Winongo Asri berhasil meraih juara 1 dalam Lomba Pengolahan Hasil Pertanian tingkat kabupaten. Produk olahan yang dikembangkan adalah tepung beras organik dan minyak cabai.',
                'image' => 'prestasi_images/pengolahan-hasil-pertanian.jpg'
            ],
            [
                'title' => 'Sertifikasi Halal untuk Produk Pertanian',
                'content' => 'Semua produk pertanian Kelompok Tani Winongo Asri berhasil mendapatkan sertifikasi halal dari Majelis Ulama Indonesia (MUI). Sertifikasi ini memastikan produk kami aman dikonsumsi oleh semua kalangan.',
                'image' => 'prestasi_images/sertifikasi-halal.jpg'
            ],
            [
                'title' => 'Penghargaan Inovasi Pertanian Ramah Lingkungan',
                'content' => 'Kelompok Tani Winongo Asri mendapatkan penghargaan Inovasi Pertanian Ramah Lingkungan dari Kementerian Lingkungan Hidup. Penghargaan ini diberikan atas komitmen dalam pengembangan pertanian berkelanjutan.',
                'image' => 'prestasi_images/pertanian-ramah-lingkungan.jpg'
            ],
            [
                'title' => 'Juara 3 Lomba Wirausaha Tani',
                'content' => 'Kelompok Tani Winongo Asri berhasil meraih juara 3 dalam Lomba Wirausaha Tani tingkat nasional. Prestasi ini diraih berkat pengembangan usaha tani yang inovatif dan berkelanjutan.',
                'image' => 'prestasi_images/wirausaha-tani.jpg'
            ],
            [
                'title' => 'Sertifikasi ISO 22000 untuk Keamanan Pangan',
                'content' => 'Kelompok Tani Winongo Asri berhasil mendapatkan sertifikasi ISO 22000 untuk sistem manajemen keamanan pangan. Sertifikasi ini membuktikan komitmen kami dalam menghasilkan produk pangan yang aman dan berkualitas.',
                'image' => 'prestasi_images/sertifikasi-iso-22000.jpg'
            ],
            [
                'title' => 'Penghargaan Petani Muda Berprestasi',
                'content' => 'Anggota muda Kelompok Tani Winongo Asri, Bapak Ahmad Fauzi, berhasil meraih penghargaan Petani Muda Berprestasi tingkat provinsi. Penghargaan ini diberikan atas inovasi dalam pengembangan pertanian modern.',
                'image' => 'prestasi_images/petani-muda-berprestasi.jpg'
            ],
            [
                'title' => 'Juara 1 Lomba Pengembangan Varietas Lokal',
                'content' => 'Kelompok Tani Winongo Asri berhasil meraih juara 1 dalam Lomba Pengembangan Varietas Lokal tingkat nasional. Varietas yang dikembangkan adalah cabai merah lokal yang tahan hama dan produktif.',
                'image' => 'prestasi_images/varietas-lokal.jpg'
            ],
            [
                'title' => 'Sertifikasi Produk Pertanian Premium',
                'content' => 'Produk pertanian Kelompok Tani Winongo Asri berhasil mendapatkan sertifikasi produk pertanian premium dari Kementerian Pertanian. Sertifikasi ini membuktikan kualitas premium produk kami.',
                'image' => 'prestasi_images/produk-premium.jpg'
            ]
        ];

        foreach ($prestasis as $prestasi) {
            Prestasi::updateOrCreate(
                ['title' => $prestasi['title']],
                $prestasi
            );
        }

        $this->command->info('Prestasis seeded successfully!');
    }
} 