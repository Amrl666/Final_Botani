<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Budi Santoso',
                'whatsapp' => '081234567890',
                'subject' => 'Pemesanan Beras Organik',
                'message' => 'Selamat pagi, saya tertarik dengan beras organik yang dijual. Apakah bisa pesan 10kg untuk pengiriman ke Jakarta? Berapa ongkos kirimnya? Terima kasih.',
                'read_at' => null
            ],
            [
                'name' => 'Siti Nurhaliza',
                'whatsapp' => '081876543210',
                'subject' => 'Informasi Paket Eduwisata',
                'message' => 'Halo, saya ingin menanyakan tentang paket eduwisata untuk anak-anak sekolah. Berapa minimal peserta dan berapa lama durasinya? Apakah ada paket khusus untuk TK?',
                'read_at' => '2024-01-15 10:30:00'
            ],
            [
                'name' => 'Ahmad Fauzi',
                'whatsapp' => '081112223334',
                'subject' => 'Kerjasama Distribusi',
                'message' => 'Selamat siang, saya pemilik toko sayuran di Pasar Magelang. Saya tertarik untuk kerjasama distribusi sayuran segar dari kelompok tani. Apakah bisa diskusi lebih lanjut?',
                'read_at' => '2024-01-14 14:20:00'
            ],
            [
                'name' => 'Dewi Sartika',
                'whatsapp' => '081445556667',
                'subject' => 'Pemesanan Cabai Merah',
                'message' => 'Halo, saya pemilik warung makan di Yogyakarta. Saya butuh cabai merah segar secara rutin. Berapa harga per kg dan minimal ordernya? Terima kasih.',
                'read_at' => null
            ],
            [
                'name' => 'Rudi Hartono',
                'whatsapp' => '081778889990',
                'subject' => 'Konsultasi Pertanian',
                'message' => 'Selamat pagi, saya petani pemula di Sleman. Saya ingin konsultasi tentang cara menanam cabai yang benar. Apakah ada layanan konsultasi atau bisa ikut pelatihan?',
                'read_at' => '2024-01-13 09:15:00'
            ],
            [
                'name' => 'Nina Safitri',
                'whatsapp' => '081223334445',
                'subject' => 'Pemesanan Sayuran Organik',
                'message' => 'Halo, saya ingin pesan sayuran organik untuk acara keluarga. Butuh tomat cherry, wortel, dan bayam. Berapa harga per kg masing-masing? Bisa kirim ke Semarang?',
                'read_at' => null
            ],
            [
                'name' => 'Joko Widodo',
                'whatsapp' => '081556667778',
                'subject' => 'Kunjungan Industri',
                'message' => 'Selamat siang, saya guru SMK Pertanian di Solo. Saya ingin membawa siswa untuk kunjungan industri ke kelompok tani. Apakah bisa diatur jadwalnya?',
                'read_at' => '2024-01-12 16:45:00'
            ],
            [
                'name' => 'Maya Indah',
                'whatsapp' => '081889990001',
                'subject' => 'Pemesanan Tomat Cherry',
                'message' => 'Halo, saya pemilik cafe di Magelang. Saya butuh tomat cherry segar untuk salad. Berapa harga per kg dan bisa kirim setiap hari? Terima kasih.',
                'read_at' => null
            ],
            [
                'name' => 'Bambang Sutejo',
                'whatsapp' => '081112223334',
                'subject' => 'Pelatihan Pertanian',
                'message' => 'Selamat pagi, saya ketua kelompok tani di Temanggung. Saya tertarik dengan teknik pertanian organik yang diterapkan. Apakah ada pelatihan yang bisa diikuti?',
                'read_at' => '2024-01-11 11:30:00'
            ],
            [
                'name' => 'Sri Wahyuni',
                'whatsapp' => '081445556667',
                'subject' => 'Pemesanan Bawang Merah',
                'message' => 'Halo, saya pedagang di pasar tradisional. Saya butuh bawang merah dalam jumlah besar. Berapa harga grosir dan minimal ordernya? Bisa nego harga?',
                'read_at' => null
            ],
            [
                'name' => 'Doni Kusuma',
                'whatsapp' => '081778889990',
                'subject' => 'Informasi Produk',
                'message' => 'Selamat siang, saya ingin menanyakan tentang produk-produk yang dijual. Apakah ada katalog lengkap dengan harga? Dan apakah ada diskon untuk pembelian dalam jumlah besar?',
                'read_at' => '2024-01-10 13:20:00'
            ],
            [
                'name' => 'Rina Marlina',
                'whatsapp' => '081223334445',
                'subject' => 'Pemesanan Kentang',
                'message' => 'Halo, saya butuh kentang segar untuk usaha keripik. Berapa harga per kg dan minimal ordernya? Apakah kualitasnya konsisten? Terima kasih.',
                'read_at' => null
            ],
            [
                'name' => 'Agus Setiawan',
                'whatsapp' => '081556667778',
                'subject' => 'Kunjungan Wisata',
                'message' => 'Selamat pagi, saya ingin mengajak keluarga untuk kunjungan wisata pertanian. Apakah ada paket khusus untuk keluarga dengan anak kecil? Berapa biayanya?',
                'read_at' => '2024-01-09 10:15:00'
            ],
            [
                'name' => 'Lina Marlina',
                'whatsapp' => '081889990001',
                'subject' => 'Pemesanan Jagung Manis',
                'message' => 'Halo, saya pemilik restoran di Yogyakarta. Saya butuh jagung manis segar untuk menu bakar. Berapa harga per buah dan bisa kirim setiap hari?',
                'read_at' => null
            ],
            [
                'name' => 'Hendra Gunawan',
                'whatsapp' => '081112223334',
                'subject' => 'Kerjasama Event',
                'message' => 'Selamat siang, saya panitia acara pertanian di Magelang. Saya ingin mengundang kelompok tani untuk menjadi pembicara. Apakah bisa diatur?',
                'read_at' => '2024-01-08 15:30:00'
            ],
            [
                'name' => 'Yuni Safitri',
                'whatsapp' => '081445556667',
                'subject' => 'Pemesanan Kacang Panjang',
                'message' => 'Halo, saya butuh kacang panjang segar untuk usaha catering. Berapa harga per ikat dan minimal ordernya? Bisa kirim ke Solo?',
                'read_at' => null
            ],
            [
                'name' => 'Rudi Kurniawan',
                'whatsapp' => '081778889990',
                'subject' => 'Konsultasi Hidroponik',
                'message' => 'Selamat pagi, saya tertarik dengan sistem hidroponik. Apakah ada pelatihan khusus untuk hidroponik? Berapa biayanya dan berapa lama durasinya?',
                'read_at' => '2024-01-07 09:45:00'
            ],
            [
                'name' => 'Diana Putri',
                'whatsapp' => '081223334445',
                'subject' => 'Pemesanan Terong Ungu',
                'message' => 'Halo, saya pemilik warung makan. Saya butuh terong ungu segar secara rutin. Berapa harga per kg dan bisa kirim setiap pagi? Terima kasih.',
                'read_at' => null
            ],
            [
                'name' => 'Eko Prasetyo',
                'whatsapp' => '081556667778',
                'subject' => 'Informasi Sertifikasi',
                'message' => 'Selamat siang, saya ingin menanyakan tentang sertifikasi organik yang dimiliki. Apakah semua produk sudah bersertifikat? Dan apakah ada jaminan kualitas?',
                'read_at' => '2024-01-06 14:20:00'
            ],
            [
                'name' => 'Sari Indah',
                'whatsapp' => '081889990001',
                'subject' => 'Pemesanan Timun',
                'message' => 'Halo, saya butuh timun segar untuk usaha jus. Berapa harga per kg dan minimal ordernya? Apakah bisa kirim setiap hari? Terima kasih.',
                'read_at' => null
            ],
            [
                'name' => 'Budi Prasetyo',
                'whatsapp' => '081112223334',
                'subject' => 'Kunjungan Study Tour',
                'message' => 'Selamat pagi, saya guru SD di Magelang. Saya ingin membawa siswa untuk study tour ke kebun pertanian. Apakah ada paket khusus untuk anak SD?',
                'read_at' => '2024-01-05 11:10:00'
            ]
        ];

        foreach ($contacts as $contact) {
            Contact::updateOrCreate(
                ['whatsapp' => $contact['whatsapp'], 'subject' => $contact['subject']],
                $contact
            );
        }

        $this->command->info('Contacts seeded successfully!');
    }
} 