<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Tips Menanam Cabai Merah yang Berkualitas Tinggi',
                'content' => '<p>Cabai merah merupakan salah satu komoditas pertanian yang memiliki nilai ekonomis tinggi. Untuk mendapatkan hasil panen yang berkualitas, ada beberapa tips yang bisa diterapkan:</p>

<h3>1. Pemilihan Benih Berkualitas</h3>
<p>Pilih benih cabai yang bersertifikat dan memiliki daya tumbuh tinggi. Benih yang baik akan menghasilkan tanaman yang sehat dan produktif.</p>

<h3>2. Persiapan Lahan</h3>
<p>Lahan harus digemburkan dan diberi pupuk organik. Pastikan pH tanah antara 6-7 untuk pertumbuhan optimal cabai.</p>

<h3>3. Penanaman</h3>
<p>Jarak tanam yang ideal adalah 60x60 cm. Hal ini akan memberikan ruang yang cukup untuk pertumbuhan tanaman.</p>

<h3>4. Perawatan</h3>
<p>Lakukan penyiraman secara teratur, pemupukan, dan pengendalian hama penyakit. Cabai membutuhkan air yang cukup terutama saat masa pembungaan.</p>

<h3>5. Panen</h3>
<p>Panen dilakukan saat cabai sudah berwarna merah merata. Panen yang tepat waktu akan menghasilkan cabai dengan kualitas terbaik.</p>

<p>Dengan menerapkan tips-tips di atas, Anda akan mendapatkan hasil panen cabai merah yang berkualitas tinggi dan bernilai ekonomis.</p>',
                'image' => 'blog_images/tips-cabai-merah.jpg'
            ],
            [
                'title' => 'Manfaat Beras Organik untuk Kesehatan Keluarga',
                'content' => '<p>Beras organik menjadi pilihan yang semakin populer di kalangan masyarakat yang peduli dengan kesehatan. Berikut adalah manfaat beras organik untuk kesehatan keluarga:</p>

<h3>1. Bebas Pestisida</h3>
<p>Beras organik ditanam tanpa menggunakan pestisida kimia, sehingga lebih aman untuk dikonsumsi dan tidak meninggalkan residu berbahaya.</p>

<h3>2. Kandungan Nutrisi Lebih Tinggi</h3>
<p>Beras organik memiliki kandungan vitamin, mineral, dan antioksidan yang lebih tinggi dibandingkan beras konvensional.</p>

<h3>3. Rasa yang Lebih Enak</h3>
<p>Beras organik memiliki aroma dan rasa yang lebih alami dan enak, sehingga lebih disukai oleh keluarga.</p>

<h3>4. Mendukung Pertanian Berkelanjutan</h3>
<p>Dengan mengonsumsi beras organik, Anda turut mendukung praktik pertanian yang ramah lingkungan dan berkelanjutan.</p>

<h3>5. Baik untuk Pencernaan</h3>
<p>Beras organik lebih mudah dicerna dan tidak menyebabkan masalah pencernaan seperti kembung atau sembelit.</p>

<p>Mulailah beralih ke beras organik untuk kesehatan keluarga yang lebih baik. Kelompok Tani Winongo Asri menyediakan beras organik berkualitas tinggi hasil panen langsung dari sawah kami.</p>',
                'image' => 'blog_images/manfaat-beras-organik.jpg'
            ],
            [
                'title' => 'Cara Budidaya Tomat Cherry di Lahan Terbatas',
                'content' => '<p>Tomat cherry bisa ditanam di lahan terbatas seperti pekarangan rumah atau menggunakan sistem hidroponik. Berikut adalah panduan lengkapnya:</p>

<h3>1. Persiapan Media Tanam</h3>
<p>Untuk lahan terbatas, gunakan pot atau polybag dengan ukuran minimal 30x30 cm. Media tanam bisa menggunakan campuran tanah, kompos, dan sekam padi.</p>

<h3>2. Pemilihan Benih</h3>
<p>Pilih benih tomat cherry yang berkualitas. Anda bisa menggunakan benih hibrida atau benih lokal yang sudah teruji.</p>

<h3>3. Penanaman</h3>
<p>Tanam benih dalam pot yang sudah disiapkan. Pastikan pot memiliki lubang drainase yang cukup untuk mencegah genangan air.</p>

<h3>4. Perawatan</h3>
<p>Lakukan penyiraman pagi dan sore hari. Berikan pupuk organik setiap 2 minggu sekali untuk pertumbuhan yang optimal.</p>

<h3>5. Pemasangan Ajir</h3>
<p>Karena tomat cherry tumbuh tinggi, pasang ajir atau tali untuk menopang tanaman agar tidak roboh.</p>

<h3>6. Panen</h3>
<p>Tomat cherry bisa dipanen setelah 60-70 hari setelah tanam. Panen dilakukan saat tomat sudah berwarna merah merata.</p>

<p>Dengan cara ini, Anda bisa menikmati tomat cherry segar dari kebun sendiri meskipun memiliki lahan terbatas.</p>',
                'image' => 'blog_images/budidaya-tomat-cherry.jpg'
            ],
            [
                'title' => 'Pentingnya Rotasi Tanaman untuk Kesuburan Lahan',
                'content' => '<p>Rotasi tanaman adalah praktik menanam jenis tanaman yang berbeda secara bergantian pada lahan yang sama. Praktik ini memiliki banyak manfaat untuk kesuburan lahan:</p>

<h3>1. Mencegah Penumpukan Hama dan Penyakit</h3>
<p>Setiap jenis tanaman memiliki hama dan penyakit yang berbeda. Dengan rotasi tanaman, hama dan penyakit tidak akan menumpuk di lahan.</p>

<h3>2. Memperbaiki Struktur Tanah</h3>
<p>Tanaman yang berbeda memiliki sistem perakaran yang berbeda pula. Hal ini akan memperbaiki struktur tanah dan meningkatkan porositas.</p>

<h3>3. Mengoptimalkan Penggunaan Nutrisi</h3>
<p>Setiap tanaman membutuhkan nutrisi yang berbeda. Rotasi tanaman akan mengoptimalkan penggunaan nutrisi di dalam tanah.</p>

<h3>4. Meningkatkan Hasil Panen</h3>
<p>Lahan yang subur dan sehat akan menghasilkan panen yang lebih baik baik dari segi kualitas maupun kuantitas.</p>

<h3>5. Mengurangi Ketergantungan pada Pupuk Kimia</h3>
<p>Dengan rotasi tanaman, kebutuhan pupuk kimia akan berkurang karena tanah sudah kaya akan nutrisi alami.</p>

<p>Kelompok Tani Winongo Asri menerapkan sistem rotasi tanaman untuk menjaga kesuburan lahan dan menghasilkan produk pertanian berkualitas tinggi.</p>',
                'image' => 'blog_images/rotasi-tanaman.jpg'
            ],
            [
                'title' => 'Teknik Pengendalian Hama Terpadu yang Ramah Lingkungan',
                'content' => '<p>Pengendalian Hama Terpadu (PHT) adalah pendekatan yang mengintegrasikan berbagai metode pengendalian hama secara bijaksana. Berikut adalah teknik PHT yang ramah lingkungan:</p>

<h3>1. Pengendalian Kultur Teknis</h3>
<p>Melakukan pengolahan tanah yang baik, pemilihan varietas tahan hama, dan pengaturan jarak tanam yang tepat.</p>

<h3>2. Pengendalian Hayati</h3>
<p>Menggunakan musuh alami hama seperti predator dan parasitoid untuk mengendalikan populasi hama.</p>

<h3>3. Pengendalian Fisik dan Mekanis</h3>
<p>Menggunakan perangkap, pemasangan kelambu, dan pembersihan gulma secara manual.</p>

<h3>4. Pengendalian Kimiawi Selektif</h3>
<p>Jika diperlukan, gunakan pestisida yang selektif dan ramah lingkungan dengan dosis yang tepat.</p>

<h3>5. Monitoring dan Evaluasi</h3>
<p>Melakukan pengamatan rutin terhadap populasi hama dan efektivitas pengendalian yang dilakukan.</p>

<p>Dengan menerapkan PHT, kita bisa mengendalikan hama secara efektif tanpa merusak lingkungan dan kesehatan manusia.</p>',
                'image' => 'blog_images/pengendalian-hama.jpg'
            ],
            [
                'title' => 'Mengenal Jenis-jenis Pupuk Organik dan Manfaatnya',
                'content' => '<p>Pupuk organik merupakan pupuk yang berasal dari bahan-bahan alami. Berikut adalah jenis-jenis pupuk organik dan manfaatnya:</p>

<h3>1. Kompos</h3>
<p>Kompos dibuat dari sisa-sisa tanaman dan hewan yang telah mengalami dekomposisi. Pupuk ini kaya akan nutrisi dan mikroorganisme yang bermanfaat.</p>

<h3>2. Pupuk Kandang</h3>
<p>Pupuk kandang berasal dari kotoran hewan ternak. Pupuk ini mengandung nitrogen, fosfor, dan kalium yang dibutuhkan tanaman.</p>

<h3>3. Pupuk Hijau</h3>
<p>Pupuk hijau dibuat dari tanaman yang sengaja ditanam untuk dijadikan pupuk. Contohnya adalah kacang-kacangan yang dapat mengikat nitrogen.</p>

<h3>4. Humus</h3>
<p>Humus adalah hasil dekomposisi bahan organik yang sudah matang. Pupuk ini sangat baik untuk memperbaiki struktur tanah.</p>

<h3>5. Pupuk Cair Organik</h3>
<p>Pupuk cair organik dibuat dari fermentasi bahan organik. Pupuk ini mudah diserap oleh tanaman dan dapat diaplikasikan melalui daun.</p>

<p>Penggunaan pupuk organik akan membuat tanah lebih subur, tanaman lebih sehat, dan hasil panen berkualitas tinggi.</p>',
                'image' => 'blog_images/pupuk-organik.jpg'
            ]
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['title' => $blog['title']],
                $blog
            );
        }

        $this->command->info('Blogs seeded successfully!');
    }
} 